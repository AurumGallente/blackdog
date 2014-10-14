<?php $mixedData=array (
  'all' => 
  array (
    'capt' => 'Members',
    'query' => 'SELECT COUNT(`ID`) FROM `Profiles` WHERE `Status`=\'Active\' AND (`Couple`=\'0\' OR `Couple`>`ID`)',
    'link' => 'browse.php',
    'icon' => 'user',
    'adm_query' => 'SELECT COUNT(`ID`) FROM `Profiles` WHERE `Status`=\'Approval\' AND (`Couple`=\'0\' OR `Couple`>`ID`)',
    'adm_link' => '{admin_url}profiles.php?action=browse&by=status&value=approval',
  ),
); ?>