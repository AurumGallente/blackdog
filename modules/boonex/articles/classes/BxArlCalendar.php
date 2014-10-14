<?php

/**
 *  
 *  
 */

bx_import('BxDolTextCalendar');

class BxArlCalendar extends BxDolTextCalendar
{
    function BxArlCalendar($iYear, $iMonth, &$oDb, &$oConfig)
    {
        parent::BxDolTextCalendar($iYear, $iMonth, $oDb, $oConfig);

        $this->sCssPrefix = 'arl';
    }
}
