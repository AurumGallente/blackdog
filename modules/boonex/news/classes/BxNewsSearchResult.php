<?php
/**
 *  
 *  
 */

bx_import('BxDolTextSearchResult');

class BxNewsSearchResult extends BxDolTextSearchResult
{
    function BxNewsSearchResult($oModule = null)
    {
        $oModule = !empty($oModule) ? $oModule : BxDolModule::getInstance('BxNewsModule');

        parent::BxDolTextSearchResult($oModule);
    }
}
