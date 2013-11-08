<?php

	/****************************************************************************************************
	* This file is part of SecureLive 8.4.01 / 5.4.01													*
	* Copyright 2008 - 2011 SecureLive, LLC																*
	* http://www.securelive.net																			*
	*																									*
	* LICENSE AND USAGE																					*
	* 	This program is free software distributed under the GPL license.  Full terms of this license 	*
	* 	can be found here: http://www.gnu.org/licenses/gpl.html											*
	*																									*
	*	This software requires a SecureLive Domain License to be fully functional.  Although the 		*
	* 	GPL license allows modification of these files, the SecureLive Service Agreement forbids this.	*
	* 	The full SecureLive agreement can be found here: 												*
	* 	http://www.securelive.net/Information/product-terms-of-use.html									*
	* 																									*
	* 	If you are a SecureLive customer and this program causes problems or does not meet your needs,	*
	* 	contact support@securelive.net or call 888-300-4546 for assistance.								*
	****************************************************************************************************/

	//error_reporting(E_ALL);
	//ini_set('display_errors',1);
	
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
		                $root = str_replace('\\','/',realpath($_SERVER['DOCUMENT_ROOT']));//doc root
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
				$docRoot = str_replace('\\','/',realpath($_SERVER['DOCUMENT_ROOT']));
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
						$blank .= "//start_url_cache\n";
						$blank .= '$expires = 30;'."\n";
						$blank .= "//end_url_cache\n";
						$blank .= "//start_timeout\n";
						$blank .= '$timeout = 3;'."\n";
						$blank .= "//end_timeout\n";
						$blank .= "//start_url_cache_mode\n";
						$blank .= '$cache_mode = 3;'."\n";
						$blank .= "//end_url_cache_mode\n";
						$blank .= "//start_db\n";
						$blank .= '//'."\n";
						$blank .= '//'."\n";
						$blank .= '//'."\n";
						$blank .= '//'."\n";
						$blank .= "//end_db\n";
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
	
	$admin = new SL_Max_Login();

	if($admin->logged_in){
		if(!$admin->try_logout()){
			echo $admin->show_page();
		}
	} else {
		if($admin->is_pwReset()){
			echo $admin->show_pwReset();
		} else {
			echo $admin->login_form();
		}
	}
	
	class SL_Max_Login{
		public $logged_in = false;
		public $messages = array();
		private $lib;
		
		public function SL_Max_Login(){
			#delete old passwd files
			$file = false;
			$homeDir = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
			$homeDir = substr($homeDir,0,strrpos($homeDir,'/'));
			if(@file_exists("$homeDir/securelive_max/passwd_reset.php")){
				$file = "$homeDir/securelive_max/passwd_reset.php";
			} elseif(@file_exists(str_replace('\\','/',dirname(__FILE__))."/passwd_reset.php")){
				$file = str_replace('\\','/',dirname(__FILE__))."/passwd_reset.php";
			}
			if($file){
				$modTime = filemtime($file);
				$timePast = time() - $modTime;
				if($timePast>(60*60)){
					@unlink($file);
				}
			}
			
			#check if logged in
			if(!isset($_SESSION)){session_start();}
			$this->lib = new adminFuncs();
			if($this->session_ok()){
				$this->logged_in = true;
			} else {
				if($this->logging_in_ok()){
					if($this->lib->config_exists()){
						require($this->lib->config_fp);
						if(isset($secret)){
							$_SESSION['_sl_logged_in_'] = md5($secret);
							$this->logged_in = true;
						} else {
							array_push($this->messages,'Error in config file. Please delete it: '.$this->lib->config_fp);
						}
					} else {
						array_push($this->messages,'Could not create config file: '.$this->lib->config_fp);
					}
				}
			}
		}
		public function is_pwReset(){
			return (isset($_REQUEST['sl_pw_reset']) && $_REQUEST['sl_pw_reset']=='true');
		}
		public function show_pwReset(){
			
			$step = isset($_REQUEST['step']) ? preg_replace("/[^a-zA-Z0-9_]/",'',$_REQUEST['step']) : '';
			
			if($step==@$_SESSION['sl_pw_reset_check']){
				#get first user or fail
				$users = $this->get_users();
				$user = isset($users[0]) ? @substr($users[0],0,@strrpos($users[0],':')) : null;
				if(empty($user)){
					return "Could not find a valid user. Password reset cannot be completed.";
				}

				#check for writable folder or fail
				$file = false;
				$homeDir = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
				$homeDir = substr($homeDir,0,strrpos($homeDir,'/'));
				if(@file_exists("$homeDir/securelive_max/") && @is_writable("$homeDir/securelive_max/")){
					$file = "$homeDir/securelive_max/passwd_reset.php";
				} elseif(@is_writable(dirname(__FILE__))){
					$file = str_replace('\\','/',dirname(__FILE__))."/passwd_reset.php";
				}
				if(!$file){
					$showDir = str_replace("$homeDir",'',str_replace('\\','/',dirname(__FILE__)));
					return "The folder $showDir is unwritable. Password reset cannot be completed.";
				}
				
				#get a valid email address or fail
				$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
				$data = $this->lib->sl_post_request('remote4.php',http_build_query(array('act'=>'get_account','host'=>$host),'','&'));
				parse_str(implode('',$data),$acct);
				$email = false;
				if(isset($acct['c_email']) && !empty($acct['c_email']) && preg_match("/.@.{1,}\..{1,}/",$acct['c_email'])){
					$email = $acct['c_email'];
				} elseif(isset($acct['r_email']) && !empty($acct['r_email']) && preg_match("/.@.{1,}\..{1,}/",$acct['r_email'])){
					$email = $acct['r_email'];
				}
				if(!$email){
					return "Your email address could not be retrieved. Password reset cannot be completed. Please contact SecureLive to validate and activate your account (888-300-4546, support@securelive.net).";
				}
				
				#generate a key to save and email
				for($key='';strlen($key)<16;$key.=chr(rand(0,127))){};
				$md5 = md5($key);

				#write a file containing the login that can be changed, overwrite if file exists - user:validationMD5 (not old password)
				$fp = fopen($file,'w+');
				fwrite($fp,"<?php /*\n");
				fwrite($fp,"$user:$md5\n");
				fwrite($fp,"*/ ?>");
				fclose($fp);
				
				#send email containing the username that can now have a new password, link to reset
				#make link
				$https = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : getenv('HTTPS');
	            if((is_string($https) && strtolower($https)!='off') ||($https && !is_string($https))){
					$http = 'https';
	            } else {
					$http = 'http';
	            }
				$domain = "$http://".$_SERVER['HTTP_HOST'];
				$resetLink = "$domain".$this->lib->sl_get_path()."/index.php?sl_pw_reset=true&step=get_new&auth=$md5";
				$adminLink = "$domain".$this->lib->sl_get_path();
				#make message
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'127.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'10.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'172.16.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'192.168.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'localhost')!==0){
					$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
				} elseif(isset($_SERVER["HTTP_NS_CLIENT_IP"]) && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'127.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'10.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'172.16.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'192.168.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'localhost')!==0){
					$ip = $_SERVER["HTTP_NS_CLIENT_IP"];
				} elseif(isset($_SERVER["HTTP_CLIENT_IP"]) && strpos($_SERVER["HTTP_CLIENT_IP"],'127.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'10.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'172.16.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'192.168.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'localhost')!==0){
					$ip = $_SERVER["HTTP_CLIENT_IP"];
				} else {
					$ip = $_SERVER["REMOTE_ADDR"];
				}

				$message = '<p style="font-size: 18px;font-family:verdana;">Secure<span style="color:red;">Live</span> Admin Password Reset Request - <i>'.date("m/d/Y H:i:s").'</i></p>

<p style="font-size: 13px;font-family:verdana;">You are receiving this message because someone has requested a password reset for your 
SecureLive Admin, located here: '.$adminLink.'</p>

<p style="font-size: 13px;font-family:verdana;">If you did not request this change, disregard this message and no change will be made. 
The request was made from IP address <b>'.$ip.'</b>. You have 1 hour to complete the password reset process.</p>

<p style="font-size: 13px;font-family:verdana;"><b>In order to reset your SecureLive Admin login password,</b> follow the link provided below:
<br/><a href="'.$resetLink.'">'.$resetLink.'</a></p>

<p style="font-size: 13px;font-family:verdana;">On the password reset page, you will need to provide the expected Username, "<b>'.$user.'</b>", 
and confirm your new desired password.</p>

<p style="font-size: 13px;font-family:verdana;">If you are unable to reset your password, please contact SecureLive at 888-300-4546 or 
<a href="mailto:support@securelive.net">support@securelive.net</a></p>

<p style="font-size: 11px;font-family:verdana;"><br/><br/><i>This is an automated message, please do not reply to this email.</i></p>';
				
				$sent = mail($email,"SecureLive Admin Password Reset Request",$message,$headers);
				
				if($sent){
					return "Message sent. Please check your email to finish the password reset process.";
				} else {
					return "Message failed. Can your server use PHP mail? Unable to complete password reset.";
				}
			}
			elseif($step=='get_new' || $step=='final'){
				#get auth for checking
				$auth = isset($_REQUEST['auth']) ? preg_replace("/[^a-zA-Z0-9]/",'',$_REQUEST['auth']) : null;
				if(empty($auth)){
					return "Unauthorized Request";
				}
				#check for file
				$file = false;
				$homeDir = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
				$homeDir = substr($homeDir,0,strrpos($homeDir,'/'));
				if(@is_readable("$homeDir/securelive_max/")){
					$file = "$homeDir/securelive_max/passwd_reset.php";
				} elseif(@is_readable(str_replace('\\','/',dirname(__FILE__))."/passwd_reset.php")){
					$file = str_replace('\\','/',dirname(__FILE__))."/passwd_reset.php";
				}
				if(!$file){
					return "Unauthorized Request";
				}
				#get data
				$user = false;
				$md5 = false;
				$lines = file($file);
				if(count($lines)==3){
					$temp = explode(':',$lines[1]);
					$user = $temp[0];
					$md5 = preg_replace("/[^a-zA-Z0-9]/",'',$temp[1]);
				}
				if(!$user || !$md5){
					return "Unauthorized Request";
				}
				
				#validate the request with the passwd file
				if($auth!=$md5){
					return 'Unauthorized Request';
				}

				#continue on to do actions
				if($step=='get_new'){
					$str = $this->login_header();
					$msg = '';
					$str .= '<div class="login-container">
		                <div class="login-box">
		                    <form action="'.$_SERVER["QUERY_STRING"].'" method="post">
		                        <div class="login-form">
		                            <h2>SecureLive Password Reset</h2>
		                            <div>'.(!empty($msg)?$msg:'').'</div>
		                            <div class="input-box input-left"><label for="username">Username:</label><br/>
		                                <input id="username" name="user" type="text" class="required-entry input-text" onkeyup="stripTheseChars(this)" />
		                            </div>
		                            <div class="input-box input-right"><label for="password">Password:</label><br />
		                                <input id="password" name="password1" type="password" class="required-entry input-text" onkeyup="check_pw_strength(this)" />
		                                <div id="pw_checker_div"><div><a href=\'javascript:void(0)\' onclick=\'strength_alert()\'>strength:</a> 0 out of 5</div></div>
		                            </div>
		                            <div class="clear"></div>
		                            <div class="input-box input-left"><label for="password-2">Confirm Password:</label><br />
		                                <input id="password-2" name="password2" type="password" class="required-entry input-text" />
		                            </div>
		                            <div class="clear"></div>
		                            <div class="form-buttons">
		                                <input type="submit" class="form-button" value="Set New Password" />
		                                <input type="hidden" name="sl_pw_reset" value="true" />
		                                <input type="hidden" name="step" value="final" />
		                                <input type="hidden" name="auth" value="'.$md5.'" />
		                            </div>
		                        </div>
		                        <p class="legal">Code and contents (C) 2009-2011 SecureLive, LLC -All rights reserved.</p>
		                    </form>
		                    <div class="bottom"></div>
		                </div>
		            </div>'."\n";
			        return $this->head().$str.$this->footer();
				}
				elseif($step=='final'){
					#validate form
					$failed = true;
					
					if(isset($_POST['user'])){
						#get the data, filtered
						$expectedUser = $user;
						$sentUser = '';
						$filter = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-0123456789@.';
						for($i=0;$i<strlen($_POST['user']);$i++){
							$char = substr($_POST['user'],$i,1);
							if(substr_count($filter,$char)){
								$sentUser .= $char;
							}
						}
						#validate user
						if($sentUser==$expectedUser){
							#see if passwords match
							$password1 = isset($_POST['password1']) ? $_POST['password1'] : null;
							$password2 = isset($_POST['password2']) ? $_POST['password2'] : null;
							$password1 = empty($password1) ? null : md5($password1);
							$password2 = empty($password2) ? null : md5($password2);
							
							if($password1 && $password2 && $password1==$password2){
								$failed = false;
							} else {
								$failed = true;
								$msg = 'Your passwords did not match or were empty.';
							}
						} else {
							$failed = true;
							$msg = 'You must provide the correct username.';
						}
					} else {
						$failed = true;
						$msg = 'You must provide the correct username.';
					}
					
					
					#give old form with message
					if($failed){
						$str = $this->login_header();
						$str .= '<div class="login-container">
			                <div class="login-box">
			                    <form action="index.php" method="post">
			                        <div class="login-form">
			                            <h2>SecureLive Password Reset</h2>
			                            <div>'.(!empty($msg)?$msg:'').'</div>
			                            <div class="input-box input-left"><label for="username">Username:</label><br/>
			                                <input id="username" name="user" type="text" class="required-entry input-text" onkeyup="stripTheseChars(this)" />
			                            </div>
			                            <div class="input-box input-right"><label for="password">Password:</label><br />
			                                <input id="password" name="password1" type="password" class="required-entry input-text" onkeyup="check_pw_strength(this)" />
			                                <div id="pw_checker_div"><div><a href=\'javascript:void(0)\' onclick=\'strength_alert()\'>strength:</a> 0 out of 5</div></div>
			                            </div>
			                            <div class="clear"></div>
			                            <div class="input-box input-left"><label for="password-2">Confirm Password:</label><br />
			                                <input id="password-2" name="password2" type="password" class="required-entry input-text" />
			                            </div>
			                            <div class="clear"></div>
			                            <div class="form-buttons">
			                                <input type="submit" class="form-button" value="Set New Password" />
			                                <input type="hidden" name="sl_pw_reset" value="true" />
			                                <input type="hidden" name="step" value="final" />
			                                <input type="hidden" name="auth" value="'.$md5.'" />
			                            </div>
			                        </div>
			                        <p class="legal">Code and contents (C) 2009-2011 SecureLive, LLC -All rights reserved.</p>
			                    </form>
			                    <div class="bottom"></div>
			                </div>
			            </div>'."\n";
				        return $this->head().$str.$this->footer();
					} else {
						#data accepted, save it to the file or fail
						$users = $this->get_users();
						$users[0] = "$expectedUser:$password1";
						#write the new
						$this->put_users($users);
						
						#check if saved
						$users = $this->get_users();
						$saved = (@$users[0]=="$expectedUser:$password1");
						
						#log in if successful
						if($saved){
							#delete the passwd file
							$file = false;
							$homeDir = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
							$homeDir = substr($homeDir,0,strrpos($homeDir,'/'));
							if(@file_exists("$homeDir/securelive_max/")){
								$file = "$homeDir/securelive_max/passwd_reset.php";
							} elseif(@file_exists(str_replace('\\','/',dirname(__FILE__))."/passwd_reset.php")){
								$file = str_replace('\\','/',dirname(__FILE__))."/passwd_reset.php";
							}
							if($file){
								@unlink($file);
							}
							
							#log in and refresh
							if($this->lib->config_exists()){
								require($this->lib->config_fp);
								if(isset($secret)){
									$_SESSION['_sl_logged_in_'] = md5($secret);
									$this->logged_in = true;
									header('location: index.php');
									die();
								} else {
									return 'Error in config file. Please delete it: '.$this->lib->config_fp;
								}
							} else {
								return 'Could not create config file: '.$this->lib->config_fp;
							}
							
						} else {
							return "Error: could not write the new data to ".htmlentities(dirname($this->lib->config_fp)).". Temporarily set this folder to 777 permissions, follow the link from your email, and try again.";
						}
					}
				}
			}
		}
		public function show_page(){
			define('SL_Admin', true);
	        include_once('sl_admin.php');
	        return $this->head() . $this->logout_btn() . $output . $this->footer();
		}
		public function login_form(){
			$users = $this->get_users();
			$str = $this->login_header();
			$this->messages = array_unique($this->messages);
			$msg = implode('<br/>',$this->messages);
			if(count($users)){
				$str .= '<div class="login-container">
                    <div class="login-box">
                        <form action="index.php" method="post">
                            <div class="login-form">
                                <h2>SecureLive Max Admin Login</h2>
                                <div>'.(!empty($msg)?$msg:'').'</div>
                                <div class="input-box input-left"><label for="username">Username:</label><br/>
                                    <input id="username" name="sl_un" type="text" class="required-entry input-text" onkeyup="stripTheseChars(this)" />
                                </div>
                                <div class="input-box input-right"><label for="password">Password:</label><br />
                                    <input id="password" name="sl_pw" type="password" class="required-entry input-text" onkeyup="check_pw_strength(this)" />
                                </div>
                                <div id="new_un" style="display:none;" class="input-box input-left"><label for="username_new">New Username:</label><br/>
                                    <input id="username_new" name="sl_new_un" type="text" class="required-entry input-text" onkeyup="stripTheseChars(this)" />
                                </div>
                                <div id="new_pw" style="display:none;" class="input-box input-right"><label for="password_new">New Password:</label><br />
                                    <input id="password_new" name="sl_new_pw" type="password" class="required-entry input-text" onkeyup="check_pw_strength(this)" />
                                    <div id="pw_checker_div"><div><a href=\'javascript:void(0)\' onclick=\'strength_alert()\'>strength:</a> 0 out of 5</div></div>
                                </div>
                                <div id="new_pw2" style="display:none;" class="input-box input-left"><label for="password_new2">Confirm New Password:</label><br />
                                    <input id="password_new2" name="sl_new_pw2" type="password" class="required-entry input-text" />
                                </div>
                                <div class="clear"></div>
                                <div class="form-buttons">
                                	<div style="float:left;">
                                		<input type="button" class="form-button" value="Forgot Password?" onClick="sl_forgot_pass()">
                                    	<input type="button" class="form-button" value="Change Login Info" onClick="show_change_info(this)">
                                    </div>
                                    <input type="submit" class="form-button" value="Login" title="Login" />
                                </div>
                            </div>
                            <p class="legal">Code and contents (C) 2009-2011 SecureLive, LLC -All rights reserved.</p>
                        </form>
                        <div class="bottom"></div>
                    </div>
                </div>'."\n";
			} else {
				$msg = 'You must create a login for the SecureLive Admin.';
				$str .= '<div class="login-container">
                    <div class="login-box">
                        <form action="index.php" method="post">
                            <div class="login-form">
                                <h2>SecureLive Max Admin Login</h2>
                                <div>'.(!empty($msg)?$msg:'').'</div>
                                <div class="input-box input-left"><label for="username">Username:</label><br/>
                                    <input id="username" name="sl_first_un" type="text" class="required-entry input-text" onkeyup="stripTheseChars(this)" />
                                </div>
                                <div class="input-box input-right"><label for="password">Password:</label><br />
                                    <input id="password" name="sl_first_pw" type="password" class="required-entry input-text" onkeyup="check_pw_strength(this)" />
                                    <div id="pw_checker_div"><div><a href=\'javascript:void(0)\' onclick=\'strength_alert()\'>strength:</a> 0 out of 5</div></div>
                                </div>
                                <div class="clear"></div>
                                <div class="input-box input-left"><label for="password2">Confirm Password:</label><br />
                                    <input id="password2" name="sl_first_pw2" type="password" class="required-entry input-text" />
                                </div>
                                <div class="clear"></div>
                                <div class="form-buttons">
                                    <input type="submit" class="form-button" value="Create and Login" />
                                </div>
                            </div>
                            <p class="legal">Code and contents (C) 2009-2011 SecureLive, LLC -All rights reserved.</p>
                        </form>
                        <div class="bottom"></div>
                    </div>
                </div>'."\n";
			}
	        return $this->head().$str.$this->footer();
		}
		public function try_logout(){
			if(isset($_POST['sl_logout'])){
	            session_unset();
	            session_destroy();
	            header('location: index.php');
	            die();
	            return true;
	        } else {
				return false;
	        }
		}
		private function session_ok(){
			if($this->lib->config_exists()){
				require($this->lib->config_fp);
				if(isset($secret)){
					if(isset($_SESSION['_sl_logged_in_']) && $_SESSION['_sl_logged_in_']==md5($secret)){
						return true;
					} else {
						//array_push($this->messages,'Invalid session token.');
					}
				} else {
					$users = $this->get_users();
					if(count($users)==0){
						//delete it and try again
						unlink($this->lib->config_fp);
						if($this->lib->config_exists()){
							array_push($this->messages,'Session token has been reset.');
						} else {
							array_push($this->messages,'Could not create the config file: '.$this->lib->config_fp);
						}
					} else {
						array_push($this->messages,'Error in config file. Please delete it: '.$this->lib->config_fp);
					}
				}
			} else {
				array_push($this->messages,'Could not create config file: '.$this->lib->config_fp);
			}
			return false;
		}
		private function get_users(){
			$arr = array();
			if($this->lib->config_exists()){
				$contents = file_get_contents($this->lib->config_fp);
				$start = stripos($contents,'start_users')+strlen("start_users");
				$length = stripos($contents,'end_users')-$start;
				$usersString = trim(substr($contents,$start,$length));
				$arr = explode("\n",$usersString);
				foreach($arr as $key=>$val){
					$arr[$key] = trim($val);
				}
				$arr = array_filter($arr);
			} else {
				array_push($this->messages,'Could not create config file: '.$this->lib->config_fp);
			}
			return $arr;
		}
		private function put_users($users){
			if($this->lib->config_exists()){
				$contents = file_get_contents($this->lib->config_fp);
				$part1 = substr($contents,0,stripos($contents,"start_users\n")+strlen("start_users\n"));
				$part2 = substr($contents,stripos($contents,"end_users"));
				$users = array_filter($users);
				$usersString = implode("\n",$users)."\n";
				if(!file_put_contents($this->lib->config_fp,$part1.$usersString.$part2)){
					array_push($this->messages,'Could not write to the config file: '.$this->lib->config_fp);
				}
			} else {
				array_push($this->messages,'Could not create config file: '.$this->lib->config_fp);
			}
		}
		private function logging_in_ok(){
			$users = $this->get_users();
			$filter = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-0123456789@.';
			if(isset($_POST['sl_first_un']) && isset($_POST['sl_first_pw']) && isset($_POST['sl_first_pw2'])){
				if(count($users)==0){
					$userName = $_POST['sl_first_un'];
					$userNameOK = true;
					//filter username
					for($i=0;$i<strlen($userName);$i++){
						$char = substr($userName,$i,1);
						if(!substr_count($filter,$char)){
							$userNameOK = false;
							break;
						}
					}
					if($userNameOK){
						if($_POST['sl_first_pw'] == $_POST['sl_first_pw2']){
							array_push($users,"$userName:".md5($_POST['sl_first_pw']));
							$this->put_users($users);
							return true;
						} else {
							array_push($this->messages,'The passwords do not match.');
						}
					} else {
						array_push($this->messages,'The username has invalid characters.');
					}
				} else {
					array_push($this->messages,'A user already exists.');
				}
			}
			elseif(isset($_POST['sl_un']) && isset($_POST['sl_pw'])){
				$userOK = false;
				foreach($users as $user){
					if($user == $_POST['sl_un'].":".md5($_POST['sl_pw'])){
						$userOK = true;
					}
				}
				if($userOK){
					if(isset($_POST['sl_new_un']) && isset($_POST['sl_new_pw']) && isset($_POST['sl_new_pw2']) && !empty($_POST['sl_new_un']) && !empty($_POST['sl_new_pw']) && !empty($_POST['sl_new_pw2'])){
						$userName = $_POST['sl_new_un'];
						$userNameOK = true;
						//filter username
						for($i=0;$i<strlen($userName);$i++){
							$char = substr($userName,$i,1);
							if(!substr_count($filter,$char)){
								$userNameOK = false;
								break;
							}
						}
						if($userNameOK){
							if($_POST['sl_new_pw'] == $_POST['sl_new_pw2']){
								//trying to create / modify a user
								$modified = false;
								for($i=0;$i<count($users);$i++){
									if(substr_count($users[$i],"$userName:")){
										$users[$i] = "$userName:".md5($_POST['sl_new_pw']);
										$modified = true;
									}
								}
								if(!$modified){
									array_push($users,"$userName:".md5($_POST['sl_new_pw']));
								}
								$this->put_users($users);
								return true;
							} else {
								array_push($this->messages,'The new passwords do not match.');
							}
						} else {
							array_push($this->messages,'The new username has invalid characters.');
						}
					} else {
						return true;
					}
				} else {
					array_push($this->messages,'Incorrect login credentials.');
				}
			}
			return false;
		}
		private function head(){
	        $pre_output = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'."\n";
	        $pre_output .= '<html>'."\n";
	        $pre_output .= '<head>'."\n";
	        $pre_output .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'."\n";
	        $pre_output .= '<title>SecureLive Max Administrator</title>'."\n";
	        $pre_output .= '<script type="text/javascript" src="inc/mootools.js"></script>'."\n";
	        $pre_output .= '<script type="text/javascript" src="inc/jquery-1.4.4.min.js"></script>'."\n";
	        $pre_output .= '<script type="text/javascript" src="inc/sl_admin.js"></script>'."\n";
	        $pre_output .= '<script type="text/javascript" src="inc/agree.js"></script>'."\n";
	        $pre_output .= '<link rel="stylesheet" href="css/default.css" type="text/css" />'."\n";
	        $pre_output .= '<link rel="stylesheet" href="css/new.css" type="text/css" />'."\n";
	        $pre_output .= '<!--[if lte IE 7]>'."\n";
	        $pre_output .= '<link rel="stylesheet" href="css/ie7.css" type="text/css" />'."\n";
	        $pre_output .= '<![endif]-->'."\n";
	        $pre_output .= '<!--[if gte IE 8]>'."\n";
	        $pre_output .= '<link rel="stylesheet" href="css/ie8.css" type="text/css" />'."\n";
	        $pre_output .= '<![endif]-->'."\n";
	        $pre_output .= '<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />'."\n";
	        $pre_output .= '</head>'."\n";
	        $pre_output .= '<body>'."\n";
	        $pre_output .= '<div id="sl_admin_container">'."\n";
	        return $pre_output;
	        
		}
		private function logout_btn(){
			$str = '';
	        $str .= '<div align="center">'."\n";
	        $str .= '   <div id="sl_logout_btn">'."\n";
	        $str .= '        <form id="sl_logout_form_elm" action="index.php" method="post">'."\n";
	        $str .= '           <input type="hidden" value="1" name="sl_logout" />'."\n";
	        $str .= '           <input type="submit" value="Logout" />'."\n";
	        $str .= '       </form>'."\n";
	        $str .= '   </div>'."\n";
	        $str .= '</div>'."\n";
	        return $str;
		}
		private function footer(){
			return '</div></body></html>';
		}
		private function login_header(){
			#stop some bots with an md5 on step1
			for($key='';strlen($key)<16;$key.=chr(rand(0,127))){};
			$_SESSION['sl_pw_reset_check'] = md5($key);
	        $str = '<link type="text/css" rel="stylesheet" href="css/login.css" />';
	        $str .= '<script type="text/javascript">
	        			function sl_forgot_pass(){
							check = confirm("You are about to reset your SecureLive Admin login password. A message will be sent to the contact email listed on your SecureLive Account for validation. You will only have one (1) hour to complete the password reset or you will have to start over.");
							if(check){
								//waiting cursor
								$("body").css("cursor","wait");
								$("a").css("cursor","wait");
								$(".pointer").css("cursor","wait");
								//ajax
								$.ajax({
									url:"index.php",
									type:"post",
									data:"sl_pw_reset=true&step='.$_SESSION['sl_pw_reset_check'].'",
									success:function(response){
										//unwait
										$("body").css("cursor","default");
										$("a").css("cursor","pointer");
										$(".pointer").css("cursor","pointer");
										alert(response);
									},
									error:function(){
										//unwait
										$("body").css("cursor","default");
										$("a").css("cursor","pointer");
										$(".pointer").css("cursor","pointer");
										alert("Password reset failed do to a server error. Try reloading the page.");
									}
								});
							}
	        			}
        				function show_change_info(obj){
	                        obj.value = obj.value == "Change Login Info" ? "Hide New Info" : "Change Login Info";
	                        document.getElementById("new_un").style.display = document.getElementById("new_un").style.display == "table-row" ? "none" : "table-row";
	                        document.getElementById("new_pw").style.display = document.getElementById("new_pw").style.display == "table-row" ? "none" : "table-row";
	                        document.getElementById("new_pw2").style.display = document.getElementById("new_pw2").style.display == "table-row" ? "none" : "table-row";
	                    }
	                    function check_pw_strength(x){
	                        //input_txt = stripTheseChars(",`<>\'\"\\\/",x);
	                        input_txt = x.value
	                        output_div = document.getElementById("pw_checker_div");
	                        strength = 0;
	                        strength += scanTextFor("abcdefghijklmnopqrstuvwxyz",input_txt);
	                        strength += scanTextFor("ABCDEFGHIJKLMNOPQRSTUVWXYZ",input_txt);
	                        strength += scanTextFor("0123456789",input_txt);
	                        strength += scanTextFor("~!@#$%^&*()-_=+[]{}:;.?|",input_txt);
	                        strength += input_txt.length > 7 ? 1 : 0;
	                        
	                        while(output_div.childNodes.length > 0){
	                            output_div.removeChild(output_div.childNodes[0]);
	                        }
	                        newdiv = document.createElement("div");
	                        newdiv.innerHTML = "<a href=\'javascript:void(0)\' onclick=\'strength_alert()\'>strength:</a> " + strength + " out of 5";
	                        output_div.appendChild(newdiv);
	                    }
	                    function stripTheseChars(object){
                    		list = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-0123456789@.";
	                        text = object.value;
	                        newtext = "";
	                        for(i=0;i<text.length;i++){
	                            if(list.indexOf(text.charAt(i)) > -1){
	                                newtext += text.charAt(i);
	                            }
	                        }
	                        object.value = newtext;
	                        return newtext;
	                    }
	                    function scanTextFor(list, text){
	                        for(i=0;i<text.length;i++){
	                            if(list.indexOf(text.charAt(i)) > -1){
	                                return 1;
	                            }
	                        }
	                        return 0;
	                    }
	                    function strength_alert(){
	                        alert("To achieve a password strength of 5, include the following:\n- A Lowercase Letter\n- An Uppercase Letter\n- A Number\n- A Special Character (such as *)\n- Password Length of 8 or More Characters");
	                    }
	                 </script>'."\n";
	        return $str;
	    }
	}	
?>