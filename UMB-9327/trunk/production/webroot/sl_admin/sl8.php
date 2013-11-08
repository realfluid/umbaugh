<?php
	/****************************************************************************************************
	* This file is part of SecureLive 8.4.02 / 5.4.02													*
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

	#ini_set('display_errors',1);
	#error_reporting(E_ALL);

	defined('LOCKDOWN_IN') or define('LOCKDOWN_IN', 3);		#Examples: 5 = lockdown mode if no connection after 5 seconds, 0 = lockdown NOW, -5 = no lockdown 5 second timeout
	defined('LOCKDOWN_TIMEOUT') or define('LOCKDOWN_TIMEOUT', 3);	#only used if $LOCKDOWN_IN is set to 0. set this for the timeout of checking a "clean request", 0 to skip SL scan
	defined('POST_FILTER_BAD_TAGS') or define('POST_FILTER_BAD_TAGS', "applet body bgsound base basefont canvas embed frame frameset head html id iframe ilayer layer link meta name object script style title xml");
	defined('POST_FILTER_BAD_ATTR') or define('POST_FILTER_BAD_ATTR', "action background codebase dynsrc lowsrc onabort onblur onchange onclick ondblclick ondragdrop onerror onfocus onkeydown onkeypress onkeyup onload onmousedown onmousemove onmouseout onmouseover onmouseup onmove onreset onresize onselect onsubmit onunload onbeforeunload");
	
	if(!class_exists('Guardian')){
		class Guardian{
			public $cid = null;
			public $isImproved = false;
			
			public function Guardian($host, $user = null, $password = null, $database = null){
				if(gettype($host) == 'resource'){
					$this->cid = $host;
				}
				else if(gettype($host) == 'object') {
					$this->isImproved = true;
					$this->cid = $host;
				}
				else if(gettype($host) == 'string') {
					$this->cid = @mysql_connect($host,$user,$password);
					if($this->cid === false)
						$this->cid = null;
					else
						if(!mysql_select_db($database,$this->cid)){
							@$this->stop();
							$this->cid = null;
						}
				}
			}
			public function stop(){
				global $wpdb;
				if(!class_exists('JFactory') && (empty($wpdb) || !isset($wpdb->dbh))){
					if($this->isImproved){
						@mysqli_close($this->cid);
						$this->cid = null;
					}
					else{
						@mysql_close($this->cid);
						$this->cid = null;
					}
				}
			}
			public function clean($str){
				if(gettype($this->cid) == "object"){//MySqlI
					return $this->cid->real_escape_string($str);
				}
				else{//MySql
					return mysql_real_escape_string($str, $this->cid);
				}
			}
			public function query($sql){
				$ret = array();
				
				if($this->isImproved){
					$result = mysqli_query($this->cid, $sql);
					if(!$result) return array();
				    while($row=@mysqli_fetch_array($result)){
				        array_push($ret, $row);
				    }
				    @mysqli_free_result($result);
				}
				else{
					$result = mysql_query($sql,$this->cid);
					if(!$result) return array();
				    while($row=@mysql_fetch_array($result)){
				        array_push($ret, $row);
				    }
				    @mysql_free_result($result);
				}
			    
			    
			    return $ret;
			}
			public function id($sql){
				if($this->isImproved){
					$result = mysqli_query($this->cid, $sql);
					if(!$result) return null;
				    $id = @mysqli_insert_id($this->cid);
				    @mysqli_free_result($result);
				}
				else{
					$result = mysql_query($sql,$this->cid);
					if(!$result) return null;
				    $id = @mysql_insert_id($this->cid);
				    @mysql_free_result($result);
				}
			    return $id;
			}
			public function affected($sql){
				if($this->isImproved){
					$result = mysqli_query($this->cid, $sql);
					if(!$result) return null;
				    $id = @mysqli_affected_rows($this->cid);
				    @mysqli_free_result($result);
				}
				else {
					$result = mysql_query($sql,$this->cid);
					if(!$result) return null;
				    $id = @mysql_affected_rows($this->cid);
				    @mysql_free_result($result);
				}
			    return $id;
			}
		}	
	}

	if(!class_exists('SecureLive_Scanner')){
		class SecureLive_Scanner{
			public $sl_engine_ver = "8.4.02";
			public $sl_admin_ver = "5.4.02";
			public $bypass_arr = null;
			public $sl_timer = null;
			public $started_session = false;
			public $curl = null;
			public $fopen = null;
			public $connected = null;
			public $ip = null;
			public $hoster = null;
			public $browser = null;
			public $ref = null;
			public $session = null;
			public $host = null;
			public $uri = null;
			public $query = null;
			public $xss = null;
			public $config_fp = null;
			public $threat_arr = array();
			public $db = null;
			public $db_host = null;
			public $db_database = null;
			public $db_username = null;
			public $db_password = null;
			public $timeout = 3;
			public $url_cache_expires = 30;
			public $url_cache_mode = 3;
			public $url_cache_loaded = false;
			private $expected_threats = array('none','whitelisted','allowbot','test','country','warning_no404','warning_captcha','admin_block','warning_404','moderate','high','admin_critical','critical','flood_control');
			
			//Construct
			public function SecureLive_Scanner(){
				//set some data vars
				
				#NEW IP DETECTION
				{
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
					} 
					elseif($bestLocalIP != ''){
						#got a local IP
						$this->ip = $bestLocalIP;
					} 
					else {
						#IP not found, now set it to 'unknown'
						$this->ip = 'unknown';
					}
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
	            } 
	            else {
					//php 4
					echo '<b>Warning</b>: SecureLive requires PHP version 5 or higher to function.';
	            }
			}
			
			//Diag
			public function requested_diagnostics(){
	            return (isset($_GET['action']) && $_GET['action']=='autoDiagnostics');
			}
			public function show_diagnostics(){
	            $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
	            $this->sl_timer = microtime(true);
	            
	            if($this->config_exists())
	            	@include($this->config_fp);
	            if(!isset($timeout) || $timeout == null)
	            	$timeout = LOCKDOWN_IN > 0 ? LOCKDOWN_IN : LOCKDOWN_IN == 0 ? LOCKDOWN_TIMEOUT : LOCKDOWN_IN*-1;
	            if($this->timeout != null) $timeout = $this->timeout;
	            if(isset($_GET['sl_diag_timeout'])) $timeout = intval($_GET['sl_diag_timeout']);
	            if(isset($_GET['sl_diag_time'])) $timeout = intval($_GET['sl_diag_timeout']);
	            
				$account = $this->sl_post_request('remote4.php', "act=test_account&host=$host", $timeout);
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

		        if(isset($account[4]) && substr_count(@$account[2],$ip)){
					$show = 1;
		        } elseif(!isset($account[4]) || empty($account[4])){
					$show = 0;
		        } else {
					$show = -1;
		        }
		        
		        //Load DB
		        $this->load_db();
		        
	            $acct_active = htmlentities(@$account[0]); // true or reason
				$connected = $this->connected; // type
				$dominfo = htmlentities(@$account[1]); //sub~dom
				$php_ver = phpversion(); //actual value
				$curl = $this->curl ? 1 : 0; //bool
				$fopen = $this->fopen ? 1 : 0; //bool
				$version = $this->sl_engine_ver.'~'.$this->sl_admin_ver; //engine~admin
				$timer = $this->sl_timer; //seconds
				
				$client_ip   = $show==1 ? htmlentities(@$account[3]) : ($show==0 ? $_SERVER['SERVER_ADDR'] : null); //from our servers, not account
				$client_host = $show==1 ? htmlentities(@$account[4]) : ($show==0 ? @gethostbyaddr($_SERVER['SERVER_ADDR']) : null); //from our servers, not account
				$file        = $show==1 ? __FILE__ : null; //abspath
				$db_enabled  = $show==1 ? ($this->db_enabled() ? 'DB: On' : 'DB: Off') : null;//DB_ENABLED
				$cache_mode  = $show==1 ? "Cache: ".(intval($this->url_cache_mode & 2) == 2 ? "PreScan" : "PostScan") : null;
				$lockdown    = $show==1 ? "Lockdown: ".(intval($this->url_cache_mode & 1) == 1 ? "On" : "Off") : null;
				$server      = ($show==1) ? (isset($account[5]) ? htmlentities($account[5]) : 'unknown') : null;
	            
	            echo "securelive_diagnostics|$acct_active|$connected|$dominfo|$php_ver|$curl|$fopen|$client_ip|$client_host|$file|$version|$db_enabled|$cache_mode|$lockdown|$server|$timer";
	            $this->stop(true);
			}
			
			//Scan
			public function init_scan(){
				#get remaining data
	            $time = time();
	            //cookie / session
	            if(isset($_COOKIE['securelive'])){
            		$this->session = $_COOKIE['securelive'];
	            } 
	            else {
            		$this->session = '';
	            }
	            if(isset($_COOKIE['secureliveBL'])){$this->session .= $_COOKIE['secureliveBL'];}
	            
	            //Setup DB
				$this->load_db();
				
				#CHECK LOCKDOWN MODE, possible lockdown
				$timeout = LOCKDOWN_IN > 0 ? LOCKDOWN_IN : LOCKDOWN_IN == 0 ? LOCKDOWN_TIMEOUT : LOCKDOWN_IN*-1;		
				if($this->timeout != null) $timeout = $this->timeout;
				
				#Use cache if DB info is present and mode is use cache first
				$cache_next = false;
				if($this->db_enabled()){
					//Check cache
					$details = '';
					$url_cache_check = $this->check_cache($this->host, $this->uri, $this->query, $details);
					//Handle Cache responce
					if($url_cache_check === true && intval($this->url_cache_mode & 2) == 2){//Clean and use cache
						$this->do_cache_safe_routine($details);
						return null;
					}
					else if($url_cache_check === false && intval($this->url_cache_mode & 2) == 2){//Dirty and use cache
						if(!$this->hoster) $this->hoster = @gethostbyaddr($this->ip);
						$this->do_cache_block_notice($details);
						return null;
					}
					else if($url_cache_check === null){//Unknown or not using cache first
						$cache_next = true;
					}
				}

				$this->hoster = @gethostbyaddr($this->ip);
				#If the cache didn't handle the request use our server
				if(LOCKDOWN_IN == 0){
					$data = array(
					    'ip'=>$this->ip,
					    'hoster'=>$this->hoster,
					    'query'=>$this->query,
					    'uri'=>$this->uri,
					    'browser'=>$this->browser,
					    'referrer'=>$this->ref,
					    'session'=>$this->session
					);
					
					#do clean string check on all data
					$temp = $this->clean_string_check($data);
					$is_clean = $temp[0];
					$reason = $temp[1];
					
					if(!$is_clean){
						#set error log instead of email
						error_log("SecureLive Lockdown: immediate, IP: ".$this->ip.", Reason: $reason");
						
						#set block page
						require(dirname(__FILE__).'/block_pages/lockdown.php');
						$this->stop(true);
					}
					#check if it should skip scan
					elseif($timeout == 0){
						#stop scanning, give null to next function
						return null;
					}
				}
				
				#DO NORMAL SCAN
		        $this->sl_timer = microtime(true);
		        $sURL = array(
	            	'ip'=>$this->ip,
	            	'hoster'=>$this->hoster,
	            	'browser'=>$this->browser,
	            	'query'=>$this->query,
	            	'referrer'=>$this->ref,
	            	'host'=>$this->host,
	            	'uri'=>$this->uri,
	            	'time'=>$time,
	            	'session'=>$this->session
		        );
		        $response = $this->sl_post_request('remote5.php', http_build_query($sURL,'','&'),$timeout);
		        $this->sl_timer = microtime(true) - $this->sl_timer;
				$response[] = $cache_next;
		        return $response;
			}
			public function process_response($data){
				if($data===null){
					#lockdown cancelled scanning
					return null;
				}

				#CHECK LOCKDOWN / connection failure
				if(!$this->connected || !isset($data[1]) || preg_match('/fail/i',$this->connected)){
					if($this->url_cache_mode !== null){
						if(intval($this->url_cache_mode & 2) == 0){//Use Cache as fall back
							$details = null;
							$cache_check = $this->check_cache($this->host, $this->uri, $this->query, $details);
							if($cache_check === true){//clean
								return null;
							}
							else if($cache_check === false){//dirty
								$this->do_cache_block_notice($details);
								return null;
							}
							else {//$cache_check === null){
								if(intval($this->url_cache_mode & 1) == 1){//Lockdown is allowed
									return $this->do_lockdown($data);
								}
								else{//Both fall backs are fail... continue the response
									return null;
								}
							}
						}
						else {
							if(intval($this->url_cache_mode & 1) == 1){//Lockdown is allowed
								return $this->do_lockdown($data);
							}
							else{//Both fall backs are fail... continue the response
								return null;
							}
						}
					}
					else{
						return $this->do_lockdown($data);
					}
				}
				else{
					if(end($data) === true){//Requesting cache
		            	$this->add_cache($this->host, $this->uri, $this->query, $data);
					}
				}
		
				//Close DataBase
				if($this->db && $this->db->cid !== null){
					$this->db->stop();
				}

				//get response data
				$threat_type = $data[0];
	            $threat_level = intval(@$data[1]);
	            $is_url_block = intval(@$data[2]);
	            $dominfo = explode('~',@$data[3]);
	            $subdomain = $dominfo[0];
	            $domain = @$dominfo[1];
	            $redirect = !empty($data[4]) ? $data[4] : false;
	            $accessword = !empty($data[5]) ? $data[5] : false;
	            $frame_buster = intval(@$data[6])==1 ? true : false;
	            $flood_limit = intval(@$data[7]) > 2 ? @intval($data[7]) : false;
	            $debug = intval(@$data[8])==1 ? true : false;
	            $this->ban_days = floatval(@$data[9]);

	            //email report
	            if(isset($data[10]) && !empty($data[10]) && isset($data[11]) && isset($data[12])){
	            	$this->SetDBSetting('r_email', @$data[10]);
	            	if(strpos(@$data[12], '<html>') === false)
	            		$this->SetDBSetting('plain_text_reports', '1');
	            	else
	            		$this->SetDBSetting('plain_text_reports', '0');
	            		
	            	if(mail(@$data[10], @$data[11], @$data[12], @$data[13])){
						$emailed = 'Email Report sent!';
	            	} 
	            	else {
						$emailed = 'The server could not send the Email Report!';
	            	}
	            } 
	            else {
					$emailed = 'No Email Report to send! Check Email Report Selection.';
	            }
	            
				// activate debug mode error_reporting
				if($debug){
					@ini_set('display_errors',1);
					@error_reporting(E_ALL);
				}
	            //flood control
	            $FL_COOKIE = '';
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
	                            $FL_COOKIE = "fl:$time|$num,";
	                        }
	                    } else {
	                        $time = microtime(true);
	                        $FL_COOKIE = "fl:$time|1,";
	                    }
	                } else {
	                    $time = microtime(true);
	                    $FL_COOKIE = "fl:$time|1,";
	                }
	            }
				
	            //add accessword to session
	            $AW_COOKIE = '';
	            if($accessword){$AW_COOKIE = "aw:$accessword,";}
	            $prev_threat = $this->get_session('tt:');
	            $prev_lvl = $this->get_session('tl:');

	            //have to destroy session (on block page) to know that the threat has been eliminated
	            if($prev_threat && is_numeric($prev_lvl)){
	                if($prev_lvl > $threat_level){
	                    $threat_type = $prev_threat;
	                    $threat_level = $prev_lvl;
	                }
	            }

				$TT_COOKIE = "tt:$threat_type,";
				$TL_COOKIE = "tl:$threat_level,";

				
				#SET THE COOKIES ONE TIME!
				@setcookie('secureliveBL',"bl:".(($threat_level>0) ? $threat_level.'~'.$this->ip : 0).",",time()+(60*60*24*$this->ban_days),'/');
				$_COOKIE['secureliveBL'] = "bl:".(($threat_level>0) ? $threat_level.'~'.$this->ip : 0).",";
				
				$this->ban_days = $this->ban_days < 1 ? 1 : $this->ban_days;
				@setcookie('securelive',"$TT_COOKIE$TL_COOKIE$AW_COOKIE$FL_COOKIE",time()+(60*60*24*$this->ban_days),'/');
				$_COOKIE['securelive'] = "$TT_COOKIE$TL_COOKIE$AW_COOKIE$FL_COOKIE";
				
	            //end result
	            if($redirect){header('Location: '.$redirect); $this->stop();}
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
				$this->present_404($threat_type, $emailed);
			}	
			
			//TyChe Request
			public function sl_post_request($purl, $data, $timeout=5){
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
			            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);        // timeout on connect
			            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);                // timeout on response
			            curl_setopt($ch, CURLOPT_ENCODING, "");                // handle all encodings
			            curl_setopt($ch, CURLOPT_USERAGENT, "");            // who am i
			            $response = curl_exec($ch);
			            if($response){
			                $this->connected = "curl";
			            } 
			            else {
							$this->connected = "failed to connect with curl";
			            }
			            curl_close($ch);
			        } 
			        elseif (function_exists('fopen')) {
			            $old = ini_get('default_socket_timeout');
			            ini_set('allow_url_fopen', 1);
			            $params = array('http' => array('method' => 'POST', 'content' => $data));
			            $ctx = stream_context_create($params);
			            ini_set('default_socket_timeout', $timeout);
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
			    } 
			    elseif($data == 'file'){ // file
			        if(function_exists('curl_init') && function_exists('curl_exec')){
			            $ch = curl_init("$url/$purl");
			            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);            //send post data
			            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        // return web page
			            curl_setopt($ch, CURLOPT_HEADER, false);            // don't return headers
			            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);    // dont follow redirects
			            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);        // timeout on connect
			            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);                // timeout on response
			            curl_setopt($ch, CURLOPT_ENCODING, "");                // handle all encodings
			            curl_setopt($ch, CURLOPT_USERAGENT, "");            // who am i
			            $response = curl_exec($ch);
			            curl_close($ch);
			            $resp = explode("\n", $response);
			        } 
			        else {
			            $resp = file("$url/$purl");
			        }
			        return $resp;
			    }
			}
			public function sl_header_request($headers, $url = 'remote4.php', $timeout = 5){
				#Where to connect to
				$url = "http://64.50.167.27/securelive/".$url;
				
				#Parse Header
				if($headers == null) $headers = array();

				if(function_exists('curl_init') && function_exists('curl_exec')){
					
					#Change $headers Associative to the array of 'header: value'
					$_headers = Array();
					if(count($headers) > 0) foreach($headers as $key => $value) $_headers[] = $key.': '.$value;
					
					#Make the Connection
					$ch = curl_init($url);
			        curl_setopt($ch,CURLOPT_HTTPHEADER, $_headers);      // Set Headers
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     // return web page
			        curl_setopt($ch, CURLOPT_HEADER, false);            // don't return headers
			        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);    // dont follow redirects
			        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // timeout on connect
			        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);        // timeout on response
			        curl_setopt($ch, CURLOPT_ENCODING, "");             // handle all encodings
			        curl_setopt($ch, CURLOPT_USERAGENT, "");            // who am i
			        $response = curl_exec($ch);                         // get resonse
			        curl_close($ch);                                    // close connection
			        
			        #Return the response
			        return $response;
				}
				else if(function_exists('fopen')){
					
					#Setup INI settings
					$org_timeout = ini_get('default_socket_timeout');
					ini_set('allow_url_fopen', 1);
			        ini_set('default_socket_timeout', $timeout);
			        
			        #Make Connection
			        $params = array('http' => $headers);
			        $fp = @fopen($url, 'rb', false, stream_context_create($params));

					#Read Resaults
			        $result = false;	
			        if($fp !== false){
			        	$result = @stream_get_contents($fp);
			        	@fclose($fp);
					}
					
					#Restore orginal ini settings
					ini_set('default_socket_timeout', $org_timeout);
					
					#Return response
					return $result; 
				}
				else{
					return false;	
				}
			}		
			
			//
			public function is_admin(){
				//return true if is admin
				$admin_arr = array('/administrator/','/wp-admin/','/sl_admin/','/e107_admin/','/index.php/admin/','/sl_scanner.php','/wp-login.php','/admin/');
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
				return false;
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
			public function stop($die=false){
				/*if($this->started_session){
					session_destroy();
				}*/
				
				if($this->db != null && $this->db->cid != null){
					$this->db->stop();	
				}
				unset($SL);
				if($die){
					die();
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
	        public function config_exists(){
				//sl8 always uses local
				$this->config_fp = dirname(__FILE__).'/sl_config.php';

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
		        } 
		        else{
					$config_exists = true;
		        }
		        
		        return $config_exists;
			}
	        public function is_ajax_req(){
				$page = isset($_POST['sl_page']) ? $_POST['sl_page'] : null;
				return ($page=='captcha');
			}
			public function ajax_response(){
				#was used for temporary captcha system, not used yet, removed
				$this->stop();
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
			public function report(){
        		// post is to be sent as variable#sl#stripped#sl#variable#sl#stripped
        		if($this->threat_arr){
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
			public function do_lockdown($data){
				#log connection failure
    			error_log("SecureLive Connection Failure! Lockdown_in: ".LOCKDOWN_IN.", Response: ".implode("|",$data).", IP: ".$this->ip.", Host: ".$this->host);
    			
    			if(LOCKDOWN_IN > 0){
    				#do clean string check on all data
    				$data = array(
						'ip'=>$this->ip,
						'hoster'=>$this->hoster,
						'query'=>$this->query,
						'uri'=>$this->uri,
						'browser'=>$this->browser,
						'referrer'=>$this->ref,
						'session'=>$this->session
					);
					
					#do clean string check on all data
					$temp = $this->clean_string_check($data);
					$is_clean = $temp[0];
					$reason = $temp[1];
					
					if(!$is_clean){
						#set error log instead of email
						error_log("SecureLive Fail/Lockdown: ".LOCKDOWN_IN.", IP: ".$this->ip.", Reason: $reason");
						
						#set block page
						require(dirname(__FILE__).'/block_pages/lockdown.php');
						return null;
					} else return null;
				} else return null;
			}
			public function present_404($threat_type, $emailed = ''){
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

			//DB Stuff
			public function db_enabled(){
				return (bool)($this->db != null && $this->db->cid != null);
			}
			public function load_db(){
        		global $wpdb;
		        if(class_exists('JFactory')){
		            $db =& JFactory::GetDBO();
		            if(isset($db->_resource))//J1.5
	            		$this->db = new Guardian($db->_resource);
		            else//J1.6
	            		$this->db = new Guardian($db->getConnection());
				}
				else if(!empty($wpdb) && isset($wpdb->dbh)){
					$this->db = new Guardian($wpdb->dbh);
				}
				else{
					$this->load_db_settings();
			        if(!empty($this->db_database) && !empty($this->db_host) && !empty($this->db_password) && !empty($this->db_username)){
	            		$this->db = new Guardian($this->db_host, $this->db_username, $this->db_password, $this->db_database);	
					}
				}
			}
	        public function load_db_settings(){
		        #Load WhiteSpace Values
				if($this->db_password == null && $this->config_exists()){
					$file = file_get_contents($this->config_fp);

					//$lines = explode("\n", $file);
					$lines = preg_split('/(\r\n|\n|\r)+/im', $file);
					$conf_inside_db = array();
					$pos = 'before';	
					//Read between start_db and end_db
					for($i = 0; $i < count($lines); $i++){
						$line = $lines[$i];
						switch($pos){
							case 'before':
								if($line == '//start_db'){
									$pos = 'inside';	
								}
								break;
								
							case 'inside':
								if($line == '//end_db'){
									$pos = 'after';	
								}
								else{
									$conf_inside_db[] = $line;
								}
								break;
								
							case 'after':
								break;	
						}
					}
					
					$this->db_host     = $this->DecodeWhiteSpace(@substr(@$conf_inside_db[0],2));
					$this->db_database = $this->DecodeWhiteSpace(@substr(@$conf_inside_db[1],2));
					$this->db_username = $this->DecodeWhiteSpace(@substr(@$conf_inside_db[2],2));
					$this->db_password = $this->DecodeWhiteSpace(@substr(@$conf_inside_db[3],2));
				}
				
				#Load config
				if($this->url_cache_loaded === false && $this->config_exists()){
					include($this->config_fp);
					$this->url_cache_loaded = true;
					if(isset($expires)) $this->url_cache_expires = $expires;
					if(isset($cache_mode)) $this->url_cache_mode = $cache_mode;
					if(isset($timeout)) $this->timeout = $timeout;
				}
			}			
			public function SetDBSetting($key, $value){
				if($this->db_enabled()){
					$key   = $this->db->clean($key);
					$value = $this->db->clean($value);
					
					//Create table if it doesn't exist
					$this->db->query("CREATE TABLE IF NOT EXISTS `sl_settings` (
								  `key` varchar(32) NOT NULL DEFAULT '',
								  `value` tinytext NOT NULL,
								  PRIMARY KEY (`key`)
								) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
					
					//Does key exist?
					$q = "SELECT * FROM `sl_settings` WHERE `key` = '$key'";
					$rs = $this->db->query($q);
					if(count($rs) > 0){//Update
						$q = "UPDATE `sl_settings` SET `value` = '$value' WHERE `key` = '$key'";
					}
					else{//Insert
						$q = "INSERT INTO `sl_settings` (`key`, `value`) VALUES ('$key', '$value')";
					}

					$this->db->query($q);
				}
			}
			public function GetDBSetting($key, $default = null){
				if($this->db_enabled()){
					$rs = $this->db->query("SELECT `value` FROM `sl_settings` WHERE `key` = '$key'");
					if(count($rs) > 0)
						return $rs[0][0];
					else
						return $default;
				}
				else {
					return $default;
				}
			}
			private function EncodeWhiteSpace($val){
				$output = '';
				for($i = 0; $i < strlen($val); $i++){
					$bin = decbin(ord($val[$i]));
					$bin = str_pad($bin, 8, '0', STR_PAD_LEFT);
					$bin = str_replace("0", " ", str_replace("1", "\t", $bin));
					$output .= $bin;
				}
				return $output;
			}
			private function DecodeWhiteSpace($val){
				$val = str_replace(" ", "0", str_replace("\t", "1", $val));
				
				#Divide val into 8 char chunks
				$bytes = array();
				for($byte = 0; $byte < strlen($val); $byte += 8){
					$b = '';
					for($bit = 0; $bit < 8; $bit++){
						$b .= @$val[$byte + $bit];
					}
					$bytes[] = $b;
				}
				
				#Decode each byte
				$output = '';
				for($i = 0; $i < count($bytes); $i++){
					$output .= chr(bindec($bytes[$i]));
				}
				
				return $output;
			}
			
			//Cache Stuff	
			public function add_cache($host, $uri, $query_string, $details){
				if($this->db_enabled()){
					//Define query varibles
					$safe = (@$details[2] == '1') ? 0 : 1;
					$host = $this->db->clean($host);
					$uri = $this->db->clean($uri);
					$query_string = $this->db->clean($query_string);
					$threat_type = ($safe == 1) ? 'none' : $this->db->clean(@$details[0]);
					$threat_level = ($safe == 1) ? 0 : intval(@$details[1]);
					$ip = $this->db->clean($this->ip);
					$now = time();
					$exp = time() + ( $this->url_cache_expires * 60 *60 * 24);
					
					if(!in_array($threat_type,$this->expected_threats) || $threat_type == 'whitelisted'){
						return null;
					}
					
					//Create table if it doesn't exist
					$this->db->query("CREATE TABLE IF NOT EXISTS `sl_url_cache` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `safe` tinyint(4) NOT NULL,
								  `host` tinytext NOT NULL,
								  `uri` tinytext NOT NULL,
								  `query_string` text NOT NULL,
								  `threat_type` tinytext NOT NULL,
								  `threat_level` smallint(6) NOT NULL,
								  `ip` varchar(15) NOT NULL,
								  `time` int(11) NOT NULL,
								  `exp` int(11) NOT NULL,
								  `blocks` tinytext,
								  PRIMARY KEY (`id`)
								) ENGINE=MyISAM DEFAULT CHARSET=utf8");
					
					//Prune Expired
					$q = "DELETE FROM `sl_url_cache` WHERE `exp` < $now";
					$this->db->query($q);
					
					//Does it exist already?
					$q = "SELECT `id` FROM `sl_url_cache` WHERE `host` = '$host' AND `uri` = '$uri'";
					$rs = $this->db->query($q);
					
					//Insert new cache record
					if(count($rs) == 0){
						$q = "INSERT INTO `sl_url_cache` (`id`, `safe`, `host`, `uri`, `query_string`, `threat_type`, `threat_level`, `ip`, `time`, `exp`)
									VALUES (null, $safe, '$host', '$uri', '$query_string', '$threat_type', $threat_level, '$ip', $now, $exp) ";
						$this->db->query($q);
					}
				}
			}
			public function check_cache($host, $uri, $query_string, &$details){
				if($this->db_enabled()){
					//Search DB for cache record
					$rs = $this->db->query("SELECT * FROM `sl_url_cache` WHERE `uri` = '".$this->db->clean($uri)."' AND `host` = '".$this->db->clean($host)."' AND `query_string` = '".$this->db->clean($query_string)."'");
					if(count($rs) == 0) return null;//return no cache record
					
					//Return results
					$details = $rs[0];
					return (bool)(intval($rs[0][1]) === 1);
				}
				else{
					return null;	
				}
			}
			public function do_cache_block_notice($details){
				if($this->db_enabled()){
					$email_select = $this->GetDBSetting('email_select');
					$email_thresh = $this->GetDBSetting('email_thresh');
					
					#Log Attack
					{
						$id = intval($details[0]);
						$rs = $this->db->query("SELECT `blocks` FROM `sl_url_cache` WHERE `id` = $id");
						if(count($rs) > 0){
							$count = $rs[0][0];
							if(strpos($count, '|') === false) $count = "0|";
							$parts = explode('|',$count);
							$count = intval(@$parts[0]) + 1;
							$ips = array_filter(explode(',', @$parts[1]));
							$ips[] = $this->ip;
							while(count($ips) > 10){
								array_shift($ips);	
							}
							$ips = implode(',', $ips);
							
							$blocks = $this->db->clean("$count|$ips");
							$q = "UPDATE `sl_url_cache` SET `blocks` = '$blocks' WHERE `id` = $id";
							$this->db->query($q);
						}
						
					}
					
					#Email Report
					if(strpos($email_select, 'db') !== false && intval($details['threat_type']) >= intval($email_thresh)){
						$r_email = $this->GetDBSetting('r_email');
						if(!$r_email == null){
							$plain_text = (bool)($this->GetDBSetting('plain_text_reports', '0') == '1');
							
							#Get Email Body
							{
								$body = '';
								if($plain_text)
									$body = file_get_contents(dirname(__file__).'/block_pages/email_standard_plainText.php');
								else
									$body = file_get_contents(dirname(__file__).'/block_pages/email_standard.php');
								
								$num_blocks = explode('|', $details['blocks']);
								$num_block  = intval($num_blocks[0]) + 1;
								
								$body = str_replace('{fulldomain}', $this->host, $body);
								$body = str_replace('{date}', date('M d, j h:i a'), $body);
								$body = str_replace('{threat_level}', $details['threat_level'], $body);
								$body = str_replace('{threat_type}', $details['threat_type'], $body);
								$body = str_replace('{num_attacks}', $num_block." (from cache)", $body);
								$body = str_replace('{ip}', $this->ip, $body);
								$body = str_replace('{why}', $details['threat_type'], $body);
								$body = str_replace('{uri}', $details['uri'], $body);
								$body = str_replace('{referrer}', $this->ref, $body);
								$body = str_replace('{browser}', $this->browser, $body);
								$body = str_replace('{os}', '', $body);
								$body = str_replace('{host}', $this->hoster, $body);
								
								$body = str_replace('{color1}', 'FFFDF6', $body);
								$body = str_replace('{color2}', 'E4E4D5', $body);
								$body = str_replace('{color3}', 'E1B42F', $body);
								$body = str_replace('{colortype}', 'attention', $body);
							}
							
							#Set Headers
							{
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								if($plain_text)
									$headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
								else
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								$headers .= 'From: SecureLive Security Advisory <support@securelive.net>' . "\r\n";
							}

	            			if(mail($r_email, "Incident report from SecureLive - ".$this->host, $body, $headers)){
								$emailed = 'Email Report sent!';
	            			} 
	            			else {
								$emailed = 'The server could not send the Email Report!';
	            			}
						}
						else{
							$emailed = 'No Email Report to send! Check Email Report Selection.';	
						}
							
					}
					else{
						$emailed = 'No Email Report to send! Check Email Report Selection.';
					}
				}
				else{
					$emailed = 'No Email Report to send! Check Cache Database Settings.';
				}
				
				$this->present_404($details[5], $emailed);
			}
			public function do_cache_safe_routine($details){
				if($this->db_enabled()){
					#Log Hit
					{
						$id = intval($details[0]);
						$rs = $this->db->query("SELECT `blocks` FROM `sl_url_cache` WHERE `id` = $id");
						if(count($rs) > 0){
							$count = $rs[0][0];
							if(strpos($count, '|') === false) $count = "0|";
							$parts = explode('|',$count);
							$count = intval(@$parts[0]) + 1;
							$ips = array_filter(explode(',', @$parts[1]));
							$ips[] = $this->ip;
							while(count($ips) > 10){
								array_shift($ips);	
							}
							$ips = implode(',', $ips);
							
							$blocks = $this->db->clean("$count|$ips");
							$q = "UPDATE `sl_url_cache` SET `blocks` = '$blocks' WHERE `id` = $id";
							$this->db->query($q);
						}
						
					}
				}
			}
			
			//XSS Filter
			private function clean_string_check($data=array(),$key=''){
				if(is_array($data)){
					foreach($data as $subKey=>$value){
						$clean = $this->clean_string_check($value,$key==''?$subKey:$key.'['.$subKey.']');
						if(!$clean[0]){
							return $clean;
						}
					}
				} else {
					$clean = $this->dirty_string_check($key,$data);
					if(!$clean[0]){
						return $clean;
					}
				}
				return array(1,'none');
			}
			private function dirty_string_check($key,$value){
				$dirty = 0;
				#super url decode
				while($value != urldecode($value)){
					$value = urldecode($value);
				}
				#super html entity decode
				while($value != html_entity_decode($value)){
					$value = html_entity_decode($value);
				}
				
				#detect test trigger
				if(preg_match('/xsecurelivex/',$value)){
					$dirty = 1;
				}
				#detect bad characters (xss)
				if(preg_match('/[^!@|\'a-zA-Z0-9[\]+&=?_\/.,%:;() -]|\'(?![sS](\s|$))/m',$value)){
					$dirty = 2;
				}
				#detect sql
				if(preg_match('/(select|drop|insert|update|union|waitfor|alter|delete|create|concat|\'|")/im',$value) && preg_match('/(from|--|where|like|#|union|delay|table)/im',$value)){
					$dirty = 3;
				}
				#detect rfi ://
				if(preg_match('/:\/\/(?!'.preg_quote($this->host).')/m',$value) && $key != 'referrer' && $key != 'browser'){
					$dirty = 4;
				}
				#detect transversal ../, .php/login.php
				if(preg_match('/(\.\.\/|\.php\/login\.php)/m',$value)){
					$dirty = 5;
				}
				#detect common script injections
				if(preg_match('/(#!\/|eval\s*("|\'|\()|base64_decode\s*("|\'|\())/im',$value)){
					$dirty = 6;
				}
				#detect hex character patterns 0x\w\w,....
				if(preg_match('/0x[0-9a-fA-F]+/m',$value)){
					$dirty = 7;
				}
				
				if($dirty){
					return array(0,"Code: $dirty, $key: $value");
				} else {
					return array(1,'none');
				}
			}
			private function do_xss_filter($value,$key=''){
				if(is_array($value)){
					foreach($value as $subKey=>$subValue){	
						$value[$subKey] = $this->do_xss_filter($subValue,$key==''?$subKey:$key.'['.$subKey.']');
					}
				} else {
					$counter = 0;
					#super url decode
					while($value != urldecode($value)){
						$value = urldecode($value);
					}
					#super html entity decode
					while($value != html_entity_decode($value)){
						$value = html_entity_decode($value);
					}
					#save the decoded value for comparison
					$newValue = $value;
					$newValHelper = $newValue;
					#loop strip function
					while($newValHelper != $this->xss_strip($newValue)){
						$counter++;
						$newValHelper = $newValue;
					}						
					#calculate what was stripped and push that to reporting array
					if($counter){
						array_push($this->threat_arr,array($key,$this->string_diff($value,$newValue)));
						$value = $newValue;
					}
				}
				return $value;	
			}
			public function xss_filter(){
		        #decide if there is anything to strip (clean string check)
				$clean = $this->clean_string_check($_POST);
				
				if($clean[0]){
					#nothing to do
					return null;
				} else {
					#going to strip!
					$_POST = $this->do_xss_filter($_POST);
					@$HTTP_POST_VARS = $_POST;
					
					#send the finished report
					$this->report();

					return null;#nothing to return
				}

			}
			private function string_diff(&$old,&$new){
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
			private function xss_strip(&$string) {
				#this goes through each step and returns the cleaned string. needs to be looped by parent
				$this->xss_strip_server_code($string);
				$this->xss_strip_web_docs($string);
				$this->xss_strip_invalid_tags($string);
				$this->xss_strip_bad_tags($string);
				$this->xss_strip_bad_attr($string);
				return $string;
			}
			private function xss_strip_bad_tags(&$string) {
				#strip any form of, or entire tag contents, of tags from the tag blacklist
				$bad_tags = explode(' ',POST_FILTER_BAD_TAGS);
				foreach($bad_tags as $tag){
					$string = preg_replace('/(<\s*'.preg_quote($tag).'(.|\s)*'.preg_quote($tag).'\s*>|<\s*'.preg_quote($tag).'(.|\s)*\/\s*>|<\s*'.preg_quote($tag).'(.|\s)*)/im','',$string);
				}
			}
			private function xss_strip_bad_attr(&$string) {
				#strip any form of, or entire tag contents, of tags w/ attr in the attr blacklist
				$bad_attr = explode(' ',POST_FILTER_BAD_ATTR);
				foreach($bad_attr as $attr){
					$string = preg_replace('/<\s*(\w+)\s+(.|\s)*'.preg_quote($attr).'\s*=(\s*[\'`"]|\w)(.|\s)*\1\s*>|<\s*(\w+)\s+(.|\s)*'.preg_quote($attr).'\s*=(\s*[\'`"]|\w)(.|\s)*\/\s*>|<\s*(\w+)\s+(.|\s)*'.preg_quote($attr).'\s*=(\s*[\'`"]|\w)(.|\s)*[^>]*>|<\s*(\w+)\s+(.|\s)*'.preg_quote($attr).'\s*=(\s*[\'`"]|\w)(.|\s)*/im','',$string);
				}
				#strip javascript and data from href and src
				$string = preg_replace('/<\s*(\w+)\s+[^>]*(href|src)\s*=\s*([\'`"])\s*((java|live|vb)script|mocha|behavior):([^>]>?[^>]*\1\s*>|.*\3[^>]*>?|.+(.|\s)*)/im','',$string);
			}
			private function xss_strip_invalid_tags(&$string) {
				#strip partial/broken tags
				#strip comments
				$string = preg_replace('/(<!--(.|\s)*-->|<!--(.|\s)*)/im','',$string);#comments
				$string = preg_replace('/^\s*[\'"]\s*\/\s*>/im','',$string);#only if it starts with escape value
			}
			private function xss_strip_web_docs(&$string) {
				#if <?xml, strip it all, strips doc types as well
				$string = preg_replace('/<\s*\?\s*xml[^>]*>?/im','',$string);#xml
				$string = preg_replace('/<\s*!\s*DOCTYPE[^>]*>?/im','',$string);#doctype
			}
			private function xss_strip_server_code(&$string) {
				#variations on <?, <%, #!/
				#strip eval statements, some sql escapes
				$string = preg_replace('/(<\s*\?(.|\s)*(\?\s*>)|<\s*\?(.|\s)*(\?\s*>)?)/im','',$string);#php
				$string = preg_replace('/(<\s*%(.|\s)*(%\s*>)|<\s*%(.|\s)*(%\s*>)?)/im','',$string);#asp
				$string = preg_replace('/#\s*!\s*(\w+:[\\\\\/]|\/)(\w*[\\\\\/])*(perl|php)(.|\s)*/im','',$string);#perl and command line php
				$string = preg_replace('/eval\s*(\(|"|\')\s*\w+(.|\s)*/im','',$string);#everything after eval
				$string = preg_replace('/([\'"]?\s*(or|and)\s*((\'|"|\d+)[\w\d\s@._-]*)[\'"]?\s*=\3(\s|.)*|^\s*([\w\d@._-]+)?\s*[\'"](\s|.)*=(\s|.)*(--|#|\/\*)(\s|.)*|^\s*(\d+|\'|")\s*;(\s|.)*(--|#|\/\*|drop|select)(\s|.)*|\'\s*(--|#|\/\*)(\s|.)*)/im','',$string);#sql
			}

		}
		
		#see if apache version ran
		if(!isset($_ENV['SECURELIVE'])){
			#create obj
		    $SL = new SecureLive_Scanner();
		    #check diag
			if($SL->requested_diagnostics()){
				$SL->show_diagnostics();
			}
			#do scan
			$SL->process_response($SL->init_scan());
			
			#do post filter
			if(!$SL->bypassed() && !$SL->is_admin()){
				$SL->xss_filter();
			}
			$SL->stop();
		}
	}
	else {
		if((defined('FRAME_BUSTER') && FRAME_BUSTER==true) || isset($_ENV['SECURELIVE_FRAME_BUSTER'])){
			$SL = new SecureLive_Scanner();
			$SL->do_frame_buster();
			$SL->stop();
		}
	}
?>