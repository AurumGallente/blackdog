<?php

/**
 *  
 *  
 */

bx_import('BxDolPrivacy');

class BxBlogsPrivacy extends BxDolPrivacy
{
    /**
    * Constructor
    */
    function BxBlogsPrivacy(&$oModule)
    {
        parent::BxDolPrivacy('bx_blogs_posts', 'PostID', 'OwnerID');
    }

    /**
    * Get database field name for action.
    *
    * @param string $sAction action name.
    * @return string with field name.
    */
    function getFieldAction($sAction)
    {
        return 'allow' . str_replace(' ', '', ucwords(str_replace('_', ' ', $sAction)));
    }
}
