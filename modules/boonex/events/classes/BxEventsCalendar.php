<?php
/**
 *  
 *  
 */

bx_import ('BxDolTwigCalendar');

class BxEventsCalendar extends BxDolTwigCalendar
{
    var $oTemplate;

    function BxEventsCalendar ($iYear, $iMonth, &$oDb, &$oConfig, &$oTemplate)
    {
        parent::BxDolTwigCalendar($iYear, $iMonth, $oDb, $oConfig);
        $this->oTemplate = &$oTemplate;
    }

    function getEntriesNames ()
    {
        return array(_t('_bx_events_single'), _t('_bx_events_plural'));
    }

}
