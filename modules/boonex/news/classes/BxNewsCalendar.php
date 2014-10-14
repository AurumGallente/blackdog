<?php

/**
 *  
 *  
 */

bx_import('BxDolTextCalendar');

class BxNewsCalendar extends BxDolTextCalendar
{
    function BxNewsCalendar($iYear, $iMonth, &$oDb, &$oConfig)
    {
        parent::BxDolTextCalendar($iYear, $iMonth, $oDb, $oConfig);

        $this->sCssPrefix = 'news';
    }
}
