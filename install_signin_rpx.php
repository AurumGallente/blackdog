<?php
require_once( "inc/header.inc.php" );
require_once( BX_DIRECTORY_PATH_INC.'db.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'design.inc.php' );

db_res("INSERT INTO `sys_page_compose` (`ID`, `Page`, `PageWidth`, `Desc`, `Caption`, `Column`, `Order`, `Func`, `Content`, `DesignBox`, `ColWidth`, `Visible`, `MinWidth`) VALUES (NULL, 'index', '998px', 'Allow users to log in to your site by using their social media account', 'RPX SignIn', '2', '1', 'PHP', 'require_once(BX_DIRECTORY_PATH_ROOT.''thakkertech/rpx_signin/rpx_signin.php'');', '1', '445px', 'non,memb', '0');
			");
			
echo "Block for SignIn RPX created sucessfully<br>";


$maxOrder = db_value("SELECT max(`menu_order`) FROM `sys_options_cats` ;");
$maxOrder += 1;

db_res("INSERT INTO `sys_options_cats` (`name`, `menu_order`) VALUES ( 'SignIn RPX', $maxOrder );");
$ParamsCategId = mysql_insert_id();


db_res("INSERT INTO `sys_options` (`Name`, `VALUE`, `kateg`, `desc`, `Type`, `check`, `err_text`, `order_in_kateg`, `AvailableValues`) VALUES
 ('rpx_api_key', '', '{$ParamsCategId}', 'RPX  Api key', 'text', 'return strlen(\$arg0) > 0;', 'cannot be empty.', 1,''), 
 ('rpx_application_name', '', '{$ParamsCategId}', 'RPX  Application name (eg. \"applicationname\". This will be expanded to RPX Domain \"applicationname.rpxnow.com\" )', 'text', 'return strlen(\$arg0) > 0;', 'cannot be empty.', 2,''),
 ('rpx_show_type', 'POPUP', '{$ParamsCategId}', 'Select whether you want to show in ifame or in popup style', 'select', 'return strlen(\$arg0) > 0;', 'annot be empty.', 3, 'IFRAME,POPUP'),
 ('rpx_imagepath', '', '{$ParamsCategId}', 'Insert full path of image. for example http://www.yoursitename.com/path/imagename.jpg or IF NOT SPECIFIED IT WILL TAKE DEFAULT IMAGE', 'text', '', '', 4, ''),
 ('appy_image_width_height', '', '{$ParamsCategId}', 'Check whether to apply the height and width of module image', 'checkbox', '', '', 5, ''),
 ('rpx_image_width', '', '{$ParamsCategId}', 'Insert Image width in pixel or it takes default width', 'digit', '', '', 6, ''),
 ('rpx_image_height', '', '{$ParamsCategId}', 'Insert Image height in pixel or it takes default height', 'digit', '', '', 7, '')");

echo "SignIn RPX settings menu created Sucessfully!<br>Now Enter RPX Api key & Application name in RPX Settings section of Settings section in Admin panel ";



$arrMenuExit = db_arr("SELECT * FROM `sys_menu_admin` WHERE `name`='tht_settings';");

if(!$arrMenuExit['id'])
{
	$strAdmMenuMain =
	"
	INSERT INTO `sys_menu_admin` (`id`, `parent_id`, `name`, `title`, `url`, `description`, `icon`, `icon_large`, `check`, `order`) 
	VALUES (
	'','0' ,'tht_settings', 'ThT Mod Settings', '', 'Settings for mods created by thakkertech', 'tht_settings.png', '', '', '4'
	);

";
	db_res($strAdmMenuMain);
	$iLastMenuID = mysql_insert_id();
}
$parentID = $arrMenuExit['id'] ? $arrMenuExit['id'] :$iLastMenuID ;


$strAdmMenu =
"


INSERT INTO `sys_menu_admin` (`id`, `parent_id`, `name`, `title`, `url`, `description`, `icon`, `icon_large`, `check`, `order`) 
VALUES (
'','$parentID' ,'SignIn_RPX', 'SignIn RPX Settings', 'settings.php?cat=$ParamsCategId', 'This module will allow users to log in to your site by using their social media account.', 'mmi_advanced_settings.gif', '', '', '4'
);


";

db_res($strAdmMenu);
echo "Admin menu created for RPX SIGNIN settings <br>";


echo "<br><br>Sql file installed <b>Sucessfully</b>";
echo "<br>Now, Remove this file.<br>";

function createCache($sDBTable, $sCacheFile) {
		$sCacheString = '';
		
		$rCacheFile = @fopen( $sCacheFile, 'w' );
		if( !$rCacheFile ) {
			echo '<br /><b>Warning!</b> Cannot open Page View cache file (' . $sCacheFile . ') for write.';
			return false;
		}
		
		fwrite( $rCacheFile, "// cache of Page View composer\n\nreturn array(\n  //pages\n" );
		
		//get pages
		$sQuery = "SELECT `Page`,`PageWidth` FROM `{$sDBTable}` WHERE `Page` != '' GROUP BY `Page`";
		$rPages = db_res( $sQuery );
		
		while( $aPage = mysql_fetch_assoc( $rPages ) ) {
			$sPageName = $aPage['Page'];
			
			fwrite( $rCacheFile, "  '$sPageName' => array(\n" );
			fwrite( $rCacheFile, "    'Width' => '{$aPage['PageWidth']}',\n" );
			fwrite( $rCacheFile, "    'Columns' => array(\n" );
			
			//get columns
			$sQuery = "
				SELECT
					`Column`,
					`ColWidth`
				FROM `{$sDBTable}`
				WHERE
					`Page` = '$sPageName' AND
					`Column` > 0
				GROUP BY `Column`
				ORDER BY `Column`
			";
			$rColumns = db_res( $sQuery );
			
			while( $aColumn = mysql_fetch_assoc( $rColumns ) ) {
				$iColumn = $aColumn['Column'];
				$iColWidth  = $aColumn['ColWidth'];
				
				fwrite( $rCacheFile, "      $iColumn => array(\n" );
				fwrite( $rCacheFile, "        'Width'  => $iColWidth,\n" );
				fwrite( $rCacheFile, "        'Blocks' => array(\n" );
				
				//get blocks of column
				$sQuery = "
					SELECT
						`ID`,
						`Caption`,
						`Func`,
						`Content`,
						`DesignBox`,
						`Visible`
					FROM `{$sDBTable}`
					WHERE
						`Page` = '$sPageName' AND
						`Column` = $iColumn
					ORDER BY `Order` ASC
				";
				$rBlocks = db_res( $sQuery );
				
				while( $aBlock = mysql_fetch_assoc( $rBlocks ) ) {
					fwrite( $rCacheFile, "          {$aBlock['ID']} => array(\n" );
					
					fwrite( $rCacheFile, "            'Func'      => '{$aBlock['Func']}',\n" );
					fwrite( $rCacheFile, "            'Content'   => '" . addAllSlashes( $aBlock['Content'] ) . "',\n" );
					fwrite( $rCacheFile, "            'Caption'   => '" . addAllSlashes( $aBlock['Caption'] ) . "',\n" );
					fwrite( $rCacheFile, "            'Visible'   => '{$aBlock['Visible']}',\n" );
					fwrite( $rCacheFile, "            'DesignBox' => {$aBlock['DesignBox']}\n" );
					
					fwrite( $rCacheFile, "          ),\n" ); //close block
				}
				fwrite( $rCacheFile, "        )\n" ); //close blocks
				fwrite( $rCacheFile, "      ),\n" ); //close column
			}
			
			fwrite( $rCacheFile, "    )\n" ); //close columns
			fwrite( $rCacheFile, "  ),\n" ); //close page
		}
		
		fwrite( $rCacheFile, ");\n" ); //close main array
		
		fclose( $rCacheFile );
		return true;
	}
 
	function addAllSlashes( $sText ) {
		$sText = str_replace( '\\', '\\\\', $sText );
		$sText = str_replace( '\'', '\\\'', $sText );
		
		return $sText;
	}

if( createCache('sys_page_compose', 'cache/sys_page_compose.inc') )  
	echo "<span style=\"font-weight:bold;\">Pages were successfully recompiled.</span>";
else
	echo "<span style=\"font-weight:bold;\">Could not recompile pages. Please contact the mod developer  so he can help you.</span>";

echo "All is done <br> Please delete this file now";

?>