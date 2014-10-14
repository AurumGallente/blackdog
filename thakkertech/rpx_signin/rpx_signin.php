<?php
global $site;
$sCode = '';
		ob_start();
		require_once( BX_DIRECTORY_PATH_CLASSES . 'BxDolProfilesController.php' );
		global $site;
		//
		// Please replace the following values:
		//
		$rpx_imageurl = $site['url'].'thakkertech/rpx_signin/rpxIcons.png';
		$apiKey		= getParam("rpx_api_key");
		$siteName	= getParam("rpx_application_name");  // eg. "applicationname". This will be expanded to RPX Domain "applicationname.rpxnow.com"
		$rpx_show_type 			= getParam("rpx_show_type");
		$rpx_show_type 			= $rpx_show_type ? $rpx_show_type : 'IFRAME';
		$rpx_imagepath 			= getParam("rpx_imagepath");
		$rpx_imagepath 			= $rpx_imagepath ? $rpx_imagepath : '';
		$appy_image_width_height= getParam("appy_image_width_height");
		$appy_image_width_height= $appy_image_width_height ? $appy_image_width_height : '';
		$rpx_image_width	 	= getParam("rpx_image_width");
		$rpx_image_width		= (int)$rpx_image_width>0 ? (int)$rpx_image_width : '';
		$rpx_image_height		= getParam("rpx_image_height");
		$rpx_image_height		= (int)$rpx_image_height>0 ? (int)$rpx_image_height : '';
		
		$rpx_image_width = ( $rpx_image_width && $appy_image_width_height ) ? 'width:'.$rpx_image_width.'px;' : '';
		$rpx_image_height = ( $rpx_image_height && $appy_image_width_height ) ? 'height:'.$rpx_image_height.'px;' : '';
		
		$rpx_imagepath = trim($rpx_imagepath);
		
		if( @GetImageSize($rpx_imagepath) )
			$rpx_imageurl = $rpx_imagepath;
		
		$iNewID = '0';
		$new = '0';
		
		$port 		= $_SERVER['SERVER_PORT'] == '80' ? '' : ':'.$_SERVER['SERVER_PORT'];
		$token_url 	= 'http://' . $_SERVER['SERVER_NAME'].$port.$_SERVER['SCRIPT_NAME'];
		if(isset($_REQUEST['token'])) 
		{ 
			$token 		= $_REQUEST['token'];
			$post_data	= array( 'token' => $_REQUEST['token'], 'apiKey' => $apiKey, 'format' => 'json' ); 
		
			$post_url	= 'https://rpxnow.com/api/v2/auth_info/?token='.$token.'&apiKey='.$apiKey.'&format=json';
			//echo $post_url;
			$curl 		= curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_URL, $post_url);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$raw_json 	= curl_exec($curl);
			curl_close($curl);
			
			// parse the json response into an associative array
			$auth_info = json_decode($raw_json, true);
				 

			// process the auth_info response
			if ($auth_info['stat'] == 'ok') 
			{
				$profileValues 		= $auth_info['profile'];
				$identifier 	= $profileValues['identifier'];
				$aData = array();
				
			
				if(isset($profileValues['displayName']))
				{
					//echo '<b>Name:</b> ' . $profileValues['displayName'] . '<br/>';
				}
				
				if(isset($profileValues['gender']))
				{
					$aData['Sex'] 	=strtolower($profileValues['gender']);
				}
				 
				if(!isset($profileValues['preferredUsername']))
				{
					//echo '<b>preferredUsername:</b> ' . $profileValues['preferredUsername'] . '<br/>';
					//$aData['NickName'] = $profileValues['preferredUsername'];
					//$aData['Password'] = $profileValues['preferredUsername'];
					
					$arrNickName 		= split('@',$profileValues['email']);
					$aData['NickName'] 	= $arrNickName[0];
					$aData['Password']  = $arrNickName[0];
					
					$sQuery = "SELECT `NickName` FROM `Profiles` WHERE `NickName`='{$aData['NickName']}'";
					$rRes = db_arr( $sQuery );
					if(!empty($rRes))
						$aData['NickName'] = $profileValues['email'];	
				}
				else
				{
					$aData['NickName'] = $profileValues['preferredUsername'];
					$sQuery = "SELECT `NickName` FROM `Profiles` WHERE `NickName`='{$aData['NickName']}'";
					$rRes = db_arr( $sQuery );
					if(!empty($rRes))
						$iNewID = $rRes['ID'];
				}
				
				if (isset($profileValues['email']))  {
					//echo '<b>Email:</b> ' . $profileValues['email'] . '<br/>';
				 
					$aData['Email'] = $profileValues['email'];
					
					$sQuery = "SELECT `ID`,`Email` FROM `Profiles` WHERE `Email`='{$profileValues['email']}'";
					$rRes = db_arr( $sQuery );
					if(!empty($rRes))
						$iNewID = $rRes['ID'];
				}
				if (isset($profileValues['gender']))  {
					//echo '<b>gender:</b> ' . $profileValues['gender'] . '<br/>';
					$aData['Sex'] = $profileValues['gender'];
				}

				
				if($iNewID == '0')
				{
				
					$aData['Status'] = 'Active';
					$profileController = new BxDolProfilesController();
					$profileController->createProfile( $aData, false);
					
					$sQuery = "SELECT `ID`,`Password` FROM `Profiles` WHERE `Email`='{$aData['Email']}'";
					$rResID = db_arr( $sQuery );
					
					createUserDataFile( $rResID['ID'] );
					$new = '1';
					
					// notify admin
					$iMemID 	= (int)$rResID['ID'];
					$aMember 	= getProfileInfo( $iMemID );
					if( !$aMember )
						return false;
						
					$sSubject	= "New user confirmed via RPX";
					$sMessage = 
"New user ".$aMember['NickName']." with email ".$aMember['Email']." has been confirmed,
his/her ID is ".$iMemID.".
--
".$site['title']." mail delivery system
Auto-generated e-mail, please, do not reply
";
					sendMail( $site['email_notify'], $sSubject, $sMessage );
				
				}
				
				$sQuery = "SELECT `ID`,`Password`,`Avatar` FROM `Profiles` WHERE `Email`='{$profileValues['email']}'";
				$pRes = db_arr( $sQuery );
				
				$update_res = db_res( "UPDATE `Profiles` SET `DateLastLogin` = NOW() WHERE `ID` = {$pRes['ID']}" );
bx_login($pRes['ID']);	

				if(isset($profileValues['photo']) && $pRes['Avatar']==0)  
				{
					 
					BxDolService::call('avatar', 'set_image_for_cropping', array($pRes['ID'],  $profileValues['photo']));
					header('Location:'.$site['url'].'m/avatar/');
					exit;
				}
				 
				//setcookie( "memberID", $pRes['ID'] , time() + 24 * 3600, '/' );
				//setcookie( "memberPassword", $pRes['Password'], time() + 24 * 3600, '/' );
				
				if($new == '1')
					header('Location:'.$site['url'].'pedit.php?ID='.$pRes['ID']);
				elseif($new == '0')
					header('Location:'.$site['url'].'member.php');
				else
					header('Location:'.$site['url']);
			} 
			else 
			{
				echo '<b>Error:</b> ' . $auth_info['err']['msg'];
			}
		} 
		else 
		{ 
			$post_token_url = 'https://'.$siteName.'.rpxnow.com/openid/embed?token_url='.urlencode($token_url); // iframe
			if( $rpx_show_type == 'POPUP')
			{
				$post_token_url = 'https://'.$siteName.'.rpxnow.com/openid/v2/signin?token_url='.$token_url;
			?>
				<div style="padding:10px 0 10px 0;"><center><a class="rpxnow" onclick="return false;" href="<?php echo $post_token_url;?>">
				<img style="border:solid 0px #eeeeee;<?=$rpx_image_width.$rpx_image_height?>" src="<?=$rpx_imageurl?>" alt="SighIn Here"/>
				</a></center></div>
			
			<script src="https://rpxnow.com/openid/v2/widget" type="text/javascript"></script>
			<script type="text/javascript">
			  RPXNOW.token_url = "<?php echo $token_url ?>";
			  RPXNOW.realm = "<?php echo $siteName;?>";
			  RPXNOW.overlay = true;
			  RPXNOW.language_preference = 'en';
			</script>
			<?php
			}
			else
			{
			$post_token_url = 'https://'.$siteName.'.rpxnow.com/openid/embed?token_url='.urlencode($token_url); // iframe
			?>
			<iframe src="<?php echo $post_token_url;?>" scrolling="no" frameBorder="no" style="width:400px;height:240px;"></iframe>
			<?php 
			}
		}
		$sCode .= ob_get_clean();
echo $sCode;
?>