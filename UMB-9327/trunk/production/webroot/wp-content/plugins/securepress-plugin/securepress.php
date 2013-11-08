<?php
/*
Plugin Name: SecurePress
Version: 5.2.06
Plugin URI: http://www.securelive.net
Description: SecurePress brings the anti-hacking power of SecureLive to your WordPress website!
Author: SecureLive, LLC
Author URL: http://www.securelive.net
*/

//ini_set('display_errors',1);
//error_reporting(E_ALL);

global $regErrors;
$regErrors=array();

if(!class_exists('adminFuncs')){
	class adminFuncs{
		public $connected;
		public $config_fp;
		public function sl_get_path(){
			$filepath = "false";
			if($this->config_exists()){
				include($this->config_fp);
			}
			if($filepath != "false" && !empty($filepath)){
				return $filepath;
			} else {
				if(dirname($_SERVER['SCRIPT_NAME'])=='' || dirname($_SERVER['SCRIPT_NAME'])=='/' || !substr_count(dirname(__FILE__),dirname($_SERVER['SCRIPT_NAME']))){
		            $root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);//doc root
		            $file = str_replace('\\','/',dirname(__FILE__));//fix windows DS
		            if($root=='/'){
		                $filepath = $file;
		            } else {
		                //loop until match found or on last dir of one of them
		                while(!substr_count($file,$root) && substr_count($root,'/',1) && substr_count($file,'/',1)){
		                    //remove first dirs from each down to last dir
		                    $root = substr($root, strpos($root,'/',1));
		                    $file = substr($file, strpos($file,'/',1));
		                }
		                if(substr_count($file,$root)){
		                    $filepath = substr($file, strpos($file,$root)+strlen($root));//take everything in __file__ after root
		                } else {
		                    //is server edition
		                    $filepath = '/sl_admin';
		                }
		            }
		        } else {
		            $root = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']));//everything after doc root
		            $root = substr_count($root, '/') > 1 ? substr($root, 0, strpos($root, '/', 1)) : $root;//get first "/dir"
		            $file = str_replace('\\','/',dirname(__FILE__));//fix windows DS
		            $filepath = substr($file, strpos($file,$root));//take everything in __file__ after root
		        }
			}
	        return $filepath;
	    }
	    private function get_auth(){
			$docRoot = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
			$acctHome = substr($docRoot,0,strrpos($docRoot,'/'));
			if(@file_exists("$acctHome/securelive_max/sl_auth.php")){
				$file = "$acctHome/securelive_max/sl_auth.php";
			}
			elseif(@file_exists(str_replace('\\','/',dirname(__FILE__))."/sl_auth.php")){
				$file = str_replace('\\','/',dirname(__FILE__))."/sl_auth.php";
			}
			elseif(@file_exists("$docRoot/administrator/components/com_securelive/sl_auth.php")){
				$file = "$docRoot/administrator/components/com_securelive/sl_auth.php";
			}
			elseif(@file_exists("$docRoot/wp-content/plugins/securepress-plugin/sl_auth.php")){
				$file = "$docRoot/wp-content/plugins/securepress-plugin/sl_auth.php";
			}
			elseif(@file_exists("$docRoot/e107_plugins/secure_e107/sl_auth.php")){
				$file = "$docRoot/e107_plugins/secure_e107/sl_auth.php";
			}
			elseif(@file_exists("$docRoot/sites/all/modules/secureDrupal/sl_auth.php")){
				$file = "$docRoot/sites/all/modules/secureDrupal/sl_auth.php";
			}
			elseif(@file_exists(str_replace('\\','/',dirname(__FILE__))."/../sl_auth.php")){
				$file = str_replace('\\','/',dirname(__FILE__))."/../sl_auth.php";
			}
			
			if(!isset($file)){
				return false;
			}
			$lines = @file($file);
			if(count($lines)==3){
				return trim($lines[1]);
			}
			return false;
		}
		public function sl_post_request($purl, $data){
			$fp = null; $res_array = array();
			$url = "http://64.50.167.27/securelive";
			if($data != 'file'){ // curl or fopen
			    
			    #put new account authorization
			    $sl_pass = $this->get_auth();
			    if($sl_pass){
					$data = "sl_pass=$sl_pass&".ltrim($data,'?&');
			    }
			    
			    $connected = false;
			    if(function_exists('curl_init') && function_exists('curl_exec')){
			        $ch = curl_init("$url/$purl");
			        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);            //send post data
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        // return web page
			        curl_setopt($ch, CURLOPT_HEADER, false);            // don't return headers
			        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);    // dont follow redirects
			        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 9);        // timeout on connect
			        curl_setopt($ch, CURLOPT_TIMEOUT, 16);                // timeout on response
			        curl_setopt($ch, CURLOPT_ENCODING, "");                // handle all encodings
			        curl_setopt($ch, CURLOPT_USERAGENT, "");            // who am i
			        $response = curl_exec($ch);
			        if($response){
			            $this->connected = "curl";
			        } else {
						$this->connected = "failed to connect with curl";
			        }
			        curl_close($ch);
			    } elseif (function_exists('fopen')) {
			        $old = ini_get('default_socket_timeout');
			        ini_set('allow_url_fopen', 1);
			        $params = array('http' => array('method' => 'POST', 'content' => $data));
			        $ctx = stream_context_create($params);
			        ini_set('default_socket_timeout', 25);
			        $fp = @fopen("$url/$purl", 'rb', false, $ctx);
			        if($fp){
			            $this->connected = "fopen";
			        }
			        ini_set('default_socket_timeout', $old);
			        if(!$fp){
			            $this->connected = "failed to connect with fopen";
			        }
			        $response = @stream_get_contents($fp);
			        @fclose($fp);
			    }
			    $res_array = substr_count($response, "|") ? explode("|", $response) : array($response);
			    return $res_array;
			} elseif($data == 'file'){ // file
			    if(function_exists('curl_init') && function_exists('curl_exec')){
			        $ch = curl_init("$url/$purl");
			        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);            //send post data
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        // return web page
			        curl_setopt($ch, CURLOPT_HEADER, false);            // don't return headers
			        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);    // dont follow redirects
			        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 9);        // timeout on connect
			        curl_setopt($ch, CURLOPT_TIMEOUT, 16);                // timeout on response
			        curl_setopt($ch, CURLOPT_ENCODING, "");                // handle all encodings
			        curl_setopt($ch, CURLOPT_USERAGENT, "");            // who am i
			        $response = curl_exec($ch);
			        curl_close($ch);
			        $resp = explode("\n", $response);
			    } else {
			        $resp = file("$url/$purl");
			    }
			    return $resp;
			}
		}
		public function config_exists(){
			//check for config above doc root
        	$this->config_fp = str_replace("\\",'/',$_SERVER['DOCUMENT_ROOT']).'/../securelive_max/sl_config.php';
			if(!@file_exists($this->config_fp)){
				//main config not found
				if(substr(dirname(__FILE__),-3)=='inc'){
					$this->config_fp = dirname(__FILE__).'/../sl_config.php';
				} else {
					$this->config_fp = dirname(__FILE__).'/sl_config.php';
				}
			}
		    $config_exists = false;
		    if(!file_exists($this->config_fp)){
				//attempt to create it
				$fp = @fopen($this->config_fp,'w');
				if(!$fp){
					@chmod(dirname($this->config_fp), 0777);
					$fp = @fopen($this->config_fp,'w');
					@chmod(dirname($this->config_fp), 0755);
				}
				if($fp){
					$alph = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$secret = '';
					while(strlen($secret)<16){
						$secret .= substr($alph,rand(0,strlen($alph)-1),1);
					}
					$blank = "<?php\n";
					$blank .= "//start_custom_path\n";
					$blank .= '$filepath = "";'."\n";
					$blank .= "//end_custom_path\n";
					$blank .= "//start_admin_alerts\n";
					$blank .= '$adminAlerts = 1;'."\n";
					$blank .= "//end_admin_alerts\n";
					$blank .= "//start_bypass_arr\n";
					$blank .= "//end_bypass_arr\n";
					$blank .= "/*start_safe_files\n";
					$blank .= "error_log .dat .jpa .tmp .spc .pdf .yuv .bmp .gif .jpg .jpeg .png .psd .psp .pspimage .thm .tif .ai .drw .eps .ps .svg .fla .3dm .pln .aac .aif .iff .mp3 .mpa .ra .wav .wma .3g2 .3gp .asf .asx .avi .flv .mov .mp4 .mpg .rm .swf .vob .wmv .fnt .fon .otf .ttf .7z .deb .gz .pkg .rar .sit .sitx .tar .zip .zipx\n";
					$blank .= "end_safe_files*/\n";
					$blank .= "//start_secret\n";
					$blank .= '$secret = "'.$secret.'";'."\n";
					$blank .= "//end_secret\n";
					$blank .= "/*start_users\n";
					$blank .= "end_users*/\n";
					$blank .= "?>";
					fwrite($fp,$blank);
					fclose($fp);
					$config_exists = true;
				}
		    } else {
				$config_exists = true;
		    }
		    return $config_exists;
		}
	}
}

add_action('init', 'sl_runner', 0);
add_action('admin_menu', 'sl_admin');
//add_action('admin_init', 'sl_warn');
add_action("widgets_init", "init_sl_widget");
add_action("sanitize_user", "sl_sanitize");
add_action("user_registration_email", "sl_validate_email");
add_action("registration_errors", "OnRegistration_Errors");

// Check new user details
function sl_sanitize($username){
	global $regErrors;
	$spamChecker = new SpamChecker();
	if($spamChecker->isEnabled){
		
		$regErr = "Known spamming username found: <br>" . $username . "<br>";
		if($spamChecker->CheckUserName($username) === false && !in_array($regErr, $regErrors))
			$regErrors[] = $regErr;
		else{
			$result = $spamChecker->CheckTerms($username);
			$regErr = "Common spam term found: <br>".$result. "<br>";
			if($result !== false && !in_array($regErr, $regErrors))
				$regErrors[] = $regErr;
		}
	}
	
	return $username;
}
function sl_validate_email($email){
	global $regErrors;
	$spamChecker = new SpamChecker();
	if($spamChecker->isEnabled){
		
		if($spamChecker->CheckEMail($email) == false)
			$regErrors[] = "Known spamming E-Mail address found: " . $email;
			
		$result = $spamChecker->CheckTerms($email);
		
		if($result !== false)
			$regErrors[] = $result;
	}
	
	return $email;
}
function OnRegistration_Errors($errors){
	global $regErrors;
	
	if(count($regErrors) > 0){
		
		$str = "";
		foreach($regErrors as $re)
			$str.="$re<br/>\n";
		
		$errors->add(1, substr($str,0, strlen($str) - 6), null);	
	}
	return $errors;
}

// show badge
function sl_widget($args){
    extract($args);
    $options = explode('#sl#', get_option('sl_badge_widget'));
    $base_url = plugins_url() . '/' . dirname(plugin_basename(__FILE__)) . '/';

    #Get $params
    {
	    $arr = array('sl_badge_series','sl_badge_type','sl_badge_color','sl_position','custom_pad_top','custom_pad_right','custom_pad_left','custom_pad_bottom','custom_margin_top','custom_margin_right','custom_margin_left','custom_margin_bottom','custom_position','custom_zindex','sl_popup','moduleclass_sfx');
	    $params = new ParamWrapper();
	    for($i=0;$i<count($arr);$i++){
			$params->set($arr[$i],$options[$i]);
	    }
	}
    
	$isIE7 = (bool)(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7") !== false);
	$popup_div = false;
	$badge = getBadge($params, $popup_div, $isIE7);

	echo $before_widget;
	echo getJS($popup_div);
	echo $badge;
	echo $after_widget;
}
function getJS($popup_div){
	if($popup_div === false)
		return '';
	
	#fix $popup_div's HTML for JS
	{
		$replaces = array(	"\r" => "",
							"\n" => "",
							"\"" => "\\\"");
		foreach($replaces as $key => $val)
			$popup_div = str_replace($key, $val, $popup_div);
	}
	
	$mod_loc = 'wp-content/plugins/securepress-plugin/sl_verify.php?mode=ajax';
		
	return <<<JS
		<script language="JavaScript" type="text/javascript">
			sl_getting_contents = false;
			sl_mod_got_content = false;
			SecureLive_mod_Init();
			function SecureLive_mod_Init(){
				document.writeln("$popup_div");
				SetLabel('Waiting for user request...');
			}
			
			function Badge_OnClick(){
				var elm = document.getElementById('sl_popup_container'); 
				if(elm.style.display == 'none') { 
					var sTop = 0; 
					
					if(window.pageYOffset) 
						sTop = window.pageYOffset; 
					else if(document.documentElement.scrollTop) 
						sTop = document.documentElement.scrollTop; 
					else if(document.body.scrollTop) 
						sTop = document.body.scrollTop; 
						
					var mt = sTop - 100; 
					elm.style.marginTop = mt.toString()+'px';  
					elm.style.display = 'block'; 
					
					if(!sl_mod_got_content){
						GetContent();
					}
				} 
				else { 
					elm.style.display = 'none'; 
				}
			}
			
			function SetLabel(str){
				var elm = document.getElementById('sl_mod_loading_label');
				if(elm){
					elm.innerHTML = str;
				}
			}
			
			function GetContent(){
				if(sl_getting_contents)
					return;
					
				sl_getting_contents = true;
				SetLabel("Initializing Connection...");
				var xmlhttp;
				if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
					
					    var elm_container = document.getElementById("sl_mod_contents");
					    var newdiv = document.createElement("div");
					    newdiv.style.position = 'relative';
						newdiv.innerHTML = xmlhttp.responseText;
						if ( elm_container.hasChildNodes() ){
							while ( elm_container.childNodes.length >= 1 ){
								elm_container.removeChild( elm_container.firstChild );       
							} 
						}
						elm_container.appendChild(newdiv);

					    
					    sl_mod_got_content = true;
					    sl_getting_contents = false;
					    var elm = document.getElementById('sl_popup_refresh');
						if(elm){
							elm.src = elm.getAttribute('src_refresh');
							elm.style.cursor = 'pointer';
						}
					}
					else if(xmlhttp.readyState==4){
					    SetLabel("Connection Failed!<a href='javascript: void(0);' onclick='return GetContent();'>Try Again?</a>");
					    sl_getting_contents = false;
					    var elm = document.getElementById('sl_popup_refresh');
						if(elm){
							elm.src = elm.getAttribute('src_refresh');
							elm.style.cursor = 'pointer';
						}
					}
				}
				
				var elm = document.getElementById('sl_popup_refresh');
				if(elm){
					elm.src = elm.getAttribute('src_spin');
					elm.style.cursor = '';
				}
				
				xmlhttp.open("GET","$mod_loc&salt="+Math.floor(Math.random()*10000),true);
				SetLabel("Transferring Data...");
				xmlhttp.send();
				
				return true;
			}
			
			-->
		</script>
JS;
}
function getBadge($params, &$popup_div, $isIE7){
		$s = $params->get('sl_badge_series');
		$t = $params->get('sl_badge_type');
		$c = $params->get('sl_badge_color');
		$sl_position = $params->get('sl_position');
		$sl_pad_top = $params->get('custom_pad_top');
		$sl_pad_right = $params->get('custom_pad_right');
		$sl_pad_left = $params->get('custom_pad_left');
		$sl_pad_bottom = $params->get('custom_pad_bottom');
		$sl_margin_top = $params->get('custom_margin_top');
		$sl_margin_right = $params->get('custom_margin_right');
		$sl_margin_left = $params->get('custom_margin_left');
		$sl_margin_bottom = $params->get('custom_margin_bottom');
		$custom_position = $params->get('custom_position');
		$custom_zindex = $params->get('custom_zindex');
		$sl_popup = $params->get('sl_popup');
		$mod_suffix = $params->get('moduleclass_sfx');
	    
		$output = '';
	    
	    //Setup Containing Div for badge
	    $textAlign = "";
	    switch($sl_position)
	    {
	        default:
	        case "01"://left
	        case "04"://custom
	            $textAlign = 'left';
	            break;
	            
	        case "02"://center
	            $textAlign = 'center';
	            break;
	            
	        case "03"://right
	            $textAlign = 'right';
	            break;
	    }
	    $output.='<div name="sl_floatingModDiv_Container" style="background: transparent !important; text-align: '.$textAlign.'" style="width: 100%">';
	    
	    //use standard style or custom style for inner div?
	    if($sl_position == 4){
	        $output .= '<div name="sl_floatingModDiv" '
	        .(isset($mod_suffix)?('id="'.$mod_suffix.'" '):'')
	        .'style="'
	        .(isset($sl_margin_left)?('margin-left: '.$sl_margin_left.'px; '): '')
	        .(isset($sl_margin_right)?('margin-right: '.$sl_margin_right.'px; '): '')
	        .(isset($sl_margin_top)?('margin-top: '.$sl_margin_top.'px; '): '')
	        .(isset($sl_margin_bottom)?('margin-bottom: '.$sl_margin_bottom.'px; '): '')
	        .(isset($sl_pad_left)?('padding-left: '.$sl_pad_left.'px; '): '')
	        .(isset($sl_pad_right)?('padding-right: '.$sl_pad_right.'px; '): '')
	        .(isset($sl_pad_top)?('padding-top: '.$sl_pad_top.'px; '): '')
	        .(isset($sl_pad_bottom)?('padding-bottom: '.$sl_pad_bottom.'px; '): '')
	        .'display: inline; height: 50px; width: 105px; text-align: inherit ! important; background: transparent !important;'
	        .(isset($custom_position)?('position: '.$custom_position.'; '): '')
	        .(isset($custom_zindex)?('z-index: '.$custom_zindex .'; '): '')
	        .'">';
	    } else {
	        $output .= '<div name="sl_floatingModDiv" style="text-align: inherit ! important; background: transparent !important;" '.(isset($mod_suffix)?'id="'.$mod_suffix.'" ':'').'>';
	    }
	    
		//Include popup optioni?
		if ($sl_popup == "1"){
		 	$output .= '<a href="javascript:void(0)" onclick="return Badge_OnClick();">   
	                    <img src="https://www.securelive.net/badges/image_create.php?s='.$s.'&amp;t='.$t.'&amp;c='.$c.'" style="border: none;" alt="SecureLive Badge" title="SecureLive Badge" /> </a>';
			$popup_div = getPopupDiv($isIE7);
		} else {
			$output .= '<img src="https://www.securelive.net/badges/image_create.php?s='.$s.'&amp;t='.$t.'&amp;c='.$c.'" style="border: none;" alt="SecureLive Badge" title="SecureLive Badge" />';
	        $popup_div = false;
	    }
	    
	    //close started tags
		$output .= '</div></div>';
		return $output;
	}	
function getPopupDiv($isIE7){
	$img_folder = 'wp-content/plugins/securepress-plugin/images/badge';
	
	$ie_7hack_closeStyle = '';
	if($isIE7){
		$ie_7hack_closeStyle = 'position: absolute !important; right: 0px !important; top: 5px !important;';
	}

	$output = "
		<div id=\"sl_popup_container\" style=\"display: none; position: absolute !important; top: 50% !important; left: 50% !important; width: 500px !important; height: 174px !important; margin-left: -250px !important; margin-top: -100px; padding: 8px !important;\">
			<table cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100% !important; height: 100% !important; border-collapse: separate;\">
				<tbody>
					<tr>
						<td style=\"width: 12px !important; height: 24px !important; background-image: url($img_folder/black_TL.png) !important;\"></td>
						<td style=\"vertical-align: top; height: 23px !important; background: #000000 !important; font-size: 16px !important; padding-top: 1px !important; color: #D0D0D0 !important; position: relative !important; font-weight: bold !important;\">
							<div style=\"height: 18px; width: 100% !important; margin-top: 3px !important;\">
								SecureLive Website Protection
								<div style=\"width: 50px !important; height: 16px !important; font-size: 13px !important; float: right !important; text-align: right !important; $ie_7hack_closeStyle\">
									<a href=\"javascript: void(0);\" style=\"cursor: pointer;\" onclick=\"javascript: document.getElementById('sl_popup_container').style.display = 'none';\">close</a>
								</div>
							</div>
						</td>
						<td style=\"width: 12px !important; height: 24px !important; background-image: url($img_folder/black_TR.png) !important;\"></td>
					</tr>
					<tr>
						<td style=\"background: #000000 !important; width: 12px !important; height: 12px !important; background-image: url($img_folder/curve_TL.png) !important;\"></td>
						<td style=\"background: #D00000 !important; border-top: 3px solid black !important;\">
							<div style=\"width: 1px; height: 1px;\"></div>
						</td>
						<td style=\"background: #000000 !important; width: 12px !important; height: 12px !important; background-image: url($img_folder/curve_TR.png) !important;\"></td>
					</tr>
					<tr>
						<td style=\"width: 10px !important; background: #D00000 !important; border-left: 2px solid black !important;\">&nbsp;</td>
						<td style=\"background: #D00000 !important; position: relative; vertical-align: top !important;\" id=\"sl_mod_contents\">
							<div style=\"position: absolute; top: 43px;\">
								<span id=\"sl_mod_loading_label\" style=\"margin-left: 8px; color: black !important; font-style: italic; font-size: 12px;\">Javascript is disabled on this browser.</span>
								<br/>
								<img src=\"$img_folder/Loading_Bar.gif\" />
							</div>
						</td>
						<td style=\"width: 10px !important; background: #D00000 !important; border-right: 2px solid black !important;\">&nbsp;</td>
					</tr>
					<tr>
						<td style=\"width: 12px !important; height: 10px !important; background-image: url($img_folder/curve_BL.png) !important;\"></td>
						<td style=\"background: #D00000 !important; border-bottom: 2px solid black !important;\">
							<div style=\"width: 1px; height: 1px;\"></div>
						</td>
						<td style=\"width: 12px !important; background-image: url($img_folder/curve_BR.png) !important;\"></td>
					</tr>
				</tbody>
			</table>
			<img style=\"position: absolute !important; right: -15px !important; bottom: -16px !important;\" src=\"$img_folder/sl_certified.png\" alt=\"SecureLive Logo\">
		</div>
	";

	return $output; 
}

// select badge
function sl_widget_opts(){
	$arr = array('sl_badge_series','sl_badge_type','sl_badge_color','sl_position','custom_pad_top','custom_pad_right','custom_pad_left','custom_pad_bottom','custom_margin_top','custom_margin_right','custom_margin_left','custom_margin_bottom','custom_position','custom_zindex','sl_popup','moduleclass_sfx');
    $options = explode('#sl#', get_option('sl_badge_widget'));
    if(isset($options[1])){
    	for($i=0;$i<count($arr);$i++){
			${$arr[$i]} = $options[$i];
    	}
    } else {
    	for($i=0;$i<count($arr);$i++){
			${$arr[$i]} = '';
    	}
        $sl_badge_series = 1; $sl_badge_type = 'max'; $sl_badge_color = 'blk'; $sl_popup = 1;
    }
    if(isset($_POST['sl_badge_series'])){
    	$vals = array();
        for($i=0;$i<count($arr);$i++){
			${$arr[$i]} = $_POST[$arr[$i]];
			array_push($vals,$_POST[$arr[$i]]);
    	}
        update_option('sl_badge_widget', implode('#sl#',$vals));
    }
?>
    Click save to view the chosen badge and display it on your website.<br /><br />
    <table>
    	<tr>
    		<td>Series:</td>
    		<td><select id="sl_badge_series" name="sl_badge_series">
			        <option value="1" <?php if($sl_badge_series==1){echo 'selected';}?>>Series 1&nbsp;</option>
			        <option value="2" <?php if($sl_badge_series==2){echo 'selected';}?>>Series 2&nbsp;</option>
			    </select></td>
    	</tr>
    	<tr>
    		<td>Type:</td>
    		<td><select id="sl_badge_type" name="sl_badge_type">
			        <option value="max" <?php if($sl_badge_type=="max"){echo 'selected';}?>>SL Max&nbsp;</option>
			        <option value="jml" <?php if($sl_badge_type=="jml"){echo 'selected';}?>>Joomla&nbsp;</option>
			        <option value="map" <?php if($sl_badge_type=="map"){echo 'selected';}?>>Map&nbsp;</option>
			        <option value="frm" <?php if($sl_badge_type=="frm"){echo 'selected';}?>>Form&nbsp;</option>
			        <option value="ana" <?php if($sl_badge_type=="ana"){echo 'selected';}?>>Analytics&nbsp;</option>
			        <option value="blg" <?php if($sl_badge_type=="blg"){echo 'selected';}?>>Blog&nbsp;</option>
			        <option value="crt" <?php if($sl_badge_type=="crt"){echo 'selected';}?>>Cart&nbsp;</option>
			        <option value="fum" <?php if($sl_badge_type=="fum"){echo 'selected';}?>>Forum&nbsp;</option>
			        <option value="plu" <?php if($sl_badge_type=="plu"){echo 'selected';}?>>Plus&nbsp;</option>
			    </select></td>
    	</tr>
    	<tr>
    		<td>Color:</td>
    		<td><select id="sl_badge_color" name="sl_badge_color">
			        <option value="blk" <?php if($sl_badge_color=="blk"){echo 'selected';}?>>Black&nbsp;</option>
			        <option value="red" <?php if($sl_badge_color=="red"){echo 'selected';}?>>Red&nbsp;</option>
			        <option value="yel" <?php if($sl_badge_color=="yel"){echo 'selected';}?>>Yellow&nbsp;</option>
			        <option value="blu" <?php if($sl_badge_color=="blu"){echo 'selected';}?>>Blue&nbsp;</option>
			        <option value="pur" <?php if($sl_badge_color=="pur"){echo 'selected';}?>>Purple&nbsp;</option>
			        <option value="grn" <?php if($sl_badge_color=="grn"){echo 'selected';}?>>Green&nbsp;</option>
			    </select></td>
    	</tr>
    	<tr>
    		<td>Popup:</td>
    		<td><select id="sl_popup" name="sl_popup">
			        <option value="1" <?php if($sl_popup==1){echo 'selected';}?>>Enabled&nbsp;</option>
			        <option value="0" <?php if($sl_popup==0){echo 'selected';}?>>Disabled&nbsp;</option>
			    </select></td>
    	</tr>
    </table>
    <br />
<?php
    echo '<img id="sl_badge_preview" src="https://www.securelive.net/badges/image_create.php?s=' . $sl_badge_series . '&t=' . $sl_badge_type . '&c=' . $sl_badge_color . '" border="0" />
	<br/><br/>
	Optional CSS Settings:
	<table>
    	<tr>
    		<td>Class Suffix:</td>
    		<td><input id="moduleclass_sfx" name="moduleclass_sfx" type="text" value="'.$moduleclass_sfx.'" /></td>
    	</tr>
    	<tr>
    		<td>Justification:</td>
    		<td><select id="sl_position" name="sl_position">
    			<option value="01" '.($sl_position=='01' ? 'selected':'').'>Left</option>
    			<option value="02" '.($sl_position=='02' ? 'selected':'').'>Centered</option>
    			<option value="03" '.($sl_position=='03' ? 'selected':'').'>Right</option>
    			<option value="04" '.($sl_position=='04' ? 'selected':'').'>Custom</option>
    		</select></td>
    	</tr>
    	
    	
    	
    	
    	<tr>
    		<td>Padding Top:</td>
    		<td><input id="custom_pad_top" name="custom_pad_top" type="text" value="'.$custom_pad_top.'" /></td>
    	</tr>
    	<tr>
    		<td>Padding Right:</td>
    		<td><input id="custom_pad_right" name="custom_pad_right" type="text" value="'.$custom_pad_right.'" /></td>
    	</tr>
    	<tr>
    		<td>Padding Left:</td>
    		<td><input id="custom_pad_left" name="custom_pad_left" type="text" value="'.$custom_pad_left.'" /></td>
    	</tr>
    	<tr>
    		<td>Padding Bottom:</td>
    		<td><input id="custom_pad_bottom" name="custom_pad_bottom" type="text" value="'.$custom_pad_bottom.'" /></td>
    	</tr>
    	<tr>
    		<td>Margin Top:</td>
    		<td><input id="custom_margin_top" name="custom_margin_top" type="text" value="'.$custom_margin_top.'" /></td>
    	</tr>
    	<tr>
    		<td>Margin Right:</td>
    		<td><input id="custom_margin_right" name="custom_margin_right" type="text" value="'.$custom_margin_right.'" /></td>
    	</tr>
    	<tr>
    		<td>Margin Left:</td>
    		<td><input id="custom_margin_left" name="custom_margin_left" type="text" value="'.$custom_margin_left.'" /></td>
    	</tr>
    	<tr>
    		<td>Margin Bottom:</td>
    		<td><input id="custom_margin_bottom" name="custom_margin_bottom" type="text" value="'.$custom_margin_bottom.'" /></td>
    	</tr>
    	<tr>
    		<td>Custom CSS Position:</td>
    		<td><select id="custom_position" name="custom_position">
    			<option value="absolute" '.($custom_position=='absolute' ? 'selected':'').'>Absolute</option>
    			<option value="relative" '.($custom_position=='relative' ? 'selected':'').'>Relative</option>
    			<option value="fixed" '.($custom_position=='fixed' ? 'selected':'').'>Fixed</option>
    			<option value="inherit" '.($custom_position=='inherit' ? 'selected':'').'>Inherit</option>
    			<option value="static" '.($custom_position=='static' ? 'selected':'').'>Static</option>
    		</select></td>
    	</tr>
    	<tr>
    		<td>Z Index:</td>
    		<td><input id="custom_zindex" name="custom_zindex" type="text" value="'.$custom_zindex.'" /></td>
    	</tr>
    	
    	
    	
	</table>
	<br/><br/>';
}

// init widget / badge
function init_sl_widget(){
    register_sidebar_widget("SecurePress Badge", "sl_widget");
    register_widget_control("SecurePress Badge", "sl_widget_opts");
}

// WP alerts - currently disabled
function sl_warn(){
    /*
    if(!$act_active[0]){
        add_action('admin_notices', create_function('', 'echo "<div class=\"error\"><p>" . sprintf("Thank you for installing SecurePress. Your account should be created within 24 hours.") . "</p></div>";'));
    }
    //get current version from remote
    $wp_ver   = "2.0.01";
    $ver_html = @file('http://www.securelivesw.com/securelive/current_version.inc');
    $cur_wp_ver = $ver_html[3];
    if($wp_ver < trim($cur_wp_ver)){
        add_action('admin_notices', create_function('', 'echo "<div class=\"error\"><p>You are not using the most recent version of SecurePress.</p></div>";'));
    }
    */
}

// register admin section
function sl_admin(){
    add_menu_page('SecurePress Account Info', 'SecurePress', 'activate_plugins', 'SecurePress', 'sl_act');
}

// display admin
function sl_act(){
    $base_url = plugins_url() . '/' . dirname(plugin_basename(__FILE__)) . '/';
    define('SL_Admin', true);
    include_once('sl_admin.php');
    

    //header stuff
    if (array_key_exists('HTTP_USER_AGENT', $_SERVER) && preg_match('/(MSIE\\s?([\\d\\.]+))/', $_SERVER['HTTP_USER_AGENT'], $matches)) {
        $IEbrowser['ie7'] = intval($matches[2]) == 7;
        $IEbrowser['ie8'] = intval($matches[2]) == 8;
    }
    if(empty($IEbrowser)){
        $IEbrowser = array(null);
    }
    //$doc->setMetaData('content-type', 'text/html; charset=utf-8', true);
    //$doc->setMetaData('content-type', 'text/html; _ISO', true);
    //$doc->setMetaData('Content-Style-Type', 'text/css; _ISO', true);
    $pre_output = '<script type="text/javascript" src="'.$base_url.'inc/agree.js"></script>';
    $pre_output .= '<script type="text/javascript" src="'.$base_url.'inc/mootools.js"></script>';
    $pre_output .= '<script type="text/javascript" src="'.$base_url.'inc/sl_admin.js"></script>';
    $pre_output .= '<link rel="stylesheet" href="'.$base_url.'css/default.css" type="text/css" />';
    if (isIe(7, $IEbrowser)) {$pre_output .= '<link rel="stylesheet" href="'.$base_url.'css/ie7.css" type="text/css" />';}
    if (isIe(8, $IEbrowser)) {$pre_output .= '<link rel="stylesheet" href="'.$base_url.'css/ie8.css" type="text/css" />';}
    $pre_output .= '<link rel="stylesheet" href="'.$base_url.'css/print.css" type="text/css" media="print" />';
	$pre_output .= '<link rel="stylesheet" href="'.$base_url.'css/new.css" type="text/css" />';
    //end header stuff
    $pre_output .= '<div id="sl_admin_container">';
    
    echo $pre_output . $output . '</div>';
}

// IE detection for sl_act function
function isIe($version, $IEbrowser) {
    if (array_key_exists('ie'.$version, $IEbrowser)) {
        return $IEbrowser['ie'.$version];
    }
    return false;
}

// SL8 protection
function sl_runner(){
    include_once('sl8.php');
}

class AccountWidget{
		public $valid = null;
		public $id = null;
		public $domain = null;
		public $subdomain = null;
		public $fname = null;
		public $lname = null;
		public $r_email = null;
		public $c_email = null;
		public $phone = null;
		public $start_time = null;
		public $exp_time = null;
		public $tz = null;
		public $wk_hrs = null;
		public $we_hrs = null;
		public $acct_type = null;
		public $email_select = null;
		public $num_attacks = null;
		public $cust_404 = null;
		public $rfi_visible = null;
		public $debug = null;
		public $memo = null;
		public $server_ip = null;
		public $server_host = null;
		public $path = null;
		public $bot_lvl = null;
		public $country_list = null;
		public $accessword = null;
		public $mod_high_crit = null;
		public $flood_limit = null;
		public $frame_buster = null;
		public $email_thresh = null;
		public $country_404 = null;
		public $tutorial = null;
		public $admin_select = null;
		public $category = null;
		public $which_db = null;
		public $safe_list = null;
		public $custom_scan = null;
		public $sl_addr = null;

		public function AccountWidget(){
			$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
			$data = $this->sl_post_request('remote4.php',http_build_query(array('act'=>'get_account','host'=>$host),'','&'));
			parse_str(implode('',$data),$acct);
			foreach($acct as $key => $val){
				$this->{$key} = $val;
			}
		}
		private function get_auth(){
			$docRoot = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
			$acctHome = substr($docRoot,0,strrpos($docRoot,'/'));
			if(@file_exists("$acctHome/securelive_max/sl_auth.php")){
				$file = "$acctHome/securelive_max/sl_auth.php";
			}
			elseif(@file_exists(str_replace('\\','/',dirname(__FILE__))."/sl_auth.php")){
				$file = str_replace('\\','/',dirname(__FILE__))."/sl_auth.php";
			}
			elseif(@file_exists("$docRoot/administrator/components/com_securelive/sl_auth.php")){
				$file = "$docRoot/administrator/components/com_securelive/sl_auth.php";
			}
			elseif(@file_exists("$docRoot/wp-content/plugins/securepress-plugin/sl_auth.php")){
				$file = "$docRoot/wp-content/plugins/securepress-plugin/sl_auth.php";
			}
			elseif(@file_exists("$docRoot/e107_plugins/secure_e107/sl_auth.php")){
				$file = "$docRoot/e107_plugins/secure_e107/sl_auth.php";
			}
			elseif(@file_exists("$docRoot/sites/all/modules/secureDrupal/sl_auth.php")){
				$file = "$docRoot/sites/all/modules/secureDrupal/sl_auth.php";
			}
			elseif(@file_exists(str_replace('\\','/',dirname(__FILE__))."/../sl_auth.php")){
				$file = str_replace('\\','/',dirname(__FILE__))."/../sl_auth.php";
			}
			
			if(!isset($file)){
				return false;
			}
			$lines = @file($file);
			if(count($lines)==3){
				return trim($lines[1]);
			}
			return false;
		}
		public function sl_post_request($purl, $data){
			$fp = null; $res_array = array();
			$url = "http://64.50.167.27/securelive";
			if($data != 'file'){ // curl or fopen
			    
			    #put new account authorization
			    $sl_pass = $this->get_auth();
			    if($sl_pass){
					$data = "sl_pass=$sl_pass&".ltrim($data,'?&');
			    }
			    
			    $connected = false;
			    if(function_exists('curl_init') && function_exists('curl_exec')){
			        $ch = curl_init("$url/$purl");
			        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);            //send post data
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        // return web page
			        curl_setopt($ch, CURLOPT_HEADER, false);            // don't return headers
			        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);    // dont follow redirects
			        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 9);        // timeout on connect
			        curl_setopt($ch, CURLOPT_TIMEOUT, 16);                // timeout on response
			        curl_setopt($ch, CURLOPT_ENCODING, "");                // handle all encodings
			        curl_setopt($ch, CURLOPT_USERAGENT, "");            // who am i
			        $response = curl_exec($ch);
			        if($response){
			            $this->connected = "curl";
			        } else {
						$this->connected = "failed to connect with curl";
			        }
			        curl_close($ch);
			    } elseif (function_exists('fopen')) {
			        $old = ini_get('default_socket_timeout');
			        ini_set('allow_url_fopen', 1);
			        $params = array('http' => array('method' => 'POST', 'content' => $data));
			        $ctx = stream_context_create($params);
			        ini_set('default_socket_timeout', 25);
			        $fp = @fopen("$url/$purl", 'rb', false, $ctx);
			        if($fp){
			            $this->connected = "fopen";
			        }
			        ini_set('default_socket_timeout', $old);
			        if(!$fp){
			            $this->connected = "failed to connect with fopen";
			        }
			        $response = @stream_get_contents($fp);
			        @fclose($fp);
			    }
			    $res_array = substr_count($response, "|") ? explode("|", $response) : array($response);
			    return $res_array;
			} elseif($data == 'file'){ // file
			    if(function_exists('curl_init') && function_exists('curl_exec')){
			        $ch = curl_init("$url/$purl");
			        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);            //send post data
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        // return web page
			        curl_setopt($ch, CURLOPT_HEADER, false);            // don't return headers
			        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);    // dont follow redirects
			        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 9);        // timeout on connect
			        curl_setopt($ch, CURLOPT_TIMEOUT, 16);                // timeout on response
			        curl_setopt($ch, CURLOPT_ENCODING, "");                // handle all encodings
			        curl_setopt($ch, CURLOPT_USERAGENT, "");            // who am i
			        $response = curl_exec($ch);
			        curl_close($ch);
			        $resp = explode("\n", $response);
			    } else {
			        $resp = file("$url/$purl");
			    }
			    return $resp;
			}
		}
	}

class ParamWrapper{
		
	private $values;
	
	function set($key, $value){
	    $this->values[$key] = $value;
	}
	function get($key, $default = ''){
	    $value = @$this->values[$key];
	    $result = (empty($value) && ($value !== 0) && ($value !== '0')) ? $default : $value;
	    return $result;
	}
}

class SpamChecker{
	var $isEnabled = false;
	
	public function __construct(){
		global $wpdb;
		
		$rs = $this->QueryDB("SELECT id FROM !spamfilter WHERE type=0");
		if(count($rs) == 0){
			//create the DB
			$fileName = dirname(__FILE__) . "/inc/sl_SpamFilter.sql";
			$sqlFile = file_get_contents($fileName);
			$sqlStatments = explode(";",$sqlFile);
			foreach($sqlStatments as $query){
				$new_query = str_replace("\r", "", str_replace("\n", "", str_replace("#__",$wpdb->prefix, $query)));
				$this->QueryDB($new_query.";", false);
			}
		}

		$this->isEnabled = $this->isEnabled();
	}
	
	public function isEnabled(){
		$rs = $this->QueryDB("SELECT time FROM !spamfilter WHERE type=0 AND term='#Enabled#'");
		$spamFilterEnabled = true;
		if(count($rs) > 0)
			$spamFilterEnabled = (intval($rs[0]->time) == 1);
		else
			$this->QueryDB("INSERT INTO !spamfilter VALUES(null, 1, 0, '#Enabled#')", false);
			
		return $spamFilterEnabled;
	}
	public function CheckIP($ip = null){
		if($ip == null){
			if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'127.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'10.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'172.16.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'192.168.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'localhost')!==0){
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} elseif(isset($_SERVER["HTTP_NS_CLIENT_IP"]) && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'127.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'10.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'172.16.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'192.168.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'localhost')!==0){
				$ip = $_SERVER["HTTP_NS_CLIENT_IP"];
			} elseif(isset($_SERVER["HTTP_CLIENT_IP"]) && strpos($_SERVER["HTTP_CLIENT_IP"],'127.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'10.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'172.16.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'192.168.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'localhost')!==0){
				$ip = $_SERVER["HTTP_CLIENT_IP"];
			} else {
				$ip = $_SERVER["REMOTE_ADDR"];
			}	
		}
		
		if(gettype($ip) == "integer")
			$ip = long2ip($ip);
		
		return(count($this->QueryDB("SELECT id FROM !spamfilter WHERE type=3 AND term='$ip'")) != 0);
	}
	public function CheckUserName($username){
		$safe_list = array( "post",
							"page",
							"attachment",
							"revision",
							"nav_menu_item",
							"publish",
							"future",
							"draft",
							"pending",
							"private",
							"trash",
							"auto-draft",
							"inherit");
		
		if(in_array($username, $safe_list))
			return true;
							
		$rs = $this->QueryDB("SELECT id FROM !spamfilter WHERE type=2 AND term='$username'");
		return (count($rs) == 0);
	}
	public function CheckTerms($values){
		if(gettype($values) == "string"){
			$values = array($values);
		}
		
		$rs = $this->QueryDB("SELECT term FROM !spamfilter WHERE type=4");

		$term = "";
		$termDisplay = "";
		if(count($rs))
			foreach($rs as $r){
				if(strpos($r->term, "~") !== false){
					$parts = explode("~", $r->term, 2);
					if(count($parts) > 1){
						$term = $parts[0];
						$termDisplay = $parts[1];
					}
					else 
						$term = $termDisplay = $r->term;
				}
				else
					$term = $termDisplay = $r->term;
					
				foreach($values as $value)
					if($term != "" && strpos($value,$term) !== false)
						return str_replace($term, "<span style='color: red;'>$termDisplay</span>", htmlentities($value));
			}

		return false;
	}
	public function CheckEMail($email){
		$rs = $this->QueryDB("SELECT id FROM !spamfilter WHERE type=1 AND term='$email'");
		return (count($rs) == 0);
	}
	
	public function QueryDB($query, $return = true){
		global $wpdb;
		
		$query = str_replace("!spamfilter",$wpdb->prefix."sl_SpamFilter", $query);

		if($return)
			return $wpdb->get_results( $query );
		else{
			$wpdb->query( $query );
			return null;
		}
	}
}

?>