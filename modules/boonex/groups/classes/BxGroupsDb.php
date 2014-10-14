<?php
/**
 *  
 *  
 */

bx_import('BxDolTwigModuleDb');

/*
 * Groups module Data
 */
class BxGroupsDb extends BxDolTwigModuleDb
{
    /*
     * Constructor.
     */
    function BxGroupsDb(&$oConfig)
    {
        parent::BxDolTwigModuleDb($oConfig);

        $this->_sTableMain = 'main';
        $this->_sTableMediaPrefix = '';
        $this->_sFieldId = 'id';
        $this->_sFieldAuthorId = 'author_id';
        $this->_sFieldUri = 'uri';
        $this->_sFieldTitle = 'title';
        $this->_sFieldDescription = 'desc';
        $this->_sFieldTags = 'tags';
        $this->_sFieldThumb = 'thumb';
        $this->_sFieldStatus = 'status';
        $this->_sFieldFeatured = 'featured';
        $this->_sFieldCreated = 'created';
        $this->_sFieldJoinConfirmation = 'join_confirmation';
        $this->_sFieldFansCount = 'fans_count';
        $this->_sTableFans = 'fans';
        $this->_sTableAdmins = 'admins';
        $this->_sFieldAllowViewTo = 'allow_view_group_to';
    }

    function deleteEntryByIdAndOwner ($iId, $iOwner, $isAdmin)
    {
        if ($iRet = parent::deleteEntryByIdAndOwner ($iId, $iOwner, $isAdmin)) {
            $this->query ("DELETE FROM `" . $this->_sPrefix . "fans` WHERE `id_entry` = $iId");
            $this->query ("DELETE FROM `" . $this->_sPrefix . "admins` WHERE `id_entry` = $iId");
            $this->deleteEntryMediaAll ($iId, 'images');
            $this->deleteEntryMediaAll ($iId, 'videos');
            $this->deleteEntryMediaAll ($iId, 'sounds');
            $this->deleteEntryMediaAll ($iId, 'files');
        }
        return $iRet;
    }

   // Get all Groups (news)
    function GetAllNews() {
        return $this->getAll("SELECT * FROM `" . $this->_sPrefix . "main`");
    }

    function GetUserProfile($sId) {
        $sId = process_db_input($sId);
        return $this->getAll('SELECT * FROM `Profiles` WHERE `ID` = "' . $sId . '"');
    }

    function getGroupById($sId) {
        $sId = process_db_input($sId);
        return $this->getAll('SELECT * FROM `' . $this->_sPrefix . 'main` WHERE `ID` = "' . $sId . '"');
    }    

    function ApiAddGroup($sTitle, $sUri, $sDesc, $iUser){                        
        $sqlQuery = "INSERT INTO bx_groups_main (title, uri, `desc`, status, thumb, created, author_id, tags, categories, allow_view_group_to, allow_view_fans_to, allow_comment_to, allow_rate_to, allow_post_in_forum_to, allow_join_to) "
                . "VALUES ('$sTitle','$sUri','$sDesc','approved',0,UNIX_TIMESTAMP(NOW()),$iUser,' ',' ',3,3,'f','f','f',3)";
        return mysql_query($sqlQuery);
    }  
}
