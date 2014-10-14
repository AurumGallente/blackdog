<?php
/**
 *  
 *  
 */

bx_import('BxDolAlerts');

class BxDolAlertsResponseSystem extends BxDolAlertsResponse
{
    function BxDolAlertsResponseSystem()
    {
        parent::BxDolAlertsResponse();
    }

    function response($oAlert)
    {
        $sMethodName = '_process' . ucfirst($oAlert->sUnit) . str_replace(' ', '', ucwords(str_replace('_', ' ', $oAlert->sAction)));
        if(method_exists($this, $sMethodName))
            $this->$sMethodName($oAlert);
    }

    function _processSystemBegin($oAlert) {}
}
