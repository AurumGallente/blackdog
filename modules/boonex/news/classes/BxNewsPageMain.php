<?php
/**
 *  
 *  
 */

bx_import('BxDolTextPageMain');

class BxNewsPageMain extends BxDolTextPageMain
{
    function BxNewsPageMain(&$oObject)
    {
        parent::BxDolTextPageMain('news_home', $oObject);
    }
}
