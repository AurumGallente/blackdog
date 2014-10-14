<?php
/**
 *  
 *  
 */

bx_import ('BxDolTwigCalendar');

class BxGroupsCalendar extends BxDolTwigCalendar
{
    function BxGroupsCalendar ($iYear, $iMonth, &$oDb, &$oConfig, &$oTemplate)
    {
        parent::BxDolTwigCalendar($iYear, $iMonth, $oDb, $oConfig);
    }

    function getEntriesNames ()
    {
        return array(_t('_bx_groups_group_single'), _t('_bx_groups_group_plural'));
    }
}
