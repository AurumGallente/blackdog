<?php $mixedData=array (
  'alerts' => 
  array (
    'system' => 
    array (
      'begin' => 
      array (
        0 => '1',
      ),
    ),
    'profile' => 
    array (
      'before_join' => 
      array (
        0 => '2',
      ),
      'join' => 
      array (
        0 => '2',
        1 => '3',
        2 => '4',
      ),
      'before_login' => 
      array (
        0 => '2',
      ),
      'login' => 
      array (
        0 => '2',
      ),
      'logout' => 
      array (
        0 => '2',
      ),
      'edit' => 
      array (
        0 => '2',
        1 => '3',
        2 => '4',
      ),
      'delete' => 
      array (
        0 => '3',
        1 => '4',
      ),
      'change_status' => 
      array (
        0 => '4',
      ),
      'commentRemoved' => 
      array (
        0 => '5',
      ),
    ),
  ),
  'handlers' => 
  array (
    1 => 
    array (
      'class' => 'BxDolAlertsResponseSystem',
      'file' => 'inc/classes/BxDolAlertsResponseSystem.php',
      'eval' => '',
    ),
    2 => 
    array (
      'class' => 'BxDolAlertsResponseProfile',
      'file' => 'inc/classes/BxDolAlertsResponseProfile.php',
      'eval' => '',
    ),
    3 => 
    array (
      'class' => 'BxDolUpdateMembersCache',
      'file' => 'inc/classes/BxDolUpdateMembersCache.php',
      'eval' => '',
    ),
    4 => 
    array (
      'class' => 'BxDolAlertsResponceMatch',
      'file' => 'inc/classes/BxDolAlertsResponceMatch.php',
      'eval' => '',
    ),
    5 => 
    array (
      'class' => 'BxDolVideoDeleteResponse',
      'file' => 'flash/modules/video_comments/inc/classes/BxDolVideoDeleteResponse.php',
      'eval' => '',
    ),
  ),
); ?>