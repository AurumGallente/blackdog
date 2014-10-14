<?php
require_once( "inc/header.inc.php" );
require_once( BX_DIRECTORY_PATH_INC.'db.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'design.inc.php' );

db_res("DELETE FROM `sys_page_compose` WHERE `Func` = 'PHP' AND `Content` = 'require_once(BX_DIRECTORY_PATH_ROOT.''thakkertech/rpx_signin/rpx_signin.php'');'		");
			
echo "Block for SignIn RPX REMOVED sucessfully<br>";



db_res("DELETE FROM `sys_options_cats` WHERE `name`= 'SignIn RPX' ");


db_res("DELETE FROM `sys_options` WHERE `Name` = 'rpx_api_key';");
db_res("DELETE FROM `sys_options` WHERE `Name` = 'rpx_application_name';");
db_res("DELETE FROM `sys_options` WHERE `Name` = 'rpx_show_type';");
db_res("DELETE FROM `sys_options` WHERE `Name` = 'rpx_imagepath';");
db_res("DELETE FROM `sys_options` WHERE `Name` = 'appy_image_width_height';");
db_res("DELETE FROM `sys_options` WHERE `Name` = 'rpx_image_width';");
db_res("DELETE FROM `sys_options` WHERE `Name` = 'rpx_image_height';");





$strAdmMenu =
"


DELETE FROM `sys_menu_admin` WHERE  `name` = 'SignIn_RPX';


";

db_res($strAdmMenu);
echo "Admin menu DELETED for RPX SIGNIN settings <br>";


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
	echo "<span style=\"font-weight:bold;\">Could not recompile pages. Please contact the mod developer (dolphinmods@gmail.com) so he can help you.</span>";

echo "All is done <br> Please delete this file now";

echo "<br>Now, Remove this file.<br>";
?>