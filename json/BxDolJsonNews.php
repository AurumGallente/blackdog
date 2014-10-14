<?php

/**
 * Copyright (c) AKrishtopin - anton.krishtopin@gmail.com
 */
class BxDolJsonNews {

    // Get News JUST TRYING
    function getGroupsFeed($sUser, $sPwd) {

        $oNews = BxDolModule::getInstance('BxGroupsModule');
        $result = $oNews->ApiGetGroups();

        foreach ($result as $item) {
            $aData = array(
                'id' => (int) $item['id'],
                'title' => (string) $item['title'],
                'desc' => (string) strip_tags($item['desc']),
                'Date' => defineTimeInterval($item['created']),
                'author' => (string) $item['bx_if:full']['content']['author'],
                'country' => (string) $item['country'],
                'city' => (string) $item['city'],
                'fans_count' => (int) $item['fans_count'],
                'categories' => (string) $item['categories'],
                'tags' => (string) $item['tags'],
//                'thumb_img' => (string) $item['thumb_url'],
                'img' => (string) $item['thumb_url'],
            );
            $aList[] = $aData;
        }
        return $aList;
    }

    // Get Events
    function getEventsFeed($sUser, $iGroupId) {

        $oNews = BxDolModule::getInstance('BxEventsModule');
        $result = $oNews->getAllEvents($iGroupId);

        foreach ($result as $item) {
            $aData = array(
                'id' => (int) $item['ID'],
                'title' => (string) $item['Title'],
                'desc' => (string) strip_tags($item['Description']),
                'Date' => defineTimeInterval($item['EventStart']),                
            );
            $aList[] = $aData;
        }
        return $aList;
    }

    function getEventsByBeaconId($sId) {
        //ALTER TABLE `bx_events_main` ADD `beacon` VARCHAR(20) NOT NULL ;
        $oEv = BxDolModule::getInstance('BxEventsModule');
        $result = $oEv->getEventsByBeaconId($sId);
        foreach ($result as $item) {
            $aData = array(
                'id' => $item['ID'],
                'title' => $item['Title'],
                'desc' => strip_tags($item['Description']),
            );
            $aList[] = $aData;
        }
        return $aList;
    }

    function createEvent($sUser, $sTitle, $sDesc, $sPlace, $iGroup) {
                
        $oEv = BxDolModule::getInstance('BxEventsModule');
        $iId = BxDolJsonUtil::getIdByNickname($sUser);
        $result = $oEv->ApiAddEvent($sTitle, $sDesc, $sPlace, $iGroup, $iId);

        return array('createEvent' => 1);
    }

    function createGroup($sUser, $sTitle, $sDesc) {                        
       
        $sUri = uriGenerate($sTitle, 'bx_groups_main', 'uri');                
        $oEv = BxDolModule::getInstance('BxGroupsModule');
        $iId = BxDolJsonUtil::getIdByNickname($sUser);
        
        $result = $oEv->ApiAddGroup($sTitle, $sUri, $sDesc, $iId);
        
        return array('createGroup' => 1);
    }
}
