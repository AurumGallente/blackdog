<?php

/**
 *  
 *  
 */

define('BX_DOL_DNSBL_NEGATIVE', 0);   // negative
define('BX_DOL_DNSBL_POSITIVE', 1);   // positive match
define('BX_DOL_DNSBL_FAILURE', 2);    // generic failure, not enabled or configured

// Types of queries for dnsbl_lookup_ip() and dnsbl_lookup_domain()
define('BX_DOL_DNSBL_ANYPOSTV_RETFIRST', 0);   // Any positive from chain, stop and return first
define('BX_DOL_DNSBL_ANYPOSTV_RETEVERY', 1);   // Any positive, check all and return every positive
define('BX_DOL_DNSBL_ALLPOSTV_RETEVERY', 2);   // All must check positive, return every positive

define('BX_DOL_DNSBL_MATCH_ANY', "any");

define('BX_DOL_DNSBL_CHAIN_SPAMMERS', "spammers");
define('BX_DOL_DNSBL_CHAIN_WHITELIST', "whitelist");
define('BX_DOL_DNSBL_CHAIN_URIDNS', "uridns");

/**
 *  Spam detection based on spammer IP
 *
 *
 * Example of usage:
 *
 *  if (DNSBL_POSITIVE == $o->dnsbl_lookup_ip(DNSBL_CHAIN_SPAMMERS, $sCurIP) && DNSBL_POSITIVE != $o->dnsbl_lookup_ip(DNSBL_CHAIN_WHITELIST, $sCurIP))
 *  {
 *    // positive detection - block this ip
 *  }
 *  // continue script execution
 *
 *
 *  There is more handy function available:
 *  @see bx_is_ip_dns_blacklisted
 */
class BxDolDNSBlacklists extends BxDolMistake
{

    private $aChains = array ();

    /**
     * Constructor
     */
    public function BxDolDNSBlacklists()
    {
        $this->initChains();
    }

    public function dnsbl_lookup_ip($mixedChain, $sIp, $querymode = BX_DOL_DNSBL_ANYPOSTV_RETFIRST)
    {
        $lookupkey = $this->ipreverse($sIp);
        if (false === $lookupkey)
            return BX_DOL_DNSBL_FAILURE;	// unable to prepare lookup string from address

        if (is_array($mixedChain))
            $aChain = $mixedChain;
        else
            $aChain = &$this->aChains[$mixedChain];
        return $this->dnsbl_lookup($aChain, $lookupkey, $querymode);
    }

    public function dnsbl_lookup_uri($sUri, $mixedChain = BX_DOL_DNSBL_CHAIN_URIDNS, $querymode = BX_DOL_DNSBL_ANYPOSTV_RETFIRST)
    {
        if (!$sUri)
            return BX_DOL_DNSBL_FAILURE;

        if (is_array($mixedChain))
            $aChain = $mixedChain;
        else
            $aChain = &$this->aChains[$mixedChain];
        return $this->dnsbl_lookup($aChain, $sUri, $querymode);
    }

    public function onPositiveDetection ($sIP, $sExtraData = '', $sType = 'dnsbl')
    {
        $iIP = sprintf("%u", ip2long($sIP));
        $iMemberId = getLoggedId();
        $sExtraData = process_db_input($sExtraData);
        return $GLOBALS['MySQL']->query("INSERT INTO `sys_antispam_block_log` SET `ip` = '$iIP', `member_id` = '$iMemberId', `type` = '$sType', `extra` = '$sExtraData', `added` = " . time());
    }

    public function clearCache ()
    {
        $GLOBALS['MySQL']->cleanCache('sys_dnsbl_'.BX_DOL_DNSBL_CHAIN_SPAMMERS);
        $GLOBALS['MySQL']->cleanCache('sys_dnsbl_'.BX_DOL_DNSBL_CHAIN_WHITELIST);
    }

    /*************** private function ***************/

    private function dnsbl_lookup(&$zones, $key, $querymode)
    {
        $numpositive = 0;
        $numservers = count ($zones);
        $servers = $zones;

        if (!$servers)
            return BX_DOL_DNSBL_FAILURE; // no servers defined

        if (($querymode!=BX_DOL_DNSBL_ANYPOSTV_RETFIRST) && ($querymode!=BX_DOL_DNSBL_ANYPOSTV_RETEVERY)
             && ($querymode!=BX_DOL_DNSBL_ALLPOSTV_RETEVERY))
             return BX_DOL_DNSBL_FAILURE;	// invalid querymode

        foreach ($servers as $r) {
            $resultaddr = gethostbyname ($key . "." . $r['zonedomain']);

            if ($resultaddr && $resultaddr != $key . "." . $r['zonedomain']) {
                // we got some result from the DNS query, not NXDOMAIN. should we consider 'positive'?
                $postvresp = $r['postvresp'];	// check positive match criteria
                if (
                    BX_DOL_DNSBL_MATCH_ANY == $postvresp || 
                    (preg_match("/^\d+\.\d+\.\d+\.\d+$/", $postvresp) && $resultaddr == $postvresp) ||
                    (is_numeric($postvresp) && (ip2long($resultaddr) & $postvresp))
                ) {
                    $numpositive++;
                    if ($querymode == BX_DOL_DNSBL_ANYPOSTV_RETFIRST)
                        return BX_DOL_DNSBL_POSITIVE;	// found one positive, returning single
                }
            }
        }
        // all servers were queried
        if ($numpositive == $numservers)
            return BX_DOL_DNSBL_POSITIVE;
        else if (($querymode == BX_DOL_DNSBL_ANYPOSTV_RETEVERY) && ($numpositive > 0))
            return BX_DOL_DNSBL_POSITIVE;
        else
            return BX_DOL_DNSBL_NEGATIVE;
    }

    private function ipreverse ($sIp)
    {
        if (!preg_match ('/(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})/', $sIp, $m))
            return false;

        return "{$m[4]}.{$m[3]}.{$m[2]}.{$m[1]}";
    }

    private function initChains()
    {
        if (!isset($GLOBALS['bx_dol_dnsbl_'.BX_DOL_DNSBL_CHAIN_SPAMMERS]))
            $GLOBALS['bx_dol_dnsbl_'.BX_DOL_DNSBL_CHAIN_SPAMMERS] = $GLOBALS['MySQL']->fromCache('sys_dnsbl_'.BX_DOL_DNSBL_CHAIN_SPAMMERS, 'getAll', "SELECT `zonedomain`, `postvresp` FROM `sys_dnsbl_rules` WHERE `chain` = '".BX_DOL_DNSBL_CHAIN_SPAMMERS."' AND `active` = 1");

        if (!isset($GLOBALS['bx_dol_dnsbl_'.BX_DOL_DNSBL_CHAIN_WHITELIST]))
            $GLOBALS['bx_dol_dnsbl_'.BX_DOL_DNSBL_CHAIN_WHITELIST] = $GLOBALS['MySQL']->fromCache('sys_dnsbl_'.BX_DOL_DNSBL_CHAIN_WHITELIST, 'getAll', "SELECT `zonedomain`, `postvresp` FROM `sys_dnsbl_rules` WHERE `chain` = '".BX_DOL_DNSBL_CHAIN_WHITELIST."' AND `active` = 1");

        if (!isset($GLOBALS['bx_dol_dnsbl_'.BX_DOL_DNSBL_CHAIN_URIDNS]))
            $GLOBALS['bx_dol_dnsbl_'.BX_DOL_DNSBL_CHAIN_URIDNS] = $GLOBALS['MySQL']->fromCache('sys_dnsbl_'.BX_DOL_DNSBL_CHAIN_URIDNS, 'getAll', "SELECT `zonedomain`, `postvresp` FROM `sys_dnsbl_rules` WHERE `chain` = '".BX_DOL_DNSBL_CHAIN_URIDNS."' AND `active` = 1");

        $this->aChains[BX_DOL_DNSBL_CHAIN_SPAMMERS] = &$GLOBALS['bx_dol_dnsbl_'.BX_DOL_DNSBL_CHAIN_SPAMMERS];
        $this->aChains[BX_DOL_DNSBL_CHAIN_WHITELIST] = &$GLOBALS['bx_dol_dnsbl_'.BX_DOL_DNSBL_CHAIN_WHITELIST];
        $this->aChains[BX_DOL_DNSBL_CHAIN_URIDNS] = &$GLOBALS['bx_dol_dnsbl_'.BX_DOL_DNSBL_CHAIN_URIDNS];

    }

}
