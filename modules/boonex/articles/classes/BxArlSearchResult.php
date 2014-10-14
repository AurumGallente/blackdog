<?php
/**
 *  
 *  
 */

bx_import('BxDolTextSearchResult');

class BxArlSearchResult extends BxDolTextSearchResult
{
    function BxArlSearchResult($oModule = null)
    {
        $oModule = !empty($oModule) ? $oModule : BxDolModule::getInstance('BxArlModule');

        parent::BxDolTextSearchResult($oModule);
    }
}
