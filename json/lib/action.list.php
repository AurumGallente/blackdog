<?

$actions = array(
    // util

    "dolphin.concat" => array(
        "function" => "BxDolJsonUtil::concat",
        "params" => array('string', 'string', 'string'),
        "docstring" => "concat two strings",
    ),
    "dolphin.getContacts" => array(
        "function" => "BxDolJsonUtil::getContacts",
        "params" => array('array', 'string', 'string'),
        "docstring" => "get user contacts",
    ),
    "dolphin.getCountries" => array(
        "function" => "BxDolJsonUtil::getCountries",
        "params" => array('array', 'string', 'string', 'string'),
        "docstring" => "get countries list",
    ),
    "dolphin.service" => array(
        "function" => "BxDolJsonUtil::service",
        "params" => array('string', 'string', 'string', 'array', 'string'),
        "docstring" => "perform serice call",
    ),
    // user related
    "dolphin.login" => array(
        "function" => "BxDolJsonUser::login",
        "params" => array('integer', 'string', 'string'),
        "docstring" => "returns user id on success or 0 if login failed",
    ),
    "dolphin.login2" => array(
        "function" => "BxDolJsonUser::login2",
        "params" => array('integer', 'string', 'string'),
        "docstring" => "returns user id on success or 0 if login failed (v.2)",
    ),
    "dolphin.login4" => array(
        "function" => "BxDolJsonUser::login4",
        "params" => array('integer', 'string', 'string'),
        "docstring" => "returns user id on success or 0 if login failed (v.4)",
    ),
    "dolphin.getHomepageInfo" => array(
        "function" => "BxDolJsonUser::getHomepageInfo",
        "params" => array('struct', 'string', 'string'),
        "docstring" => "return logged in user information to dispay on homepage",
    ),
    "dolphin.getHomepageInfo2" => array(
        "function" => "BxDolJsonUser::getHomepageInfo2",
        "params" => array('struct', 'string', 'string', 'string'),
        "docstring" => "return logged in user information to dispay on homepage (v.2)",
    ),
    "dolphin.getUserInfo" => array(
        "function" => "BxDolJsonUser::getUserInfo",
        "params" => array('struct', 'string', 'string', 'string', 'string'),
        "docstring" => "return user information",
    ),
    "dolphin.getUserInfo2" => array(
        "function" => "BxDolJsonUser::getUserInfo2",
        "params" => array('struct', 'string', 'string', 'string', 'string'),
        "docstring" => "return user information (v.2)",
    ),
    "dolphin.getUserInfoExtra" => array(
        "function" => "BxDolJsonUser::getUserInfoExtra",
        "params" => array('array', 'string', 'string', 'string', 'string'),
        "docstring" => "return extended users information",
    ),
    "dolphin.updateStatusMessage" => array(
        "function" => "BxDolJsonUser::updateStatusMessage",
        "params" => array('string', 'string', 'string', 'string'),
        "docstring" => "update user status message, returns 0 on error, or 1 on success",
    ),
    "dolphin.getUserLocation" => array(
        "function" => "BxDolJsonUser::getUserLocation",
        "params" => array('struct', 'string', 'string', 'string'),
        "docstring" => "get user location, returns struct on succees, 0 on error, -1 on access denied",
    ),
    "dolphin.updateUserLocation" => array(
        "function" => "BxDolJsonUser::updateUserLocation",
        "params" => array('string', 'string', 'string', 'string', 'string', 'string', 'string'),
        "docstring" => "update user location, returns 1 on succees, 0 on error",
    ),
    // messages
    "dolphin.getMessagesInbox" => array(
        "function" => "BxDolJsonMessages::getMessagesInbox",
        "params" => array('array', 'string', 'string'),
        "docstring" => "get user's inbox messages",
    ),
    "dolphin.getMessagesSent" => array(
        "function" => "BxDolJsonMessages::getMessagesSent",
        "params" => array('array', 'string', 'string'),
        "docstring" => "get user's sent messages",
    ),
    "dolphin.getMessageInbox" => array(
        "function" => "BxDolJsonMessages::getMessageInbox",
        "params" => array('struct', 'string', 'string', 'string'),
        "docstring" => "get user's inbox message",
    ),
    "dolphin.getMessageSent" => array(
        "function" => "BxDolJsonMessages::getMessageSent",
        "params" => array('struct', 'string', 'string', 'string'),
        "docstring" => "get user's sent message",
    ),
    "dolphin.sendMessage" => array(
        "function" => "BxDolJsonMessages::sendMessage",
        "params" => array('struct', 'string', 'string', 'string', 'string', 'string', 'string'),
        "docstring" => "send message",
    ),
    "dolphin.getMessagesDialog" => array(
        "function" => "BxDolJsonMessages::getMessagesDialog",
        "params" => array('array', 'string', 'string', 'string'),
        "docstring" => "get dialog messages",
    ),
    // search
    "dolphin.getSeachHomeMenu3" => array(
        "function" => "BxDolJsonSearch::getSeachHomeMenu3",
        "params" => array('struct', 'string', 'string', 'string'),
        "docstring" => "get search homepage menu",
    ),
    "dolphin.getSearchResultsLocation" => array(
        "function" => "BxDolJsonSearch::getSearchResultsLocation",
        "params" => array('array', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string'),
        "docstring" => "get search results by location",
    ),
    "dolphin.getSearchResultsKeyword" => array(
        "function" => "BxDolJsonSearch::getSearchResultsKeyword",
        "params" => array('array', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string'),
        "docstring" => "get search results by keyword",
    ),
    "dolphin.getSearchResultsNearMe" => array(
        "function" => "BxDolJsonSearch::getSearchResultsNearMe",
        "params" => array('array', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string'),
        "docstring" => "get search results near specified location",
    ),
    // friends
    "dolphin.getFriends" => array(
        "function" => "BxDolJsonFriends::getFriends",
        "params" => array('array', 'string', 'string', 'string', 'string'),
        "docstring" => "get user's friends",
    ),
    "dolphin.getFriendRequests" => array(
        "function" => "BxDolJsonFriends::getFriendRequests",
        "params" => array('array', 'string', 'string', 'string'),
        "docstring" => "get friend requests",
    ),
    "dolphin.declineFriendRequest" => array(
        "function" => "BxDolJsonFriends::declineFriendRequest",
        "params" => array('string', 'string', 'string', 'string'),
        "docstring" => "decline friend request",
    ),
    "dolphin.acceptFriendRequest" => array(
        "function" => "BxDolJsonFriends::acceptFriendRequest",
        "params" => array('string', 'string', 'string', 'string'),
        "docstring" => "accept friend request",
    ),
    "dolphin.removeFriend" => array(
        "function" => "BxDolJsonFriends::removeFriend",
        "params" => array('string', 'string', 'string', 'string'),
        "docstring" => "remove friend",
    ),
    "dolphin.addFriend" => array(
        "function" => "BxDolJsonFriends::addFriend",
        "params" => array('string', 'string', 'string', 'string', 'string'),
        "docstring" => "add friend",
    ),
    // images
    /*
      "dolphin.getImages" => array(
      "function" => "BxDolJsonImages::getImages",
      "params" => array (array ('array', 'string', 'string', 'string')),
      "docstring" => "get profile's images",
      ),
     */
    "dolphin.removeImage" => array(
        "function" => "BxDolJsonImages::removeImage",
        "params" => array('string', 'string', 'string', 'string'),
        "docstring" => "remove user image by id",
    ),
    "dolphin.makeThumbnail" => array(
        "function" => "BxDolJsonImages::makeThumbnail",
        "params" => array('string', 'string', 'string', 'string'),
        "docstring" => "make primary image by image id",
    ),
    "dolphin.getImageAlbums" => array(
        "function" => "BxDolJsonImages::getImageAlbums",
        "params" => array('array', 'string', 'string', 'string'),
        "docstring" => "get profile's images albums",
    ),
    "dolphin.uploadImage" => array(
        "function" => "BxDolJsonImages::uploadImage",
        "params" => array('string', 'string', 'string', 'string', 'base64', 'string', 'string', 'string', 'string'),
        "docstring" => "upload new image",
    ),
    "dolphin.getImagesInAlbum" => array(
        "function" => "BxDolJsonImages::getImagesInAlbum",
        "params" => array('array', 'string', 'string', 'string', 'string'),
        "docstring" => "get profile's images in specified album",
    ),
    // audio
    "dolphin.removeAudio" => array(
        "function" => "BxDolJsonMediaAudio::removeAudio5",
        "params" => array('string', 'string', 'string', 'string'),
        "docstring" => "remove user sound by id (v.5)",
    ),
    "dolphin.getAudioAlbums" => array(
        "function" => "BxDolJsonMediaAudio::getAudioAlbums",
        "params" => array('array', 'string', 'string', 'string'),
        "docstring" => "get profile's sound albums",
    ),
    "dolphin.getAudioInAlbum" => array(
        "function" => "BxDolJsonMediaAudio::getAudioInAlbum",
        "params" => array('array', 'string', 'string', 'string', 'string'),
        "docstring" => "get profile's sounds in specified album",
    ),
    // video
    "dolphin.removeVideo" => array(
        "function" => "BxDolJsonMediaVideo::removeVideo5",
        "params" => array('string', 'string', 'string', 'string'),
        "docstring" => "remove user video by id (v.5)",
    ),
    "dolphin.getVideoAlbums" => array(
        "function" => "BxDolJsonMediaVideo::getVideoAlbums",
        "params" => array('array', 'string', 'string', 'string'),
        "docstring" => "get profile's video albums",
    ),
    "dolphin.uploadVideo" => array(
        "function" => "BxDolJsonMediaVideo::uploadVideo5",
        "params" => array('string', 'string', 'string', 'string', 'base64', 'string', 'string', 'string', 'string', 'string'),
        "docstring" => "upload new video (v.5)",
    ),
    "dolphin.getVideoInAlbum" => array(
        "function" => "BxDolJsonMediaVideo::getVideoInAlbum",
        "params" => array('array', 'string', 'string', 'string', 'string'),
        "docstring" => "get profile's video in specified album",
    ),
    // Custom webber part - try to get some groups
    "dolphin.getNews" => array(
        "function" => "BxDolJsonNews::getNewsFeed",
        "params" => array('integer'),
        "docstring" => "get all news",
    ),
    // Events API
    "dolphin.getGroupsFeed" => array(
        "function" => "BxDolJsonNews::getGroupsFeed",
        "params" => array(),
        "docstring" => "get groups",
    ),

    "dolphin.getEventsFeed" => array(
        "function" => "BxDolJsonNews::getEventsFeed",
        "params" => array('integer'),
        "docstring" => "get all events",
    ),

    "dolphin.getEventsByBeaconId" => array(
        "function" => "BxDolJsonNews::getEventsByBeaconId",
        "params" => array('string'),
        "docstring" => "get all events By Beacon Id",
    ),
    "dolphin.createNewEvent" => array(
        "function" => "BxDolJsonNews::createEvent",
        "params" => array('string','string','string','integer'),
        "docstring" => "create a new event",
    ),    
    "dolphin.createNewGroup" => array(
        "function" => "BxDolJsonNews::createGroup",
        "params" => array('string','string','string'),
        "docstring" => "create a new group",
    ),
    // Creating Profile API
    "dolphin.registerNewMember" => array(
        "function" => "BxDolJsonUser::registerNewMember",
        "params" => array('string','string','string','string','string','string'),
        "docstring" => "register a new boonex user",
    ),
    
);
