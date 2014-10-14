<?php
/**
 *  
 *  
 */

class BxDolIO
{
    // constructor
    function BxDolIO() {}

    function isExecutable($sFile)
    {
        clearstatcache();

        $aPathInfo = pathinfo(__FILE__);
        $sFile = $aPathInfo['dirname'] . '/../../' . $sFile;

        return (is_file($sFile) && is_executable($sFile));
    }

    function isWritable($sFile, $sPrePath = '/../../')
    {
        clearstatcache();

        $aPathInfo = pathinfo(__FILE__);
        $sFile = $aPathInfo['dirname'] . '/../../' . $sFile;

        return is_readable($sFile) && is_writable($sFile);
    }

    function getPermissions($sFileName)
    {
        $sPath = $GLOBALS['logged']['admin'] == true ? BX_DIRECTORY_PATH_ROOT : '../';

        clearstatcache();
        $hPerms = @fileperms($sPath . $sFileName);
        if($hPerms == false) return false;
        $sRet = substr( decoct( $hPerms ), -3 );
        return $sRet;
    }
}
