<?php
/**
 *  
 *  
 */

bx_import('BxDolFilesCalendar');

class BxFilesCalendar extends BxDolFilesCalendar
{
    function BxFilesCalendar ($iYear, $iMonth, &$oDb, &$oTemplate, &$oConfig)
    {
        parent::BxDolFilesCalendar($iYear, $iMonth, $oDb, $oTemplate, $oConfig);
    }
}
