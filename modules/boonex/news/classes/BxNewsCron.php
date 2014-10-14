<?php
/**
 *  
 *  
 */

bx_import('BxDolTextCron');

class BxNewsCron extends BxDolTextCron
{
    function BxNewsCron()
    {
        parent::BxDolTextCron();

        $this->_oModule = BxDolModule::getInstance('BxNewsModule');
    }
}
