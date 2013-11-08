<?php
	/****************************************************************************************************
	* This file is part of SecureLive 8.2.04 / 5.2.06													*
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

	//ini_set('display_errors',1);
	//error_reporting(E_ALL);
	
	if(!class_exists('SecureLive_Scanner')){
		class SecureLive_Scanner{
			public $sl_engine_ver = "8.2.04";
			public $sl_admin_ver = "5.2.06";
			public $bypass_arr = null;
			public $sl_timer = null;
			public $started_session = false;
			public $curl = null;
			public $fopen = null;
			public $connected = null;
			public $ip = null;
			public $browser = null;
			public $ref = null;
			public $host = null;
			public $uri = null;
			public $query = null;
			public $xss = null;
			public $config_fp = null;

			public function SecureLive_Scanner(){
				//set some data vars
				
				#NEW IP DETECTION
				$bestIP = '';
				$bestLocalIP = '';
				$ipvars = array('HTTP_X_FORWARDED_FOR','HTTP_NS_CLIENT_IP','HTTP_CLIENT_IP','REMOTE_ADDR');
				foreach($ipvars as $ipvar){
					$ip = isset($_SERVER[$ipvar]) ? $_SERVER[$ipvar] : null;
					if($ip && stripos($ip,'unknown')!==0 && strpos($ip,'127.')!==0 && strpos($ip,'10.')!==0 && strpos($ip,'172.16.')!==0 && strpos($ip,'192.168.')!==0 && stripos($ip,'localhost')!==0){
						$bestIP = $bestIP=='' ? $ip : $bestIP;
					} elseif($ip && (strpos($ip,'127.')===0 || strpos($ip,'10.')===0 || strpos($ip,'172.16.')===0 || strpos($ip,'192.168.')===0 || stripos($ip,'localhost')===0)){
						$bestLocalIP = $bestLocalIP=='' ? $ip : $bestLocalIP;
					}
				}
				
				if($bestIP != ''){
					#got a remote IP
					$this->ip = $bestIP;
				} elseif($bestLocalIP != ''){
					#got a local IP
					$this->ip = $bestLocalIP;
				} else {
					#IP not found, now set it to 'unknown'
					$this->ip = 'unknown';
				}
				

	            $this->browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');
	            $this->query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : getenv('QUERY_STRING');
	            $this->ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : getenv('HTTP_REFERER');
	            $this->host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
	            $this->uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
				//critical diagnostics
				//php version
	            if(version_compare(phpversion(), '5.0.0', '>=')){
					//curl check
		            $this->curl = (function_exists('curl_init') && function_exists('curl_exec'));
		            //fopen check
		            $ini_vals = array(1,'1','on','On','ON',true,'true','True','TRUE');
		            $this->fopen = (function_exists('fopen') && in_array(ini_get('allow_url_fopen'), $ini_vals));
		            if(!$this->curl && !$this->fopen){
						//no curl or fopen
						echo '<b>Warning</b>: The required functions for communication with the SecureLive Server are not available.';
		            }
	            } else {
					//php 4
					echo '<b>Warning</b>: SecureLive requires PHP version 5 or higher to function.';
	            }
			}
			
			public function requested_diagnostics(){
	            return (isset($_GET['action']) && $_GET['action']=='autoDiagnostics');
			}
			public function show_diagnostics(){
	            $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
	            $this->sl_timer = microtime(true);
				$account = $this->sl_post_request('remote4.php', "act=test_account&host=$host");
	            $this->sl_timer = microtime(true) - $this->sl_timer;
	            
	            //see if it is SL checking diag
				if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'127.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'10.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'172.16.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'192.168.')!==0 && strpos($_SERVER["HTTP_X_FORWARDED_FOR"],'localhost')!==0){
					$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
				} elseif(isset($_SERVER["HTTP_NS_CLIENT_IP"]) && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'127.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'10.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'172.16.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'192.168.')!==0 && strpos($_SERVER["HTTP_NS_CLIENT_IP"],'localhost')!==0){
					$ip = $_SERVER["HTTP_NS_CLIENT_IP"];
				} elseif(isset($_SERVER["HTTP_CLIENT_IP"]) && strpos($_SERVER["HTTP_CLIENT_IP"],'127.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'10.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'172.16.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'192.168.')!==0 && strpos($_SERVER["HTTP_CLIENT_IP"],'localhost')!==0){
					$ip = $_SERVER["HTTP_CLIENT_IP"];
				} else {
					$ip = $_SERVER["REMOTE_ADDR"];
				}

		        if(isset($account[4]) && substr_count($account[2],$ip)){
					$show = 1;
		        } elseif(!isset($account[4]) || empty($account[4])){
					$show = 0;
		        } else {
					$show = -1;
		        }
		        
	            $acct_active = htmlentities($account[0]); // true or reason
				$connected = $this->connected; // type
				$dominfo = htmlentities($account[1]); //sub~dom
				$php_ver = phpversion(); //actual value
				$curl = $this->curl ? 1 : 0; //bool
				$fopen = $this->fopen ? 1 : 0; //bool
				$client_ip = $show==1 ? htmlentities($account[3]) : ($show==0 ? $_SERVER['SERVER_ADDR'] : null); //from our servers, not account
				$client_host = $show==1 ? htmlentities($account[4]) : ($show==0 ? gethostbyaddr($_SERVER['SERVER_ADDR']) : null); //from our servers, not account
				$file = $show==1 ? __FILE__ : null; //abspath
				$version = $this->sl_engine_ver.'~'.$this->sl_admin_ver; //engine~admin
				$timer = $this->sl_timer; //seconds
				
				$server = ($show==1) ? (isset($account[5]) ? htmlentities($account[5]) : 'unknown') : null;
	            
	            echo "securelive_diagnostics|$acct_active|$connected|$dominfo|$php_ver|$curl|$fopen|$client_ip|$client_host|$file|$version|$server|$timer";
	            $this->stop(true);
			}
			public function init_scan(){
	            $time = time();
	            //cookie / session
	            if(isset($_COOKIE['securelive'])){
            		$session = $_COOKIE['securelive'];
					//$session = isset($_SESSION['securelive']) ? $_SESSION['securelive'] : null;
	            } else {
            		$session = '';
            		/*
            		if(!isset($_SESSION)){
						session_start();
						$this->started_session = true;
            		}
					$session = isset($_SESSION['securelive']) ? $_SESSION['securelive'] : null;
					*/
	            }
	            if(isset($_COOKIE['secureliveBL'])){$session .= $_COOKIE['secureliveBL'];}
	            $this->sl_timer = microtime(true);
	            $sURL = array('act'=>'detect_hack','ip'=>$this->ip,'browser'=>$this->browser,'query'=>$this->query,'referrer'=>$this->ref,'host'=>$this->host,'uri'=>$this->uri,'time'=>$time,'session'=>$session);
	            $response = $this->sl_post_request('remote4.php', http_build_query($sURL,'','&'));
	            $this->sl_timer = microtime(true) - $this->sl_timer;
	            return $response;
			}
			public function process_response($data){
				//get response data
				$threat_type = $data[0];
	            if(!isset($data[1])){return null;}//there must be an error...should email it to us
	            $threat_level = intval($data[1]);
	            $dominfo = explode('~',$data[2]);
	            $subdomain = $dominfo[0];
	            $domain = $dominfo[1];
	            $redirect = !empty($data[3]) ? $data[3] : false;
	            $accessword = !empty($data[4]) ? $data[4] : false;
	            $frame_buster = intval($data[5])==1 ? true : false;
	            $flood_limit = intval($data[6]) > 2 ? intval($data[6]) : false;
	            $debug = intval($data[7])==1 ? true : false;
	            $this->ban_days = intval($data[8]);
	            
	            //email report
	            if(isset($data[9]) && !empty($data[9])){
	            	if(mail($data[9],$data[10],$data[11],$data[12])){
						$emailed = 'Email Report sent!';
	            	} else {
						$emailed = 'The server could not send the Email Report!';
	            	}
	            } else {
					$emailed = 'No Email Report to send! Check Email Report Selection.';
	            }
	            
				// activate debug mode error_reporting
				if($debug){
					@ini_set('display_errors',1);
					@error_reporting(E_ALL);
				}
	            //flood control
	            if($flood_limit){
	                if($this->get_session('fl:')){
	                    $temp = explode("|",$this->get_session('fl:'));
	                    $time = $temp[0];
	                    $num = $temp[1];
	                    if(microtime(true)-$time <= 1){
	                        if($num >= $flood_limit){//default 7 requests in 1 second
	                            //if threat level not greater than flood threat (1)
	                            if($threat_level <= 1){
	                                $threat_type = 'flood_control';
	                                $threat_level += 1;
	                            } else {
	                                $threat_level += 1;
	                            }
	                        } else {
	                            $num++;
	                            $this->set_session('fl:',"$time|$num");
	                        }
	                    } else {
	                        $time = microtime(true);
	                        $this->set_session('fl:',"$time|1");
	                    }
	                } else {
	                    $time = microtime(true);
	                    $this->set_session('fl:',"$time|1");
	                }
	            }
				
	            //add accessword to session
	            if($accessword){$this->set_session('aw:',$accessword);}
	            $prev_threat = $this->get_session('tt:');
	            $prev_lvl = $this->get_session('tl:');

	            //have to destroy session (on block page) to know that the threat has been eliminated
	            if($prev_threat && is_numeric($prev_lvl)){
	                if($prev_lvl > $threat_level){
	                    $threat_type = $prev_threat;
	                    $threat_level = $prev_lvl;
	                }
	            }
	            $this->set_session('tt:',$threat_type);
	            $this->set_session('tl:',$threat_level);
				$this->set_session('bl:',(($threat_level>0) ? $threat_level.'~'.$this->ip : 0));
	            //end result
	            if($redirect){header('Location: '.$redirect);die();}
	            if($threat_type == 'none'){
            		if($debug){
						echo "<div><b>SecureLive Debug</b>: Domain: $domain, Connection: ".$this->connected.", Timer: ".$this->sl_timer." seconds. Response: ".$data[0]."</div>";
		            }
            		if($frame_buster && !$this->is_admin()){
            			if(!$this->do_frame_buster()){
							define('FRAME_BUSTER',true);
            			}
            		}
            		return null;
	            }
	            
	            if($threat_type=='whitelisted' || $threat_type=='allowbot' || $threat_type=='none'){return null;}
	            // $filepath = $this->sl_get_path();
	            if($threat_type=='test'){require(dirname(__FILE__).'/block_pages/test_block.php');}
	            if($threat_type=='country'){require(dirname(__FILE__).'/block_pages/country_block.php');}
	            if($threat_type=='warning_no404'){require(dirname(__FILE__).'/block_pages/warning_no404.php');}
	            if($threat_type=='warning_captcha'){require(dirname(__FILE__).'/block_pages/warning_captcha.php');}
	            if($threat_type=='admin_block'){require(dirname(__FILE__).'/block_pages/admin_block.php');}
	            if($threat_type=='warning_404'){require(dirname(__FILE__).'/block_pages/warning_404.php');}
	            if($threat_type=='moderate'){require(dirname(__FILE__).'/block_pages/moderate_threat.php');}
	            if($threat_type=='high'){require(dirname(__FILE__).'/block_pages/high_threat.php');}
	            if($threat_type=='admin_critical'){require(dirname(__FILE__).'/block_pages/admin_critical.php');}
	            if($threat_type=='critical'){require(dirname(__FILE__).'/block_pages/critical_threat.php');}
	            if($threat_type=='flood_control'){require(dirname(__FILE__).'/block_pages/flood_control.php');}
			}
			public function is_admin(){
				//return true if is admin
				$admin_arr = array('/administrator','/wp-admin','/sl_admin','/e107_admin','/index.php/admin','/sl_scanner.php');
				foreach($admin_arr as $admin){
					if(substr_count($this->uri,$admin) && !substr_count($this->query,$admin)){
						return true;
					}
				}
				//check for drupal admin
				if(isset($_POST['q']) && $_POST['q']=='admin' && function_exists('user_access')){
					if(user_access('SecureDrupal Admin')){
						return true;
					}
				}
			}
			public function bypassed(){
				//return true if post password(s) found
				if($this->config_exists()){
					include($this->config_fp);
					if(isset($this->dir_bypass_arr) && is_array($this->dir_bypass_arr)){
						#dir bypass prepends the URI with the HTTP_HOST
						$host = $this->host.$this->uri;
						foreach($this->dir_bypass_arr as $dir){
							if(substr_count($host,$dir) && !substr_count($this->query,$dir)){
								return true;
							}
						}
					}
					
					if(isset($this->bypass_arr) && is_array($this->bypass_arr)){
						foreach($this->bypass_arr as $bypass){
							if(is_array($bypass['var']) && is_array($bypass['val'])){
								//check multiple vars that must all be right
								$matched = true;
								for($i=0;$i<count($bypass['var']);$i++){
									if(!isset($_POST[$bypass['var'][$i]]) || $_POST[$bypass['var'][$i]]!=$bypass['val'][$i]){
										$matched = false;
										break;
									}
								}
								if($matched){
									return true;
								}
							} else {
								//check single var
								if(isset($_POST[$bypass['var']]) && $_POST[$bypass['var']]==$bypass['val']){
									return true;
								}
							}
						}
					}
				}
				return false;
			}
			public function xss_filter(){
				$this->xss = new XSS_Filter();
				$this->xss->host = $this->host;
				$this->xss->ip = $this->ip;
				$this->xss->browser = $this->browser;
				$this->xss->ref = $this->ref;
				$this->xss->uri = $this->uri;
				
        		$_POST = $this->xss->process($_POST);
        		if(count($this->xss->threat_arr)>0){
					$this->xss->report();
        		}
			}
			public function stop($die=false){
				if($this->started_session){
					session_destroy();
				}
				unset($SL);
				if($die){
					die();
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
			public function do_frame_buster(){
				$filepath = $this->sl_get_path();
	            if(defined('_JEXEC')){
            		//joomla
	                $doc =& JFactory::getDocument();
	                #$doc->addScript($filepath.'/inc/sl_framebuster.js');
	                $doc->addScript('components/com_securelive/inc/sl_framebuster.js');
	                return true;
	            } elseif(function_exists('wp_enqueue_script')) {
					//wordpress
					$https = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : getenv('HTTPS');
		            if((is_string($https) && strtolower($https)!='off') ||($https && !is_string($https))){
						$http = 'https';
		            } else {
						$http = 'http';
		            }
					$wp_path = "$http://".$_SERVER['HTTP_HOST'].$filepath.'/inc/sl_framebuster.js';
					wp_enqueue_script('sl_framebuster', $wp_path);
					return true;
	            } else {
            		//drupal
            		$f = dirname(__FILE__).'/../../includes/common.inc';
            		if(@file_exists($f)){
						include($f);
            		}
					if(function_exists('drupal_add_js')){
						drupal_add_js(str_replace($GLOBALS['base_path'],'',$filepath).'/inc/sl_framebuster.js');
						return true;
					}
	            }
	            return false;
			}
			public function get_session($what){
				//$what == aw: bl: fl: tt: tl:
				//tries to get from cookie first, then session
				if($what=='bl:'){
					if(isset($_COOKIE['secureliveBL'])){
						$haystack = $_COOKIE['secureliveBL'];
					} else {
						$haystack = false;
					}
				} else {
					if(isset($_COOKIE['securelive'])){
						$haystack = $_COOKIE['securelive'];
					} elseif(isset($_SESSION)){
						if(isset($_SESSION['securelive'])){
							$haystack = $_SESSION['securelive'];
						} else {
							$haystack = false;
						}
					} else {
						//$this->started_session = true;
						//session_start();
						if(isset($_SESSION['securelive'])){
							$haystack = $_SESSION['securelive'];
						} else {
							$haystack = false;
						}
					}
				}
				if($haystack){
					if($what=='all'){
						return $haystack;
					}
					if(substr_count($haystack,$what)){
						$start = stripos($haystack,$what) + strlen($what);
						$len = stripos($haystack,',',$start) - $start;
						$ret = substr($haystack,$start,$len);
						return (empty($ret) ? false : $ret);
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
			public function set_session($what,$val){
				if($what=='bl:'){
					//blacklist cookie
					@setcookie('secureliveBL',"bl:$val,",time()+(60*60*24*$this->ban_days),'/');
				} else {
					$haystack = $this->get_session('all');
					if(substr_count($haystack,$what)){
						//change it
						$part1 = substr($haystack,0,strpos($haystack,$what)+strlen($what));
						$part2 = substr($haystack,strpos($haystack,',',strpos($haystack,$what)));
						$newstack = $part1.$val.$part2;
					} else {
						//add it
						$newstack = $haystack."$what$val,";
					}
					$_COOKIE['securelive'] = $newstack;
					@setcookie('securelive',$newstack,0,'/');
				}
			}
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
	        public function is_ajax_req(){
				$page = isset($_POST['sl_page']) ? $_POST['sl_page'] : null;
				return ($page=='captcha');
			}
			public function ajax_response(){
				$str = '';
				$what = isset($_POST['what']) ? $_POST['what'] : null;
				
				if($what == 'sl_captcha'){
			        $which = isset($_POST['which']) ? $_POST['which'] : null;
			        switch($which){
			            case 1:
			                echo 'F7rQ3';
			                break;
			            case 2:
			                echo 'z55pL';
			                break;
			            case 3:
			                echo '8g1jT';
			                break;
			            case 4:
			                echo 'u9Rk2';
			                break;
			            case 5:
			                echo 'De4iB';
			                break;
			            case 'correct':
			                $this->set_session('tl:',0);
			                $this->set_session('tt:','none');
			                $this->set_session('bl:',0);
			                echo 'true';
			                break;
			            default:
			                break;
			        }
				}
			    
				echo $str;
				die();
			}
			public function blocked_user_form(){
				if(isset($_POST['blocked_user_submit'])){
					$email = isset($_POST['email']) ? str_replace('<',' ',urldecode($_POST['email'])) : '';
					$desc = isset($_POST['description']) ? $_POST['description'] : '';
					$ref = isset($_POST['referrer']) ? $_POST['referrer'] : $this->ref;
					
					$cookie = isset($_COOKIE['securelive']) ? $_COOKIE['securelive'] : '';
					$cookie .= isset($_COOKIE['secureliveBL']) ? $_COOKIE['secureliveBL'] : '';
					
					$time = isset($_POST['time']) ? $_POST['time'] : time();
					
					$ok = true;
					$message = '';
					if(strpos($email,'@')<1 || strpos($email,'.')<3 || strlen($email)<5){
						$message .= 'You must provide a valid email address.<br/>';
						$ok = false;
					}
					if(strlen($desc)<10){
						$message .= 'You must provide a description of your actions to be considered for unblocking. Your description is too short.<br/>';
						$ok = false;
					}
					if($ok){
						$subject = "User blocked on ".$this->host;
						$arr = array('act'=>'make_blocked_email','host'=>$this->host,'ip'=>$this->ip,'desc'=>$desc,'ref'=>$ref,'email'=>$email,'cookie'=>$cookie,'time'=>$time);
						$response = $this->sl_post_request('remote4.php',http_build_query($arr));
						$ok = array_shift($response);
						if($ok=='true'){
							$to = array_shift($response);
							$message = array_shift($response);
							$isPlain = array_shift($response);
						} else {
							return 'There were errors generating the report. Please try again later. The server said: <br/>'.$ok;
						}
						if($isPlain)
							$headers = "From: SecureLive Blocked User <blocks@securelive.net>\nMIME-Version: 1.0\nContent-type: text/plain; charset=iso-8859-1";
						else
							$headers = "From: SecureLive Blocked User <blocks@securelive.net>\nMIME-Version: 1.0\nContent-type: text/html; charset=iso-8859-1";
							
						$check = mail($to,$subject,$message,$headers);
						if($check){
							return 'Thank you, your message has been sent. Please give us time to process your request.';
						} else {
							return 'We\'re sorry, but your message could not be delivered.  Please email us directly at blocks@securelive.net';
						}
					} else {
						return '<script type="text/javascript">
								<!--
								function sl_check(blockform){
									ok = true;
									message = "";
									e = blockform.email.value;
									d = blockform.description.value;
									if(e.indexOf("@")<1 || e.indexOf(".")<3 || e.length<5){
										message += "You must provide a valid email address.\n";
										ok = false;
									}
									if(d.length<10){
										message += "You must provide a description of your actions to be considered for unblocking. Your description is too short.\n";
										ok = false;
									}
									if(!ok){
										alert(message);
									}
									return ok;
								}
								//-->
							</script>
							<p>If you feel you have reached this page in error, please clear your cookies and try again.<br/>
							If you still cannot access the site, contact us through the form below. All fields are required.</p>
							<p>Your message was not sent:<br/>'.$message.'</p>
							<form action="'.str_replace($this->query,'',$this->uri).'" method="post" onsubmit="return sl_check(this)">
								<table>
									<tr>
										<td>Your Email:</td>
										<td><input name="email" type="text" style="width:300px;" value="'.$email.'" /></td>
									</tr>
									<tr>
										<td>Describe your actions:</td>
										<td><textarea name="description" style="width:300px">'.$desc.'</textarea></td>
									</tr>
									<tr>
										<td colspan="2" align="right">
											<input name="referrer" type="hidden" value="'.$ref.'" />
											<input name="time" type="hidden" value="'.$time.'" />
											<input name="blocked_user_submit" type="submit" value="Submit" />
										</td>
									</tr>
								</table>
							</form>';
					}
				} else {
					$session = isset($_COOKIE['securelive']) ? $_COOKIE['securelive'] : '';
					$session .= isset($_COOKIE['secureliveBL']) ? $_COOKIE['secureliveBL'] : '';
					return '<script type="text/javascript">
								<!--
								function sl_check(blockform){
									ok = true;
									message = "";
									e = blockform.email.value;
									d = blockform.description.value;
									if(e.indexOf("@")<1 || e.indexOf(".")<3 || e.length<5){
										message += "You must provide a valid email address.\n";
										ok = false;
									}
									if(d.length<10){
										message += "You must provide a description of your actions to be considered for unblocking. Your description is too short.\n";
										ok = false;
									}
									if(!ok){
										alert(message);
									}
									return ok;
								}
								//-->
							</script>
							<p>If you feel you have reached this page in error, please clear your cookies and try again.<br/>
							If you still cannot access the site, contact us through the form below. All fields are required.</p>
							<form action="'.str_replace($this->query,'',$this->uri).'" method="post" onsubmit="return sl_check(this)">
								<table>
									<tr>
										<td>Your Email:</td>
										<td><input name="email" type="text" style="width:300px;" /></td>
									</tr>
									<tr>
										<td>Describe your actions:</td>
										<td><textarea name="description" style="width:300px"></textarea></td>
									</tr>
									<tr>
										<td colspan="2" align="right">
											<input name="host" type="hidden" value="'.$this->host.'" />
											<input name="ip" type="hidden" value="'.$this->ip.'" />
											<input name="referrer" type="hidden" value="'.$this->ref.'" />
											<input name="cookie" type="hidden" value="'.$session.'" />
											<input name="time" type="hidden" value="'.time().'" />
											<input name="blocked_user_submit" type="submit" value="Submit" />
										</td>
									</tr>
								</table>
							</form>';
	            }
			}
			public function safe_query(){
				return false;
			}
		}
		class XSS_Filter extends SecureLive_Scanner {
	        protected $tagsArray;    // default = empty array
	        protected $attrArray;    // default = empty array

	        protected $tagsMethod;    // default = 0
	        protected $attrMethod;    // default = 0

	        protected $xssAuto;     // default = 1
	        protected $tagBlacklist = array('applet', 'body', 'bgsound', 'base', 'basefont', 'embed', 'frame', 'frameset', 'head', 'html', 'id', 'iframe', 'ilayer', 'layer', 'link', 'meta', 'name', 'object', 'script', 'style', 'title', 'xml');
	        protected $attrBlacklist = array('action', 'background', 'codebase', 'dynsrc', 'lowsrc');  // also will strip ALL event handlers
	        
	        public $threat_arr = array();
	        
	        public function XSS_Filter($tagsArray = array(), $attrArray = array(), $tagsMethod = 0, $attrMethod = 0, $xssAuto = 1) {        
	            // make sure user defined arrays are in lowercase
	            for ($i = 0; $i < count($tagsArray); $i++) $tagsArray[$i] = strtolower($tagsArray[$i]);
	            for ($i = 0; $i < count($attrArray); $i++) $attrArray[$i] = strtolower($attrArray[$i]);
	            // assign to member vars
	            $this->tagsArray = (array) $tagsArray;
	            $this->attrArray = (array) $attrArray;
	            $this->tagsMethod = $tagsMethod;
	            $this->attrMethod = $attrMethod;
	            $this->xssAuto = $xssAuto;
	        }
	        //modified process to send key to remove if array
	        public function process($source) {
	            // clean all elements in this array
	            if (is_array($source)) {
	                foreach($source as $key => $value)
	                    // filter element for XSS and other 'bad' code etc.
	                    if (is_string($value)) $source[$key] = $this->remove($this->decode($value),$key);
	                return $source;
	            // clean this string
	            } else if (is_string($source)) {
	                // filter source for XSS and other 'bad' code etc.
	                return $this->remove($this->decode($source));
	            // return parameter as given
	            } else return $source;    
	        }
			//modified remove to use new function to find differences in before and after and push data to threat_arr for reporting; does not modify source anymore, uses newsource
	        private function remove($source, $key='') {
        		$newsource = $source;
	            $loopCounter=0;
	            // provides nested-tag protection
	            while($newsource != $this->filterTags($newsource)) {
	                $newsource = $this->filterTags($newsource);
	                $loopCounter++;
	            }
	            if($loopCounter >= 1){
					//it stripped at least one tag, so need to find the difference, then push array(key,stripped) to threat_arr
					array_push($this->threat_arr,array($key,$this->string_diff($source,$newsource)));
	            }
	            return $newsource;
	        }    
	        
	        private function filterTags($source) {
	            // filter pass setup
	            $preTag = NULL;
	            $postTag = $source;
	            // find initial tag's position
	            $tagOpen_start = strpos($source, '<');
	            // interate through string until no tags left
	            while($tagOpen_start !== FALSE) {
	                // process tag interatively
	                $preTag .= substr($postTag, 0, $tagOpen_start);
	                $postTag = substr($postTag, $tagOpen_start);
	                $fromTagOpen = substr($postTag, 1);
	                // end of tag
	                $tagOpen_end = strpos($fromTagOpen, '>');
	                //SL MODS
	                $tagOpen_end = $tagOpen_end===false ? strpos($fromTagOpen, ' ') : $tagOpen_end;
	                $tagOpen_end = $tagOpen_end===false ? strlen($fromTagOpen) : $tagOpen_end;
	                // next start of tag (for nested tag assessment)
	                $tagOpen_nested = strpos($fromTagOpen, '<');
	                if (($tagOpen_nested !== false) && ($tagOpen_nested < $tagOpen_end)) {
	                    $preTag .= substr($postTag, 0, ($tagOpen_nested+1));
	                    $postTag = substr($postTag, ($tagOpen_nested+1));
	                    $tagOpen_start = strpos($postTag, '<');
	                    continue;
	                } 
	                $tagOpen_nested = (strpos($fromTagOpen, '<') + $tagOpen_start + 1);
	                $currentTag = substr($fromTagOpen, 0, $tagOpen_end);
	                $tagLength = strlen($currentTag);
	                if (!$tagOpen_end) {
	                    $preTag .= $postTag;
	                    $tagOpen_start = strpos($postTag, '<');            
	                }
	                // iterate through tag finding attribute pairs - setup
	                $tagLeft = $currentTag;
	                $attrSet = array();
	                $currentSpace = strpos($tagLeft, ' ');
	                // is end tag
	                if (substr($currentTag, 0, 1) == "/") {
	                    $isCloseTag = TRUE;
	                    list($tagName) = explode(' ', $currentTag);
	                    $tagName = substr($tagName, 1);
	                // is start tag
	                } else {
	                    $isCloseTag = FALSE;
	                    list($tagName) = explode(' ', $currentTag);
	                }        
	                // excludes all "non-regular" tagnames OR no tagname OR remove if xssauto is on and tag is blacklisted
	                if ((!preg_match("/^[a-z][a-z0-9]*$/i",$tagName)) || (!$tagName) || ((in_array(strtolower($tagName), $this->tagBlacklist)) && ($this->xssAuto))) {                 
	                    $postTag = substr($postTag, ($tagLength + 2));
	                    $tagOpen_start = strpos($postTag, '<');
	                    // don't append this tag
	                    continue;
	                }
	                // this while is needed to support attribute values with spaces in!
	                while ($currentSpace !== FALSE) {
	                    $fromSpace = substr($tagLeft, ($currentSpace+1));
	                    $nextSpace = strpos($fromSpace, ' ');
	                    $openQuotes = strpos($fromSpace, '"');
	                    $closeQuotes = strpos(substr($fromSpace, ($openQuotes+1)), '"') + $openQuotes + 1;
	                    // another equals exists
	                    if (strpos($fromSpace, '=') !== FALSE) {
	                        // opening and closing quotes exists
	                        if (($openQuotes !== FALSE) && (strpos(substr($fromSpace, ($openQuotes+1)), '"') !== FALSE))
	                            $attr = substr($fromSpace, 0, ($closeQuotes+1));
	                        // one or neither exist
	                        else $attr = substr($fromSpace, 0, $nextSpace);
	                    // no more equals exist
	                    } else $attr = substr($fromSpace, 0, $nextSpace);
	                    // last attr pair
	                    if (!$attr) $attr = $fromSpace;
	                    // add to attribute pairs array
	                    $attrSet[] = $attr;
	                    // next inc
	                    $tagLeft = substr($fromSpace, strlen($attr));
	                    $currentSpace = strpos($tagLeft, ' ');
	                }
	                // appears in array specified by user
	                $tagFound = in_array(strtolower($tagName), $this->tagsArray);            
	                // remove this tag on condition
	                if ((!$tagFound && $this->tagsMethod) || ($tagFound && !$this->tagsMethod)) {
	                    // reconstruct tag with allowed attributes
	                    if (!$isCloseTag) {
	                        $attrSet = $this->filterAttr($attrSet);
	                        $preTag .= '<' . $tagName;
	                        for ($i = 0; $i < count($attrSet); $i++)
	                            $preTag .= ' ' . $attrSet[$i];
	                        // reformat single tags to XHTML
	                        if (strpos($fromTagOpen, "</" . $tagName)) $preTag .= '>';
	                        else $preTag .= ' />';
	                    // just the tagname
	                    } else $preTag .= '</' . $tagName . '>';
	                }
	                // find next tag's start
	                $postTag = substr($postTag, ($tagLength + 2));
	                $tagOpen_start = strpos($postTag, '<');            
	            }
	            // append any code after end of tags
	            $preTag .= $postTag;
	            return $preTag;
	        }

	        private function filterAttr($attrSet) {    
	            $newSet = array();
	            // process attributes
	            for ($i = 0; $i <count($attrSet); $i++) {
	                // skip blank spaces in tag
	                if (!$attrSet[$i]) continue;
	                // split into attr name and value
	                $attrSubSet = explode('=', trim($attrSet[$i]));
	                list($attrSubSet[0]) = explode(' ', $attrSubSet[0]);
	                // removes all "non-regular" attr names AND also attr blacklisted
	                if ((!eregi("^[a-z]*$",$attrSubSet[0])) || (($this->xssAuto) && ((in_array(strtolower($attrSubSet[0]), $this->attrBlacklist)) || (substr($attrSubSet[0], 0, 2) == 'on')))) 
	                    continue;
	                // xss attr value filtering
	                if ($attrSubSet[1]) {
	                    // strips unicode, hex, etc
	                    $attrSubSet[1] = str_replace('&#', '', $attrSubSet[1]);
	                    // strip normal newline within attr value
	                    $attrSubSet[1] = preg_replace('/\s+/', '', $attrSubSet[1]);
	                    // strip double quotes
	                    $attrSubSet[1] = str_replace('"', '', $attrSubSet[1]);
	                    // [requested feature] convert single quotes from either side to doubles (Single quotes shouldn't be used to pad attr value)
	                    if ((substr($attrSubSet[1], 0, 1) == "'") && (substr($attrSubSet[1], (strlen($attrSubSet[1]) - 1), 1) == "'"))
	                        $attrSubSet[1] = substr($attrSubSet[1], 1, (strlen($attrSubSet[1]) - 2));
	                    // strip slashes
	                    $attrSubSet[1] = stripslashes($attrSubSet[1]);
	                }
	                // auto strip attr's with "javascript:
	                if (    ((strpos(strtolower($attrSubSet[1]), 'expression') !== false) &&    (strtolower($attrSubSet[0]) == 'style')) ||
	                        (strpos(strtolower($attrSubSet[1]), 'javascript:') !== false) ||
	                        (strpos(strtolower($attrSubSet[1]), 'behaviour:') !== false) ||
	                        (strpos(strtolower($attrSubSet[1]), 'vbscript:') !== false) ||
	                        (strpos(strtolower($attrSubSet[1]), 'mocha:') !== false) ||
	                        (strpos(strtolower($attrSubSet[1]), 'livescript:') !== false) 
	                ) continue;

	                // if matches user defined array
	                $attrFound = in_array(strtolower($attrSubSet[0]), $this->attrArray);
	                // keep this attr on condition
	                if ((!$attrFound && $this->attrMethod) || ($attrFound && !$this->attrMethod)) {
	                    // attr has value
	                    if ($attrSubSet[1]) $newSet[] = $attrSubSet[0] . '="' . $attrSubSet[1] . '"';
	                    // attr has decimal zero as value
	                    else if ($attrSubSet[1] == "0") $newSet[] = $attrSubSet[0] . '="0"';
	                    // reformat single attributes to XHTML
	                    else $newSet[] = $attrSubSet[0] . '="' . $attrSubSet[0] . '"';
	                }    
	            }
	            return $newSet;
	        }
	        
	        private function decode($source) {
	            // url decode
	            $source = html_entity_decode($source, ENT_QUOTES, "ISO-8859-1");
	            // convert decimal
	            $source = preg_replace('/&#(\d+);/me',"chr(\\1)", $source);                // decimal notation
	            // convert hex
	            $source = preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)", $source);    // hex notation
	            return $source;
	        }

	        public function safeSQL($source, &$connection) {
	            // clean all elements in this array
	            if (is_array($source)) {
	                foreach($source as $key => $value)
	                    // filter element for SQL injection
	                    if (is_string($value)) $source[$key] = $this->quoteSmart($this->decode($value), $connection);
	                return $source;
	            // clean this string
	            } else if (is_string($source)) {
	                // filter source for SQL injection
	                if (is_string($source)) return $this->quoteSmart($this->decode($source), $connection);
	            // return parameter as given
	            } else return $source;    
	        }

	        private function quoteSmart($source, &$connection) {
	            // strip slashes
	            if (get_magic_quotes_gpc()) $source = stripslashes($source);
	            // quote both numeric and text
	            $source = $this->escapeString($source, $connection);
	            return $source;
	        }
	        
	        private function escapeString($string, &$connection) {
	            // depreciated function
	            if (version_compare(phpversion(),"4.3.0", "<")) mysql_escape_string($string);
	            // current function
	            else mysql_real_escape_string($string);
	            return $string;
	        }
	        //added by joe
	        private function string_diff($old,$new){
				for($n=0,$o=0,$stripped='';$o<strlen($old);$n++){
				    $newChar = substr($new,$n,1);
				    $oldChar = substr($old,$o,1);
				    if($newChar != $oldChar){
				        $matches = $newChar=='' ? 0 : substr_count($old,$newChar,$o);
				        if($matches > 0){
				            $longest_match = 1;
				            $offset = $o;
				            while($pointer = strpos($old,substr($new,$n,$longest_match),$offset)){
				                while(substr($new,$n,$longest_match)==substr($old,$pointer,$longest_match) && $n+$longest_match<=strlen($new)){
				                    $longest_match++;
				                }
				                $offset = $pointer+1;
				            }
				            $stripped .= substr($old,$o,$offset-$o-1);
				            $o = $offset;
				        } else {
				            $stripped .= $oldChar;
				            $o += ($o<strlen($old) ? 1 : 0);
				        }
				    } else {
				        $o += ($o<strlen($old) ? 1 : 0);
				    }
				}
				return $stripped;
			}
	        //added by joe
	        public function report(){
        		// post is to be sent as variable#sl#stripped#sl#variable#sl#stripped
        		$post = '';
	            for($i=0;$i<count($this->threat_arr);$i++){
            		$threat = $this->threat_arr[$i];
            		$var = $threat[0];
            		$stripped = $threat[1];
					$post .= "$var#sl#$stripped";
					if($i<count($this->threat_arr)-1){
						$post .= "#sl#";
					}
	            }
				$sURL = array('act'=>'xss_report','ip'=>$this->ip,'browser'=>$this->browser,'referrer'=>$this->ref,'host'=>$this->host,'uri'=>$this->uri,'time'=>time(),'post'=>$post);
		        $response = $this->sl_post_request('remote4.php', http_build_query($sURL,'','&'));
		        if(count($response)==4){
		        	mail($response[0],$response[1],$response[2],$response[3]);
		        }
			}
	    }
	    
	    $SL = new SecureLive_Scanner();
		if($SL->requested_diagnostics()){
			$SL->show_diagnostics();
		}
		$SL->process_response($SL->init_scan());
		if(!$SL->bypassed() && !$SL->is_admin()){
			$SL->xss_filter();
		}
		$SL->stop();
	} else {
		if(defined('FRAME_BUSTER') && FRAME_BUSTER==true){
			$SL = new SecureLive_Scanner();
			$SL->do_frame_buster();
			$SL->stop();
		}
	}
?>