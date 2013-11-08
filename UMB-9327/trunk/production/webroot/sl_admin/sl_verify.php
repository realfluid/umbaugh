<?php

	/****************************************************************************************************
	* This file is part of SecureLive 8.3.02 / 5.3.02													*
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
	
	#FOR SERVER EDITION

	define("MOD_PATH", ".");
	define("IMG_PATH", MOD_PATH."/images");
	
	if(!isset($_GET['mode']) || $_GET['mode'] == 'ajax'){
		define("IMG_PATH", "images");
		$isIE7 = (bool)(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7") !== false);
		$popup_div = false;
		$badge = getBadge(null, $popup_div, $isIE7);
		echo "	<HTML>
					<head>
						".getJS($popup_div)."
					</head>
					<body style='background: #D00000;'>
						
					</body>
				</HTML>";
	}
	
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
	if(!class_exists('Account')){
		class Account{
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

			public function Account(){
				$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
				$data = $this->sl_post_request('remote4.php',http_build_query(array('act'=>'get_account','host'=>$host),'','&'));
				parse_str(implode('',$data),$acct);
				foreach($acct as $key => $val){
					$this->{$key} = $val;
				}
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
		}
	}
	
	$verify = new Verify();
	
	if($verify->account->valid=='true'){
		echo $verify->showBadge_contents();
	}
	
	unset($verify);
	
	class Verify{
		public $sl_module_ver = '5.2.06';
		public $account = null;
		public $filepath = null;
		public $ip = null;
		private $host = null;
		private $uri = null;
		private $config_fp = null;
		public $connection;
		
		public function Verify(){
			$this->host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
			$this->account = new Account();
			$lib = new adminFuncs();
			$this->filepath = $lib->sl_get_path();
			$this->uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
			$this->ip = isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : (isset($_SERVER["HTTP_CLIENT_IP"]) ? $_SERVER["HTTP_CLIENT_IP"] : $_SERVER["REMOTE_ADDR"]);
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
		
		public function showBadge_contents(){
			$nl = "\n";
			$img_folder = IMG_PATH;
			
			$domainName = '';
			//$this->account->domain = 'A123456789B123456789C123456789D123456789E123456789';   //Test string for overflow
			if(strlen($this->account->domain) > 33){
				//first 15
				$domainName .= substr($this->account->domain, 0, 15);
				//insert ...
				$domainName .= '...';
				//last 15
				$domainName .= substr($this->account->domain, strlen($this->account->domain) - 15, 15);
			}
			else{
				$domainName = $this->account->domain;
			}
			
			$extra_table_style = "";
			$header_row = '';
			$img = "<img id='sl_popup_refresh' src_spin='".IMG_PATH."/spinner.gif' src_refresh='".IMG_PATH."/refresh.png' src='".IMG_PATH."/refresh.png' style=\"cursor: pointer; position: absolute !important; right: -7px !important; top: -4px !important;\" onclick='return GetContent();' />";
			if(!isset($_GET['mode']) || $_GET['mode'] != 'ajax'){
				$extra_table_style = "margin: auto; background: #D00000;";
				$img = "";
				$header_row = "
					<tr>
						<td colspan='2' style='background: black; font-weight: bold; font-size: 18px; color: white; padding: 3px; border-radius: 4px; -moz-border-radius: 4px;'>
							SecureLive Website Protection 
						</td>
					</tr>
				";
			}
			
			
			$output = "
				$img
				<table style=\"color: white !important; width: 475px !important; height: 126px !important; font-size: 12px; !important; $extra_table_style\" cellspacing=\"0\" cellpadding=\"0\">
					<tbody>
						$header_row
						<tr>
							<td style=\"color: white !important; text-align: right !important; font-weight: bold  !important;\">VERIFIED AT:</td>
							<td style=\"color: white !important; padding-left: 6px !important;\">".date("F d, Y h:i:s A")."</td>
						</tr>
						<tr>
							<td style=\"color: white !important; text-align: right !important; font-weight: bold !important;\">DOMAIN NAME:</td>
							<td style=\"color: white !important; padding-left: 6px !important;\">$domainName</td>
						</tr>
						<tr>
							<td style=\"color: white !important; text-align: right !important; font-weight: bold !important;\">PROTECTED SINCE:</td>
							<td style=\"color: white !important; padding-left: 6px !important;\">".date("F d, Y", $this->account->start_time)."</td>
						</tr>
						<tr>
							<td style=\"color: white !important; text-align: right !important; font-weight: bold  !important;\">HACKS BLOCKED:</td>
							<td style=\"color: white !important; padding-left: 6px !important;\">".$this->account->num_attacks."</td>
						</tr>
						<tr>
							<td colspan=\"2\">
								<div style=\"width: 100% !important; height: 100% !important;\">
									<table style=\"width: 100% !important; height: 100% !important;\" cellspacing=\"0\" cellpadding=\"0\">
										<tbody>
											<tr>
												<td style=\"width: 6px !important; height: 6px !important; background-image: url(".IMG_PATH."/blk_curve_r12_TL.png) !important;\"></td>
												<td style=\"background-color: black !important;\"></td>
												<td style=\"width: 6px !important; height: 6px !important; background-image: url(".IMG_PATH."/blk_curve_r12_TR.png) !important;\"></td>
											</tr>
											<tr>
												<td style=\"width: 6px; background-color: black !important;\"></td>
												<td style=\"background-color: black !important;\">
													<div style=\"width: 440px !important; line-height: 18px !important; color: white !important;\">
														<img style=\"position: absolute;!important\" src=\"".IMG_PATH."/lock.png\" />
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														Web based security enforced by <a target=\"_blank\" href=\"http://www.securelive.net\">SecureLive</a>, a patented security solution that blocks and alerts in real time.
													</div>
												</td>
												<td style=\"width: 6px !important; background-color: black; !important\"></td>
											</tr>
											<tr>
												<td style=\"width: 6px !important; height: 6px !important; background-image: url(".IMG_PATH."/blk_curve_r12_BL.png) !important;\"></td>
												<td style=\"background: black; !important\"></td>
												<td style=\"width: 6px !important; height: 6px !important; background-image: url(".IMG_PATH."/blk_curve_r12_BR.png) !important;\"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			";
			
			return $output;
		}//reurn string
	}
	
	function getJS($popup_div){
		if($popup_div === false)
			return '';
			
		$mod_loc = MOD_PATH.'/sl_verify.php?mode=ajax';
		
		#fix $popup_div's HTML for JS
		{
			$replaces = array(	"\r" => "",
								"\n" => "",
								"\"" => "\\\"");
			foreach($replaces as $key => $val)
				$popup_div = str_replace($key, $val, $popup_div);
		}
		
		
		
		if(isset($_GET['mode']) && $_GET['mode'] == 'ajax'){
			$run = "SecureLive_mod_Init();";
		}
		else {
			$run = "";
		}
		
		return <<<JS
			<script language="JavaScript" type="text/javascript">
			    sl_getting_contents = false;
				sl_mod_got_content = false;
				$run
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
		if($params != null){
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
		}
		else {
			$s = 0;
			$t = 0;
			$c =0;
			$sl_position = 0;
			$sl_pad_top = 0;
			$sl_pad_right =0;
			$sl_pad_left = 0;
			$sl_pad_bottom = 0;
			$sl_margin_top = 0;
			$sl_margin_right = 0;
			$sl_margin_left = 0;
			$sl_margin_bottom = 0;
			$custom_position = 0;
			$custom_zindex = 0;
			$sl_popup = 1;
			$mod_suffix = 0;
		}
	        
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
		$img_folder = IMG_PATH;
			
		$ie_7hack_closeStyle = '';
		if($isIE7){
			$ie_7hack_closeStyle = 'position: absolute !important; right: 0px !important; top: 5px !important;';
		}

		$output = "
			<div id=\"sl_popup_container\" style=\"display: none; position: absolute !important; top: 50% !important; left: 50% !important; width: 500px !important; height: 174px !important; margin-left: -250px !important; margin-top: -100px; padding: 8px !important;\">
				<table cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100% !important; height: 100% !important;\" id='sl_popup_table'>
					<tbody>
						<tr>
							<td style=\"width: 12px !important; height: 24px !important; background-image: url($img_folder/black_TL.png) !important;\"></td>
							<td style=\"height: 23px !important; background: #000000 !important; font-size: 16px !important; padding-top: 1px !important; color: #D0D0D0 !important; position: relative !important; font-weight: bold !important;\">
								<div style=\"width: 100% !important; margin-top: 3px !important;\">
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
							<td style=\"width: 12px !important; height: 12px !important; background-image: url($img_folder/curve_BL.png) !important;\"></td>
							<td style=\"background: #D00000 !important; border-bottom: 2px solid black !important;\">
								<div style=\"width: 1px; height: 1px;\"></div>
							</td>
							<td style=\"width: 12px !important; height: 12px !important; background-image: url($img_folder/curve_BR.png) !important;\"></td>
						</tr>
					</tbody>
				</table>
				<img style=\"position: absolute !important; right: -15px !important; bottom: -16px !important;\" src=\"$img_folder/sl_certified.png\" alt=\"SecureLive Logo\">
			</div>
		";

		return $output; 
	}
?>