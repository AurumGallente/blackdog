<?php
/**
 *  
 *  
 */

bx_import('BxDolTextPageMain');

class BxArlPageMain extends BxDolTextPageMain
{
    function BxArlPageMain(&$oObject)
    {
        parent::BxDolTextPageMain('articles_home', $oObject);
    }
}
