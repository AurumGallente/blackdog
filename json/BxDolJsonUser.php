<?php
//include_once("../inc/db.inc.php");
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */
//define('BX_XMLRPC_PROTOCOL_VER', 5);

class BxDolJsonUser {

    function login($sUser, $sPwd) {
        $iId = BxDolJsonUtil::checkLogin($sUser, $sPwd);
        return (int) $iId;
    }

    function login4($sUser, $sPwdClear) {
        $iId = 0;
        $aProfileInfo = getProfileInfo(getID($sUser));
        if ($aProfileInfo && ((32 == strlen($sPwdClear) || 40 == strlen($sPwdClear)) && BxDolJsonUtil::checkLogin($sUser, $sPwdClear)))
            $iId = $aProfileInfo['ID'];
        elseif ($aProfileInfo && check_password($aProfileInfo['ID'], $sPwdClear, BX_DOL_ROLE_MEMBER, false))
            $iId = $aProfileInfo['ID'];

        return array(
            'member_id' => (int) $iId,
            'member_pwd_hash' => (string) $iId ? $aProfileInfo['Password'] : "",
            'member_username' => (string) $iId ? getUsername($iId) : "",
        );
    }

    function login2($sUser, $sPwd) {
        $iId = BxDolJsonUtil::checkLogin($sUser, $sPwd);
        return array(
            'member_id' => (int) $iId,
        );
    }

    //-------------- need to replace to JSON
    function updateUserLocation($sUser, $sPwd, $sLat, $sLng, $sZoom, $sMapType) {
        if (!($iId = BxDolXMLRPCUtil::checkLogin($sUser, $sPwd)) || !preg_match('/^[A-Za-z0-9]*$/', $sMapType))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1, "int")), "struct"));

        $iRet = BxDolService::call('wmap', 'update_location_manually', array('profiles', $iId, (float) $sLat, (float) $sLng, (int) $sZoom, $sMapType)) ? '1' : '0';

        return new xmlrpcresp(new xmlrpcval(true === $iRet ? true : false));
    }

    function getUserLocation($sUser, $sPwd, $sNick) {
        if (!($iId = BxDolXMLRPCUtil::checkLogin($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1, "int")), "struct"));

        $iProfileId = getID($sNick, false);
        $aLocation = BxDolService::call('wmap', 'get_location', array('profiles', $iProfileId, $iId));
        if (-1 == $aLocation) // access denied
            return new xmlrpcval("-1");
        if (!is_array($aLocation)) // location is undefined
            return new xmlrpcval("0");

        return new xmlrpcval(array(
            'lat' => new xmlrpcval($aLocation['lat']),
            'lng' => new xmlrpcval($aLocation['lng']),
            'zoom' => new xmlrpcval($aLocation['zoom']),
            'type' => new xmlrpcval($aLocation['type']),
            'address' => new xmlrpcval($aLocation['address']),
            'country' => new xmlrpcval($aLocation['country']),
                ), 'struct');
    }

    function getHomepageInfo($sUser, $sPwd) {
        if (!($iId = BxDolXMLRPCUtil::checkLogin($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1, "int")), "struct"));

        $aRet = BxDolXMLRPCUtil::getUserInfo($iId);

        $aRet['unreadLetters'] = new xmlrpcval(getNewLettersNum($iId));
        $aFriendReq = db_arr("SELECT count(*) AS `num` FROM `sys_friend_list` WHERE `Profile` = {$iId} AND  `Check` = '0'");
        $aRet['friendRequests'] = new xmlrpcval($aFriendReq['num']);

        return new xmlrpcval($aRet, "struct");
    }

    function getHomepageInfo2($sUser, $sPwd, $sLang) {
        if (!($iId = BxDolXMLRPCUtil::checkLogin($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1, "int")), "struct"));

        BxDolXMLRPCUtil::setLanguage($sLang);

        $aRet = BxDolXMLRPCUtil::getUserInfo($iId);

        $aMarkersReplace = array(
            'member_id' => $iId,
            'member_username' => $sUser,
            'member_password' => $sPwd,
        );
        $aRet['menu'] = new xmlrpcval(BxDolXMLRPCUtil::getMenu('homepage', $aMarkersReplace), 'array');

        bx_import('BxDolMemberInfo');
        $oMemberInfo = BxDolMemberInfo::getObjectInstance(getParam('sys_member_info_thumb'));
        $aRet['search_with_photos'] = new xmlrpcval($oMemberInfo->isAvatarSearchAllowed() ? 1 : 0);

        return new xmlrpcval($aRet, "struct");
    }

    function getUserInfo2($sUser, $sPwd, $sNick, $sLang) {
        $iIdProfile = BxDolXMLRPCUtil::getIdByNickname($sNick);
        if (!$iIdProfile || !($iId = BxDolXMLRPCUtil::checkLogin($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1, "int")), "struct"));

        BxDolXMLRPCUtil::setLanguage($sLang);

        $mixedRet = BxDolXMLRPCUser::_checkUserPrivacy($iId, $iIdProfile);
        if (true !== $mixedRet)
            return $mixedRet;

        $aRet['info'] = new xmlrpcval(BxDolXMLRPCUtil::getUserInfo($iIdProfile, 0, false), "struct");

        $aMarkersReplace = array(
            'member_id' => $iId,
            'member_username' => $sUser,
            'member_password' => $sPwd,
            'profile_id' => $iIdProfile,
            'profile_username' => $sNick,
        );
        $aRet['menu'] = new xmlrpcval(BxDolXMLRPCUtil::getMenu('profile', $aMarkersReplace), 'array');

        return new xmlrpcval($aRet, "struct");
    }
    
    function getIdByNickname ($sUser)
    {
        $sUser = process_db_input($sUser, BX_TAGS_NO_ACTION, BX_SLASHES_NO_ACTION);
        return (int)db_value("SELECT `ID` FROM `Profiles` WHERE `NickName` = '$sUser' LIMIT 1");
    }
    
    function getUserInfo($sUser, $sPwd, $sNick, $sLang) {
        $iIdProfile = BxDolJsonUtil::getIdByNickname($sNick);
        if (!$iIdProfile || !($iId = BxDolJsonUtil::checkLogin($sUser, $sPwd)))
            return array('error' => 1);

        BxDolXMLRPCUtil::setLanguage($sLang);
        $mixedRet = BxDolXMLRPCUser::_checkUserPrivacy($iId, $iIdProfile);
        if (true !== $mixedRet)
            return $mixedRet;
                       
        $aRet = BxDolJsonUtil::getUserInfo($iIdProfile, 0, true);
        return $aRet;
    }

    function _checkUserPrivacy($iId, $iIdProfile) {
        $mixedAccessDenied = false;

        if ($iIdProfile != $iId) {
            // membership
            $aCheckRes = checkAction($iId, ACTION_ID_VIEW_PROFILES, true, $iIdProfile);
            if ($aCheckRes[CHECK_ACTION_RESULT] != CHECK_ACTION_RESULT_ALLOWED)
                $mixedAccessDenied = strip_tags($aCheckRes[CHECK_ACTION_MESSAGE]);

            // privacy
            if (false === $mixedAccessDenied) {
                bx_import('BxDolPrivacy');
                $oPrivacy = new BxDolPrivacy('Profiles', 'ID', 'ID');
                if ($iIdProfile != $iId && !$oPrivacy->check('view', $iIdProfile, $iId))
                    $mixedAccessDenied = '-1';
            }
        }

        bx_import('BxDolAlerts');
        $oZ = new BxDolAlerts('mobile', 'view_profile', $iIdProfile, $iId, array('access_denied' => &$mixedAccessDenied));
        $oZ->alert();

        if (false !== $mixedAccessDenied)
            return new xmlrpcval($mixedAccessDenied);

        return true;
    }

    function getUserInfoExtra($sUser, $sPwd, $sNick, $sLang) {
        $iIdProfile = BxDolXMLRPCUtil::getIdByNickname($sNick);
        if (!$iIdProfile || !($iId = BxDolXMLRPCUtil::checkLogin($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1, "int")), "struct"));

        BxDolXMLRPCUtil::setLanguage($sLang);

        $o = new BxDolXMLRPCProfileView($iIdProfile, $iId);
        return $o->getProfileInfoExtra();
    }

    function updateStatusMessage($sUser, $sPwd, $sStatusMsg) {
        if (!($iId = BxDolXMLRPCUtil::checkLogin($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1, "int")), "struct"));

        ob_start();
        $_GET['action'] = '1';
        require_once( BX_DIRECTORY_PATH_ROOT . 'list_pop.php' );
        ob_end_clean();

        $_POST['status_message'] = $sStatusMsg;
        ActionChangeStatusMessage($iId);

        return new xmlrpcresp(new xmlrpcval($iRet, "int"));
    }

    //---------------------------end of unchanged area 
            
    function registerNewMember($sUserName, $sFirstName, $sLastName, $sPwd, $sPwdConfirm, $sEmail) {

        $sParams = 'NickName[0]='.$sUserName.'&FirstName[0]='.$sFirstName.'&LastName[0]='.$sLastName.'&Password[0]='.$sPwd.'&Password_confirm[0]='.$sPwdConfirm.'&Email[0]='.$sEmail.'&join_page=done';
        $sParams = str_replace('"', '', $sParams);

        if (strcmp($sPwd, $sPwdConfirm) == 0) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://boonex/join.php');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $sParams);
            $out = curl_exec($curl);
                        
            if (curl_errno($curl)) {
                print curl_error($curl);
            } else {
                curl_close($curl);
            }
            preg_match("/<span id=\"(.*?)\"><\/span>/",$out,$match);
            $iUserId = $match[1];            
            BxDolJsonUtil::setMobileStatus($iUserId);
        }
        
        $par = BxDolJsonUtil::getLoginData($iUserId);
        return array(
                'login' => $par[0],
                'hash' => $par[1]
            );
    }

}
