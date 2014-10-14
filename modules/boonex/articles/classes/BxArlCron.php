<?php
/**
 *  
 *  
 */

bx_import('BxDolTextCron');

class BxArlCron extends BxDolTextCron
{
    function BxArlCron()
    {
        parent::BxDolTextCron();

        $this->_oModule = BxDolModule::getInstance('BxArlModule');
    }
}
