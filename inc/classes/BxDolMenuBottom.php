<?php

    /**
 *  
 *  
 */

    bx_import('BxTemplMenuSimple');

    /**
     * Bottom menu
     *
     * Related classes:
     *  @see BxBaseMenuBottom - bottom menu base representation
     *  @see BxTemplMenuBottom - bottom menu template representation
     *
     * Table structure - `sys_menu_bottom`;
     *
     * Memberships/ACL:
     * no levels
     *
     * Alerts:
     * no alerts
     */
    class BxDolMenuBottom extends BxTemplMenuSimple
    {
        function BxDolMenuBottom()
        {
            parent::BxTemplMenuSimple();

            $this->sName = 'bottom';
            $this->sDbTable = 'sys_menu_bottom';
            $this->sCacheKey = 'sys_menu_bottom';
        }
    }
