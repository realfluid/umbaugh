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

	#ini_set('display_errors',1);
	#error_reporting(E_ALL);

    if(!class_exists('SecureLive_Scanner')){
    	include('sl8.php');
	}
	global $sl_admin;
	$sl_admin = new SecureLive_Admin();
	$output = '';
	if($sl_admin->account->valid=='true'){
		if($sl_admin->is_ajax_req()){
			echo $sl_admin->ajax_response();
		} elseif($sl_admin->is_page_req()) {
			echo $sl_admin->page_response();
		} else {
			#$output .= $sl_admin->current_page();
			$output .= $sl_admin->loader();
		}
	} else {
		$output .= $sl_admin->invalid_acct();
	}
	$sl_admin->stop();
	/************************************************************/
	class SecureLive_Admin{
		public $sl_engine_ver = '8.2.04';
		public $sl_admin_ver = '5.2.06';
		public $account = null;
		public $filepath = null;
		public $ip = null;
		private $host = null;
		private $uri = null;
		private $page_arr = array('ip','statistics','attacklog','diagnostics','memos','addons','help','details');
		private $bypass_arr = null;
		private $sl_custom_path = null;
		public $config_fp = null;
		public $connection;
		public $versionMessage = null;
		private $db = null;
		private $mainframe = null;
		/***************************************/
		
		public function SecureLive_Admin(){
			$this->host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
			$this->filepath = $this->sl_get_path();
			$this->account = new Account();
			$this->uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
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
		}
		public function LinkThreatLevel($val){
			$val = intval($val);
			
			if($val >= 0 &&	$val < 3){
				return "Low";
			}
			else if($val >= 3 && $val < 6){
				return "Medium";
			}
			else {
				return "High";
			}
		}
		public function stop($die=false){
			global $sl_admin;
			unset($sl_admin);
			unset($this);
			if($die){
				die();
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
        private function sl_changeURI($uri, $what, $to){
	        $what_start = strpos($uri, $what);
	        $what_end = strpos($uri, $what) + strlen($what);
	        $val_start = $what_end;
	        $val_end = substr_count($uri, '&', $val_start) ? strpos($uri, '&', $val_start)-1 : strlen($uri);
	        if(substr($uri,$what_start-1,1) != '?'){
	            $what_start = strpos($uri, $what)-1;
	        } else {
	            $val_end++;
	        }
	        if(substr_count($uri, '&', $val_start)){
	            $val_end++;
	        }
	        if(!$to){
	            return substr($uri, 0, $what_start).substr($uri, $val_end);
	        } else {
	            return substr($uri, 0, $val_start).$to.substr($uri, $val_end);
	        }
	    }
        private function putMemos($thisDomainAcct, $filepath){
	        $mURL = array('act'=>'count_tickets','host'=>$this->host);
	        $num = @intval(reset($this->sl_post_request("remote4.php", http_build_query($mURL,'','&'))));

	        // link - currently no link given
	        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
	        //$memoURL = substr_count($uri, 'sl_page=') ? sl_changeURI($uri, 'sl_page=', 'memos') : (substr_count($uri, '?') ? $uri.'&sl_page=memos' : $uri.'?sl_page=memos');
	        $on_memo_page = substr_count($uri, 'sl_page=memos') ? true : false;
	        if($num > 0){
	            //return "mailbox_full.png\" align=\"top\" /> <span style=\"color:#ff0;padding:0px;\">$num new!</span> ";
	            if($on_memo_page){
	                return "<img src=\"".$this->filepath."/images/mailbox_full.png\" align=\"top\" /> <span style=\"color:#ff0;padding:0px;\">$num new</span><span style=\"color:#ccc;\">Support";
	            } else {
	                return "<div id=\"animate\" style=\"display:inline;position:relative;top:0px;\">
	                			<img src=\"".$this->filepath."/images/mailbox_full.png\" align=\"top\" />
	                			<span style=\"color:#ff0;padding:0px;\">$num new</span>
	                        </div>
	                		<script type=\"text/javascript\">memoAlert.animate();</script><span style=\"color:#ccc;\">Support</span>";
	            }
	        } else {
	            return '<img src="'.$this->filepath.'/images/mailbox_empty.png" align="top" /><span style="color:#ccc;">Support Tickets</span>';
	        }
	    }
		private function foot(){
			$output = '            <!-- Footer -->'."\n";
		    $output .= '            <div class="s5_wrap">'."\n";
		    $output .= '                <div id="s5_footerleft"></div>'."\n";
		    $output .= '                <div id="s5_footermiddle">'."\n";
		    $output .= '                    <div id="s5_footcopy">'."\n";
		    $output .= '                        <span class="footerc">Copyright &copy;2009-2010. <a href="http://www.securelive.net" target="_blank">SecureLive, LLC</a>.</span>'."\n";
		    $output .= '                    </div>'."\n";
		    $output .= '                    <div style="clear:both;"></div>'."\n";
		    $output .= '                </div>'."\n";
		    $output .= '                <div id="s5_footerright"></div>'."\n";
		    $output .= '            </div>'."\n";
		    $output .= '            <!-- End Footer -->'."\n";
		    $output .= '            <div style="height:30px;clear:both;"></div>'."\n";
		    $output .= '        </div>'."\n";
		    return $output;
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
				setcookie('secureliveBL',"bl:$val,",time()+(60*60*24*$this->ban_days),'/');
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
				setcookie('securelive',$newstack,0,'/');
			}
		}
	    private function nicetrim ($string, $maxsize=22) {
	        if (!isset($maxsize)){$maxsize = 25;}
	        $str_to_count = html_entity_decode($string);
	        if (strlen($str_to_count) <= $maxsize) {
	            return $string;
	        }
	        $string2 = substr($str_to_count, 0, $maxsize - 3).'...';
	        return htmlentities($string2);
	    }
		private function topRightStart ($domainname){
			$sl_output =	'				<div id="s5_topright" style="width:450px; height: 375px;">'."\n";
			$sl_output .=	'					<div class="s5_whitemodtl"></div>'."\n";
			$sl_output .=	'					<div class="s5_whitemodtm" style="width:436px;"></div>'."\n";
			$sl_output .=	'					<div class="s5_whitemodtr"></div>'."\n";
			$sl_output .=	'					<div style="clear:both;"></div>'."\n";
			$sl_output .=	'					<div class="s5_whitemodleftwrap">'."\n";
			$sl_output .=	'						<div class="s5_whitemodrightwrap" style="width:450px;">'."\n";
			$sl_output .=	'							<div class="s5_backmiddlemiddle_r" style="width:436px;">'."\n";
			$sl_output .=	'								<div class="module">'."\n";
			$sl_output .=	'									<div>'."\n";
			$sl_output .=	'										<div>'."\n";
			$sl_output .=	'											<div>'."\n";
			//$sl_output .=	'												<a href="'.$this->sl_make_link('help').'&id=account_information"><img src="'.$this->filepath.'/images/help.png" align="right"/></a>'."\n";
			//$sl_output .=	'												<h3 class="s5_mod_h3-light"><span class="s5_h3_first">Account </span> Information for <span style="color: #D01314; font-weight: bold;">'.$this->nicetrim($domainname, 35).'</span></h3>';
			$sl_output .=	'												<div id="s5_buttonswrap_ts2" style="width:418px;"></div>'."\n";
			$sl_output .=	'												<div id="s5_buttonswrap_ts2" style="width:418px;"></div>'."\n";
			$sl_output .=	'												<div style="clear:both;"></div>'."\n";
			$sl_output .=	'												<div id="s5_tabshow_left2" style="width:421px;">'."\n";
			$sl_output .=	'													<div id="s5_tabshow_right2" style="width:426px;">'."\n";
			$sl_output .=	'														<div style="width:441px; overflow:hidden;">'."\n";
			$sl_output .=	'															<div id="s5_button2" style="width:421px; ">'."\n";
			$sl_output .=	'																<ul id="s5_button_content2" style="margin-left:-40px;">'."\n";
			$sl_output .=	'																	<li class="s5_button_item2" id="s5_button_item_copy_1" style="left:0px;display:block;">'."\n";
			$sl_output .=	'																		<div style="width:451px; margin-right:12px; padding-right:4px;">'."\n";
			$sl_output .=	'																			<div style="width:391px;padding:10px;margin-top:10px;">'."\n";
			$sl_output .=	'																				<div class="moduletable">'."\n";
			return $sl_output;
		}
		private function topRightEnd (){
			$sl_output =	'																				</div>'."\n";
			$sl_output .=	'																			</div>'."\n";
			$sl_output .=	'																		</div>'."\n";
			$sl_output .=	'																	</li>'."\n";
			$sl_output .=	'																</ul>'."\n";
			$sl_output .=	'															</div>'."\n";
			$sl_output .=	'														</div>'."\n";
			$sl_output .=	'													</div>'."\n";
			$sl_output .=	'												</div>'."\n";
			$sl_output .=	'												<div id="s5_tabshow_bottomleft2"></div>'."\n";
			$sl_output .=	'												<div id="s5_tabshow_bottommiddle2" style="width:424px;"></div>'."\n";
			$sl_output .=	'												<div id="s5_tabshow_bottomright2"></div>'."\n";
			$sl_output .=	'												<div style="clear:both;height:13px;"></div>'."\n";
			$sl_output .=	'											</div>'."\n";
			$sl_output .=	'										</div>'."\n";
			$sl_output .=	'									</div>'."\n";
			$sl_output .=	'								</div>'."\n";
			$sl_output .=	'								<div style="clear:both;"></div>'."\n";
			$sl_output .=	'							</div>'."\n";
			$sl_output .=	'						</div>'."\n";
			$sl_output .=	'					</div>'."\n";
			$sl_output .=	'					<div class="s5_whitemodtbl"></div>'."\n";
			$sl_output .=	'					<div class="s5_whitemodtbm" style="width:436px;"></div>'."\n";
			$sl_output .=	'					<div class="s5_whitemodtbr"></div>'."\n";
			$sl_output .=	'					<div style="clear:both;"></div>'."\n";
			$sl_output .=	'				</div>'."\n";
			return $sl_output;
		}
		private function ModuleStart($modNum=1, $width=100, $color='light', $title=null, $modType, $show_help=false){
			$expTitle = explode(" ", $title);
			if(!isset($expTitle[0])){$expTitle[0]=NULL;}
			$expTitle2 = '';
			for($i=1;$i<count($expTitle);$i++){
				$expTitle2 .= ' '.$expTitle[$i];
			}
			$sl_output =	'					<div id="s5_'.$modType.$modNum.'_'.$width.'">'."\n";
			$sl_output .=	'						<div class="module'.$color.'">'."\n";
			$sl_output .=	'							<div>'."\n";
			$sl_output .=	'								<div>'."\n";
			$sl_output .=	'									<div>'."\n";
			if ($show_help){
				$sl_output .=	'										<a href="#" onclick="sl_gateway.open(\'help\',\'&id='.strtolower($expTitle[0]).(isset($expTitle[1]) ? '_'.strtolower($expTitle[1]) : '').'\');return false;"><img src="'.$this->filepath.'/images/help.png" align="right" style="margin-top: -4px;"/></a>'."\n";
			}
			$sl_output .=	'										<h3 class="s5_mod_h3'.$color.'"><span class="s5_h3_first">'.$expTitle[0].'</span>'.$expTitle2.'</h3>'."\n";
			return $sl_output;
		}
		private function EndModule(){
			$sl_output =	'									</div>'."\n";
			$sl_output .=	'								</div>'."\n";
			$sl_output .=	'							</div>'."\n";
			$sl_output .=	'						</div>'."\n";
			$sl_output .=	'					</div>'."\n";
			return $sl_output;
		}
		private function sl_convert_country($cc){
	        $names = array('Anonymous Proxy', 'Satellite Provider', 'Andorra', 'United Arab Emirates', 'Afghanistan', 'Antigua and Barbuda', 'Anguilla', 'Albania', 'Armenia','Netherlands Antilles', 'Angola', 'Asia/Pacific Region', 'Antarctica', 'Argentina', 'American Samoa', 'Austria', 'Australia', 'Aruba', 'Aland Islands', 'Azerbaijan', 'Bosnia and Herzegovina', 'Barbados', 'Bangladesh', 'Belgium', 'Burkina Faso', 'Bulgaria', 'Bahrain', 'Burundi', 'Benin', 'Bermuda', 'Brunei Darussalam', 'Bolivia', 'Brazil', 'Bahamas', 'Bhutan','Bouvet Island', 'Botswana', 'Belarus', 'Belize', 'Canada', 'Cocos (Keeling) Islands', 'Congo, Democratic Republic', 'Central African Republic', 'Congo', 'Switzerland', 'Cote d Ivoire', 'Cook Islands', 'Chile', 'Cameroon', 'China', 'Colombia', 'Costa Rica', 'Cuba', 'Cape Verde', 'Christmas Island', 'Cyprus', 'Czech Republic', 'Germany', 'Djibouti', 'Denmark', 'Dominica', 'Dominican Republic', 'Algeria', 'Ecuador', 'Estonia', 'Egypt', 'Western Sahara', 'Eritrea', 'Spain', 'Ethiopia', 'Europe', 'Finland', 'Fiji', 'Falkland Islands (Malvinas)', 'Micronesia, Federated States', 'Faroe Islands', 'France', 'Gabon', 'United Kingdom', 'Grenada', 'Georgia', 'French Guiana', 'Guernsey', 'Ghana', 'Gibraltar', 'Greenland', 'Gambia', 'Guinea', 'Guadeloupe', 'Equatorial Guinea', 'Greece', 'South Georgia and Sandwich Islands', 'Guatemala', 'Guam', 'Guinea-Bissau', 'Guyana', 'Hong Kong', 'Heard Island and McDonald Islands', 'Honduras', 'Croatia', 'Haiti', 'Hungary', 'Indonesia', 'Ireland', 'Israel', 'Isle of Man', 'India', 'British Indian Ocean Territory', 'Iraq', 'Iran, Islamic Republic of', 'Iceland', 'Italy', 'Jersey', 'Jamaica', 'Jordan', 'Japan', 'Kenya', 'Kyrgyzstan', 'Cambodia', 'Kiribati', 'Comoros', 'Saint Kitts and Nevis', 'Korea, Democratic S. Republic of', 'Korea, Republic of', 'Kuwait', 'Cayman Islands', 'Kazakhstan', 'Lao S. Democratic Republic', 'Lebanon', 'Saint Lucia', 'Liechtenstein', 'Sri Lanka', 'Liberia', 'Lesotho', 'Lithuania', 'Luxembourg', 'Latvia', 'Libyan Arab Jamahiriya', 'Morocco', 'Monaco', 'Moldova, Republic of', 'Montenegro', 'Madagascar', 'Marshall Islands', 'Macedonia', 'Mali', 'Myanmar', 'Mongolia', 'Macao', 'Northern Mariana Islands', 'Martinique', 'Mauritania', 'Montserrat', 'Malta', 'Mauritius', 'Maldives', 'Malawi', 'Mexico', 'Malaysia', 'Mozambique', 'Namibia', 'New Caledonia', 'Niger', 'Norfolk Island', 'Nigeria', 'Nicaragua', 'Netherlands', 'Norway', 'Nepal', 'Nauru', 'Niue', 'New Zealand', 'Oman', 'Panama', 'Peru', 'French Polynesia', 'Papua New Guinea', 'Philippines', 'Pakistan', 'Poland', 'Saint Pierre and Miquelon', 'Pitcairn', 'Puerto Rico', 'Palestinian Territory', 'Portugal', 'Palau', 'Paraguay', 'Qatar', 'Reunion', 'Romania', 'Serbia', 'Russian Federation', 'Rwanda', 'Saudi Arabia', 'Solomon Islands', 'Seychelles', 'Sudan', 'Sweden', 'Singapore', 'Saint Helena', 'Slovenia', 'Svalbard and Jan Mayen', 'Slovakia', 'Sierra Leone', 'San Marino', 'Senegal', 'Somalia', 'Suriname', 'Sao Tome and Principe', 'El Salvador', 'Syrian Arab Republic', 'Swaziland', 'Turks and Caicos Islands', 'Chad', 'French Southern Territories', 'Togo', 'Thailand', 'Tajikistan', 'Tokelau', 'Timor-Leste', 'Turkmenistan', 'Tunisia', 'Tonga', 'Turkey', 'Trinidad and Tobago', 'Tuvalu', 'Taiwan', 'Tanzania, United Republic of', 'Ukraine', 'Uganda', 'United States Minor Outlying Islands', 'United States', 'Uruguay', 'Uzbekistan', 'Holy See (Vatican City State)', 'Saint Vincent and the Grenadines', 'Venezuela', 'Virgin Islands, British', 'Virgin Islands, U.S.', 'Vietnam', 'Vanuatu', 'Wallis and Futuna', 'Samoa', 'Yemen', 'Mayotte', 'South Africa', 'Zambia', 'Zimbabwe');
	        $vals =  array('a1.gif', 'a2.png', 'ad.png', 'ae.png', 'af.png', 'ag.png', 'ai.png', 'al.png', 'am.png', 'an.png', 'ao.png', 'ap.png', 'aq.png', 'ar.png', 'as.png', 'at.png', 'au.png', 'aw.png', 'ax.png', 'az.png', 'ba.png', 'bb.png', 'bd.png', 'be.png', 'bf.png', 'bg.png', 'bh.png', 'bi.png', 'bj.png', 'bm.png', 'bn.png', 'bo.png', 'br.png', 'bs.png', 'bt.png', 'bv.png', 'bw.png', 'by.png', 'bz.png', 'ca.png', 'cc.png', 'cd.png', 'cf.png', 'cg.png', 'ch.png', 'ci.png', 'ck.png', 'cl.png', 'cm.png', 'cn.png', 'co.png', 'cr.png', 'cu.png', 'cv.png', 'cx.png', 'cy.png', 'cz.png', 'de.png', 'dj.png', 'dk.png', 'dm.png', 'do.png', 'dz.png', 'ec.png', 'ee.png', 'eg.png', 'eh.png', 'er.png', 'es.png', 'et.png', 'eu.png', 'fi.png', 'fj.png', 'fk.png', 'fm.png', 'fo.png', 'fr.png', 'ga.png', 'gb.png', 'gd.png', 'ge.png', 'gf.png', 'gg.png', 'gh.png', 'gi.png', 'gl.png', 'gm.png', 'gn.png', 'gp.png', 'gq.png', 'gr.png', 'gs.png', 'gt.png', 'gu.png', 'gw.png', 'gy.png', 'hk.png', 'hm.png', 'hn.png', 'hr.png', 'ht.png', 'hu.png', 'id.png', 'ie.png', 'il.png', 'im.png', 'in.png', 'io.png', 'iq.png', 'ir.png', 'is.png', 'it.png', 'je.png', 'jm.png', 'jo.png', 'jp.png', 'ke.png', 'kg.png', 'kh.png', 'ki.png', 'km.png', 'kn.png', 'kp.png', 'kr.png', 'kw.png', 'ky.png', 'kz.png', 'la.png', 'lb.png', 'lc.png', 'li.png', 'lk.png', 'lr.png', 'ls.png', 'lt.png', 'lu.png', 'lv.png', 'ly.png', 'ma.png', 'mc.png', 'md.png', 'me.png', 'mg.png', 'mh.png', 'mk.png', 'ml.png', 'mm.png', 'mn.png', 'mo.png', 'mp.png', 'mq.png', 'mr.png', 'ms.png', 'mt.png', 'mu.png', 'mv.png', 'mw.png', 'mx.png', 'my.png', 'mz.png', 'na.png', 'nc.png', 'ne.png', 'nf.png', 'ng.png', 'ni.png', 'nl.png', 'no.png', 'np.png', 'nr.png', 'nu.png', 'nz.png', 'om.png', 'pa.png', 'pe.png', 'pf.png', 'pg.png', 'ph.png', 'pk.png', 'pl.png', 'pm.png', 'pn.png', 'pr.png', 'ps.png', 'pt.png', 'pw.png', 'py.png', 'qa.png', 're.png', 'ro.png', 'rs.png', 'ru.png', 'rw.png', 'sa.png', 'sb.png', 'sc.png', 'sd.png', 'se.png', 'sg.png', 'sh.png', 'si.png', 'sj.png', 'sk.png', 'sl.png', 'sm.png', 'sn.png', 'so.png', 'sr.png', 'st.png', 'sv.png', 'sy.png', 'sz.png', 'tc.png', 'td.png', 'tf.png', 'tg.png', 'th.png', 'tj.png', 'tk.png', 'tl.png', 'tm.png', 'tn.png', 'to.png', 'tr.png', 'tt.png', 'tv.png', 'tw.png', 'tz.png', 'ua.png', 'ug.png', 'um.png', 'us.png', 'uy.png', 'uz.png', 'va.png', 'vc.png', 've.png', 'vg.png', 'vi.png', 'vn.png', 'vu.png', 'wf.png', 'ws.png', 'ye.png', 'yt.png', 'za.png', 'zm.png', 'zw.png');
	        for($i=0;$i<count($names);$i++){
	            if(strtolower($cc)==strtolower($names[$i])){
	                return $vals[$i];
	            }
	        }
	    }
	    private function sl_attack_breakdown($atk_type){
	        $atk_color = ''; $desc = '';
	        if (preg_match("/transversal/i", $atk_type)) {
	            $atk_color="#2727CB";
	            $why = 'Transversal Attack';
	            $desc = '<div style="text-align: justify">Transversal attacks, are attacks that try to move backwards into your server\'s directories. Usually this is to obtain your server\'s password file, or to gain access to outside of the public folders. Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a>.</div>';
	        } elseif (preg_match("/remote file/i", $atk_type)) {
	            $atk_color="#FF0000";
	            $why = 'Remote File Include';
	            $desc = '<div style="text-align: justify">A Remote File Include attack, also known as RFI attack is still debated as the worst attack of all. There are many out there that can compete with this but this can be the most dangerous of them all. RFI attacks come in many different flavors, the most common is to try and inject a file into your site. This can happen with file permissions set to allow writing to everyone (usually that is a setting of 777). SecureLive uses very advanced detection system just for RFIs and the technology is updated very often. Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a>.</div>';
	        } elseif (preg_match("/bot/i", trim($atk_type))) {
	            $atk_color="#00AEEF";
	            $why = 'Known Spam Bot Host';
	            $desc = '<div style="text-align: justify">Known Spam Bot Hosts are matched against the referrer, header agent string, IP address or keywords that are in the URL. Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a>.</div>';
	        } elseif (preg_match("/shell/i", $atk_type)) {
	            $atk_color="#088B29";
	            $why = 'Shell or SSH Attack';
	            $desc = '<div style="text-align: justify">Shell or SSH Attack, Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a>.</div>';
	        } elseif (preg_match("/xss/i", $atk_type)) {
	            $atk_color="#4B176F";
	            $why = 'XSS Attack';
	            $desc = '<div style="text-align: justify">An XSS Attack is usually the cause of attempting a line of code into a form or URL, although we filter many types of injections through the forms as possible, SecureLive also scans other areas that may be a threat. Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a></div>';
	        } elseif (preg_match("/email/i", $atk_type)) {
	            $atk_color="#152C50";
	            $why = 'E-Mail Scavenger or Probe';
	            $desc = '<div style="text-align: justify">E-Mail probes will scrape your website to look for text@text.tld when it finds a match, it will then take all of the E-Mails it finds and sell them to spamming companies. These companies will then advertise theirs or other people products, this unsolicited mail is called spamming.</div>';
	        } elseif (preg_match("/sql/i", $atk_type)) {
	            $atk_color="#6A6F58";
	            $why = 'SQL Injection Attack';
	            $desc = '<div style="text-align: justify">A form of attack on a database-driven Web site in which the attacker executes unauthorized SQL commands by taking advantage of insecure code on a system connected to the Internet.  SQL injection attacks are used to steal information from a database from which the data would normally not be available and/or to gain access to an organization\'s host computers through the computer that is hosting the database. Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a>.</div>';
	        } elseif (preg_match("/php/i", $atk_type)) {
	            if (preg_match("/phpbb/i", $atk_type)) {
	                $atk_color="#24034D";
	                $why = 'PHPBB Forum Attack';
	                $desc = '<div style="text-align: justify">PHPBB is one of the most popular PHP Forum systems around, because it is free to download, and is extremely versital to use. This also allows hackers to download and try to find vulnerabilities in the coding, SecureLive detects most of these types of attacks and blocks the hackers from achieving their goal.</div>';
	            } else {
	                $atk_color="#710581";
	                $why = 'PHP Injection Attack';
	                $desc = '<div style="text-align: justify">Code injection can be many form of code types, such as PHP, ASP, HTML, JAVA, and JS is the exploitation of a computer bug that is caused by processing invalid data. Code injection can be used by an attacker to introduce (or "inject") code into a computer program to change the course of execution. The results of a Code Injection attack can be disastrous. For instance, code injection is used by some Computer worms to propagate. Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a>.</div>';
	            }
	        } elseif (preg_match("/server/i", $atk_type)) {
	            $atk_color="#932967";
	            $why = 'Server to Server Attack';
	            $desc = '<div style="text-align: justify">A server-side include vulnerability is a vulnerability that may allow an attacker to execute arbitrary scripts on a host server by causing an existing script to include an arbitrary file. The vulnerability arises by allowing unchecked user data to be passed to include directives in scripting languages, such as PHP. Other types of vulnerabilities of this can be holes in old versions of your server\'s core web environment such as PHP 4.0 or ASP 1.0. Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a>.</div>';
	        } elseif (preg_match("/firewall/i", $atk_type)) {
	            $atk_color="#00B905";
	            $why = 'Firewall Pollute';
	            $desc = '<div style="text-align: justify">Firewall Pollute, Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a>.</div>';
	        } elseif (preg_match("/common/i", $atk_type)) {
	            $atk_color="#00B905";
	            $why = 'Common Bot Search String';
	            $desc = '<div style="text-align: justify">Common Bot Search String, Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a>.</div>';
	        } elseif (preg_match("/editor/i", $atk_type)) {
	            $atk_color="#5A467E";
	            $why = 'Remote Editor Attacks';
	            $desc = '<div style="text-align: justify">Remote Editor Attacks, usues a mixture of other types of attacks to use editors remotely to access your code and change your code to their liking.</div>';
	        } elseif (preg_match("/port/i", $atk_type)) {
	            $atk_color="#521F1A";
	            $why = 'System Port Attack';
	            $desc = '<div style="text-align: justify">In computer networking, port knocking is a method of externally opening ports on a firewall by generating a connection attempt on a set of prespecified closed ports. Once a correct sequence of connection attempts is received, the firewall rules are dynamically modified to allow the host which sent the connection attempts to connect over specific port(s). A variant called Single Packet Authentication exists, where only a single \'knock\' is needed, consisting of an encrypted packet.<br /><br />The primary purpose of port knocking is to prevent an attacker from scanning a system for potentially exploitable services by doing a port scan, because unless the attacker sends the correct knock sequence, the protected ports will appear closed.</div>';
	        } else {
	            $atk_color="#3E3434";
	            $why = 'Other type of attack';
	            $desc = '<div style="text-align: justify">There are tens of thousands of attack types, SecureLive tracks and stores only the most important ones, but blocks 98.9% of all attacks. This attack type is probably more of a unknown entity trying to do unknown things. Even though it isn\'t in the top attack type, you should still investigate the location that was attempted on. Depending on links on your website, this may produce a <a href="'.$this->sl_make_link('help').'&id=false_positive">false positive</a></div>';
	        }
	        return $atk_color."~".$why."~".$desc;
	    }
	    private function validateIpAddress($ip_addr){
	        if(preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/",$ip_addr)){
	            $parts=explode(".",$ip_addr);
	            foreach($parts as $ip_parts){
	                if(intval($ip_parts)>255 || intval($ip_parts)<0)
	                return false;
	            }
	            return true;
	        } else {
	            return false;
	        }
		}
		private function IPv4To6($Ip) {
		    static $Mask = '::ffff:'; // This tells IPv6 it has an IPv4 address
		    $IPv6 = (strpos($Ip, '::') === 0);
		    $IPv4 = (strpos($Ip, '.') > 0);

		    if (!$IPv4 && !$IPv6) return false;
		    if ($IPv6 && $IPv4) $Ip = substr($Ip, strrpos($Ip, ':')+1); // Strip IPv4 Compatibility notation
		    elseif (!$IPv4) return $Ip; // Seems to be IPv6 already?
		    $Ip = array_pad(explode('.', $Ip), 4, 0);
		    if (count($Ip) > 4) return false;
		    for ($i = 0; $i < 4; $i++) if ($Ip[$i] > 255) return false;

		    $Part7 = base_convert(($Ip[0] * 256) + $Ip[1], 10, 16);
		    $Part8 = base_convert(($Ip[2] * 256) + $Ip[3], 10, 16);
		    return $Mask.$Part7.':'.$Part8;
		}
		private function utf8RawUrlDecode ($source) {
	        $decodedStr = "";
	        $pos = 0;
	        $len = strlen ($source);
	        while ($pos < $len) {
	            $charAt = substr ($source, $pos, 1);
	            if ($charAt == '%') {
	                $pos++;
	                $charAt = substr ($source, $pos, 1);
	                if ($charAt == 'u') {
	                    // we got a unicode character
	                    $pos++;
	                    $unicodeHexVal = substr ($source, $pos, 4);
	                    $unicode = hexdec ($unicodeHexVal);
	                    $entity = "&#". $unicode . ';';
	                    $decodedStr .= utf8_encode ($entity);
	                    $pos += 4;
	                }
	                else {
	                    // we have an escaped ascii character
	                    $hexVal = substr ($source, $pos, 2);
	                    $decodedStr .= chr (hexdec ($hexVal));
	                    $pos += 2;
	                }
	            } else {
	                $decodedStr .= $charAt;
	                $pos++;
	            }
	        }
	        return $decodedStr;
	    }
	    private function colorizeit($query){
	        if (is_null($query)){
	            return 'Nothing to do';
	        } else {
	            //$query = preg_replace("/['\"]([^'\"]*)['\"]/i", "'<FONT COLOR='#FF6600'>$1</FONT>'", $query, -1);
	            $query = str_ireplace(
	            array ('*', 'SELECT', 'UPDATE ', 'DELETE ', 'INSERT ', 'INTO', 'VALUES', 'FROM', 'LEFT', 'JOIN', 'WHERE', 'LIMIT', 'ORDER BY', 'AND', 'OR ', 'DESC', 'ASC', 'ON ', 'UNION',
	                        '&lt;!--', '&lt;!DOCTYPE', '&lt;a href=', '&lt;abbr', '&lt;acronym', '&lt;address', '&lt;applet', '&lt;area', '&lt;b', '&lt;base', '&lt;basefont', '&lt;bdo', '&lt;big', '&lt;blockquote', '&lt;body',
	                        '&lt;br', '&lt;button', '&lt;caption', '&lt;center', '&lt;cite', '&lt;code', '&lt;col', '&lt;colgroup', '&lt;dd', '&lt;del', '&lt;dfn', '&lt;dir', '&lt;div', '&lt;dl', '&lt;dt', '&lt;em',
	                        '&lt;fieldset', '&lt;font', '&lt;form', '&lt;frame', '&lt;frameset', '&lt;head', '&lt;h1', '&lt;h2', '&lt;h3', '&lt;h4', '&lt;h5', '&lt;h6', '&lt;hr', '&lt;html', '&lt;i', '&lt;iframe', '&lt;img',
	                        '&lt;input', '&lt;ins', '&lt;kbd', '&lt;label', '&lt;legend', '&lt;li', '&lt;link', '&lt;map', '&lt;menu', '&lt;meta', '&lt;noframes', '&lt;noscript', '&lt;object', '&lt;ol', '&lt;optgroup',
	                        '&lt;option', '&lt;p', '&lt;param', '&lt;pre', '&lt;q', '&lt;s', '&lt;samp', '&lt;script', '&lt;select', '&lt;small', '&lt;span', '&lt;strike', '&lt;strong', '&lt;style', '&lt;sub', '&lt;sup',
	                        '&lt;table', '&lt;tbody', '&lt;td', '&lt;textarea', '&lt;tfoot', '&lt;th', '&lt;thead', '&lt;title', '&lt;tr', '&lt;tt', '&lt;u', '&lt;ul', '&lt;var',
	                        '&lt;//a', '&lt;/abbr', '&lt;/acronym', '&lt;/address', '&lt;/applet', '&lt;/area', '&lt;/b', '&lt;/base', '&lt;/basefont', '&lt;/bdo', '&lt;/big', '&lt;/blockquote', '&lt;/body',
	                        '&lt;/br', '&lt;/button', '&lt;/caption', '&lt;/center', '&lt;/cite', '&lt;/code', '&lt;/col', '&lt;/colgroup', '&lt;/dd', '&lt;/del', '&lt;/dfn', '&lt;/dir', '&lt;/div', '&lt;/dl', '&lt;/dt', '&lt;/em',
	                        '&lt;/fieldset', '&lt;/font', '&lt;/form', '&lt;/frame', '&lt;/frameset', '&lt;/head', '&lt;/h1', '&lt;/h2', '&lt;/h3', '&lt;/h4', '&lt;/h5', '&lt;/h6', '&lt;/hr', '&lt;/html', '&lt;/i', '&lt;/iframe', '&lt;/img',
	                        '&lt;/input', '&lt;/ins', '&lt;/kbd', '&lt;/label', '&lt;/legend', '&lt;/li', '&lt;/link', '&lt;/map', '&lt;/menu', '&lt;/meta', '&lt;/noframes', '&lt;/noscript', '&lt;/object', '&lt;/ol', '&lt;/optgroup',
	                        '&lt;/option', '&lt;/p', '&lt;/param', '&lt;/pre', '&lt;/q', '&lt;/s', '&lt;/samp', '&lt;/script', '&lt;/select', '&lt;/small', '&lt;/span', '&lt;/strike', '&lt;/strong', '&lt;/style', '&lt;/sub', '&lt;/sup',
	                        '&lt;/table', '&lt;/tbody', '&lt;/td', '&lt;/textarea', '&lt;/tfoot', '&lt;/th', '&lt;/thead', '&lt;/title', '&lt;/tr', '&lt;/tt', '&lt;/u', '&lt;/ul', '&lt;/var'
	            ),
	            array ("<FONT COLOR='#FF6600'><B>*</B></FONT>", "<FONT COLOR='#00AA00'><B>SELECT</B> </FONT>", "<FONT COLOR='#00AA00'><B>UPDATE</B> </FONT>",
	                        "<FONT COLOR='#00AA00'><B>DELETE</B> </FONT>", "<FONT COLOR='#00AA00'><B>INSERT</B> </FONT>", "<FONT COLOR='#00AA00'><B>INTO</B></FONT>", "<FONT COLOR='#00AA00'><B>VALUES</B></FONT>",
	                        "<FONT COLOR='#00AA00'><B>FROM</B></FONT>", "<FONT COLOR='#00CC00'><B>LEFT</B></FONT>", "<FONT COLOR='#00CC00'><B>JOIN</B></FONT>", "<FONT COLOR='#00AA00'><B>WHERE</B></FONT>",
	                        "<FONT COLOR='#AA0000'><B>LIMIT</B></FONT>", "<FONT COLOR='#00AA00'><B>ORDER BY</B></FONT>", "<FONT COLOR='#0000AA'><B>AND</B></FONT>", "<FONT COLOR='#0000AA'><B>OR </B> </FONT>",
	                        "<FONT COLOR='#0000AA'><B>DESC</B></FONT>", "<FONT COLOR='#0000AA'><B>ASC</B></FONT>", "<FONT COLOR='#00DD00'><B>ON </B> </FONT>", "<FONT COLOR='#00DD00'><B>UNION</B> </FONT>",
	                        '<FONT COLOR="#FF6600"><B>&lt;!--</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;!DOCTYPE</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;a href=</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;abbr</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;acronym</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;address</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;applet</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;area</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;b</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;base</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;basefont</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;bdo</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;big</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;blockquote</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;body</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;br</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;button</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;caption</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;center</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;cite</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;code</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;col</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;colgroup</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;dd</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;del</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;dfn</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;dir</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;div</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;dl</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;dt</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;em</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;fieldset</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;font</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;form</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;frame</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;frameset</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;head</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;h1</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;h2</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;h3</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;h4</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;h5</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;h6</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;hr</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;html</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;i</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;iframe</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;img</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;input</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;ins</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;kbd</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;label</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;legend</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;li</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;link</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;map</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;menu</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;meta</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;noframes</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;noscript</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;object</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;ol</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;optgroup</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;option</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;p</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;param</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;pre</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;q</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;s</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;samp</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;script</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;select</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;small</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;span</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;strike</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;strong</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;style</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;sub</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;sup</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;table</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;tbody</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;td</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;textarea</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;tfoot</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;th</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;thead</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;title</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;tr</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;tt</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;u</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;ul</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;var</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;/a href=</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/abbr</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/acronym</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/address</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/applet</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/area</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/b</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/base</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/basefont</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/bdo</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;/big</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/blockquote</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/body</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/br</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/button</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/caption</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/center</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/cite</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/code</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/col</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/colgroup</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/dd</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;/del</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/dfn</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/dir</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/div</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/dl</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/dt</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/em</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/fieldset</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/font</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/form</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/frame</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/frameset</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/head</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;/h1</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/h2</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/h3</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/h4</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/h5</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/h6</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/hr</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/html</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/i</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/iframe</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/img</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/input</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/ins</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/kbd</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/label</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;/legend</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/li</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/link</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/map</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/menu</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/meta</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/noframes</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/noscript</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/object</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/ol</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/optgroup</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/option</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;/p</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/param</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/pre</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/q</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/s</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/samp</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/script</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/select</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/small</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/span</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/strike</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/strong</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/style</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;/sub</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/sup</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/table</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/tbody</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/td</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/textarea</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/tfoot</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/th</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/thead</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/title</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/tr</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/tt</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/u</B></FONT>', '<FONT COLOR="#FF6600"><B>&lt;/ul</B></FONT>',
	                        '<FONT COLOR="#FF6600"><B>&lt;/var</B></FONT>'
	            ), $query);
	            return "<FONT COLOR='#000000'>".$query."</FONT>\n";
	        }
	    }
	    private function sl_page_selector($start, $length, $total){
	        $pages = floor($total/$length)+1;
	        if($pages > 1){
	            $current = floor($start/$length)+1;
	            $string = '<select onchange="sl_gateway.open(\'attacklog\',\'&id=\'+this.value);">'."\n";
	            for($x=1;$x<=$pages;$x++){
	                $string .= '<option value="'.$length*($x-1).'" '.($x==$current ? 'selected' : '').'>Page '.$x.'</option>'."\n";
	            }
	            $string .= '</select>'."\n";
	            return $string;
	        }
	    }
	    public function highlight_code($terms,$string){
    		$pieces = array();
			$haystack_decoded = strtolower(urldecode($string));
			foreach($terms as $term){
				//if array is empty, scan string and make array
				if(count($pieces)==0){
					//use explode to split into ??? parts
					$temp = explode($term,$haystack_decoded);
					//loop and insert term in between
					for($i=0;$i<count($temp);$i++){
						array_push($pieces, array('clean', $temp[$i]));
						if($i<count($temp)-1){
							array_push($pieces, array('dirty', $term));
						}
					}
				} else {
					//$pieces is now array like [clean, str],[dirty,term],[clean,str],[dirty,term],[clean,str]
					// array_splice() can replace clean arrays with another array of clean dirty clean
					$complete = false;
					$i = 0;
					while(!$complete){
						$start_count = count($pieces);

						$status = $pieces[$i][0];
						$string = $pieces[$i][1];
						if($status!='dirty' && substr_count($string,$term)){
							array_splice($pieces,$i,1,$this->ret_arr_of_pieces_arr($pieces[$i], $term));
						}

						$final_count = count($pieces);
						$i = $i + 1 + ($final_count - $start_count);
						if($i==$final_count){
							$complete = true;
						}
					}
				}
			}
			//before imploding, apply html entities and add bold tags
			$completed_string = '';
			foreach($pieces as $piece){
				$status = $piece[0];
				$string = $piece[1];
				if($status=='clean'){
					$completed_string .= htmlentities($string);
				} else {
					if(is_array($string)){
						var_dump($string);die();
					}
					$completed_string .= '<b style="background-color:#ff0;">'.htmlentities($string).'</b>';
				}
			}
			return $completed_string;
		}
		public function ret_arr_of_pieces_arr($piece_arr, $term2){
			$string = $piece_arr[1];
			$ret_arr = array();
			//use explode to split into ??? parts
			$temp = explode($term2,$string);
			//loop and insert term in between
			for($x=0;$x<count($temp);$x++){
				array_push($ret_arr, array('clean', $temp[$x]));
				if($x<count($temp)-1){
					array_push($ret_arr, array('dirty', $term2));
				}
			}
			return $ret_arr;
		}
	    public function is_ajax_req(){
			$page = isset($_POST['sl_page']) ? $_POST['sl_page'] : null;
			return ($page=='ajax');
		}
		public function getVersionMessage(){
			$ver_msg = '';
	        $ver_html = $this->sl_post_request('current_version.inc', 'file');
	        $cur_sl_engine_ver = trim($ver_html[0]);
	        $cur_sl_admin_ver = trim($ver_html[1]);
	        
	        
	        if(version_compare($this->sl_engine_ver,$cur_sl_engine_ver,'<') || version_compare($this->sl_admin_ver,$cur_sl_admin_ver,'<')){
	        	$dir = str_replace('\\','/',dirname(__FILE__));
	        	#try directories
	        	if(substr_count($dir,'/administrator')){
					$ver_msg .= ' Currently Outdated <a href="http://www.securelivesw.com/downloads/joomla_securelive_package.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Update Available</span></a>';
	        	} elseif(substr_count($dir,'/wp-admin')){
					$ver_msg .= ' Currently Outdated <a href="http://www.securelivesw.com/downloads/securepress-plugin.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Update Available</span></a>';
	        	} elseif(substr_count($dir,'/sl_admin')){
	            	#auto update link
	            	$ver_msg .= ' Currently Outdated: <a href="javascript:void(0)" onclick="sl_confirm_update();return false;"><span style="color: #ff0000; font-weight: bold;">Auto-Update</span></a>';
	            	#core update & complete links
	            	if(version_compare($this->sl_engine_ver,$cur_sl_engine_ver,'<')){
						$ver_msg .= '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Download Core Files: <a href="http://www.securelivesw.com/downloads/securelive_max'.$this->sl_engine_ver.'-'.$cur_sl_engine_ver.'.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Update</span></a>, <a href="http://www.securelivesw.com/downloads/securelive_max.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Complete</span></a>';
	            	}
	            	#admin update & complete links
	            	if(version_compare($this->sl_admin_ver,$cur_sl_admin_ver,'<')){
						$ver_msg .= '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Download Admin Files: <a href="http://www.securelivesw.com/downloads/sl_admin'.$this->sl_admin_ver.'-'.$cur_sl_admin_ver.'.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Update</span></a>, <a href="http://www.securelivesw.com/downloads/sl_admin.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Complete</span></a>';
	            	}
	        	} else {
	        		#try account types
					if(substr_count($this->account->acct_type,'sj')){
		                $ver_msg .= ' Currently Outdated <a href="http://www.securelivesw.com/downloads/joomla_securelive_package.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Update Available</span></a>';
		            } elseif(substr_count($this->account->acct_type,'wp')){
		                $ver_msg .= ' Currently Outdated <a href="http://www.securelivesw.com/downloads/securepress-plugin.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Update Available</span></a>';
		            } elseif(substr_count($this->account->acct_type,'e107')){
		                $ver_msg .= ' Currently Outdated <a href="http://www.securelivesw.com/downloads/secure_e107_package.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Update Available</span></a>';
		            } elseif(substr_count($this->account->acct_type,'slm')){
		                $ver_msg .= ' Currently Outdated <a href="http://www.securelivesw.com/downloads/sl_admin.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Update Available</span></a>';
		            } elseif(substr_count($this->account->acct_type,'sd')){
		                $ver_msg .= ' Currently Outdated <a href="http://www.securelivesw.com/downloads/secureDrupal.zip" target="_blank"><span style="color: #ff0000; font-weight: bold;">Update Available</span></a>';
		            }
	        	}
	        } else {
	            $ver_msg = ' <span style="color: #0F9800; font-weight: bold;">Current</span>';
	        }
			$this->versionMessage = $ver_msg;
			return $ver_msg;
		}
		private function bad_permissions($file){
			$fileperms = substr(decoct(fileperms($file)),3);
			$lastNum = intval(substr($fileperms,-1,1));
	        if($lastNum==2 || $lastNum==3 || $lastNum==6 || $lastNum==7){
				return true;
	        } else {
				return false;
	        }
		}
		private function is_valid_help($key){
			$decoded = '';
			$key_arr = array('wOadW','rAeTf','Lklnq','tICgP','uGMHQ','jboUy','chJVF','mixNp','DEXRv','zSsKB');
			for($i=0;$i<strlen($key);$i++){
				$char = substr($key,$i,1);
				for($x=0;$x<10;$x++){
					if(substr_count($key_arr[$x],$char)){
						$decoded .= $x;
						continue;
					}
				}
			}
			$dayTime = 60*60*24;
			$keyTime = intval($decoded);
			$time = time();
			return ($time-$keyTime < $dayTime && $time-$keyTime > ($dayTime*-1));
	    }
	    private function memo_header($page, $domain=null, $newback=null){
    		$inbox = '<a href="javascript:void(0)" onclick="memos.get(\'inbox\');return false;"><img src="'.$this->sl_get_path().'/images/inboxM.png" '.($page=='inbox' ? 'style="opacity:0.4;filter:alpha(opacity=40)" ' : '').'border="0" title="Inbox" alt="Inbox" width="20" height="20" />Inbox</a>';
			$outbox = '<a href="javascript:void(0)" onclick="memos.get(\'outbox\');return false;"><img src="'.$this->sl_get_path().'/images/outboxM.png" '.($page=='outbox' ? 'style="opacity:0.4;filter:alpha(opacity=40)" ' : '').'border="0" title="Outbox" alt="Outbox" width="20" height="20" />Outbox</a>';
			$trash = '<a href="javascript:void(0)" onclick="memos.get(\'trash\');return false;"><img src="'.$this->sl_get_path().'/images/trashM.png" '.($page=='trash' ? 'style="opacity:0.4;filter:alpha(opacity=40)" ' : '').'border="0" title="Trash" alt="Trash" width="20" height="20" />Trash</a>';
			$new = '<a href="javascript:void(0)" onclick="memos.new_memo(\''.$domain.'\',null,null,null,\''.addcslashes($newback,"'").'\');return false;"><img src="'.$this->sl_get_path().'/images/newM.png" '.($page=='new' ? 'style="opacity:0.4;filter:alpha(opacity=40)" ' : '').'border="0" title="New Message" alt="New Message" width="20" height="20" />New</a>';
			$restore = '<a href="javascript:void(0)" onclick="memos.restore_selected(\''.$page.'\');return false;"><img id="restore_selected_memos_img" src="'.$this->sl_get_path().'/images/restoreM.png" border="0" title="Restore Selected" alt="Restore Selected" width="20" height="20" />Restore</a>';
			$remove = '<a href="javascript:void(0)" onclick="memos.remove_selected(\''.$page.'\');return false;"><img src="'.$this->sl_get_path().'/images/removeM.png" '.($page=='new' || $page=='trash' ? 'style="opacity:0.4;filter:alpha(opacity=40)" ' : '').'border="0" title="Remove Selected" alt="Remove Selected" width="20" height="20" />Delete</a>';

    		//$showdomain = $page=='thread' ? "<a href='http://$domain' target='_blank' style='position:absolute;right:190px;font-size:14px;'><b>$domain</b></a>" : '';
			$showdomain = '';
			$str = "<div id=\"please_wait\" style=\"display:inline;float:left;\"></div>$inbox $outbox $trash $new $remove $restore $showdomain <br/><br/>";
			$str = str_replace("\n",'',$str);
			$str = addcslashes($str,"'");
			$str = '<script type="text/javascript">memos.add_menu(\''.$str.'\', 0, true, null, true);</script>';
			return $str;
	    }
	    private function get_domain_thread($arr, $client=false){
    		//need to return the most recent memo details and total count of unread, locked, and read
    		$unread = 0;
    		$locked = 0;
    		$read = 0;
    		$most_recent_time = 0;
    		$most_recent_i = 0;
    		for($i=0;$i<count($arr);$i++){
    			$memo = $arr[$i];
				$domain = $memo['txt_domain'];
				$id = $memo['int_id'];
				$subject = empty($memo['txt_subject']) ? 'No Subject' : stripcslashes(stripcslashes($memo['txt_subject']));
				$message = stripcslashes(stripcslashes($memo['txt_message']));
				$urgency = $memo['int_level'];
				$c_stat = $memo['int_cstatus'];
				$a_stat = $memo['int_astatus'];
				$time = get_memo_time($memo['txt_date'],$memo['txt_time']);
				$reply_of = $memo['int_replyid'];
				$from = $memo['txt_from'];
				if($time > $most_recent_time){
					$most_recent_time = $time;
					$ret_arr = array('id'=>$id,'domain'=>$domain,'subject'=>$subject,'message'=>$message,'urgency'=>$urgency,'time'=>$time,'a_stat'=>$a_stat);
				}
				if($client){
					$unread = $c_stat==0 ? $unread+1 : $unread;
    				$locked = $c_stat==2 ? $locked+1 : $locked;
    				$read = $c_stat==1 ? $read+1 : $read;
				} else {
					$unread = $a_stat==0 ? $unread+1 : $unread;
    				$locked = $a_stat==2 ? $locked+1 : $locked;
    				$read = $a_stat==1 ? $read+1 : $read;
				}
    		}
    		$ret_arr['unread'] = $unread;
    		$ret_arr['locked'] = $locked;
    		$ret_arr['read'] = $read;
    		//get details of $arr[$most_recent_i]
    		//$results[] = array(domain, subject, message, urgency, time, $a_stat, unread, locked, read)
    		//if($unread==0 && $domain=='drinkedin.net'){die("$unread unread from $domain");}
    		return $ret_arr;
	    }
	    private function message_toolbar($domain, $subject, $id, $urgency, $threadback, $outbox=false){
	    	if($outbox){
				return '<div style="text-align:right;"><a href="javascript:void(0)" onclick="memos.forward('.$id.');return false;"><img src="'.$this->sl_get_path().'/images/mail_forward.png" border="0" title="Forward" alt="Forward" style="margin-top: 5px;" /></a><a href="javascript:memos.send(\'lock\','.$id.')"><img src="'.$this->sl_get_path().'/images/lock2.png" border="0" title="Lock" alt="Lock" style="margin-top: 5px;" /></a></div>';
	    	} else {
				return '<div style="text-align:right;"><a href="javascript:void(0)" onclick="memos.new_memo(\''.$domain.'\',\''.addcslashes($subject,"'").'\','.$id.','.$urgency.',\''.addcslashes($threadback,"'").'\');return false;"><img src="'.$this->sl_get_path().'/images/mail_into.png" border="0" title="Reply" alt="Reply" style="margin-top: 5px;" /></a><a href="javascript:void(0)" onclick="memos.forward('.$id.');return false;"><img src="'.$this->sl_get_path().'/images/mail_forward.png" border="0" title="Forward" alt="Forward" style="margin-top: 5px;" /></a><a href="javascript:void(0)" onclick="memos.send(\'lock\','.$id.');return false;"><img src="'.$this->sl_get_path().'/images/lock2.png" border="0" title="Lock" alt="Lock" style="margin-top: 5px;" /></a></div>';
	    	}
	    }
	    private function num_per_page(){
			$cookie = isset($_COOKIE['sl_memo_num']) ? intval($_COOKIE['sl_memo_num']) : 10;
    		$select = '<select onchange="accounts.set_cookie(\'sl_memo_num\',this.value)" style="height:16px;font-size:9px;">
    					<option value="5" '.($cookie==5?'selected':'').'>5</option>
    					<option value="10" '.($cookie==10?'selected':'').'>10</option>
    					<option value="15" '.($cookie==15?'selected':'').'>15</option>
    					<option value="20" '.($cookie==20?'selected':'').'>20</option>
    					<option value="25" '.($cookie==25?'selected':'').'>25</option>
    					</select>';
    		return $select;
	    }
	    public function is_joomla(){
			if(!defined('DS')){define( 'DS', DIRECTORY_SEPARATOR );}
			if(!defined('JPATH_BASE')){define('JPATH_BASE', $_SERVER['DOCUMENT_ROOT']);}
            $jFile1 = JPATH_BASE .DS.'includes'.DS.'defines.php';
			$jFile2 = JPATH_BASE .DS.'includes'.DS.'framework.php';
			
            $is_securejoomla = substr_count($this->account->acct_type,'sj');#not relevant?
            $j_framework_exists = (file_exists($jFile1) && file_exists($jFile2));
            $is_administrator = substr_count($this->uri,'/administrator/');
            return ((defined('_JEXEC') && $is_administrator) || ($j_framework_exists && $is_administrator));
	    }
	    public function is_WordPress(){
	    	if(!defined('DS')){define( 'DS', DIRECTORY_SEPARATOR );}
	    	
			if(!defined('WP_PATH_BASE')){
				$pos = strpos(__file__,"wp-content/");
				if($pos === false)
					define('WP_PATH_BASE', $_SERVER['DOCUMENT_ROOT']);
				else
					define('WP_PATH_BASE', $addon = substr(__file__, 0, $pos).DS);
			}

            $wpFile1 = WP_PATH_BASE.DS.'wp-includes'.DS.'wp-db.php';
			$wpFile2 = WP_PATH_BASE.DS.'wp-includes'.DS.'wp-diff.php';

            $is_securepress = (bool)substr_count($this->account->acct_type,'wp');#not relevant?
            $wp_framework_exists = (file_exists($wpFile1) && file_exists($wpFile2));
            $is_wp_dir = substr_count($_SERVER['REQUEST_URI'],'/wp-admin');
            
            return ($wp_framework_exists && $is_wp_dir) || ($is_securepress && $is_wp_dir);
		}
	    private function get_secret(){
	    	if($this->config_exists()){
				include($this->config_fp);
				if(isset($secret) && !empty($secret)){
					return md5($secret);
				} else {
					#try to recreate it
					@unlink($this->config_fp);
					if($this->config_exists()){
						include($this->config_fp);
						return (isset($secret) && !empty($secret)) ? md5($secret) : '09b062a3c602cd82279ad520723af6c3';
					} else {
						return null;
					}
				}
	    	} else {
				return null;
	    	}
	    }
	    private function put_auth($password){
			$docRoot = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
			$acctHome = substr($docRoot,0,strrpos($docRoot,'/'));
			if(@file_exists("$acctHome/securelive_max") && @is_writable("$acctHome/securelive_max")){
				$file = "$acctHome/securelive_max/sl_auth.php";
			}
			elseif(@is_writable(dirname(__FILE__))){
				$file = str_replace('\\','/',dirname(__FILE__))."/sl_auth.php";
			}
			if(isset($file)){
				$fp = fopen($file,'w+');
				fwrite($fp,"<?php /*\n");
				fwrite($fp,md5($password)."\n");
				fwrite($fp,"*/ ?>");
				fclose($fp);
			}
			
			return @file_exists($file);
	    }
	    //ajax functions (tickets)
	    public function ajax_response($w=false){
	    	if(!isset($_COOKIE['sl_ajax_auth']) || $this->get_secret()===null || $_COOKIE['sl_ajax_auth']!=$this->get_secret()){
				return 'Unauthorized Request';
	    	}

			$str = '';
			$what = isset($_POST['what']) ? $_POST['what'] : null;
			$what = $w ? $w : $what;

			if($what == 'dir_tree'){
		        $where = isset($_POST['where']) ? $_POST['where'] : null;
		        $show_arr = array();
		        $thisdir = scandir($where);
		        foreach($thisdir as $item){
		            if(is_dir($where.'/'.$item) && $item!='.' && $item!='..'){
		                array_push($show_arr, $where.'/'.$item);
		            }
		        }
		        $str .= implode("|",$show_arr);
		    }
		    elseif($what == 'new_dir_tree'){
		    	$helperFile = dirname(__FILE__).'/inc/sl_scan_helper.php';
		        $helperFile = str_replace('\\','/',$helperFile);

		        $contents = file_get_contents($helperFile);
				$term = "lastscan = '";
				$start = strpos($contents,$term)+strlen($term);
				$length = strpos($contents,"'",$start) - $start;
				$lastscan = substr($contents,$start,$length);
				$term = "rootdir = '";
				$start = strpos($contents,$term)+strlen($term);
				$length = strpos($contents,"'",$start) - $start;
				$root = substr($contents,$start,$length);
				$term = "exclude = '";
				$start = strpos($contents,$term)+strlen($term);
				$length = strpos($contents,"'",$start) - $start;
				$exclude = substr($contents,$start,$length);
				$ok = 'ok';

				$root = isset($_POST['where']) ? $_POST['where'] : $_SERVER['DOCUMENT_ROOT'];

				$rootContents = array();
			    $thisdir = @scandir($root);
			    if(!$thisdir){
					$root = $_SERVER['DOCUMENT_ROOT'];
			    }
			    $thisdir = @scandir($root);
			    foreach($thisdir as $item){
			        if(is_dir($root.'/'.$item) && $item!='.' && $item!='..'){
			            array_push($rootContents, $root.'/'.$item);
			        }
			    }

				$str .= 'showMenu("'.$ok.'", "'.$lastscan.'", "'.$root.'", "'.implode("|",$rootContents).'", "'.$exclude.'")';
		    }
		    elseif($what == 'initMalScan'){
				$root = isset($_POST['root']) ? $_POST['root'] : null;
				//get list of terms

				$arr = array('act'=>'get_mal_scan','host'=>$this->host);
				$response = $this->sl_post_request('remote4.php',http_build_query($arr,'','&'));
				$response = implode("|",$response);
				$response = explode('#sl#',$response);
				if($response[0]=='true'){
					array_shift($response);
					$terms = $response;
				} else {
					$terms = array();
				}

				if(!is_dir($root)){
					$root = $_SERVER['DOCUMENT_ROOT'];
				}
				//get dirs and files in root
				$dirs = array();
				$files = array();
		        $thisdir = scandir($root);
		        foreach($thisdir as $item){
		            if(is_dir($root.'/'.$item) && $item!='.' && $item!='..'){
		                array_push($dirs, $root.'/'.$item);
		            }
		            elseif(is_file($root.'/'.$item) && $item!='.' && $item!='..'){
		                array_push($files, $root.'/'.$item);
		            }
		        }
		        $str .= implode("|",$dirs).'#sl#'.implode("|",$files).'#sl#'.implode('#sl#',$terms);
		    }
		    elseif($what == 'tutorial'){
				$which = isset($_POST['which']) ? $_POST['which'] : null;
				if($which=='on'){
					$val = substr_count($this->account->tutorial,'~u') ? '1~u' : '1~n';
				} elseif($which=='off'){
					$val = substr_count($this->account->tutorial,'~u') ? '0~u' : '0~n';
				} else {
					$val = null;
				}
				if($val){
					$arr = array('act'=>'tutorial','host'=>$this->host,'val'=>$val);
					$response = $this->sl_post_request('remote4.php',http_build_query($arr,'','&'));
					if($response[0]=='true'){
						$str .= 'Your settings have been updated.';
					} else {
						$str .= $response[0];
					}
				} else {
					$str .= 'Invalid Request';
				}
		    }
		    elseif($what == 'sl_cal'){
		        $where = isset($_POST['where']) ? $_POST['where'] : null;
		        if($where && substr_count($where,'~')){
		            $temp = explode('~',$where);
		            $month = intval($temp[0]);
		            $year = intval($temp[1]);

		            $days = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		            $days[1] += (date("L",mktime(0,0,0,1,1,$year))?1:0);
		            $numDays = $days[$month];

		            $start = mktime(0,0,0,($month+1),1,$year);
		            $end = mktime(23,59,59,($month+1),$numDays,$year);

		            $arr = array('act'=>'get_attacks','what'=>'calendar','where'=>"$start~$end",'host'=>$this->host);
		            $retData = $this->sl_post_request('remote4.php',http_build_query($arr,'','&'));
		            $str .= implode("|", $retData);
		        }
		    }
		    elseif($what == 'edit_bypass'){
		    	$data = isset($_POST['sl_dir_arr']) ? $_POST['sl_dir_arr'] : array();
				$data = array_filter($data);
		    	# new dir bypass save

				$dir_array = array();
		    	$dir_string = '$this->dir_bypass_arr = array(';
		    	for($i=0;$i<count($data);$i++){
					$ok = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_^|/.+~- @&=';
					$item = trim(urldecode($data[$i]));
					if($item=='No Directory Bypasses Created'){continue;}
					$clean = '';
					for($j=0;$j<strlen($item);$j++){
						$char = substr($item,$j,1);
						if(substr_count($ok,$char)){
							$clean .= $char;
						}
					}
					//parse $clean and add to string
					if(!empty($clean)){
						$dir_array[] = "'$clean'";
					}
				}
				if(count($dir_array)){
					$dir_string .= implode(',',$dir_array);
				}
		    	$dir_string .= ");";




				$data = isset($_POST['sl_bp_arr']) ? $_POST['sl_bp_arr'] : array();
				$data = array_filter($data);


				$put_string = "\n".'$this->bypass_arr = array(';
				//make the new php array string
				for($i=0;$i<count($data);$i++){
					$ok = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_^|/.+~- @&=';
					$item = trim($data[$i]);
					$clean = '';
					for($j=0;$j<strlen($item);$j++){
						$char = substr($item,$j,1);
						if(substr_count($ok,$char)){
							$clean .= $char;
						}
					}
					//parse $clean and add to string
					if(substr_count($clean,'|')){
						//loop - //array('var'=>array('variable1','variable2'),'val'=>array('value1','value2'))
						$temp = explode('|',$clean);

						//array('variable1','variable2')
						$var_str = "array(";
						$val_str = "array(";
						for($j=0;$j<count($temp);$j++){
							$var = reset(explode('^',$temp[$j]));
							$val = end(explode('^',$temp[$j]));
							$var_str .= "'$var'";
							$val_str .= "'$val'";
							if($j<count($temp)-1){
								$var_str .= ",";
								$val_str .= ",";
							}
						}
						$var_str .= ")";
						$val_str .= ")";
						$put_string .= "\narray('var'=>$var_str,'val'=>$val_str)";
					} else {
						//single - //array('var'=>'bypass','val'=>'true')
						$var = reset(explode('^',$clean));
						$val = end(explode('^',$clean));
						$put_string .= "\narray('var'=>'$var','val'=>'$val')";
					}
					//add comma
					if($i<count($data)-1){
						$put_string .= ',';
					}
				}
				$put_string .= "\n);";




				#use file() to replace all values
				$contents = file_get_contents($this->config_fp);#for a simple check
				$this->config_exists();
				$lines = file($this->config_fp);
				$lines = array_filter($lines);
				foreach($lines as $key=>$val){
					$lines[$key] = trim($val);
				}

				#splice bypass array
				for($i=0;$i<count($lines);$i++){
					$line = $lines[$i];
					if(substr_count($line,'//start_bypass_arr')){
						$start = $i+1;
					}
					if(substr_count($line,'//end_bypass_arr')){
						$end = $i;
						break;
					}
				}

				$replace = explode("\n",$put_string);
				$replace = array_filter($replace);

				array_splice($lines,$start,($end-$start),$replace);

				#insert or splice dir array
				if(substr_count($contents,'//start_dir_bypass_arr') && substr_count($contents,'//end_dir_bypass_arr')){

					for($i=0;$i<count($lines);$i++){
						$line = $lines[$i];
						if(substr_count($line,'//start_dir_bypass_arr')){
							$start = $i+1;
						}
						if(substr_count($line,'//end_dir_bypass_arr')){
							$end = $i;
							break;
						}
					}

					$replace = explode("\n",$put_string);
					$replace = array_filter($replace);
					array_splice($lines,$start,($end-$start),$replace);
				} else {
					$replace = explode("\n",$dir_string);
					$replace = array_filter($replace);
					array_splice($lines,(count($lines)-1),0,$replace);
				}
				$contents = implode("\n",$lines);

				$check = file_put_contents($this->config_fp,$contents);

				if($check){
					$str .= '1';
				} else {
					$str .= '0';
				}
		    }
		    //for tickets
			elseif($what=='inbox'){
				$offset = isset($_POST['offset']) ? $_POST['offset'] : null;
		        $num = isset($_POST['num']) ? $_POST['num'] : null;
		        $offset = $offset ? $offset : 0;
		        $num = $num ? $num : (isset($_COOKIE['sl_memo_num']) ? intval($_COOKIE['sl_memo_num']) : 10);
				// get list of all admin sent tickets that are not trashed
				$ret = $this->sl_post_request('remote4.php','act=get_inbox&host='.$this->host);
				//remove "true"
				array_shift($ret);
				//put tickets into appropriate array
				$unread_arr = array();
		        $locked_arr = array();
		        $read_arr = array();
				for($i=0;$i<count($ret);$i+=6){
					// id, subject, message, urgency, time, c_stat
					$id = intval($ret[$i]);
					$subject = empty($ret[$i+1]) ? 'No Subject' : stripcslashes(stripcslashes($ret[$i+1]));
					$message = stripcslashes(stripcslashes($ret[$i+2]));
					$urgency = intval($ret[$i+3]);
					$time = intval($ret[$i+4]);
					$c_stat = intval($ret[$i+5]);

					$arr = array('id'=>$id,'subject'=>$subject,'message'=>$message,'urgency'=>$urgency,'time'=>$time,'c_stat'=>$c_stat);

					if($c_stat == 0){
						//put in unread
						array_push($unread_arr, $arr);
			        } elseif($c_stat == 2){
						//put in locked
						array_push($locked_arr, $arr);
			        } else {
						//put in read
						array_push($read_arr, $arr);
			        }
				}


				//SORT THE ARRAYS BY URGENCY THEN TIME
		        $urgency_arr = array(); $time_arr = array();
				foreach ($unread_arr as $key => $row) {
				    $urgency_arr[$key] = $row['urgency'];
				    $time_arr[$key] = $row['time'];
				}
				@array_multisort($urgency_arr, SORT_DESC, $time_arr, SORT_DESC, $unread_arr);
		        //sort $locked_arr by urgency then time
		        $urgency_arr = array(); $time_arr = array();
		        foreach ($locked_arr as $key => $row) {
				    $urgency_arr[$key] = $row['urgency'];
				    $time_arr[$key] = $row['time'];
				}
				@array_multisort($urgency_arr, SORT_DESC, $time_arr, SORT_DESC, $locked_arr);
		        //sort $read_arr by urgency then time
		        $urgency_arr = array(); $time_arr = array();
		        foreach ($read_arr as $key => $row) {
				    $urgency_arr[$key] = $row['urgency'];
				    $time_arr[$key] = $row['time'];
				}
				@array_multisort($urgency_arr, SORT_DESC, $time_arr, SORT_DESC, $read_arr);
				//remove blank pages
				$total = count($unread_arr) + count($locked_arr) + count($read_arr);
				$offset = $offset>=$total && $offset-$num>=0 ? $offset-$num : $offset;


				// DISPLAY
				$table = $this->memo_header('inbox',null,"get(\'inbox\',\'offset~$offset^num~$num\')").'<table cellspacing="0px" cellpadding="2px" width="100%" border="0">
							<tr>
								<td>#</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>Subject</td>
								<td>Preview</td>
								<td>Date</td>
							</tr>';
		        //display $unread_arr
		        //display $locked_arr
		        //display $read_arr
		        $arrays = array($unread_arr, $locked_arr, $read_arr);
		        $count = 0;
		        $real_count = 1;
		        foreach($arrays as $array){
			        foreach($array as $thread){
        				if($real_count-1 >= $offset && $count < $num){
        					$id = $thread['id'];
        					$domain = $this->account->domain;
							$subject = $thread['subject'];
							$message = $thread['message'];
							$urgency = $thread['urgency'];
							$time = $thread['time'];
							$c_stat = $thread['c_stat'];

							$date = '<span style="font-size:10px;">'.date("n/j/y g:i a",$time).'</span>';
							$class = $urgency==1 ? 'urgency_normal' : ($urgency==2 ? 'urgency_high' : ($urgency==3 ? 'urgency_critical' : ''));
							if($c_stat == 0){
								$icon = 'email.png';
								$bolded_domain = "<b>".$this->nicetrim($subject, 40)."</b>";
								$bolded_subject = "<b>".htmlentities($this->nicetrim($message, 60))."</b>";
								$bolded_date = "<b>$date</b>";
					        } elseif($c_stat == 2){
								$icon = 'lock.png';
								$bolded_domain = $this->nicetrim($subject, 40);
								$bolded_subject = htmlentities($this->nicetrim($message, 60));
								$bolded_date = $date;
					        } else {
								$icon = 'email_open.png';
								$bolded_domain = $this->nicetrim($subject, 40);
								$bolded_subject = htmlentities($this->nicetrim($message, 60));
								$bolded_date = $date;
					        }
							//$onclick = "memos.get('thread', 'domain~$domain^from~inbox', 'get(\'inbox\',\'offset~$offset^num~$num\')');";
							$onclick = "memos.toggle('show_message_$count');";
							$toggle = "memos.send('toggle',$id)";
							$table .= "<tr class=\"$class\">
										<td width=\"10px\">$real_count</td>
										<td width=\"25px\" align=\"center\"><input id=\"remove_$count\" value=\"$id\" type=\"checkbox\" /></td>
										<td width=\"40px\" align=\"center\"><a href=\"javascript:void(0)\" onclick=\"$toggle;return false;\"><img src=\"".$this->sl_get_path()."/images/$icon\" border=\"0\" title=\"Click to mark as read / unread\" alt=\"Click to mark as read / unread\" /></a></td>
										<td width=\"25%\" onclick=\"$onclick\" style='cursor:pointer;'>$bolded_domain</td>
										<td width=\"35%\" onclick=\"$onclick\" style='cursor:pointer;'><acronym title='".$subject."'>".$bolded_subject."</acronym></td>
										<td onclick=\"$onclick\" style='cursor:pointer;'>$bolded_date</td>
									</tr>
									<tr id=\"show_message_$count\" style=\"display:none;\">
										<td colspan=\"6\" style=\"position:relative;\">\n";
							$table .= "                                    <div>\n";
							$table .= "                                        <div id=\"maintop\">\n";
							$table .= "                                            <div class=\"maintopbox float-left width100 separator\" id=\"stage\">\n";
							$table .= "                                                <div class=\"module mod-rounded first\">\n";
							$table .= "                                                    <h3 class=\"header\">\n";
							$table .= "                                                        <span class=\"header-2\"><span class=\"header-3\">\n";
							$table .= "															<acronym title='".$subject."'>".$bolded_domain."</acronym>\n";
							$table .= "                                                            <span style=\"float:right;\">\n";
							$table .= "                                                                <span>\n";
							$table .= "                                                                    ".$this->message_toolbar($domain, $subject, $id, $urgency,'get(\'inbox\',\'offset~'.$offset.'^num~'.$num.'\')')."\n";
							$table .= "                                                                </span>\n";
							$table .= "                                                            </span>\n";
							$table .= "                                                        </span>\n";
							$table .= "                                                    </h3>\n";
							$table .= "                                                    <div class=\"box-t1\">\n";
							$table .= "                                                        <div class=\"box-t2\">\n";
							$table .= "                                                            <div class=\"box-t3\"></div>\n";
							$table .= "                                                        </div>\n";
							$table .= "                                                    </div>\n";
							$table .= "                                                    <div class=\"box-1\">\n";
							$table .= "                                                        <div class=\"box-2\">\n";
							$table .= "                                                            <div class=\"box-3 deepest with-header\" style=\"min-height: 35px;\">\n";
							$table .= "                                                                <span style=\"width: 80%; font-size: 12px;\">\n";
							$table .= "																		".str_replace("\n",'<br/>',htmlentities($message))."\n";
							$table .= "                                                                </span>\n";
							$table .= "                                                            </div>\n";
							$table .= "                                                        </div>\n";
							$table .= "                                                    </div>\n";
							$table .= "                                                    <div class=\"box-b1\">\n";
							$table .= "                                                        <div class=\"box-b2\">\n";
							$table .= "                                                            <div class=\"box-b3\"/></div>\n";
							$table .= "                                                        </div>\n";
							$table .= "                                                    </div>\n";
							$table .= "                                                </div>\n";
							$table .= "                                            </div>\n";
							$table .= "                                        </div>\n";
							$table .= "                                        </div>\n";
							$table .= "</td>
									</tr>";
							$count++;
						}
						$real_count++;
			        }
				}
		        $table .= '</table>
        					<input id="refresh_tickets" type="hidden" value="get(\'inbox\',\'offset~'.$offset.'^num~'.$num.'\')" />
        					<div style="position:absolute;bottom:0px;">'.$this->num_per_page().'</div><div style="position:absolute;bottom:0px;right:0px;width:auto;"><a href="javascript:void(0)" onclick="memos.get(\'inbox\', \'offset~'.($offset-$num>-1 ? $offset-$num : 0).'^num~'.$num.'\');return false;"><img src="'.$this->sl_get_path().'/images/prevM.png" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="memos.get(\'inbox\', \'offset~'.($offset+$num).'^num~'.$num.'\');return false;"><img src="'.$this->sl_get_path().'/images/nextM.png" border="0" /></a></div>';
		        $str = $table."<br/><br/>";

			}
			elseif($what=='outbox'){
				//show outbox, group by domain
		        //show client unread first, then client locked, then client read
		        $offset = isset($_POST['offset']) ? $_POST['offset'] : null;
		        $num = isset($_POST['num']) ? $_POST['num'] : null;
		        $offset = $offset ? $offset : 0;
		        $num = $num ? $num : (isset($_COOKIE['sl_memo_num']) ? intval($_COOKIE['sl_memo_num']) : 10);


		        $ret = $this->sl_post_request('remote4.php','act=get_outbox&host='.$this->host);
				//remove "true"
				array_shift($ret);
				//put tickets into appropriate array
				$unread_arr = array();
		        $locked_arr = array();
		        $read_arr = array();
				for($i=0;$i<count($ret);$i+=6){
					// id, subject, message, urgency, time, c_stat
					$id = intval($ret[$i]);
					$subject = empty($ret[$i+1]) ? 'No Subject' : stripcslashes(stripcslashes($ret[$i+1]));
					$message = stripcslashes(stripcslashes($ret[$i+2]));
					$urgency = intval($ret[$i+3]);
					$time = intval($ret[$i+4]);
					$a_stat = intval($ret[$i+5]);

					// id, subject, message, urgency, time, c_stat
					$id = intval($ret[$i]);
					$subject = empty($ret[$i+1]) ? 'No Subject' : stripcslashes(stripcslashes($ret[$i+1]));
					$message = stripcslashes(stripcslashes($ret[$i+2]));
					$urgency = intval($ret[$i+3]);
					$time = intval($ret[$i+4]);
					$a_stat = intval($ret[$i+5]);

					$arr = array('id'=>$id,'subject'=>$subject,'message'=>$message,'urgency'=>$urgency,'time'=>$time,'a_stat'=>$a_stat);

					if($a_stat == 0){
						//put in unread
						array_push($unread_arr, $arr);
			        } elseif($a_stat == 2){
						//put in locked
						array_push($locked_arr, $arr);
			        } else {
						//put in read
						array_push($read_arr, $arr);
			        }
				}

		        //sort $unread_arr by urgency then time
		        $urgency_arr = array(); $time_arr = array();
				foreach ($unread_arr as $key => $row) {
				    $urgency_arr[$key] = $row['urgency'];
				    $time_arr[$key] = $row['time'];
				}
				@array_multisort($urgency_arr, SORT_DESC, $time_arr, SORT_DESC, $unread_arr);
		        //sort $locked_arr by urgency then time
		        $urgency_arr = array(); $time_arr = array();
		        foreach ($locked_arr as $key => $row) {
				    $urgency_arr[$key] = $row['urgency'];
				    $time_arr[$key] = $row['time'];
				}
				@array_multisort($urgency_arr, SORT_DESC, $time_arr, SORT_DESC, $locked_arr);
		        //sort $read_arr by urgency then time
		        $urgency_arr = array(); $time_arr = array();
		        foreach ($read_arr as $key => $row) {
				    $urgency_arr[$key] = $row['urgency'];
				    $time_arr[$key] = $row['time'];
				}
				@array_multisort($urgency_arr, SORT_DESC, $time_arr, SORT_DESC, $read_arr);
				//remove blank pages
				$total = count($unread_arr) + count($locked_arr) + count($read_arr);
				$offset = $offset>=$total && $offset-$num>=0 ? $offset-$num : $offset;


				/////////DISPLAY
				$table = $this->memo_header('outbox', null,"get(\'outbox\',\'offset~$offset^num~$num\')").'<table cellspacing="0px" cellpadding="2px" width="100%" border="0">
							<tr>
								<td>#</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>Subject</td>
								<td>Preview</td>
								<td>Date</td>
							</tr>';
		        //display $unread_arr
		        //display $locked_arr
		        //display $read_arr
		        $arrays = array($unread_arr, $locked_arr, $read_arr);
		        $count = 0;
		        $real_count = 1;
		        foreach($arrays as $array){
			        foreach($array as $thread){
        				if($real_count-1 >= $offset && $count < $num){
        					$id = $thread['id'];
        					$domain = $this->account->domain;
                            $subject = $thread['subject'];
							$subject = strlen($subject) > 55 ? substr($subject,0,55).'...' : $subject;
							$message = $thread['message'];
							$urgency = $thread['urgency'];
							$time = $thread['time'];
							$a_stat = $thread['a_stat'];

							$date = '<span style="font-size:10px;">'.date("n/j/y g:i a",$time).'</span>';
							$class = $urgency==1 ? 'urgency_normal' : ($urgency==2 ? 'urgency_high' : ($urgency==3 ? 'urgency_critical' : 'error in ticket.php'));
                            if($a_stat == 0){
								$icon = 'email.png';
                                $bolded_domain = "<b>".$this->nicetrim($subject, 40)."</b>";
                                $bolded_subject = "<b>".htmlentities($this->nicetrim($message, 60))."</b>";
                                $bolded_date = "<b>$date</b>";
					        } elseif($a_stat == 2){
								$icon = 'lock.png';
                                $bolded_domain = $this->nicetrim($subject, 40);
                                $bolded_subject = htmlentities($this->nicetrim($message, 60));
                                $bolded_date = $date;
					        } else {
								$icon = 'email_open.png';
                                $bolded_domain = $this->nicetrim($subject, 40);
                                $bolded_subject = htmlentities($this->nicetrim($message, 60));
                                $bolded_date = $date;
					        }
							//$onclick = "memos.get('thread', 'domain~$domain^from~outbox', 'get(\'outbox\',\'offset~$offset^num~$num\')');";
							$onclick = "memos.toggle('show_message_$count');";
							$table .= "<tr class=\"$class\">
										<td width=\"10px\">$real_count</td>
										<td width=\"25px\" align=\"center\"><input id=\"remove_$count\" value=\"$id\" type=\"checkbox\" /></td>
										<td width=\"40px\" align=\"center\"><img src=\"".$this->sl_get_path()."/images/$icon\" border=\"0\" /></td>
										<td width=\"25%\" onclick=\"$onclick\" style='cursor:pointer;'>$bolded_domain</td>
										<td width=\"35%\" onclick=\"$onclick\" style='cursor:pointer;'><acronym title='".$subject."'>".$bolded_subject."</acronym></td>
										<td onclick=\"$onclick\" style='cursor:pointer;'>$bolded_date</td>
									</tr>
									<tr id=\"show_message_$count\" style=\"display:none;\">
										<td colspan=\"6\">\n";
							$table .= "                                    <div>\n";
							$table .= "                                        <div id=\"maintop\">\n";
							$table .= "                                            <div class=\"maintopbox float-left width100 separator\" id=\"stage\">\n";
							$table .= "                                                <div class=\"module mod-rounded first\">\n";
							$table .= "                                                    <h3 class=\"header\">\n";
							$table .= "                                                        <span class=\"header-2\"><span class=\"header-3\">\n";
							$table .= "															<acronym title='".$subject."'>".$bolded_domain."</acronym>\n";
							$table .= "                                                            <span style=\"float:right;\">\n";
							$table .= "                                                                <span>\n";
							$table .= "                                                                    ".$this->message_toolbar($domain, $subject, $id, $urgency,'get(\'outbox\',\'offset~'.$offset.'^num~'.$num.'\')',true)."\n";
							$table .= "                                                                </span>\n";
							$table .= "                                                            </span>\n";
							$table .= "                                                        </span>\n";
							$table .= "                                                    </h3>\n";
							$table .= "                                                    <div class=\"box-t1\">\n";
							$table .= "                                                        <div class=\"box-t2\">\n";
							$table .= "                                                            <div class=\"box-t3\"></div>\n";
							$table .= "                                                        </div>\n";
							$table .= "                                                    </div>\n";
							$table .= "                                                    <div class=\"box-1\">\n";
							$table .= "                                                        <div class=\"box-2\">\n";
							$table .= "                                                            <div class=\"box-3 deepest with-header\" style=\"min-height: 35px;\">\n";
							$table .= "                                                                <span style=\"width: 80%; font-size: 12px;\">\n";
							$table .= "																		".str_replace("\n",'<br/>',htmlentities($message))."\n";
							$table .= "                                                                </span>\n";
							$table .= "                                                            </div>\n";
							$table .= "                                                        </div>\n";
							$table .= "                                                    </div>\n";
							$table .= "                                                    <div class=\"box-b1\">\n";
							$table .= "                                                        <div class=\"box-b2\">\n";
							$table .= "                                                            <div class=\"box-b3\"/></div>\n";
							$table .= "                                                        </div>\n";
							$table .= "                                                    </div>\n";
							$table .= "                                                </div>\n";
							$table .= "                                            </div>\n";
							$table .= "                                        </div>\n";
							$table .= "                                        </div>\n";
							$table .= "</td>
									</tr>";
							$count++;
						}
						$real_count++;
			        }
				}
		        $table .= '</table>
        					<input id="refresh_tickets" type="hidden" value="get(\'outbox\',\'offset~'.$offset.'^num~'.$num.'\')" />
        					<div style="position:absolute;bottom:0px;">'.$this->num_per_page().'</div><div style="position:absolute;bottom:0px;right:0px;width:auto;"><a href="javascript:void(0)" onclick="memos.get(\'outbox\', \'offset~'.($offset-$num>-1 ? $offset-$num : 0).'^num~'.$num.'\');return false;"><img src="'.$this->sl_get_path().'/images/prevM.png" border="0" /></a>&nbsp;<a href="javascript:void(0)" onclick="memos.get(\'outbox\', \'offset~'.($offset+$num).'^num~'.$num.'\');return false;"><img src="'.$this->sl_get_path().'/images/nextM.png" border="0" /></a></div>';//JS object for loading other pages and doing ajax
		        $str = $table."<br/><br/>";
			}
			elseif($what=='trash'){
				$offset = isset($_POST['offset']) ? $_POST['offset'] : null;
		        $num = isset($_POST['num']) ? $_POST['num'] : null;
		        $offset = $offset ? $offset : 0;
		        $num = $num ? $num : (isset($_COOKIE['sl_memo_num']) ? intval($_COOKIE['sl_memo_num']) : 10);
				// get list of all admin sent tickets that are not trashed
				$ret = $this->sl_post_request('remote4.php','act=get_trash&host='.$this->host);
				//remove "true"
				array_shift($ret);
				//put tickets into appropriate array
				$unread_arr = array();
		        $locked_arr = array();
		        $read_arr = array();
				for($i=0;$i<count($ret);$i+=6){
					// id, subject, message, urgency, time, c_stat
					$id = intval($ret[$i]);
					$subject = empty($ret[$i+1]) ? 'No Subject' : stripcslashes(stripcslashes($ret[$i+1]));
					$message = stripcslashes(stripcslashes($ret[$i+2]));
					$urgency = intval($ret[$i+3]);
					$time = intval($ret[$i+4]);
					$c_stat = intval($ret[$i+5]);

					$arr = array('id'=>$id,'subject'=>$subject,'message'=>$message,'urgency'=>$urgency,'time'=>$time,'c_stat'=>$c_stat);

					if($c_stat == 0){
						//put in unread
						array_push($unread_arr, $arr);
			        } elseif($c_stat == 2){
						//put in locked
						array_push($locked_arr, $arr);
			        } else {
						//put in read
						array_push($read_arr, $arr);
			        }
				}


				//SORT THE ARRAYS BY URGENCY THEN TIME
		        $urgency_arr = array(); $time_arr = array();
				foreach ($unread_arr as $key => $row) {
				    $urgency_arr[$key] = $row['urgency'];
				    $time_arr[$key] = $row['time'];
				}
				@array_multisort($urgency_arr, SORT_DESC, $time_arr, SORT_DESC, $unread_arr);
		        //sort $locked_arr by urgency then time
		        $urgency_arr = array(); $time_arr = array();
		        foreach ($locked_arr as $key => $row) {
				    $urgency_arr[$key] = $row['urgency'];
				    $time_arr[$key] = $row['time'];
				}
				@array_multisort($urgency_arr, SORT_DESC, $time_arr, SORT_DESC, $locked_arr);
		        //sort $read_arr by urgency then time
		        $urgency_arr = array(); $time_arr = array();
		        foreach ($read_arr as $key => $row) {
				    $urgency_arr[$key] = $row['urgency'];
				    $time_arr[$key] = $row['time'];
				}
				@array_multisort($urgency_arr, SORT_DESC, $time_arr, SORT_DESC, $read_arr);
				//remove blank pages
				$total = count($unread_arr) + count($locked_arr) + count($read_arr);
				$offset = $offset>=$total && $offset-$num>=0 ? $offset-$num : $offset;


				// DISPLAY
				$table = $this->memo_header('trash',null,"get(\'trash\',\'offset~$offset^num~$num\')").'<table cellspacing="0px" cellpadding="2px" width="100%" border="0">
							<tr>
								<td>#</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>Subject</td>
								<td>Preview</td>
								<td>Date</td>
							</tr>';
		        //display $unread_arr
		        //display $locked_arr
		        //display $read_arr
		        $arrays = array($unread_arr, $locked_arr, $read_arr);
		        $count = 0;
		        $real_count = 1;
		        foreach($arrays as $array){
			        foreach($array as $thread){
        				if($real_count-1 >= $offset && $count < $num){
        					$id = $thread['id'];
        					$domain = $this->account->domain;
							$subject = $thread['subject'];
							$message = $thread['message'];
							$urgency = $thread['urgency'];
							$time = $thread['time'];
							$c_stat = $thread['c_stat'];

							$date = '<span style="font-size:10px;">'.date("n/j/y g:i a",$time).'</span>';
							$class = $urgency==1 ? 'urgency_normal' : ($urgency==2 ? 'urgency_high' : ($urgency==3 ? 'urgency_critical' : ''));
							if($c_stat == 0){
								$icon = 'email.png';
								$bolded_domain = "<b>".$this->nicetrim($subject, 40)."</b>";
								$bolded_subject = "<b>".htmlentities($this->nicetrim($message, 60))."</b>";
								$bolded_date = "<b>$date</b>";
					        } elseif($c_stat == 2){
								$icon = 'lock.png';
								$bolded_domain = $this->nicetrim($subject, 40);
								$bolded_subject = htmlentities($this->nicetrim($message, 60));
								$bolded_date = $date;
					        } else {
								$icon = 'email_open.png';
								$bolded_domain = $this->nicetrim($subject, 40);
								$bolded_subject = htmlentities($this->nicetrim($message, 60));
								$bolded_date = $date;
					        }
							//$onclick = "memos.get('thread', 'domain~$domain^from~inbox', 'get(\'inbox\',\'offset~$offset^num~$num\')');";
							$onclick = "memos.toggle('show_message_$count');";
							$table .= "<tr class=\"$class\">
										<td width=\"10px\">$real_count</td>
										<td width=\"25px\" align=\"center\"><input id=\"restore_$count\" value=\"$id\" type=\"checkbox\" /></td>
										<td width=\"40px\" align=\"center\"><img src=\"".$this->sl_get_path()."/images/$icon\" border=\"0\" /></td>
										<td width=\"25%\" onclick=\"$onclick\" style='cursor:pointer;'>$bolded_domain</td>
										<td width=\"35%\" onclick=\"$onclick\" style='cursor:pointer;'><acronym title='".$subject."'>".$bolded_subject."</acronym></td>
										<td onclick=\"$onclick\" style='cursor:pointer;'>$bolded_date</td>
									</tr>
									<tr id=\"show_message_$count\" style=\"display:none;\">
										<td colspan=\"6\">\n";
							$table .= "                                    <div>\n";
							$table .= "                                        <div id=\"maintop\">\n";
							$table .= "                                            <div class=\"maintopbox float-left width100 separator\" id=\"stage\">\n";
							$table .= "                                                <div class=\"module mod-rounded first\">\n";
							$table .= "                                                    <h3 class=\"header\">\n";
							$table .= "                                                        <span class=\"header-2\"><span class=\"header-3\">\n";
							$table .= "															<acronym title='".$subject."'>".$bolded_domain."</acronym>\n";
							$table .= "                                                            <span style=\"float:right;\">\n";
							$table .= "                                                                <span>\n";
							$table .= "                                                                    ".$this->message_toolbar($domain, $subject, $id, $urgency,'get(\'trash\',\'offset~'.$offset.'^num~'.$num.'\')',true)."\n";
							$table .= "                                                                </span>\n";
							$table .= "                                                            </span>\n";
							$table .= "                                                        </span>\n";
							$table .= "                                                    </h3>\n";
							$table .= "                                                    <div class=\"box-t1\">\n";
							$table .= "                                                        <div class=\"box-t2\">\n";
							$table .= "                                                            <div class=\"box-t3\"></div>\n";
							$table .= "                                                        </div>\n";
							$table .= "                                                    </div>\n";
							$table .= "                                                    <div class=\"box-1\">\n";
							$table .= "                                                        <div class=\"box-2\">\n";
							$table .= "                                                            <div class=\"box-3 deepest with-header\" style=\"min-height: 35px;\">\n";
							$table .= "                                                                <span style=\"width: 80%; font-size: 12px;\">\n";
							$table .= "																		".str_replace("\n",'<br/>',htmlentities($message))."\n";
							$table .= "                                                                </span>\n";
							$table .= "                                                            </div>\n";
							$table .= "                                                        </div>\n";
							$table .= "                                                    </div>\n";
							$table .= "                                                    <div class=\"box-b1\">\n";
							$table .= "                                                        <div class=\"box-b2\">\n";
							$table .= "                                                            <div class=\"box-b3\"/></div>\n";
							$table .= "                                                        </div>\n";
							$table .= "                                                    </div>\n";
							$table .= "                                                </div>\n";
							$table .= "                                            </div>\n";
							$table .= "                                        </div>\n";
							$table .= "                                        </div>\n";
							$table .= "</td>
									</tr>";
							$count++;
						}
						$real_count++;
			        }
				}
		        $table .= '</table>
        					<input id="refresh_tickets" type="hidden" value="get(\'inbox\',\'offset~'.$offset.'^num~'.$num.'\')" />
        					<div style="position:absolute;bottom:0px;">'.$this->num_per_page().'</div><div style="position:absolute;bottom:0px;right:0px;width:auto;"><a href="javascript:void(0)" onclick="memos.get(\'inbox\', \'offset~'.($offset-$num>-1 ? $offset-$num : 0).'^num~'.$num.'\');return false;"><img src="'.$this->sl_get_path().'/images/prevM.png" border="0" /></a>&nbsp;<a href="javascript:void(0)" onclick="memos.get(\'inbox\', \'offset~'.($offset+$num).'^num~'.$num.'\');return false;"><img src="'.$this->sl_get_path().'/images/nextM.png" border="0" /></a></div>';
		        $str = $table."<br/><br/>";
			}
			elseif($what=='new'){
				$domain = $this->account->domain;
				$subject = isset($_POST['subject']) ? $_POST['subject'] : null;
				$replyID = isset($_POST['replyID']) ? $_POST['replyID'] : null;
				$urgency = isset($_POST['urgency']) ? $_POST['urgency'] : null;
				$back = isset($_POST['back']) ? $_POST['back'] : null;

				//window
				$form_str = '<div id="reply_window" style="position:relative;overflow:hidden;height:270px;width:100%;">';
				//container
				$form_str .= '	<div id="reply_container" style="position:absolute;height:270px;left:0px">';
				//start first div
				$form_str .= '		<div style="height:270px;width:895px;position:absolute;">';
				$form_str .= '			<div align="center">'.$this->memo_header('new').'<b style="position:absolute;left:220px;">New Support Ticket</b><br/>
		    								<form action="javascript:void(0)" method="post" onsubmit="memos.save_new_memo(this);return false;">
		    									<table>
		    										<tr>
		    											<td>Urgency:</td>
		    											<td><select name="urgency" style="width:75px;margin-left:3px;">
																<option value="1" '.($urgency==1 ? 'selected' : '').'>Normal</option>
																<option value="2" '.($urgency==2 ? 'selected' : '').'>High</option>
																<option value="3" '.($urgency==3 ? 'selected' : '').'>Critical</option>
															</select>
														</td>
		    										</tr>
		    										<tr>
		    											<td>Subject:</td>
		    											<td><input name="subject" type="text" value="'.(!empty($subject) ? 're: '.$subject : $subject).'" style="width:396px;margin-left:3px" /></td>
		    										</tr>
		    										<tr>
		    											<td>Message</td>
		    											<td><textarea name="message" style="width:380px;height:150px;"></textarea></td>
		    										</tr>
		    										<tr>
		    											<td colspan="2" align="right">
															<input name="replyID" type="hidden" value="'.$replyID.'" />
															<input type="submit" value="Save" />
															<input type="button" value="Cancel" onclick="eval(\'memos.\'+\''.addcslashes($back,"'").'\')" />
														</td>
		    										</tr>
												</table>
												</form>
		    									<input id="refresh_tickets" type="hidden" value="dnum;sl_gateway.refresh(\'header\');" />
		    									</div>';
		    					//cancel is back button here
				$form_str .= '			</div>';//end first div
				//loop through the reply divs
				if($replyID && $replyID != 0){
					//get the thread
					$ret = $this->sl_post_request('remote4.php','act=get_thread&id='.$replyID.'&host='.$this->host);
					//remove "true"
					array_shift($ret);
					//loop ret
					$thread = array();
					for($i=0;$i<count($ret);$i+=6){
						array_push($thread,array('id'=>$ret[$i],'subject'=>stripslashes(stripslashes($ret[$i+1])),'message'=>str_replace("\n",'<br/>',htmlentities(stripslashes(stripslashes($ret[$i+2])))),'urgency'=>$ret[$i+3],'time'=>intval($ret[$i+4]),'from'=>$ret[$i+5]));
					}
					//SORT
			        $time_arr = array();
			        foreach ($thread as $key => $row) {
					    $time_arr[$key] = $row['time'];
					}
					@array_multisort($time_arr, SORT_DESC, $thread);

					$shift = 0;
					foreach($thread as $item){
						$shift += 895;
						$form_str .= '<div align="center" style="height:270px;width:895px;position:absolute;top:0px;left:'.$shift.'px;">';//start this 'page'

						$date = date("n/j/y g:i a",$item['time']);
						if($item['from']=='admin'){
							$header = "SecureLive wrote this message on <b>$date</b>";
						} else {
							$header = "You wrote this message on <b>$date</b>";
						}

						$form_str .= '	<div style="width:500px;text-align:left;">'.$header.'<br/><hr/><br/>'.$item['message'].'</div>';
						$form_str .= '</div>';//end this 'page'
					}
				}
				$form_str .= '	</div>';//end container
				//MEMO SLIDER
				if($replyID && $replyID != 0){
					$prev_img = '<img src="'.$this->sl_get_path().'/images/prevmsg.png" border="0" alt="Go Back" title="Go Back" height="20px" width="26px" />';
					$home_img = '<img src="'.$this->sl_get_path().'/images/goreply.png" border="0" alt="Go Back to New Message Form" title="Go Back to New Message Form" height="20px" width="26px" />';
					$next_img = '<img src="'.$this->sl_get_path().'/images/nextmsg.png" border="0" alt="View Earlier Message" title="View Earlier Message" height="20px" width="26px" />';

					$form_str .= '<script type="text/javascript">memo_slider = new MemoSlider();</script>';
					$form_str .= "<div style=\"height:20px;position:absolute;bottom:0px;width:100%\"><a href=\"javascript:void(0)\" onclick=\"memo_slider.prev();return false;\" style=\"position:absolute;left:0px;\">$prev_img</a><a href=\"javascript:void(0)\" onclick=\"memo_slider.home();return false;\" style=\"position:absolute;left:50%;\">$home_img</a><a href=\"javascript:void(0)\" onclick=\"memo_slider.next();return false;\" style=\"position:absolute;right:0px;\">$next_img</a><input id='memo_shift' type='hidden' value='$shift' /></div>";//footer controls
				}
				$form_str .= '</div>';//end window
				$str = $form_str;
			}
			elseif($what=='forward'){
				$id = isset($_POST['id']) ? intval($_POST['id']) : null;
				$to = isset($_POST['to']) ? $_POST['to'] : null;

                $ret = $this->sl_post_request('remote4.php',http_build_query(array('act'=>'forward_tickets','id'=>$id,'host'=>$this->host),'','&'));

                if($ret[0]=='true'){
	                $check = mail($to,$ret[1],$ret[2],$ret[3]);
	                if($check){
						$str = 'Message sent.';
	                } else {
						$str = 'Failed to send the email from your server.';
	                }
                } else {
					$str = 'The server said: '.$ret[0];
                }
			}
			elseif($what=='ajax'){
				$action = isset($_POST['action']) ? $_POST['action'] : null;
    			$data = isset($_POST['data']) ? $_POST['data'] : null;

    			if($action=='add'){
    				$urgency = isset($_POST['urgency']) ? str_replace('#sl_amp#','&',$_POST['urgency']) : null;
    				$subject = isset($_POST['subject']) ? str_replace('#sl_amp#','&',$_POST['subject']) : null;
    				$message = isset($_POST['message']) ? str_replace('#sl_amp#','&',$_POST['message']) : null;
    				$replyID = isset($_POST['replyID']) ? str_replace('#sl_amp#','&',$_POST['replyID']) : null;

    				$ret = $this->sl_post_request('remote4.php',http_build_query(array('act'=>'add_ticket','urgency'=>$urgency,'subject'=>$subject,'message'=>$message,'replyID'=>$replyID,'host'=>$this->host),'','&'));

					if($ret[0]=='true'){
						$str = 'true';
					} else {
						$str = 'Unable to save your message.<br/>'.$ret[0];
					}
    			}
    			elseif($action=='toggle'){
    				$data = intval($data);
                    $ret = $this->sl_post_request('remote4.php',http_build_query(array('act'=>'toggle_ticket','id'=>$data,'host'=>$this->host),'','&'));
					$str = 'true';
    			}
    			elseif($action=='lock'){
					$data = intval($data);
                    $ret = $this->sl_post_request('remote4.php',http_build_query(array('act'=>'lock_ticket','id'=>$data,'host'=>$this->host),'','&'));
					$str = 'true';
    			}
    			elseif($action=='restore'){
                    $ids = '';
                    $ok = '0123456789~';
                    for($i=0;$i<strlen($data);$i++){
                        if(strpos($ok,substr($data,$i,1))!==false){
                            $ids .= substr($data,$i,1);
                        }
                    }
                    $ret = $this->sl_post_request('remote4.php',http_build_query(array('act'=>'restore_tickets','ids'=>$ids,'host'=>$this->host),'','&'));
                    $str = 'true';
                }
                elseif($action=='remove'){
                    $ids = '';
                    $ok = '0123456789~';
                    for($i=0;$i<strlen($data);$i++){
                        if(strpos($ok,substr($data,$i,1))!==false){
                            $ids .= substr($data,$i,1);
                        }
                    }
                    $ret = $this->sl_post_request('remote4.php',http_build_query(array('act'=>'remove_tickets','ids'=>$ids,'host'=>$this->host),'','&'));
                    $str = 'true';
                }
			}
		    //
			return $str;
		}
		/************************************* pages */

		public function invalid_acct(){
			$server_response = null;
			//if form submitted, send it
			if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email'])){
				
				if(isset($_POST['password']) && !empty($_POST['password'])){
					$put = $this->put_auth($_POST['password']);
					$password = $put ? $_POST['password'] : null;
				} else {
					$password = null;
				}
				
				$arr = array('act'=>'activate','host'=>$this->host,'fname'=>$_POST['fname'],'lname'=>$_POST['lname'],'email'=>$_POST['email'],'password'=>$password);
				$response = $this->sl_post_request('remote4.php',http_build_query($arr,'','&'));
				if($response[0]=='true'){
					header("location: ".$_SERVER['REQUEST_URI']);
					die();
				} else {
					#if it failed, we need to reload account to see if it actually is valid again
					$this->account = new Account();
					if($this->account->valid=='true'){
						header("location: ".$_SERVER['REQUEST_URI']);
						die();
					} else {
						$server_response = htmlentities($response[0]);
					}
				}
			}




			$output = $this->head();
			$output .= '        <!-- Adverts -->';
		    $output .= '        <div class="s5_wrap" >';
		    $output .= '            <div class="s5_w_modwrap">';
		    $output .= '                <div class="s5_backmiddlemiddle2">';
		    $output .= $this->ModuleStart("1", "100", "", "Invalid Account", "advert", TRUE);
			
			$output .= '<script type="text/javascript">
							<!--
							jQuery.noConflict();
							//-->
						</script>';


		    $output .= "We're sorry, but your account could not be found.<br/><br/>";
			//account response
			if($server_response){
				$output .= "Your account could not be activated. The server said:<br/>$server_response<br/><br/>";
			}
			$output .= "<b>Account Denial Reason:</b> ".$this->account->valid."<br/><br/>";

			//activation form
			$output .= '<form action="'.$this->uri.'" method="post">';
			$output .= '	<table>';
			$output .= '		<tr>';
			$output .= '			<td colspan="2"><b>New customers,</b> please activate your account with this form.</td>';
			$output .= '		</tr>';
			$output .= '		<tr>';
			$output .= '			<td>First Name:</td>';
			$output .= '			<td><input type="text" name="fname" style="width:180px;" /></td>';
			$output .= '		</tr>';
			$output .= '		<tr>';
			$output .= '			<td>Last Name:</td>';
			$output .= '			<td><input type="text" name="lname" style="width:180px;" /></td>';
			$output .= '		</tr>';
			$output .= '		<tr>';
			$output .= '			<td>Email:</td>';
			$output .= '			<td><input type="text" name="email" style="width:180px;" /></td>';
			$output .= '		</tr>';
			$output .= '		<tr>';
			$output .= '			<td>Password:</td>';
			$output .= '			<td><input type="password" name="password" style="width:180px;" /></td>';
			$output .= '		</tr>';
			$output .= '		<tr>';
			$output .= '			<td colspan="2">If you have not created an account password, you may specify one now. You will not be asked for this again unless it is deleted from your server.</td>';
			$output .= '		</tr>';
			$output .= '		<tr>';
			$output .= '			<td colspan="2"><input type="submit" value="Activate Account" /></td>';
			$output .= '		</tr>';
			$output .= '	</table>';
			$output .= '</form><br/>';

		    //possible reasons
			$output .= "<b>Possible reasons:</b><br/>\n";
			$output .= "1) If you are a new customer, you need to try to activate your account with the form above. If you are unable to do this, your domain is not yet on file or we have the wrong domain on file. Your domain is usually on file within the hour of purchase, but if you purchased outside of our normal business hours, please give us up to 24 hours to put your domain into our system. If you have waited and still cannot activate, or cannot wait, please contact us at 888-300-4546 or support@securelive.net and provide us with your name, order number, and domain name you wish to activate.<br/><br/>\n";
			$output .= "2) If you already have an account, your server's IP might have changed. You will need to contact us at 888-300-4546 or support@securelive.net and let us know your domain name and that your account is disabled.<br/><br/>\n";
			$output .= "3) If you have put a password on your account, you will need to provide this above, or request a password reset. You will need to contact us at 888-300-4546 or support@securelive.net and let us know your domain name and that your account needs a password reset. You will be required to prove account ownership via email at the time of this request.  If your password is entered correctly, the software may be unable to write the needed file.<br/><br/>\n";


		    $output .= $this->EndModule();
		    $output .= '            <div style="clear:both;"></div>'."\n";
		    $output .= '        </div>'."\n";
		    $output .= '    </div>'."\n";
		    $output .= '    <div class="s5_w_modbl"></div>'."\n";
		    $output .= '    <div class="s5_w_modbm"></div>'."\n";
		    $output .= '    <div class="s5_w_modbr"></div>'."\n";
		    $output .= '    <div style="clear:both;"></div>'."\n";
		    $output .= '    <div class="s5_leftshadow" ></div>'."\n";
		    $output .= '    <div class="s5_rightshadow" ></div>'."\n";
		    $output .= '    <!-- End Adverts -->'."\n";
		    $output .= '    <div style="clear:both;"></div>'."\n";





			return $output;
		}
		private function head(){
			$str = '        <!-- Header -->'."\n";
	        $str .= '        <div class="s5_wrap" style="position:relative;">'."\n";
	        $str .= '            <div id="s5_headerleft"></div>'."\n";
	        $str .= '            <div id="s5_headermid">'."\n";
	        $str .= '                <div id="s5_headerglow">'."\n";
	        $str .= '                    <div id="s5_headleft">'."\n";
	        $str .= '                        <div id="s5_topmenu">'."\n";
	        $str .= '                            <div id="sl_header_link_div" class="moduletable">'."\n";
	        $str .= '                                <ul class="menu">'."\n";
	        $page = isset($_GET['sl_page']) ? $_GET['sl_page'] : null;
	        $str .= $this->sl_admin_header($this->account->acct_type, $page);
	        $str .= '                                </ul>'."\n";
	        $str .= '                            </div>'."\n";
	        $str .= '                        </div>'."\n";
	        $str .= '                        <div style="clear:both;"></div>'."\n";
	        $str .= '                        <div id="s5_logo"></div>'."\n";
	        $str .= '                    </div>'."\n";
	        $str .= '                    <div style="clear:both;"></div>'."\n";
	        $str .= '                </div>'."\n";
	        $str .= '            </div>'."\n";
	        $str .= '            <div id="s5_headerright">'."\n";
	        $str .= '                <a href="http://www.twitter.com/securelivellc" target="_blank"><div id="s5_logo_twitter" style="cursor:pointer;"></div></a>'."\n";
	        $str .= '                <a href="http://www.facebook.com/pages/SecureLive/138316522879769" target="_blank"><div id="s5_logo_facebook" style="cursor:pointer;"></div></a>'."\n";
	        $str .= '            </div>'."\n";
	        $str .= '            <div style="clear:both;"></div>'."\n";
	        $str .= '            <div class="s5_leftshadow"></div>'."\n";
	        $str .= '            <div class="s5_rightshadow"></div>'."\n";
	        $str .= '            <div id="tutorial_output" style="display:none;" class="sl_tutorial_div">
	        						<div class="tl_tut"></div>
	        						<div class="t_tut"></div>
	        						<div class="tr_tut"></div>
	        						<div class="r_tut"></div>
	        						<div class="br_tut"></div>
	        						<div class="b_tut"></div>
	        						<div class="bl_tut"></div>
	        						<div class="l_tut"></div>
	        						<div id="tutorial_output_inner"></div>
	                             </div>'."\n";
	        $str .= '        </div>'."\n";
	        $str .= '        <!-- End Header -->'."\n";
	        $str .= '        <div style="clear:both;"></div>'."\n";
	        
	        $version = $this->versionMessage ? $this->versionMessage : $this->getVersionMessage();
	        if(substr_count($version,'Outdated')){
				$str .= '        <!-- Adverts -->';
		        $str .= '        <div class="s5_wrap" >';
		        $str .= '            <div class="s5_w_modwrap">';
		        $str .= '                <div class="s5_backmiddlemiddle2">';
		        $str .= $this->ModuleStart("1", "100", "", "Update Available", "advert", false);

		        $str .= '<b style="font-size:13px !important;">Your version of SecureLive is '.$version.'</b><br /><br/>'."\n";

		        $str .= $this->EndModule();
		        $str .= '            <div style="clear:both;"></div>'."\n";
		        $str .= '        </div>'."\n";
		        $str .= '    </div>'."\n";
		        $str .= '    <div class="s5_w_modbl"></div>'."\n";
		        $str .= '    <div class="s5_w_modbm"></div>'."\n";
		        $str .= '    <div class="s5_w_modbr"></div>'."\n";
		        $str .= '    <div style="clear:both;"></div>'."\n";
		        $str .= '    <div class="s5_leftshadow" ></div>'."\n";
		        $str .= '    <div class="s5_rightshadow" ></div>'."\n";
		        $str .= '    <!-- End Adverts -->'."\n";
		        $str .= '    <div style="clear:both;"></div>'."\n";
	        }
			
	        return $str;
		}
		private function sl_admin_header($account_act, $page_name){
			$returnOutput = '
				<li class="item140">
					<a href="#" id="sl_scorecard_menulink" onclick="sl_gateway.open(\'scorecard\');return false;">
						<span>
							<img src="'.$this->filepath.'/images/data_view.png" align="top" />
							<span name="sl_header_tab_link" style="color:#ccc;">ScoreCard</span>
						</span>
					</a>
				</li>
				<li class="item140">
					<a href="#" id="sl_overview_menulink" onclick="sl_gateway.open(\'overview\');return false;">
						<span>
							<img src="'.$this->filepath.'/images/data_view.png" align="top" />
							<span name="sl_header_tab_link" style="color:#ccc;">System Overview</span>
						</span>
					</a>
				</li>
				<li class="item140">
					<a href="#" id="sl_tools_menulink" onclick="sl_gateway.open(\'tools\');return false;">
						<span>
							<img src="'.$this->filepath.'/images/environment_view.png" align="top" />
							<span name="sl_header_tab_link" style="color:#ccc;">System Tools</span>
						</span>
					</a>
				</li>
				<li class="item140">
					<a href="#" id="sl_stats_menulink" onclick="sl_gateway.open(\'stats\');return false;">
						<span>
							<img src="'.$this->filepath.'/images/column-chart.png" align="top" />
							<span name="sl_header_tab_link" style="color:#ccc;">Statistics</span>
						</span>
					</a>
				</li>
				<li class="item140">
					<a href="#" id="sl_attacklog_menulink" onclick="sl_gateway.open(\'attacklog\');return false;">
						<span>
							<img src="'.$this->filepath.'/images/document_connection.png" align="top" />
							<span name="sl_header_tab_link" style="color:#ccc;">Attack Log</span>
						</span>
					</a>
				</li>
				<li class="item140">
					<a href="#" id="sl_diagnostics_menulink" onclick="sl_gateway.open(\'diagnostics\');return false;">
						<span>
							<img src="'.$this->filepath.'/images/client_network.png" align="top" />
							<span name="sl_header_tab_link" style="color:#ccc;">Diagnostics</span>
						</span>
					</a>
				</li>
				<li class="item140">
					<a href="#" id="sl_tickets_menulink" onclick="sl_gateway.open(\'tickets\');return false;">
						<span>'.$this->putMemos($this->account->domain, $this->filepath).'</span>
					</a>
				</li>
				<li class="item140">
					<a href="#" id="sl_addons_menulink" onclick="sl_gateway.open(\'addons\');return false;">
						<span>
							<img src="'.$this->filepath.'/images/document_connection.png" align="top" />
							<span style="color:#ccc;">Add Ons</span>
						</span>
					</a>
				</li>
				<li class="item140">
					<a href="#" id="sl_help_menulink" onclick="sl_gateway.open(\'help\');return false;">
						<span>
							<img src="'.$this->filepath.'/images/lifebelt.png" align="top" />
							<span style="color:#ccc;">Help</span>
						</span>
					</a>
				</li>';
			return $returnOutput;
        }
        private function sl_make_link($sl_linkname){
	        $fp = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
	        while(substr_count($fp, 'stat=') || substr_count($fp, 'items=') || substr_count($fp, 'id=') || substr_count($fp, 'action=') || substr_count($fp, 'scanner=')){
	            $tempvar = substr_count($fp, 'stat=') ? $this->sl_changeURI($fp, 'stat=', null) : $fp;
	            $tempvar2 = substr_count($tempvar, 'items=') ? $this->sl_changeURI($tempvar, 'items=', null) : $tempvar;
	            $tempvar3 = substr_count($tempvar2, 'id=') ? $this->sl_changeURI($tempvar2, 'id=', null) : $tempvar2;
	            $tempvar4 = substr_count($tempvar3, 'action=') ? $this->sl_changeURI($tempvar3, 'action=', null) : $tempvar3;
	            $fp = substr_count($tempvar4, 'scanner=') ? $this->sl_changeURI($tempvar4, 'scanner=', null) : $tempvar4;
	        }

	        $sl_URL = substr_count($fp, 'sl_page=') ? $this->sl_changeURI($fp, 'sl_page=', $sl_linkname) : (substr_count($fp, '?') ? $fp.'&sl_page='.$sl_linkname : $fp.'?sl_page='.$sl_linkname);
	        return $sl_URL;
	    }
		private function detect_holes(){
			$alerts = array();
			$alerts[0] = '';
			$alerts[1] = '';

			#check version and alert if needed
			$version = $this->versionMessage ? $this->versionMessage : $this->getVersionMessage();
			if(substr_count($version,'Outdated')){
				$alerts[1] .= '<b style="font-size:13px !important;">Your version of SecureLive is '.$version.'</b><br /><br/>'."\n";
			}

			//quickly scan all dirs and files for anything writable
			if(substr_count(__FILE__,'\\') || (!substr_count(str_replace("\\",'/',__FILE__),"/".get_current_user()."/") && get_current_user()!='root')){
				$alerts[0] = 'N/A';
				return $alerts;
			}
			if($this->config_exists()){
				include($this->config_fp);
				if(isset($adminAlerts) && $adminAlerts===0){
					$alerts[0] = 'DISABLED';
					return $alerts;
				}
			}
			$root = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : getenv('DOCUMENT_ROOT');
			$holes = array();
	        $stack[] = $root;
	        while ($stack) {
	            $current_dir = array_pop($stack);
	            if($dh = @opendir($current_dir)){
	                while (($file = readdir($dh)) !== false) {
	                    if ($file !== '.' AND $file !== '..') {
	                        $current_file = "{$current_dir}/{$file}";
	                        if(is_file($current_file) && $this->bad_permissions($current_file)) {
	                            array_push($holes,str_replace($root,'',$current_file));
	                        } elseif (is_dir($current_file)) {
	                            if($this->bad_permissions($current_file)){
									array_push($holes,str_replace($root,'',$current_file));
	                            }
	                            $stack[] = $current_file;
	                        }
	                    }
	                }
	            } else {
					//alert about unreadable dir?
	            }
	        }
			if(count($holes)>0){
				$alerts[0] = true;
				$alerts[1] .= "The following are writable by the public:<br/><br/>".implode('<br/>',$holes)."<br/><br/>For your security, it is absolutely critical that you restore these file permissions to 755 (folders) and 644 (files). Send us a support ticket if you need assistance.";
				return $alerts;
			} else {
				$alerts[0] = true;
				return $alerts;
			}
		}
		public function QueryDB($query, $return = true){
			#ATTEMPT TO ACCESS DATABASE, LOAD A CMS FRAMEWORK IF NEEDED
			$response = array();
			if($this->is_WordPress()){
				global $wpdb;
				
				if($wpdb == null){
					//Load Wordpress
					$configFile = file_get_contents(dirname(__FILE__).'/../../../wp-config.php');
					$lines = explode("\n", $configFile);
					foreach($lines as $line){
						if(strpos($line, "define") === 0 || strpos($line, "\$table_prefix") === 0 ){//look for only define and $table_prefix
							@eval($line);	
						}
					}

					function is_multisite(){};//must have this defined for WP
					function wp_die(){};
			
					define('WP_Table_Prefix', $table_prefix); 
					
					include_once(dirname(__FILE__).'/../../../wp-includes/wp-db.php');
				}
				
				$query = str_replace("!spamfilter",WP_Table_Prefix."sl_SpamFilter", $query);
		

				if($return){
					$rs = $wpdb->get_results( $query );
					
					for($i = 0; $i < count($rs); $i++){
						$rs[$i] = (array)$rs[$i];
						$c = 0;
						foreach($rs[$i] as $key=>$value){
							$rs[$i][$c] = $value; 
							$c++;
						}
					}
					
					return $rs;
				}
				else{
					$wpdb->query( $query );
					return null;
				}
			}
			else if($this->is_joomla()){
				if($this->db){ //already have the DB
					#SET JOOMLA QUERY
					$query = str_replace("!spamfilter","#__sl_SpamFilter", $query);
					$this->db->setQuery($query);
					$this->db->query();
					if($return){
						$response = $this->db->loadRowList();
					}
				}
				else {
					#CHECK CONFIG FOR DB ACCESS IN FUTURE

					#LOAD JOOMLA
					if(!defined('DS')){define( 'DS', DIRECTORY_SEPARATOR );}
					if(!defined('JPATH_BASE')){define('JPATH_BASE', $_SERVER['DOCUMENT_ROOT']);}
					$jFile1 = JPATH_BASE .DS.'includes'.DS.'defines.php';
					$jFile2 = JPATH_BASE .DS.'includes'.DS.'framework.php';
					if(file_exists($jFile1) && file_exists($jFile2)){
						#SET JOOMLA MAINFRAME, DB, AND QUERY
						define( '_JEXEC', 1 );
						require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
						require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
						$this->mainframe =& JFactory::getApplication('site');
						$this->db =& JFactory::getDBO();
						#SET JOOMLA QUERY
						$query = str_replace("!spamfilter","#__sl_SpamFilter", $query);
						$this->db->setQuery($query);
						$this->db->query();
						if($return){
							$response = $this->db->loadRowList();
						}
					} 	
				}
			}
			else {
				//what?	
			}

			global $sl_admin;
			$sl_admin = $this;
			
			return ($return) ? $response : true;
		}//CMS Specific

		private function header_module(){
			return 'DONE*sl^module#message*'.$this->head();
		}
		private function alerts_module(){
			$alerts = $this->detect_holes();
	        if($alerts[0]===true){
	            $output = '        <!-- Adverts -->';
	            $output .= '        <div class="s5_wrap" >';
	            $output .= '            <div class="s5_w_modwrap">';
	            $output .= '                <div class="s5_backmiddlemiddle2">';
	            $output .= $this->ModuleStart("1", "100", "", "ATTENTION NEEDED!", "advert", TRUE);

	            $output .= "                ".$alerts[1]."\n";

	            $output .= $this->EndModule();
	            $output .= '            <div style="clear:both;"></div>'."\n";
	            $output .= '        </div>'."\n";
	            $output .= '    </div>'."\n";
	            $output .= '    <div class="s5_w_modbl"></div>'."\n";
	            $output .= '    <div class="s5_w_modbm"></div>'."\n";
	            $output .= '    <div class="s5_w_modbr"></div>'."\n";
	            $output .= '    <div style="clear:both;"></div>'."\n";
	            $output .= '    <div class="s5_leftshadow" ></div>'."\n";
	            $output .= '    <div class="s5_rightshadow" ></div>'."\n";
	            $output .= '    <!-- End Adverts -->'."\n";
	            $output .= '    <div style="clear:both;"></div>'."\n";
	        } else {
				$output = $alerts[1];
	        }
	        $alerts[0] = $alerts[0]===true ? 'DONE' : $alerts[0];
			return $alerts[0].'*sl^module#message*'.$output;
		}
		private function last5_module(){
			$output = '        <!-- Adverts -->';
	        $output .= '        <div class="s5_wrap" >';
	        $output .= '            <div class="s5_w_modwrap">';
	        $output .= '                <div class="s5_backmiddlemiddle2">';
	        $output .= $this->ModuleStart("1", "100", "-light", "Last 5 Logged Attacks", "advert", TRUE);
	        $output .= '                    <table>'."\n";
	        $output .= '                        <tr>'."\n";
	        $output .= '                            <td style="min-width:15px;"><span style="color:#000; font-weight: bold">#</span></td>'."\n";
	        $output .= '                            <td style="min-width:50px;"><span style="color:#000; font-weight: bold">Details</span></td>'."\n";
	        $output .= '                            <td style="min-width:115px;"><span style="color:#000; font-weight: bold">IP Address</span></td>'."\n";
	        $output .= '                            <td style="min-width:170px;"><span style="color:#000; font-weight: bold">Attack Type</span></td>'."\n";
	        $output .= '                            <td style="min-width:65px;"><span style="color:#000; font-weight: bold">Attack ID</span></td>'."\n";
	        $output .= '                            <td style="min-width:80px;"><span style="color:#000; font-weight: bold">Threat Level</span></td>'."\n";
	        $output .= '                            <td style="min-width:110px;"><span style="color:#000; font-weight: bold">Date</span></td>'."\n";
	        $output .= '                            <td style="min-width:10px;"><span style="color:#000; font-weight: bold">Time</span></td>'."\n";
	        $output .= '                        </tr>'."\n";
	        //call
	        $retData = $this->sl_post_request('remote4.php',"act=get_attacks&what=last5&host=".$this->host);
	        //loop
	        for($i=1;$i<6 && isset($retData[$i]) && $retData[$i]!='end';$i++){
	            $counter = $i;
	            $atk_arr = explode('~',$retData[$i]);
	            $atk_id = $atk_arr[0];
	            $atk_ip = $atk_arr[1];
	            $atk_date = $atk_arr[2];
	            $atk_type = $atk_arr[3];
	            $threat_level = $atk_arr[4];
	            $country = $atk_arr[5];
	            $atk_ccflag = $this->sl_convert_country($country);

	            $atk_info = explode("~", $this->sl_attack_breakdown($atk_type));
	            $atk_color = $atk_info[0];
	            $why = $atk_info[1];
	            $atk_desc = $atk_info[2];

	            $atk_str = explode("#", $atk_type);
	            $atk_name = $atk_str[0];
	            $atk_typeid = substr($atk_str[1], 0, (strlen($atk_str[1])+8)-strlen($atk_str[1]));

	            $atk_dte = date("m/d/y",intval($atk_date));
	            $atk_tme = date("H:i:s",intval($atk_date));

	            $output .= '                        <tr>'."\n";
	            $output .= '                            <td><span style="color:'.$atk_color.'; font-weight: bold">'.$counter.'</span></td>'."\n";
	            $output .= '                            <td align="center"><a href="#" onclick="sl_gateway.open(\'details\',\'id='.$atk_id.'~'.$atk_ip.'\');return false;"><img src="'.$this->filepath.'/images/view.png" alt="View details about '.$atk_ip.'" title="View details about '.$atk_ip.'" /></a></td>'."\n";
	            $output .= '                            <td>'.(!empty($atk_ccflag) ? '<img src="'.$this->filepath.'/images/flags/'.$atk_ccflag.'" alt="'.$country.'" title="'.$country.'" />' : '').' <a href="#" onclick="sl_gateway.open(\'details\',\'id='.$atk_id.'~'.$atk_ip.'\');return false;"><span style="color:#000; font-weight: bold"><acronym title="View details about '.$atk_ip.'">'.$atk_ip.'</acronym></span></a></td>'."\n";
	            $output .= '                            <td><span style="color:'.$atk_color.'; font-weight: bold">'.$this->nicetrim($atk_name, 30).'</span></td>'."\n";
	            $output .= '                            <td><span style="color:'.$atk_color.'; font-weight: bold">'.$atk_typeid.'</span></td>'."\n";
	            $output .= '                            <td align="center">'.$this->LinkThreatLevel($threat_level).'</td>'."\n";
	            $output .= '                            <td><span style="color:'.$atk_color.'; font-weight: bold">'.$atk_dte.'</span></td>'."\n";
	            $output .= '                            <td><span style="color:'.$atk_color.'; font-weight: bold">'.$atk_tme.'</span></td>'."\n";
	            $output .= '                        </tr>'."\n";
	        }
	        $output .= '                    </table>'."\n";
	        $output .= $this->EndModule();
	        $output .= '            <div style="clear:both;"></div>'."\n";
	        $output .= '        </div>'."\n";
	        $output .= '    </div>'."\n";
	        $output .= '    <div class="s5_w_modbl"></div>'."\n";
	        $output .= '    <div class="s5_w_modbm"></div>'."\n";
	        $output .= '    <div class="s5_w_modbr"></div>'."\n";
	        $output .= '    <div style="clear:both;"></div>'."\n";
	        $output .= '    <div class="s5_leftshadow" ></div>'."\n";
	        $output .= '    <div class="s5_rightshadow" ></div>'."\n";
	        $output .= '    <!-- End Adverts -->'."\n";
	        $output .= '    <div style="clear:both;"></div>'."\n";
	        return 'DONE*sl^module#message*'.$output;
		}
		private function scorecard_module(){
			define('SL_Admin_scorecard',1);
			$scoreFile = str_replace('\\','/',dirname(__FILE__)).'/inc/sl_scorecard.php';
	        if(file_exists($scoreFile)){
	            $output = '        <!-- Adverts -->';
	            $output .= '        <div class="s5_wrap" >';
	            $output .= '            <div class="s5_w_modwrap">';
	            $output .= '                <div class="s5_backmiddlemiddle2">';
	            $output .= $this->ModuleStart("1", "100", "", "Security Score", "advert", TRUE);

	            require($scoreFile);

	            $output .= $this->EndModule();
	            $output .= '            	<div style="clear:both;"></div>'."\n";
	            $output .= '        	</div>'."\n";
	            $output .= '    	</div>'."\n";
	            $output .= '    	<div class="s5_w_modbl"></div>'."\n";
	            $output .= '    	<div class="s5_w_modbm"></div>'."\n";
	            $output .= '    	<div class="s5_w_modbr"></div>'."\n";
	            $output .= '    	<div style="clear:both;"></div>'."\n";
	            $output .= '    	<div class="s5_leftshadow" ></div>'."\n";
	            $output .= '    	<div class="s5_rightshadow" ></div>'."\n";
	            $output .= '   	 	<!-- End Adverts -->'."\n";
	            $output .= '    	<div style="clear:both;"></div>'."\n";
	        } else {
				$output = '';
	        }
			return 'DONE*sl^module#message*'.$output;
		}
		private function details_module(){
			$error_message = '';
			$id = isset($_POST['id']) ? $_POST['id'] : null;
			
			if(isset($_POST['sl_remove'])){// REMOVE FROM BLACKLIST
	            $sURL = array('act'=>'remove_attack','id'=>$id,'host'=>$this->host);
	            $check = $this->sl_post_request('remote4.php', http_build_query($sURL,'','&'));
	            if($check[0]=='1' || $check[0]=='2' || $check[0]=='3'){
	                return 'REFRESH*sl^module#message*';
	            } else {
	                $error_message = '<br/>Sorry, but the attack could not be removed from the database. The server said:<br/><br/>'.$check[0]."<br/>\n";
	            }
	        }
	        
	        $arr = array('act'=>'get_attacks','what'=>'single','host'=>$this->host,'id'=>$id);
	        $retData = $this->sl_post_request('remote4.php', http_build_query($arr,'','&'));

	        if($retData[0]=='true'){
	            $atk_arr = explode('~',$retData[1]);
	            $atk_id = $atk_arr[0];
	            $atk_ip = $atk_arr[1];
	            $atk_date = intval($atk_arr[2]);
	            $atk_browser = $atk_arr[3];
	            $atk_os = $atk_arr[4];
	            $atk_type = $atk_arr[5];
	            $atk_str = $atk_arr[6];
	            $atk_str2 = $atk_str;
	            $atk_fullstr = htmlentities($atk_arr[6]);
	            $atk_latlong = trim($atk_arr[7]);
	            $atk_country = $atk_arr[8];
	            $atk_city = $atk_arr[9];
	            $atk_state = $atk_arr[10];
	            $atk_zip = $atk_arr[11];
	            $atk_isp = $atk_arr[12];
	            $atk_host = $atk_arr[13];
	            $atk_org = $atk_arr[14];
	            $atk_ref = $atk_arr[15];
	            $area_code = $atk_arr[16];
	            $atk_threat = $atk_arr[17];
	            $block_type = $atk_arr[18];

	            $atk_ccflag = $this->sl_convert_country($atk_arr[8]);
	            $atk_info = explode("~", $this->sl_attack_breakdown($atk_type));
	            $atk_color = $atk_info[0];
	            $why = $atk_info[1];
	            $atk_desc = $atk_info[2];
	            $atk_str = explode("#", $atk_type);
	            $atk_name = $atk_str[0];
	            $atk_typeid = $atk_str[1];

	            $atk_dte = date("m/d/Y",$atk_date);
	            $atk_tme = date("H:i:s",$atk_date);
	        } else {
	            $atk_dte = 'ERROR:<br/>'.$retData[0];
	        }
	        $str = '        <!-- Adverts -->';
	        $str .= '        <div class="s5_wrap" >';
	        $str .= '            <div class="s5_w_modwrap">';
	        $str .= '                <div class="s5_backmiddlemiddle2">';
	        $str .= $this->ModuleStart("1", "25", "-light", "Attack Information", "advert", TRUE);
	        $str .= '<div style="overflow:auto">
	                    <span style="font-weight: bold">Attack Date:</span> '.$atk_dte.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Attack Time:</span> '.$atk_tme.'<br />'."\n";
	        //$str .= '<span style="font-weight: bold">Attack ID:</span> '.$atk_typeid.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Attack Info:</span> <span style="color:'.$atk_color.'; font-weight: bold">'.$atk_type.'</span><br />'."\n";
	        $str .= '<span style="font-weight: bold">Block Type:</span> '.$block_type.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Threat Level:</span> '.$atk_threat.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Attack String:</span> '.$atk_fullstr.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Referer:</span> '.$atk_ref.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Browser:</span> '.$atk_browser.'
	                    </div><br /><br />'."\n";
	        $str .= $this->EndModule();
	        $str .= $this->ModuleStart("2", "20", "-light", "About the Attack", "advert", FALSE);
	        $str .= $atk_desc;
	        //get info
	        $sURL = array('act'=>'validator','txt'=>$atk_str2,'host'=>$this->host);
	        $retData = $this->sl_post_request('remote4.php', http_build_query($sURL,'','&'));
	        if(array_shift($retData) == 'true'){
	            array_pop($retData);
	            array_pop($retData);
	            $highlighted_code = $this->highlight_code($retData, $atk_str2);
	            //make pattern string
	            $pattern_string = '';
	            for($i=0;$i<count($retData);$i++){
	                if(!substr_count($pattern_string, $retData[$i])){
	                    $pattern_string .= $retData[$i].'  ';
	                }
	            }
	            $str .= '<div><br/>
	                            URI matched these patterns: <i>'.htmlentities($pattern_string).'</i><br/><br/>
	                            '.$highlighted_code.'
	                        </div>'."\n";
	        }
	        $str .= $this->EndModule();
	        $str .= $this->ModuleStart("3", "25", "-light", "User Information", "advert", TRUE);
	        $str .= '<span style="font-weight: bold">IP Address:</span> '.$atk_ip.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">ISP:</span> '.$atk_isp.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Hosting Company:</span> '.$atk_host.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Originazation:</span> '.$atk_org.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Country:</span> <img src="'.$this->filepath.'/images/flags/'.$atk_ccflag.'" alt="'.$atk_country.'" title="'.$atk_country.'" /> '.$atk_country.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">City:</span> '.$atk_city.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">State:</span> '.$atk_state.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Zip:</span> '.$atk_zip.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Area Code:</span> '.$area_code.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Browser:</span> '.$atk_browser.'<br />'."\n";
	        $str .= '<span style="font-weight: bold">Operating System:</span> '.$atk_os.'<br />'."\n";
	        $str .= $this->EndModule();
	        $str .= $this->ModuleStart("4", "25", "-light", "Geolocation of Attacker", "advert", FALSE);
	        $str .= '<script type="text/javascript">
	        			<!-- 
	        			//need to get rid of this and use http://maps.google.com/maps/api/js?sensor=false once google fixes the bug with the getScript function
						window.google = window.google || {};
						google.maps = google.maps || {};
						(function() {
							function getScript(src) {
								scriptElement = document.createElement("script");
								scriptElement.setAttribute("src", src);
								document.body.appendChild(scriptElement);
							}

							var modules = google.maps.modules = {};
							google.maps.__gjsload__ = function(name, text) {
								modules[name] = text;
							};

							google.maps.Load = function(apiLoad) {
								delete google.maps.Load;
								apiLoad([null,[[["http://mt0.google.com/vt?lyrs=m@138\u0026src=api\u0026hl=en-US\u0026","http://mt1.google.com/vt?lyrs=m@138\u0026src=api\u0026hl=en-US\u0026"],null,"foo"],[["http://khm0.google.com/kh?v=74\u0026hl=en-US\u0026","http://khm1.google.com/kh?v=74\u0026hl=en-US\u0026"],null,"foo",null,1],[["http://mt0.google.com/vt?lyrs=h@138\u0026src=api\u0026hl=en-US\u0026","http://mt1.google.com/vt?lyrs=h@138\u0026src=api\u0026hl=en-US\u0026"],null,"foo","imgtp=png32\u0026"],[["http://mt0.google.com/vt?lyrs=t@126,r@138\u0026src=api\u0026hl=en-US\u0026","http://mt1.google.com/vt?lyrs=t@126,r@138\u0026src=api\u0026hl=en-US\u0026"],null,"foo"],null,[[null,0,7,7,[[[330000000,1246050000],[386200000,1293600000]],[[366500000,1297000000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026"]],[null,0,8,9,[[[330000000,1246050000],[386200000,1279600000]],[[345000000,1279600000],[386200000,1286700000]],[[348900000,1286700000],[386200000,1293600000]],[[354690000,1293600000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026"]],[null,0,10,19,[[[329890840,1246055600],[386930130,1284960940]],[[344646740,1284960940],[386930130,1288476560]],[[350277470,1288476560],[386930130,1310531620]],[[370277730,1310531620],[386930130,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026"]],[null,3,7,7,[[[330000000,1246050000],[386200000,1293600000]],[[366500000,1297000000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026"]],[null,3,8,9,[[[330000000,1246050000],[386200000,1279600000]],[[345000000,1279600000],[386200000,1286700000]],[[348900000,1286700000],[386200000,1293600000]],[[354690000,1293600000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026"]],[null,3,10,null,[[[329890840,1246055600],[386930130,1284960940]],[[344646740,1284960940],[386930130,1288476560]],[[350277470,1288476560],[386930130,1310531620]],[[370277730,1310531620],[386930130,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026"]]],[["http://cbk0.google.com/cbk?","http://cbk1.google.com/cbk?"],null,"foo"],[["http://khmdb0.google.com/kh?v=33\u0026hl=en-US\u0026","http://khmdb1.google.com/kh?v=33\u0026hl=en-US\u0026"],null,"foo"],[["http://mt0.google.com/mapslt?hl=en-US\u0026","http://mt1.google.com/mapslt?hl=en-US\u0026"],null,"foo"],[["http://mt0.google.com/mapslt/ft?hl=en-US\u0026","http://mt1.google.com/mapslt/ft?hl=en-US\u0026"],null,"foo"]],["en-US","US",null,0,null,"http://maps.google.com","http://maps.gstatic.com/intl/en_us/mapfiles/","http://gg.google.com","https://maps.googleapis.com","http://maps.googleapis.com"],["http://maps.gstatic.com/intl/en_us/mapfiles/api-3/3/0","3.3.0"],[1229228594],1,null,null,null,null,0,""], loadScriptTime);
							};
							var loadScriptTime = (new Date).getTime();
							//getScript("http://maps.gstatic.com/intl/en_us/mapfiles/api-3/3/0/main.js");
						})();
						//-->
			        </script>
	        		<script type="text/javascript" src="http://maps.gstatic.com/intl/en_us/mapfiles/api-3/3/0/main.js"></script>
	        
	        
	        
	        
	                    <div id="map_canvas" style="width:250px; height:190px;"></div>
	                        <script type="text/javascript">
	                            function initialize_map() {
	                                var prev_info = null;
	                                var center = new google.maps.LatLng('.$atk_latlong.');
	                                var myOptions = {
	                                    scrollwheel:false,
	                                    mapTypeControl: true,
	                                    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
	                                    navigationControl: true,
	                                    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
	                                    zoom: 3,
	                                    center: center,
	                                    mapTypeId: google.maps.MapTypeId.ROADMAP};
	                                var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);'."\n";
	        $str .= '            var pos_1 = new google.maps.LatLng('.$atk_latlong.');
	                                var content_1 = "<strong>Why Blocked: </strong>'.$why.'<br />"+"<strong>When: </strong>'.$atk_date.'<br />"+"<strong>String: </strong>'.$atk_type.'";
	                                var info_1 = new google.maps.InfoWindow({
	                                    position: pos_1,
	                                    content: content_1,
	                                    maxWidth: 400});
	                                var attack_1= new google.maps.Marker({
	                                    position: pos_1,
	                                    map: map,
	                                    title:"'.$why.'"'."\n";
	            //only put icons if not opera
	            if(!preg_match("/opera/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
	                $str .= '            ,icon: "'.$this->filepath.'/images/blocked_map_img.png"'."\n";
	            }
	        $str .= '            });
	                                google.maps.event.addListener(attack_1, \'click\', function() {
	                                    if(prev_info){
	                                        prev_info.close(map);
	                                    }
	                                    info_1.open(map);
	                                    prev_info = info_1;
	                                });'."\n";
	        $str .= '        }
							//initialize_map();
	                    </script>
	                    <br/><br/>'."\n";
	        $str .= $this->EndModule();
	        $str .= '            <div style="clear:both;"></div>'."\n";
	        $str .= '        </div>'."\n";
	        $str .= '    </div>'."\n";
	        $str .= '    <div class="s5_w_modbl"></div>'."\n";
	        $str .= '    <div class="s5_w_modbm"></div>'."\n";
	        $str .= '    <div class="s5_w_modbr"></div>'."\n";
	        $str .= '    <div style="clear:both;"></div>'."\n";
	        $str .= '    <div class="s5_leftshadow" ></div>'."\n";
	        $str .= '    <div class="s5_rightshadow" ></div>'."\n";
	        $str .= '    <!-- End Adverts -->'."\n";
	        $str .= '    <div style="clear:both;"></div>'."\n";
	        $str .= '        <!-- Adverts -->';
	        $str .= '        <div class="s5_wrap" >';
	        $str .= '            <div class="s5_w_modwrap">';
	        $str .= '                <div class="s5_backmiddlemiddle2">';
	        $str .= $this->ModuleStart("1", "100", "-light", "Reporting Information", "advert", TRUE);
	        $str .= '<fieldset>
	                        <form action="'.$this->uri.'" method="post" onsubmit="sl_gateway.open(\'details\',this);return false;">';
	        $str .= '        <input type="button" name="sl_print" value="Print" class="submit" onClick="window.print()">';
	        $str .= '        <input type="hidden" name="id" value="'.addcslashes($id,'"').'">';
	        $str .= '        <input type="submit" name="sl_remove" value="Remove" class="submit" onclick="sl_prompt=prompt(\'If you really want to remove this attack from the blacklist, type SECURELIVE in the box and press OK.\');return sl_prompt&&sl_prompt.toLowerCase()==\'securelive\'?true:false;" />&nbsp;
	                        </form>';
			################################
	        $str .= $error_message;
	        $str .= '</fieldset>';
	        $str .= $this->EndModule();
	        $str .= '            <div style="clear:both;"></div>'."\n";
	        $str .= '        </div>'."\n";
	        $str .= '    </div>'."\n";
	        $str .= '    </div>'."\n";#NEED THIS???
	        $str .= '    <div class="s5_w_modbl"></div>'."\n";
	        $str .= '    <div class="s5_w_modbm"></div>'."\n";
	        $str .= '    <div class="s5_w_modbr"></div>'."\n";
	        $str .= '    <div style="clear:both;"></div>'."\n";
	        $str .= '    <div class="s5_leftshadow" ></div>'."\n";
	        $str .= '    <div class="s5_rightshadow" ></div>'."\n";
	        $str .= '    <!-- End Adverts -->'."\n";
	        $str .= '    <div style="clear:both;"></div>'."\n";
	        $str .= '    <!-- Bottom Modules -->'."\n";
	        $str .= '        <div class="s5_wrap">'."\n";
	        $str .= '            <div class="s5_bblack_tl"></div>'."\n";
	        $str .= '            <div class="s5_bblack_tm"></div>'."\n";
	        $str .= '            <div class="s5_bblack_tr"></div>'."\n";
	        $str .= '            <div style="clear:both;"></div>'."\n";
	        $str .= '            <div class="s5_bblack_outter">'."\n";
	        $str .= '                <div class="s5_backmiddlemiddle" style="padding-left:8px;">'."\n";
	        $str .= $this->ModuleStart("1", "100", "", "Information Section", "user", FALSE);
	        $str .= '            Use these tools to gather information to help determine the attack attempt was a false positive or real. Look for additional help in the help section to learn more on how these tools can help you<br /><br />'."\n";
	        $str .= $this->EndModule();
	        $str .= '                        <div style="clear:both;"></div>'."\n";
	        $str .= '                    </div>'."\n";
	        $str .= '                </div>'."\n";
	        $str .= '                <div class="s5_bblack_bl"></div>'."\n";
	        $str .= '                <div class="s5_bblack_bm"></div>'."\n";
	        $str .= '                <div class="s5_bblack_br"></div>'."\n";
	        $str .= '                <div style="clear:both;"></div>'."\n";
	        $str .= '                <div class="s5_leftshadow"></div>'."\n";
	        $str .= '                <div class="s5_rightshadow"></div>'."\n";
	        $str .= '            </div>'."\n";
	        $str .= '            <!-- End Bottom Modules -->'."\n";
	        $str .= '            <div style="clear:both;"></div>'."\n";
	        $outputMessage = isset($outputMessage) ? $outputMessage : 'DONE';
			return $outputMessage.'*sl^module#message*'.$str;
		}
		private function acct_form_module(){
			$output = '';
			// SAVE NEW ACCOUNT DATA IF FORM SUBMITTED
			{
				
				if(isset($_POST['sl_submit'])){
					if(defined('SL_Admin') && SL_Admin===true){
						//Check for state of $spamFilterEnabled
						{//This code is called here because we need to know this before the Spam Filter saves to the DB
							$rs = $this->QueryDB("SELECT time FROM !spamfilter WHERE type=0 AND term='#Enabled#'");
							$spamFilterEnabled = true;
							if(count($rs) > 0){
								$spamFilterEnabled = (intval($rs[0][0]) == 1);
							} else {
								$this->QueryDB("INSERT INTO !spamfilter VALUES(null, 1, 0, '#Enabled#')", false);
							}
						}
						//Spam Filter Settings
						{
							//Add items
							{
								//spamEMail_add
								if(isset($_POST['spamEMail_add']) && $_POST['spamEMail_add'] != ""){
									//is it part of the DB?
									if(count($this->QueryDB("SELECT id FROM !spamfilter WHERE type=1 AND term='".mysql_escape_string($_POST['spamEMail_add'])."'")) == 0)
										$this->QueryDB("INSERT INTO !spamfilter VALUES(null, ".time().", 1, '"  .mysql_escape_string($_POST['spamEMail_add'])."')", false);
								}
								//spamUsername_add
								if(isset($_POST['spamUsername_add']) && $_POST['spamUsername_add'] != ""){
									//is it part of the DB?
									if(count($this->QueryDB("SELECT id FROM !spamfilter WHERE type=2 AND term='".mysql_escape_string($_POST['spamUsername_add'])."'")) == 0)
										$this->QueryDB("INSERT INTO !spamfilter VALUES(null, ".time().", 2, '"  .mysql_escape_string($_POST['spamUsername_add'])."')", false);
								}
								//spamIP_add
								if(isset($_POST['spamIP_add']) && $_POST['spamIP_add'] != ""){
									//is it part of the DB?
									if(count($this->QueryDB("SELECT id FROM !spamfilter WHERE type=3 AND term='".mysql_escape_string($_POST['spamIP_add'])."'")) == 0)
										$this->QueryDB("INSERT INTO !spamfilter VALUES(null, ".time().", 3, '"  .mysql_escape_string($_POST['spamIP_add'])."')", false);
								}
								//spamTerm_add
								if(isset($_POST['spamTerm_add']) && $_POST['spamTerm_add'] != ""){
									//is it part of the DB?
									if(count($this->QueryDB("SELECT id FROM !spamfilter WHERE type=4 AND term='".mysql_escape_string($_POST['spamTerm_add'])."'")) == 0)
										$this->QueryDB("INSERT INTO !spamfilter VALUES(null, ".time().", 4, '"  .mysql_escape_string($_POST['spamTerm_add'])."')", false);
								}
							}

							//Remove items
							{
								$remIdList = "";

								//EMail
								if(isset($_POST['spamEMail_rem_check']) && isset($_POST['spamFilterEmail_rem']) && count($_POST['spamFilterEmail_rem']) > 0){
									foreach($_POST['spamFilterEmail_rem'] as $id){
										if($remIdList == "")
											$remIdList .= "id=".mysql_escape_string($id);
										else
											$remIdList .= " OR id=".mysql_escape_string($id);
									}
								}
								//Username
								if(isset($_POST['spamUsername_rem_check']) && isset($_POST['spamFilterUsername_rem']) && count($_POST['spamFilterUsername_rem']) > 0){
									foreach($_POST['spamFilterUsername_rem'] as $id){
										if($remIdList == "")
											$remIdList .= "id=".mysql_escape_string($id);
										else
											$remIdList .= " OR id=".mysql_escape_string($id);
									}
								}
								//IP
								if(isset($_POST['spamIP_rem_check']) && isset($_POST['spamFilterIp_rem']) && count($_POST['spamFilterIp_rem']) > 0){
									foreach($_POST['spamFilterIp_rem'] as $id){
										if($remIdList == "")
											$remIdList .= "id=".mysql_escape_string($id);
										else
											$remIdList .= " OR id=".mysql_escape_string($id);
									}
								}
								else
								{
									$output .= "";
								}
								//Term
								if(isset($_POST['spamTerm_rem_check']) && isset($_POST['spamFilterTerm_rem']) && count($_POST['spamFilterTerm_rem']) > 0){
									foreach($_POST['spamFilterTerm_rem'] as $id){
										if($remIdList == "")
											$remIdList .= "id=".mysql_escape_string($id);
										else
											$remIdList .= " OR id=".mysql_escape_string($id);
									}
								}

								if($remIdList != "")
									$this->QueryDB("DELETE FROM !spamfilter WHERE $remIdList", false);
							}

							//Enable/Disable
							{
								if(isset($_POST['sl_spamFilterEnabled'])){
									$setEnabled = (intval($_POST['sl_spamFilterEnabled']) == 1);

									if($setEnabled != $spamFilterEnabled){
										$spamFilterEnabled = $setEnabled;
										$query = "UPDATE !spamfilter SET time=".($spamFilterEnabled ? '1' : '0')." WHERE type=0 AND term='#Enabled#'";
										$this->QueryDB($query, false);
									}
								}
							}
						}

						$fname = isset($_POST['fname']) ? $_POST['fname'] : null;
		                $lname = isset($_POST['lname']) ? $_POST['lname'] : null;
		                $email = isset($_POST['email']) ? $_POST['email'] : null;
		                $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
		                $cust404 = isset($_POST['cust404']) ? $_POST['cust404'] : null;
		                //$remoteInc = isset($_POST['remoteInc']) ? $_POST['remoteInc'] : null;
		                $tz = isset($_POST['tz']) ? $_POST['tz'] : null;
		                $wdhours = isset($_POST['wdhours']) ? $_POST['wdhours'] : null;
		                $wehours = isset($_POST['wehours']) ? $_POST['wehours'] : null;
		                $act_emailrpt = isset($_POST['email_lvl']) ? $_POST['email_lvl'] : null;
		                $act_debug = isset($_POST['act_debug']) ? $_POST['act_debug'] : null;
		                $contact_email = isset($_POST['contact_email']) ? $_POST['contact_email'] : null;
		                //bot lvl
		                $act_bot_lvl = isset($_POST['bot_lvl']) ? $_POST['bot_lvl'] : null;
		                $act_bot_ban = isset($_POST['bot_ban']) ? $_POST['bot_ban'] : null;
		                $act_bot_lvl = $act_bot_ban==3 ? $act_bot_ban : $act_bot_lvl;

		                $accessword = isset($_POST['memo_pass']) ? $_POST['memo_pass'] : null;
		                $act_country_block = isset($_POST['country']) ? $_POST['country'] : array();
		                //thresh email_thresh
		                $email_thresh = isset($_POST['email_thresh']) ? $_POST['email_thresh'] : null;
		                //country 404 country404
		                $country404 = isset($_POST['country404']) ? $_POST['country404'] : null;
		                //mod mod_int mod_mod
		                $temp = isset($_POST['mod_int']) ? $_POST['mod_int'] : null;
		                $temp2 = isset($_POST['mod_mod']) ? $_POST['mod_mod'] : null;
		                $mod = "$temp-$temp2";
		                //high high_int high_mod
		                $temp = isset($_POST['high_int']) ? $_POST['high_int'] : null;
		                $temp2 = isset($_POST['high_mod']) ? $_POST['high_mod'] : null;
		                $high = "$temp-$temp2";
		                //crit crit_int crit_mod
		                $temp = isset($_POST['crit_int']) ? $_POST['crit_int'] : null;
		                $temp2 = isset($_POST['crit_mod']) ? $_POST['crit_mod'] : null;
		                $mod_high_crit = "$mod~$high~$temp-$temp2";
		                //flood flood_limit
		                $flood_limit = isset($_POST['flood_limit']) ? $_POST['flood_limit'] : null;
		                $flood_switch = isset($_POST['flood_switch']) ? $_POST['flood_switch'] : null;
		                $flood_limit = $flood_switch == -1 ? $flood_switch : $flood_limit;
		                //LISTS
		                $whitelist_add = isset($_POST['whitelist_add']) ? trim($_POST['whitelist_add']) : null;
		                $whitelist_rem = isset($_POST['whitelist_rem']) ? $_POST['whitelist_rem'] : array();
		                $whitelist_rem_check = isset($_POST['whitelist_rem_check']) ? $_POST['whitelist_rem_check'] : null;
		                $blacklist_add = isset($_POST['blacklist_add']) ? trim($_POST['blacklist_add']) : null;
		                $blacklist_rem = isset($_POST['blacklist_rem']) ? $_POST['blacklist_rem'] : array();
		                $blacklist_rem_check = isset($_POST['blacklist_rem_check']) ? $_POST['blacklist_rem_check'] : null;
		                $safelist_add = isset($_POST['safelist_add']) ? trim($_POST['safelist_add']) : null;
		                $safelist_rem = isset($_POST['safelist_rem']) ? $_POST['safelist_rem'] : array();
		                $safelist_rem_check = isset($_POST['safelist_rem_check']) ? $_POST['safelist_rem_check'] : null;
		                $customlist_add = isset($_POST['customlist_add']) ? trim($_POST['customlist_add']) : null;
		                $customlist_rem = isset($_POST['customlist_rem']) ? $_POST['customlist_rem'] : array();
		                $customlist_rem_check = isset($_POST['customlist_rem_check']) ? $_POST['customlist_rem_check'] : null;

		                //frame sl_frame_buster
		                $frame_buster = isset($_POST['sl_frame_buster']) ? $_POST['sl_frame_buster'] : null;

		                //set access word if one
		                if($accessword){
	                		$this->set_session('aw:',$accessword);
		                }
		                //country block string
		                $act_country_block = implode('~',$act_country_block);
		                //Disable Cookies
		                $remoteInc = isset($_POST['act_disableCookies']) ? $_POST['act_disableCookies'] : null;

		                //whitelist remove string
		                if($whitelist_rem_check){
		                    $whitelist_rem = implode('~',$whitelist_rem);
		                } else {
		                    $whitelist_rem = null;
		                }
		                //blacklist remove string
		                if($blacklist_rem_check){
		                    $blacklist_rem = implode('~',$blacklist_rem);
		                } else {
		                    $blacklist_rem = null;
		                }
		                //safelist remove string
		                if($safelist_rem_check){
		                    $safelist_rem = implode('^',$safelist_rem);
		                } else {
		                    $safelist_rem = null;
		                }
		                //customlist remove string
		                if($customlist_rem_check){
		                    $customlist_rem = implode('#sl#',$customlist_rem);
		                } else {
		                    $customlist_rem = null;
		                }
		                //email select string
		                $act_emailrpt = implode('~',$act_emailrpt);

						$send_arr = array(
							'act'=>'update_account',
							'host'=>$this->host,
							'fname'=>$fname,
							'lname'=>$lname,
							'email'=>$email,
							'phone'=>$phone,
							'cust404'=>$cust404,
							'remoteInc'=>$remoteInc,
							'tz'=>$tz,
							'wdhours'=>$wdhours,
							'wehours'=>$wehours,
							'email_lvl'=>$act_emailrpt,
							'act_debug'=>$act_debug,
							'contact_email'=>$contact_email,
							'bot_lvl'=>$act_bot_lvl,
							'accessword'=>$accessword,
							'country'=>$act_country_block,
							'whitelist_add'=>$whitelist_add,
							'whitelist_rem'=>$whitelist_rem,
							'blacklist_add'=>$blacklist_add,
							'blacklist_rem'=>$blacklist_rem,
							'safelist_add'=>$safelist_add,
							'safelist_rem'=>$safelist_rem,
							'customlist_add'=>$customlist_add,
							'customlist_rem'=>$customlist_rem,
							'email_thresh'=>$email_thresh,
							'country404'=>$country404,
							'mod_high_crit'=>$mod_high_crit,
							'flood_limit'=>$flood_limit,
							'frame_buster'=>$frame_buster,
							'ip'=>$this->ip);
						$check = $this->sl_post_request('remote4.php',http_build_query($send_arr,'','&'));

		                if($check[0] == 'true'){
	                		$https = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : getenv('HTTPS');
	                		if((is_string($https) && strtolower($https)!='off') ||($https && !is_string($https))){
								$http = 'https';
	                		} else {
								$http = 'http';
	                		}
	                		
	                		//email on access word change
			                if(!empty($accessword) && $accessword != $this->account->accessword){
			                	$_email = empty($this->account->c_email) ? $this->account->r_email : $this->account->c_email;
		                		if(!empty($_email)){
		                			$headers  = "From: \"SecureLive\"<support@securelive.net>\n";
		                			$headers  = "To: \"SecureLive Admistrator\"<".$_email.">\n";
									$headers .= "MIME-Version: 1.0\n";
									$headers .= "Content-Type: text/plain;"; 
									
									$body = "Hello,\r\n\r\n\tYour accessword for your SecureLive account on " . $this->account->domain . " has been updated to:\r\n\r\n\t " . $accessword ."\r\n\r\n\tThis means that to access your CMS administrator pages your will need to enter \"?$accessword\" after the URL. For example, if using Joomla: ".$this->account->domain."/administrator?$accessword or for WordPress: ".$this->account->domain."/wp-admin?$accessword\r\n\r\n\tPlease keep this email for your records.\r\n\r\nSecureLive";
								
									mail($_email, "SecureLive AccessWord Updated", $body, $headers);
								}
							}	
	                		
	                		$this->account = new Account();
		                    #$outputMessage = "REFRESH";
		                } else {
		                    $output .= "<br />We're sorry, but your request could not be processed.  The server returned the following error:<br/>".$check[0]."<br/><br/>\n";
		                }
					} else {
						$output .= "<br />It looks like you are trying to modify your account without being logged into the Administrator area. This is not allowed.<br/><br/>\n";
					}
				}
			}
			
			//Javascripts
			{
	            //explode slider data
	            $temp = explode('~',$this->account->mod_high_crit);
	            $mod_blocking = explode('-',$temp[0]);
	            $high_blocking = explode('-',$temp[1]);
	            $crit_blocking = explode('-',$temp[2]);
	            //tutorial data
	            $temp = explode('~',$this->account->tutorial);
	            $tutorial = intval($temp[0])==1 ? true : false;
	            $tutorial = ($tutorial && (!isset($_COOKIE['sl_tutorial']) || $_COOKIE['sl_tutorial']=='show')) ? true : false;
	            $tcode = $temp[1];
	            $output .= '        <script type="text/javascript">
	            						<!--
		                                function sl_init(){
		                                    email_thresh = new sl_slider("et", 0, 200, '.$this->account->email_thresh.');
		                                    flood_limit = new sl_slider("fl", 3, 203, '.($this->account->flood_limit > 2 ? $this->account->flood_limit : 3).');
		                                    mod_block = new sl_slider("mt", 1, 30, '.$mod_blocking[0].');
		                                    high_block = new sl_slider("ht", 1, 30, '.$high_blocking[0].');
		                                    crit_block = new sl_slider("ct", 1, 30, '.$crit_blocking[0].');
		                                    //sl_cal = new sl_calendar("sl_calendar_holder");
		                                    //initialize_map();
		                                    '.($tutorial ? 'SL_Tutorial.start("'.$tcode.'");' : '').'
		                                }
		                                function sl_limit_filter(elm){
	                                		limit = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	                                		newstr = "";
	                                		oldstr = elm.value;
	                                		for(i=0;i<oldstr.length;i++){
	                                			if(limit.indexOf(oldstr.charAt(i))>-1){newstr += oldstr.charAt(i);}
	                                		}
	                                		elm.value = newstr;
		                                }
		                                //-->
	                                </script>'."\n";
            }
            //ACCOUNT INFO
            {
            	$output .= '<form id="sl_act_update_form" name="sl_act_update_form" action="#" onsubmit="sl_gateway.open(\'overview\',this);return false;" method="post" onreset="setTimeout(\'sl_reset_form()\',0);">';
	            $output .= '        <!-- Adverts -->';
	            $output .= '        <div class="s5_wrap" >';
	            $output .= '            <div class="s5_w_modwrap">';
	            $output .= '                <div class="s5_backmiddlemiddle2">';
	            $output .= $this->ModuleStart("1", "100", "-light", 'Account Information for <span style="font-weight:bold;color:#D9002F;">'.$this->account->domain.'</span>', "advert", TRUE);
	            
	            $output .= '<div id="sl_account_info">
                        <table width="100%">
                        	<tr>
                        		<td><label for="sl_fname">First Name</label>
			                            <input id="sl_fname" name="fname" type="text" value="'.$this->account->fname.'" maxlength="150" class="textfield" /></td>
                        		<td><label for="sl_phone">Phone Number</label>
				                        <input id="sl_phone" name="phone" type="text" value="'.$this->account->phone.'" class="textfield" maxlength="150" /></td>
                        	</tr>
                        	<tr>
                        		<td><label for="sl_lname">Last Name</label>
			                            <input id="sl_lname" name="lname" type="text" value="'.$this->account->lname.'" class="textfield" maxlength="150" /></td>
                        		<td><label for="sl_wdhours">Weekday Hrs.</label>
				                        <input id="sl_wdhours" name="wdhours" type="text" value="'.$this->account->wk_hrs.'" class="textfield" maxlength="150" /></td>
                        	</tr>
                        	<tr>
                        		<td><label for="sl_contact_email">Contact Email</label>
			                            <input id="sl_contact_email" name="contact_email" type="text" value="'.$this->account->c_email.'" class="textfield" maxlength="150" /></td>
                        		<td><label for="sl_wehours">Weekend Hrs.</label>
				                        <input id="sl_wehours" name="wehours" type="text" value="'.$this->account->we_hrs.'" class="textfield" maxlength="150" /></td>
                        	</tr>
                        	<tr>
                        		<td><label for="sl_email">Report Email</label>
			                            <input id="sl_email" name="email" type="text" value="'.$this->account->r_email.'" class="textfield" maxlength="150" /></td>
                        		<td><label for="sl_tz">Time Zone</label>
				                        <div class="ovhidden">
				                            <select id="sl_tz" name="tz" class="selectfield">
				                                <option value="-12" '.($this->account->tz=="-12"?'selected':'').'>(GMT -12:00) Eniwetok, Kwajalein</option>
				                                <option value="-11" '.($this->account->tz=="-11"?'selected':'').'>(GMT -11:00) Midway Island, Samoa</option>
				                                <option value="-10" '.($this->account->tz=="-10"?'selected':'').'>(GMT -10:00) Hawaii</option>
				                                <option value="-9" '.($this->account->tz=="-9"?'selected':'').'>(GMT -9:00) Alaska</option>
				                                <option value="-8" '.($this->account->tz=="-8"?'selected':'').'>(GMT -8:00) Pacific Time (US & Canada)</option>
				                                <option value="-7" '.($this->account->tz=="-7"?'selected':'').'>(GMT -7:00) Mountain Time (US & Canada)</option>
				                                <option value="-6" '.($this->account->tz=="-6"?'selected':'').'>(GMT -6:00) Central Time (US & Canada), Mexico City</option>
				                                <option value="-5" '.($this->account->tz=="-5"?'selected':'').'>(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima</option>
				                                <option value="-4" '.($this->account->tz=="-4"?'selected':'').'>(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
				                                <option value="-3.5" '.($this->account->tz=="-3.5"?'selected':'').'>(GMT -3:30) Newfoundland</option>
				                                <option value="-3" '.($this->account->tz=="-3"?'selected':'').'>(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
				                                <option value="-2" '.($this->account->tz=="-2"?'selected':'').'>(GMT -2:00) Mid-Atlantic</option>
				                                <option value="-1" '.($this->account->tz=="-1"?'selected':'').'>(GMT -1:00 hour) Azores, Cape Verde Islands</option>
				                                <option value="0" '.($this->account->tz=="0"?'selected':'').'>(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
				                                <option value="1" '.($this->account->tz=="1"?'selected':'').'>(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
				                                <option value="2" '.($this->account->tz=="2"?'selected':'').'>(GMT +2:00) Kaliningrad, South Africa</option>
				                                <option value="3" '.($this->account->tz=="3"?'selected':'').'>(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
				                                <option value="3.5" '.($this->account->tz=="3.5"?'selected':'').'>(GMT +3:30) Tehran</option>
				                                <option value="4" '.($this->account->tz=="4"?'selected':'').'>(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
				                                <option value="4.5" '.($this->account->tz=="4.5"?'selected':'').'>(GMT +4:30) Kabul</option>
				                                <option value="5" '.($this->account->tz=="5"?'selected':'').'>(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
				                                <option value="5.5" '.($this->account->tz=="5.5"?'selected':'').'>(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
				                                <option value="5.75" '.($this->account->tz=="5.75"?'selected':'').'>(GMT +5:45) Kathmandu</option>
				                                <option value="6" '.($this->account->tz=="6"?'selected':'').'>(GMT +6:00) Almaty, Dhaka, Colombo</option>
				                                <option value="7" '.($this->account->tz=="7"?'selected':'').'>(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
				                                <option value="8" '.($this->account->tz=="8"?'selected':'').'>(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
				                                <option value="9" '.($this->account->tz=="9"?'selected':'').'>(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
				                                <option value="9.5" '.($this->account->tz=="9.5"?'selected':'').'>(GMT +9:30) Adelaide, Darwin</option>
				                                <option value="10" '.($this->account->tz=="10"?'selected':'').'>(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
				                                <option value="11" '.($this->account->tz=="11"?'selected':'').'>(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
				                                <option value="12" '.($this->account->tz=="12"?'selected':'').'>(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
				                            </select>
				                        </div></td>
                        	</tr>
                        	<tr>
                        		<td colspan="2"><label for="sl_mms">MMS Generator</label>
				                        <div class="ovhidden" style="display:inline-block !important;">
				                            <select id="sl_mms" name="sl_mms" class="selectfield">
				                                <option value="number@aircel.co.in">Aircel - India</option>
				                                <option value="number@airtelap.com">Airtel - Andhra Pradesh, India</option>
				                                <option value="number@airtelkkk.com">Airtel - Karnataka, India</option>
				                                <option value="number@msg.acsalaska.net">Alaska Communications Systems - US</option>
				                                <option value="number@mms.alltel.net">Alltel Wireless - US</option>
				                                <option value="number@text.aql.com">AQL - UK</option>
				                                <option value="number@mms.att.net">AT&T Wireless - US</option>
				                                <option value="number@page.att.net">AT&T Enterprise Paging - US</option>
				                                <option value="number@txt.bell.ca">Bell Mobility & Solo Mobile - CA</option>
				                                <option value="number@boostmobile.com">Boost Mobile - US</option>
				                                <option value="number@mms.bouyguestelecom.fr">Bouygues Telecom - France</option>
				                                <option value="number@bplmobile.com">Loop (BPL Mobile) - Mumbai, India</option>
				                                <option value="number@mobile.celloneusa.com">Cellular One (Dobson) - US</option>
				                                <option value="number@cwemail.com">Centennial Wireless - US</option>
				                                <option value="number@mms.gocbw.com">Cincinnati Bell - US</option>
				                                <option value="number@clarotorpedo.com.br">Claro - Brasil</option>
				                                <option value="number@ideasclaro-ca.com">Claro - Nicaragua</option>
				                                <option value="number@comcel.com.co">Comcel - Colombia</option>
				                                <option value="number@mms.mycricket.com">Cricket</option>
				                                <option value="number@emtelworld.net">Emtel - Mauritius</option>
				                                <option value="number@fido.ca">Fido - CA</option>
				                                <option value="number@smssturen.com">Freebie SMS - Europe</option> <!--message in subject line-->
				                                <option value="number@mobile.gci.net">General Communications Inc. - US</option>
				                                <option value="number@msg.globalstarusa.com">Globalstar (satellite)</option>
				                                <option value="number@myhelio.com">Helio</option>
				                                <option value="number@msg.iridium.com">Iridium</option>
				                                <option value="number.iws@iwspcs.net">i wireless (T-Mobile)</option>
				                                <option value="number@iwirelesshometext.com">i-wireless (Sprint PCS)</option>
				                                <option value="number@msg.telus.com">Koodo Mobile - CA</option>
				                                <option value="977number@sms.spicenepal.com">Mero Mobile - Nepal</option>
				                                <option value="number@mymetropcs.com">MetroPCS</option>
				                                <option value="number@movimensaje.com.ar">Movicom</option>
				                                <option value="number@sms.mobitel.lk">Mobitel - Sri Lanka</option>
				                                <option value="number@movistar.com.co">Movistar - Columbia</option>
				                                <option value="number@sms.co.za">MTN - South Africa</option>
				                                <option value="number@text.mtsmobility.com">MTS Mobility - Canada</option>
				                                <option value="number@messaging.nextel.com">Nextel - US</option>
				                                <option value="number@msgnextel.com.mx">Nextel - Mexico</option>
				                                <option value="TwoWay.11number@nextel.net.ar">Nextel - Argentina</option>
				                                <option value="number@orange.pl">Orange - Poland</option> <!--9digit-->
				                                <option value="number@alertas.personal.com.ar">Personal - Argentina</option>
				                                <option value="+48number@text.plusgsm.pl">Plus - Poland</option>
				                                <option value="number@mobiletxt.ca">PC Telecom - Canada</option>
				                                <option value="number@qwestmp.com">Qwest Wireless - USA</option>
				                                <option value="number@pcs.rogers.com">Rogers Wireless - Canada</option>
				                                <option value="number@sms.sasktel.com">SaskTel - Canada</option>
				                                <option value="297+number@mas.aw">Setar Mobile - Aruba</option>
				                                <option value="number@pm.sprint.com">Sprint (PCS) - USA</option>
				                                <option value="number@messaging.nextel.com">Sprint (Nextel) - USA</option>
				                                <option value="number@tms.suncom.com">Suncom</option>
				                                <option value="number@gsm.sunrise.ch">Sunrise Communications - Switzerland</option>
				                                <option value="number@rinasms.com">Syringa Wireless - USA</option>
				                                <option value="number@tmomail.net">T-Mobile - USA</option> <!--number should start with 1-->
				                                <option value="number@sms.t-mobile.at">T-Mobile - Australia</option>
				                                <option value="385number@sms.t-mobile.hr">T-Mobile - Croatia</option>
				                                <option value="number@msg.telus.com">Telus Mobility - Canada</option>
				                                <option value="number@sms.tigo.com.co">Tigo (Formerly Ola) - Columbia</option>
				                                <option value="number@utext.com">Unicel - USA</option>
				                                <option value="number@mms.uscc.net">US Cellular - USA</option>
				                                <option value="number@vzwpix.com">Verizon - USA</option>
				                                <option value="number@mmsviaero.com">Viaero - USA</option>
				                                <option value="number@torpedoemail.com.br">Vivo - Brasil</option>
				                                <option value="number@vmobile.ca">Virgin Mobile - Canada</option>
				                                <option value="number@vmpix.com">Virgin Mobile - USA</option>
				                                <option value="number@voda.co.za">Vodacom - South Africa</option>
				                            </select>
				                        </div>
				                		<a href="javascript:void(0)" onclick="sl_mms_generator();return false;" style="position:absolute;margin-left:3px;"><img src="'.$this->filepath.'/images/pda2_into.png" border="0" alt="Select your carrier and click here to enter your number" title="Select your carrier and click here to enter your number" /></a>
				                </td>
                        	</tr>
                        </table>
                    </div>'."\n";
	            $output .= $this->EndModule();

	            $output .= '    			</div>'."\n";

	            $output .= '            <div style="clear:both;"></div>'."\n";
	            $output .= '        </div>'."\n";
	            $output .= '    </div>'."\n";
	            $output .= '    <div class="s5_w_modbl"></div>'."\n";
	            $output .= '    <div class="s5_w_modbm"></div>'."\n";
	            $output .= '    <div class="s5_w_modbr"></div>'."\n";
	            $output .= '    <div style="clear:both;"></div>'."\n";
	            $output .= '    <div class="s5_leftshadow" ></div>'."\n";
	            $output .= '    <div class="s5_rightshadow" ></div>'."\n";
	            $output .= '    <!-- End Adverts -->'."\n";
	            $output .= '    <div style="clear:both;"></div>'."\n";
            }
            //EMAIL SELECT
            {
				$output .= '    <!-- Bottom Modules -->'."\n";
                $output .= '        <div class="s5_wrap">'."\n";
                $output .= '            <div class="s5_bblack_tl"></div>'."\n";
                $output .= '            <div class="s5_bblack_tm"></div>'."\n";
                $output .= '            <div class="s5_bblack_tr"></div>'."\n";
                $output .= '            <div style="clear:both;"></div>'."\n";
                $output .= '            <div class="s5_bblack_outter">'."\n";
                $output .= '                <div class="s5_backmiddlemiddle" style="padding-left:8px;">'."\n";
                $output .= '<div style="padding-top:6px;">';
                $output .= $this->ModuleStart("1", "100", "", "E-Mail Report Selection", "user", TRUE);
                $output .= '</div>';

       			$name_arr = array(null,'Shell Attacks','SQL Injection','PHP Injection','XSS Injection','Remote File Includes','Bad Bots','Safe Bots','Country Blocking','Spam Bots','Server Log Pollutants','Nesting Attacks','CMS Attacks','cPanel Attacks','Transversal Attacks','Test Alerts','Administrator Blocking','Duplicate Blocking','Server Attacks','Flood Limit','Post XSS','Plain Text Reports');
       			$val_arr = array(null,'sh','si','pi','xa','fi','bb','sb','cb','se','sp','na','ca','ch','ta','te','ab','db','sa','fl','px','pt');
       			$output .= '<table width="100%">';
       			for($i=1;$i<count($val_arr);$i++){
       				$name = $name_arr[$i];
       				$value = $val_arr[$i];
       				if(substr_count($this->account->email_select, $value)){
						$class = 'checked';
       					$checked = 'checked="checked"';
       				} else {
						$class = 'unchecked';
       					$checked = '';
       				}
       				//calculate rows
       				if($i%5==1){
						$output .= '<tr>';
       				}
       				$output .= "<td><label style=\"position:absolute;margin-top:0px;\" onclick=\"setTimeout('reset_chkbox_imgs($i)',0)\" id=\"for_e$i\" for=\"e$i\" class=\"$class\"><span style=\"margin-left: 20px; top: 0px;\">$name</span></label><input type=\"checkbox\" name=\"email_lvl[]\" id=\"e$i\" value=\"$value\" $checked/></td>";
       				if($i%5==0){
						$output .= '</tr>';
       				}
       			}
       			$output .= '</table><br/>';
       			

	            $output .= $this->EndModule();
	            $output .= '                        <div style="clear:both;"></div>'."\n";
	            $output .= '                    </div>'."\n";
	            $output .= '                </div>'."\n";
	            $output .= '                <div class="s5_bblack_bl"></div>'."\n";
	            $output .= '                <div class="s5_bblack_bm"></div>'."\n";
	            $output .= '                <div class="s5_bblack_br"></div>'."\n";
	            $output .= '                <div style="clear:both;"></div>'."\n";
	            $output .= '                <div class="s5_leftshadow"></div>'."\n";
	            $output .= '                <div class="s5_rightshadow"></div>'."\n";
	            $output .= '            </div>'."\n";
	            $output .= '            <!-- End Bottom Modules -->'."\n";
	            $output .= '            <div style="clear:both;"></div>'."\n";
            }
            //SLIDERS
            {
				$output .= '        <!-- Adverts -->';
	            $output .= '        <div class="s5_wrap" >';
	            $output .= '            <div class="s5_w_modwrap">';
	            $output .= '                <div class="s5_backmiddlemiddle2">';
	            $output .= $this->ModuleStart("1", "100", "", "Basic Preferences", "advert", TRUE);

	            $output .= '<table width="100%">
								<tr>
									<td colspan="2">
	            						<div style="width:100%;">
											These settings allow you to control some basic preferences in the way SecureLive blocks hacking attempts. The Email Threshold will disable attack reporting unless the attack Threat Level is as high as the Email Threshold.
	            						</div>
	            						<div style="clear: both;"></div>
	            					</td>
								</tr>
	            				<tr>
	            					<td style="padding-left: 5px;">
	            						<div style="text-align:left; width: 333px">
	            							<br/>
	            							<div style="width:100%;">
				                                <span style="float:left;">Email Threshold (threat level must be this high to report):</span><br/>
				                                <div style="position: relative;width:auto;">
				                                    <input name="email_thresh" id="et_slider_val" type="text" value="'.$this->account->email_thresh.'" style="width:30px;font-size:13px;position:absolute;top:3px;" />
				                                    <div id="et_slider_holder" class="sl_slider_holder">
				                                        <div id="et_slider" class="sl_slider" style="left:-5px;"></div>
				                                    </div>
				                                </div>
				                            </div>
				                            <br/>
				                            <div style="width:100%;">
				                                <span style="float:left;">Flood Limit (max pages per second per visitor):</span><br/>
				                                <div style="position: relative;float:left;width:auto;">
				                                    <input name="flood_limit" id="fl_slider_val" type="text" value="'.($this->account->flood_limit > 2 ? $this->account->flood_limit : 3).'" style="width:30px;font-size:13px;position:absolute;top:3px;" />
				                                    <div id="fl_slider_holder" class="sl_slider_holder">
				                                        <div id="fl_slider" class="sl_slider" style="left:-5px;"></div>
				                                    </div>
				                                </div>
				                                <select id="flood_switch" name="flood_switch">
				                                    <option value="x" '.($this->account->flood_limit > 2 ? 'selected="selected"' : '').'>On</option>
				                                    <option value="-1" '.($this->account->flood_limit== -1 ? 'selected="selected"' : '').'>Off</option>
				                                </select>
				                            </div>
	            						</div>
	            					</td>
	            					<td style="padding-left: 5px;">
	            						<div style="text-align:left;width:100%;">
	            							<div style="width:100%;">
				                                <span style="float:left;">Moderate Threat Ban Time:</span><br/>
				                                <div style="position: relative;float:left;width:auto;">
				                                    <input name="mod_int" id="mt_slider_val" type="text" value="'.$mod_blocking[0].'" style="width:30px;font-size:13px;position:absolute;top:3px;" />
				                                    <div id="mt_slider_holder" class="sl_slider_holder">
				                                        <div id="mt_slider" class="sl_slider" style="left:-5px;"></div>
				                                    </div>
				                                </div>
				                                <select id="mod_mod" name="mod_mod">
				                                    <option value="h" '.($mod_blocking[1]=='h' ? 'selected="selected"' : '').'>Hours</option>
				                                    <option value="d" '.($mod_blocking[1]=='d' ? 'selected="selected"' : '').'>Days</option>
				                                    <option value="m" '.($mod_blocking[1]=='m' ? 'selected="selected"' : '').'>Months</option>
				                                    <option value="y" '.($mod_blocking[1]=='y' ? 'selected="selected"' : '').'>Years</option>
				                                </select>
				                            </div>
				                            <br/>
				                            <div style="width:100%;">
				                                <span style="float:left;">High Threat Ban Time:</span><br/>
				                                <div style="position: relative;float:left;width:auto;">
				                                    <input name="high_int" id="ht_slider_val" type="text" value="'.$high_blocking[0].'" style="width:30px;font-size:13px;position:absolute;top:3px;" />
				                                    <div id="ht_slider_holder" class="sl_slider_holder">
				                                        <div id="ht_slider" class="sl_slider" style="left:-5px;"></div>
				                                    </div>
				                                </div>
				                                <select id="high_mod" name="high_mod">
				                                    <option value="h" '.($high_blocking[1]=='h' ? 'selected="selected"' : '').'>Hours</option>
				                                    <option value="d" '.($high_blocking[1]=='d' ? 'selected="selected"' : '').'>Days</option>
				                                    <option value="m" '.($high_blocking[1]=='m' ? 'selected="selected"' : '').'>Months</option>
				                                    <option value="y" '.($high_blocking[1]=='y' ? 'selected="selected"' : '').'>Years</option>
				                                </select>
				                            </div>
				                            <br/>
				                            <div style="width:100%;">
				                                <span style="float:left;">Critical Threat Ban Time:</span><br/>
				                                <div style="position: relative;float:left;width:auto;">
				                                    <input name="crit_int" id="ct_slider_val" type="text" value="'.$crit_blocking[0].'" style="width:30px;font-size:13px;position:absolute;top:3px;" />
				                                    <div id="ct_slider_holder" class="sl_slider_holder">
				                                        <div id="ct_slider" class="sl_slider" style="left:-5px;"></div>
				                                    </div>
				                                </div>
				                                <select id="crit_mod" name="crit_mod">
				                                    <option value="h" '.($crit_blocking[1]=='h' ? 'selected="selected"' : '').'>Hours</option>
				                                    <option value="d" '.($crit_blocking[1]=='d' ? 'selected="selected"' : '').'>Days</option>
				                                    <option value="m" '.($crit_blocking[1]=='m' ? 'selected="selected"' : '').'>Months</option>
				                                    <option value="y" '.($crit_blocking[1]=='y' ? 'selected="selected"' : '').'>Years</option>
				                                </select>
				                            </div>
	            						</div>
	            					</td>
	            				</tr>
	            				</table>'."\n";
	            $output .= $this->EndModule();
	            $output .= '            <div style="clear:both;"></div>'."\n";
	            $output .= '        </div>'."\n";
	            $output .= '    </div>'."\n";
	            $output .= '    <div class="s5_w_modbl"></div>'."\n";
	            $output .= '    <div class="s5_w_modbm"></div>'."\n";
	            $output .= '    <div class="s5_w_modbr"></div>'."\n";
	            $output .= '    <div style="clear:both;"></div>'."\n";
	            $output .= '    <div class="s5_leftshadow" ></div>'."\n";
	            $output .= '    <div class="s5_rightshadow" ></div>'."\n";
	            $output .= '    <!-- End Adverts -->'."\n";
	            $output .= '    </div>'."\n";
	            $output .= '    <div style="clear:both;"></div>'."\n";
            }
            //PROGRAM SETTINGS AND COUNTRY BLOCK
            {
				$output .= '    <!-- Bottom Modules -->'."\n";
	            $output .= '        <div class="s5_wrap">'."\n";
	            $output .= '            <div class="s5_bblack_tl"></div>'."\n";
	            $output .= '            <div class="s5_bblack_tm"></div>'."\n";
	            $output .= '            <div class="s5_bblack_tr"></div>'."\n";
	            $output .= '            <div style="clear:both;"></div>'."\n";
	            $output .= '            <div class="s5_bblack_outter">'."\n";
	            $output .= '                <div class="s5_backmiddlemiddle" style="padding-left:8px;">'."\n";
	            $output .= $this->ModuleStart("1", "50", "", "Program Settings", "user", TRUE);

	                $ver_msg = $this->versionMessage ? $this->versionMessage : $this->getVersionMessage();

	                $output .= '<fieldset>'."\n";
	                $output .= 'Your version of SecureLive is -'.$ver_msg.'<br />'."\n";
	                if($this->account->email_select==1 || $this->account->email_select==2 || $this->account->email_select==3 || $this->account->email_select==4 || $this->account->email_select==5){
	                    $output .=  'Current level:<br/>
	                                    <select id="sl_email_lvl" class="selectfield" disabled>
	                                        <option value="1" '.($this->account->email_select=="1"?'selected':'').'>1: Receive all E-Mails</option>
	                                        <option value="2" '.($this->account->email_select=="2"?'selected':'').'>2: All E-Mails except BotHost</option>
	                                        <option value="3" '.($this->account->email_select=="3"?'selected':'').'>3: Remote File, Transversal, SQL, Server Attacks Only</option>
	                                        <option value="4" '.($this->account->email_select=="4"?'selected':'').'>4: Remote File Includes Only</option>
	                                        <option value="5" '.($this->account->email_select=="5"?'selected':'').'>5: E-Mail reporting disabled</option>
	                                    </select><br />'."\n";
	                }
	                $output .= '<br />
	                            <label for="sl_bot_lvl">Bad Bots Are...&nbsp;</label>
	                            <div class="smovhidden">
	                                <select id="sl_bot_lvl" name="bot_lvl" class="selectfield" onchange="sl_bot_alert(this.value)">
	                                	<option value="0" '.($this->account->bot_lvl=="0"||!$this->account->bot_lvl||$this->account->bot_lvl=='3'?'selected':'').'>0: Bots with Hack (block malicous bots)</option>
	                                  	<option value="1" '.($this->account->bot_lvl=="1"?'selected':'').'>1: No Bots (allow all)</option>
	                                  	<option value="2" '.($this->account->bot_lvl=="2"?'selected':'').'>2: All Bots (block all)</option>
	                                </select>
	                            </div>
	                            <br />
	                            <label for="sl_bot_ban">Ban Bad Bots?&nbsp;</label>
	                            <div class="smovhidden">
	                                <select id="sl_bot_ban" name="bot_ban" class="selectfield" onchange="sl_bot_alert(this.value)">
	                                  <option value="0" '.($this->account->bot_lvl!="3"||!$this->account->bot_lvl||!$this->account->bot_lvl=='0'?'selected':'').'>Never</option>
	                                  <option value="3" '.($this->account->bot_lvl=="3"?'selected':'').'>Always</option>
	                                </select>
	                            </div>
	                            <br />
	                            <label for="sl_cust404">404 Page<sup style="color: #ff0000; font-weight: bold;">*</sup> </label>
	                            <input id="sl_cust404" name="cust404" type="text" value="'.$this->account->cust_404.'" size="30" maxlength="150" class="textfield" /><br />
	                            <label for="sl_memo_pass">Access Word<sup style="color: #ff0000; font-weight: bold;">**</sup></label>
	                            <input id="sl_memo_pass" name="memo_pass" type="text" value="'.$this->account->accessword.'" size="30" maxlength="20" class="textfield" onkeyup="sl_limit_filter(this)" /><br />
	                            <label for="sl_frame_buster">Frame Buster<sup style="color: #ff0000; font-weight: bold;">***</sup> </label>
	                            <div class="smovhidden">
	                                <select id="sl_frame_buster" name="sl_frame_buster" class="selectfield">
	                                    <option value="1" '.($this->account->frame_buster==1?'selected':'').'>On</option>
	                                    <option value="0" '.($this->account->frame_buster==0?'selected':'').'>Off</option>
	                                </select><br />
	                            </div>
	                            <br/>
	                            <label for="sl_act_debug">Debug Mode<a href="#"><sup style="color: #0F9800; font-weight: bold;">? </sup></a></label>
	                            <div class="smovhidden">
	                                <select id="sl_act_debug" name="act_debug" class="selectfield" onchange="sl_bot_alert(\'debug\'+this.value)">
	                                    <option value="1" '.($this->account->debug=="1"?'selected':'').'>On</option>
	                                    <option value="0" '.($this->account->debug=="0"?'selected':'').'>Off</option>
	                                </select><br />
	                            </div>
	                            <br/>
	                            <label for="sl_act_debug">Disable Cookies<a href="#"><sup style="color: #0F9800; font-weight: bold;">? </sup></a></label>
	                            <div class="smovhidden">
	                                <select id="sl_act_disableCookies" name="act_disableCookies" class="selectfield" onchange="">
	                                    <option value="1" '.($this->account->rfi_visible=="1"?'selected':'').'>On</option>
	                                    <option value="0" '.($this->account->rfi_visible=="0"?'selected':'').'>Off</option>
	                                </select><br />
	                            </div>
	                        </fieldset>'."\n";

	                $output .= $this->EndModule();
	                $output .= $this->ModuleStart("2", "50", "", "Block by Country", "user", TRUE);
	                $output .= '<div id="sl_country_select">
	                Select the countries you wish to block from your website (you must submit the form for this to take effect).<br/>
	                Hold the CTRL button to select multiple countries.<br/><br />
	                <select multiple="multiple" size="10" style="width:250px; margin:0px 0 0px 0;" id="sl_countries" name="country[]">
	                    <option value="A1"'.(substr_count($this->account->country_list,'A1')?' selected':'').'>Anonymous Proxy</option>
	                    <option value="A2"'.(substr_count($this->account->country_list,'A2')?' selected':'').'>Satellite Provider</option>
	                    <option value="AD"'.(substr_count($this->account->country_list,'AD')?' selected':'').'>Andorra</option>
	                    <option value="AE"'.(substr_count($this->account->country_list,'AE')?' selected':'').'>United Arab Emirates</option>
	                    <option value="AF"'.(substr_count($this->account->country_list,'AF')?' selected':'').'>Afghanistan</option>
	                    <option value="AG"'.(substr_count($this->account->country_list,'AG')?' selected':'').'>Antigua and Barbuda</option>
	                    <option value="AI"'.(substr_count($this->account->country_list,'AI')?' selected':'').'>Anguilla</option>
	                    <option value="AL"'.(substr_count($this->account->country_list,'AL')?' selected':'').'>Albania</option>
	                    <option value="AM"'.(substr_count($this->account->country_list,'AM')?' selected':'').'>Armenia</option>
	                    <option value="AN"'.(substr_count($this->account->country_list,'AN')?' selected':'').'>Netherlands Antilles</option>
	                    <option value="AO"'.(substr_count($this->account->country_list,'AO')?' selected':'').'>Angola</option>
	                    <option value="AP"'.(substr_count($this->account->country_list,'AP')?' selected':'').'>Asia/Pacific Region</option>
	                    <option value="AQ"'.(substr_count($this->account->country_list,'AQ')?' selected':'').'>Antarctica</option>
	                    <option value="AR"'.(substr_count($this->account->country_list,'AR')?' selected':'').'>Argentina</option>
	                    <option value="AS"'.(substr_count($this->account->country_list,'AS')?' selected':'').'>American Samoa</option>
	                    <option value="AT"'.(substr_count($this->account->country_list,'AT')?' selected':'').'>Austria</option>
	                    <option value="AU"'.(substr_count($this->account->country_list,'AU')?' selected':'').'>Australia</option>
	                    <option value="AW"'.(substr_count($this->account->country_list,'AW')?' selected':'').'>Aruba</option>
	                    <option value="AX"'.(substr_count($this->account->country_list,'AX')?' selected':'').'>Aland Islands</option>
	                    <option value="AZ"'.(substr_count($this->account->country_list,'AZ')?' selected':'').'>Azerbaijan</option>
	                    <option value="BA"'.(substr_count($this->account->country_list,'BA')?' selected':'').'>Bosnia and Herzegovina</option>
	                    <option value="BB"'.(substr_count($this->account->country_list,'BB')?' selected':'').'>Barbados</option>
	                    <option value="BD"'.(substr_count($this->account->country_list,'BD')?' selected':'').'>Bangladesh</option>
	                    <option value="BE"'.(substr_count($this->account->country_list,'BE')?' selected':'').'>Belgium</option>
	                    <option value="BF"'.(substr_count($this->account->country_list,'BF')?' selected':'').'>Burkina Faso</option>
	                    <option value="BG"'.(substr_count($this->account->country_list,'BG')?' selected':'').'>Bulgaria</option>
	                    <option value="BH"'.(substr_count($this->account->country_list,'BH')?' selected':'').'>Bahrain</option>
	                    <option value="BI"'.(substr_count($this->account->country_list,'BI')?' selected':'').'>Burundi</option>
	                    <option value="BJ"'.(substr_count($this->account->country_list,'BJ')?' selected':'').'>Benin</option>
	                    <option value="BM"'.(substr_count($this->account->country_list,'BM')?' selected':'').'>Bermuda</option>
	                    <option value="BN"'.(substr_count($this->account->country_list,'BN')?' selected':'').'>Brunei Darussalam</option>
	                    <option value="BO"'.(substr_count($this->account->country_list,'BO')?' selected':'').'>Bolivia</option>
	                    <option value="BR"'.(substr_count($this->account->country_list,'BR')?' selected':'').'>Brazil</option>
	                    <option value="BS"'.(substr_count($this->account->country_list,'BS')?' selected':'').'>Bahamas</option>
	                    <option value="BT"'.(substr_count($this->account->country_list,'BT')?' selected':'').'>Bhutan</option>
	                    <option value="BV"'.(substr_count($this->account->country_list,'BV')?' selected':'').'>Bouvet Island</option>
	                    <option value="BW"'.(substr_count($this->account->country_list,'BW')?' selected':'').'>Botswana</option>
	                    <option value="BY"'.(substr_count($this->account->country_list,'BY')?' selected':'').'>Belarus</option>
	                    <option value="BZ"'.(substr_count($this->account->country_list,'BZ')?' selected':'').'>Belize</option>
	                    <option value="CA"'.(substr_count($this->account->country_list,'CA')?' selected':'').'>Canada</option>
	                    <option value="CC"'.(substr_count($this->account->country_list,'CC')?' selected':'').'>Cocos (Keeling) Islands</option>
	                    <option value="CD"'.(substr_count($this->account->country_list,'CD')?' selected':'').'>Congo, Democratic Republic</option>
	                    <option value="CF"'.(substr_count($this->account->country_list,'CF')?' selected':'').'>Central African Republic</option>
	                    <option value="CG"'.(substr_count($this->account->country_list,'CG')?' selected':'').'>Congo</option>
	                    <option value="CH"'.(substr_count($this->account->country_list,'CH')?' selected':'').'>Switzerland</option>
	                    <option value="CI"'.(substr_count($this->account->country_list,'CI')?' selected':'').'>Cote d Ivoire</option>
	                    <option value="CK"'.(substr_count($this->account->country_list,'CK')?' selected':'').'>Cook Islands</option>
	                    <option value="CL"'.(substr_count($this->account->country_list,'CL')?' selected':'').'>Chile</option>
	                    <option value="CM"'.(substr_count($this->account->country_list,'CM')?' selected':'').'>Cameroon</option>
	                    <option value="CN"'.(substr_count($this->account->country_list,'CN')?' selected':'').'>China</option>
	                    <option value="CO"'.(substr_count($this->account->country_list,'CO')?' selected':'').'>Colombia</option>
	                    <option value="CR"'.(substr_count($this->account->country_list,'CR')?' selected':'').'>Costa Rica</option>
	                    <option value="CU"'.(substr_count($this->account->country_list,'CU')?' selected':'').'>Cuba</option>
	                    <option value="CV"'.(substr_count($this->account->country_list,'CV')?' selected':'').'>Cape Verde</option>
	                    <option value="CX"'.(substr_count($this->account->country_list,'CX')?' selected':'').'>Christmas Island</option>
	                    <option value="CY"'.(substr_count($this->account->country_list,'CY')?' selected':'').'>Cyprus</option>
	                    <option value="CZ"'.(substr_count($this->account->country_list,'CZ')?' selected':'').'>Czech Republic</option>
	                    <option value="DE"'.(substr_count($this->account->country_list,'DE')?' selected':'').'>Germany</option>
	                    <option value="DJ"'.(substr_count($this->account->country_list,'DJ')?' selected':'').'>Djibouti</option>
	                    <option value="DK"'.(substr_count($this->account->country_list,'DK')?' selected':'').'>Denmark</option>
	                    <option value="DM"'.(substr_count($this->account->country_list,'DM')?' selected':'').'>Dominica</option>
	                    <option value="DO"'.(substr_count($this->account->country_list,'DO')?' selected':'').'>Dominican Republic</option>
	                    <option value="DZ"'.(substr_count($this->account->country_list,'DZ')?' selected':'').'>Algeria</option>
	                    <option value="EC"'.(substr_count($this->account->country_list,'EC')?' selected':'').'>Ecuador</option>
	                    <option value="EE"'.(substr_count($this->account->country_list,'EE')?' selected':'').'>Estonia</option>
	                    <option value="EG"'.(substr_count($this->account->country_list,'EG')?' selected':'').'>Egypt</option>
	                    <option value="EH"'.(substr_count($this->account->country_list,'EH')?' selected':'').'>Western Sahara</option>
	                    <option value="ER"'.(substr_count($this->account->country_list,'ER')?' selected':'').'>Eritrea</option>
	                    <option value="ES"'.(substr_count($this->account->country_list,'ES')?' selected':'').'>Spain</option>
	                    <option value="ET"'.(substr_count($this->account->country_list,'ET')?' selected':'').'>Ethiopia</option>
	                    <option value="EU"'.(substr_count($this->account->country_list,'EU')?' selected':'').'>Europe</option>
	                    <option value="FI"'.(substr_count($this->account->country_list,'FI')?' selected':'').'>Finland</option>
	                    <option value="FJ"'.(substr_count($this->account->country_list,'FJ')?' selected':'').'>Fiji</option>
	                    <option value="FK"'.(substr_count($this->account->country_list,'FK')?' selected':'').'>Falkland Islands (Malvinas)</option>
	                    <option value="FM"'.(substr_count($this->account->country_list,'FM')?' selected':'').'>Micronesia, Federated States</option>
	                    <option value="FO"'.(substr_count($this->account->country_list,'FO')?' selected':'').'>Faroe Islands</option>
	                    <option value="FR"'.(substr_count($this->account->country_list,'FR')?' selected':'').'>France</option>
	                    <option value="GA"'.(substr_count($this->account->country_list,'GA')?' selected':'').'>Gabon</option>
	                    <option value="GB"'.(substr_count($this->account->country_list,'GB')?' selected':'').'>United Kingdom</option>
	                    <option value="GD"'.(substr_count($this->account->country_list,'GD')?' selected':'').'>Grenada</option>
	                    <option value="GE"'.(substr_count($this->account->country_list,'GE')?' selected':'').'>Georgia</option>
	                    <option value="GF"'.(substr_count($this->account->country_list,'GF')?' selected':'').'>French Guiana</option>
	                    <option value="GG"'.(substr_count($this->account->country_list,'GG')?' selected':'').'>Guernsey</option>
	                    <option value="GH"'.(substr_count($this->account->country_list,'GH')?' selected':'').'>Ghana</option>
	                    <option value="GI"'.(substr_count($this->account->country_list,'GI')?' selected':'').'>Gibraltar</option>
	                    <option value="GL"'.(substr_count($this->account->country_list,'GL')?' selected':'').'>Greenland</option>
	                    <option value="GM"'.(substr_count($this->account->country_list,'GM')?' selected':'').'>Gambia</option>
	                    <option value="GN"'.(substr_count($this->account->country_list,'GN')?' selected':'').'>Guinea</option>
	                    <option value="GP"'.(substr_count($this->account->country_list,'GP')?' selected':'').'>Guadeloupe</option>
	                    <option value="GQ"'.(substr_count($this->account->country_list,'GQ')?' selected':'').'>Equatorial Guinea</option>
	                    <option value="GR"'.(substr_count($this->account->country_list,'GR')?' selected':'').'>Greece</option>
	                    <option value="GS"'.(substr_count($this->account->country_list,'GS')?' selected':'').'>South Georgia and Sandwich Islands</option>
	                    <option value="GT"'.(substr_count($this->account->country_list,'GT')?' selected':'').'>Guatemala</option>
	                    <option value="GU"'.(substr_count($this->account->country_list,'GU')?' selected':'').'>Guam</option>
	                    <option value="GW"'.(substr_count($this->account->country_list,'GW')?' selected':'').'>Guinea-Bissau</option>
	                    <option value="GY"'.(substr_count($this->account->country_list,'GY')?' selected':'').'>Guyana</option>
	                    <option value="HK"'.(substr_count($this->account->country_list,'HK')?' selected':'').'>Hong Kong</option>
	                    <option value="HM"'.(substr_count($this->account->country_list,'HM')?' selected':'').'>Heard Island and McDonald Islands</option>
	                    <option value="HN"'.(substr_count($this->account->country_list,'HN')?' selected':'').'>Honduras</option>
	                    <option value="HR"'.(substr_count($this->account->country_list,'HR')?' selected':'').'>Croatia</option>
	                    <option value="HT"'.(substr_count($this->account->country_list,'HT')?' selected':'').'>Haiti</option>
	                    <option value="HU"'.(substr_count($this->account->country_list,'HU')?' selected':'').'>Hungary</option>
	                    <option value="ID"'.(substr_count($this->account->country_list,'ID')?' selected':'').'>Indonesia</option>
	                    <option value="IE"'.(substr_count($this->account->country_list,'IE')?' selected':'').'>Ireland</option>
	                    <option value="IL"'.(substr_count($this->account->country_list,'IL')?' selected':'').'>Israel</option>
	                    <option value="IM"'.(substr_count($this->account->country_list,'IM')?' selected':'').'>Isle of Man</option>
	                    <option value="IN"'.(substr_count($this->account->country_list,'IN')?' selected':'').'>India</option>
	                    <option value="IO"'.(substr_count($this->account->country_list,'IO')?' selected':'').'>British Indian Ocean Territory</option>
	                    <option value="IQ"'.(substr_count($this->account->country_list,'IQ')?' selected':'').'>Iraq</option>
	                    <option value="IR"'.(substr_count($this->account->country_list,'IR')?' selected':'').'>Iran, Islamic Republic of</option>
	                    <option value="IS"'.(substr_count($this->account->country_list,'IS')?' selected':'').'>Iceland</option>
	                    <option value="IT"'.(substr_count($this->account->country_list,'IT')?' selected':'').'>Italy</option>
	                    <option value="JE"'.(substr_count($this->account->country_list,'JE')?' selected':'').'>Jersey</option>
	                    <option value="JM"'.(substr_count($this->account->country_list,'JM')?' selected':'').'>Jamaica</option>
	                    <option value="JO"'.(substr_count($this->account->country_list,'JO')?' selected':'').'>Jordan</option>
	                    <option value="JP"'.(substr_count($this->account->country_list,'JP')?' selected':'').'>Japan</option>
	                    <option value="KE"'.(substr_count($this->account->country_list,'KE')?' selected':'').'>Kenya</option>
	                    <option value="KG"'.(substr_count($this->account->country_list,'KG')?' selected':'').'>Kyrgyzstan</option>
	                    <option value="KH"'.(substr_count($this->account->country_list,'KH')?' selected':'').'>Cambodia</option>
	                    <option value="KI"'.(substr_count($this->account->country_list,'KI')?' selected':'').'>Kiribati</option>
	                    <option value="KM"'.(substr_count($this->account->country_list,'KM')?' selected':'').'>Comoros</option>
	                    <option value="KN"'.(substr_count($this->account->country_list,'KN')?' selected':'').'>Saint Kitts and Nevis</option>
	                    <option value="KP"'.(substr_count($this->account->country_list,'KP')?' selected':'').'>Korea, Democratic S. Republic of</option>
	                    <option value="KR"'.(substr_count($this->account->country_list,'KR')?' selected':'').'>Korea, Republic of</option>
	                    <option value="KW"'.(substr_count($this->account->country_list,'KW')?' selected':'').'>Kuwait</option>
	                    <option value="KY"'.(substr_count($this->account->country_list,'KY')?' selected':'').'>Cayman Islands</option>
	                    <option value="KZ"'.(substr_count($this->account->country_list,'KZ')?' selected':'').'>Kazakhstan</option>
	                    <option value="LA"'.(substr_count($this->account->country_list,'LA')?' selected':'').'>Lao S. Democratic Republic</option>
	                    <option value="LB"'.(substr_count($this->account->country_list,'LB')?' selected':'').'>Lebanon</option>
	                    <option value="LC"'.(substr_count($this->account->country_list,'LC')?' selected':'').'>Saint Lucia</option>
	                    <option value="LI"'.(substr_count($this->account->country_list,'LI')?' selected':'').'>Liechtenstein</option>
	                    <option value="LK"'.(substr_count($this->account->country_list,'LK')?' selected':'').'>Sri Lanka</option>
	                    <option value="LR"'.(substr_count($this->account->country_list,'LR')?' selected':'').'>Liberia</option>
	                    <option value="LS"'.(substr_count($this->account->country_list,'LS')?' selected':'').'>Lesotho</option>
	                    <option value="LT"'.(substr_count($this->account->country_list,'LT')?' selected':'').'>Lithuania</option>
	                    <option value="LU"'.(substr_count($this->account->country_list,'LU')?' selected':'').'>Luxembourg</option>
	                    <option value="LV"'.(substr_count($this->account->country_list,'LV')?' selected':'').'>Latvia</option>
	                    <option value="LY"'.(substr_count($this->account->country_list,'LY')?' selected':'').'>Libyan Arab Jamahiriya</option>
	                    <option value="MA"'.(substr_count($this->account->country_list,'MA')?' selected':'').'>Morocco</option>
	                    <option value="MC"'.(substr_count($this->account->country_list,'MC')?' selected':'').'>Monaco</option>
	                    <option value="MD"'.(substr_count($this->account->country_list,'MD')?' selected':'').'>Moldova, Republic of</option>
	                    <option value="ME"'.(substr_count($this->account->country_list,'ME')?' selected':'').'>Montenegro</option>
	                    <option value="MG"'.(substr_count($this->account->country_list,'MG')?' selected':'').'>Madagascar</option>
	                    <option value="MH"'.(substr_count($this->account->country_list,'MH')?' selected':'').'>Marshall Islands</option>
	                    <option value="MK"'.(substr_count($this->account->country_list,'MK')?' selected':'').'>Macedonia</option>
	                    <option value="ML"'.(substr_count($this->account->country_list,'ML')?' selected':'').'>Mali</option>
	                    <option value="MM"'.(substr_count($this->account->country_list,'MM')?' selected':'').'>Myanmar</option>
	                    <option value="MN"'.(substr_count($this->account->country_list,'MN')?' selected':'').'>Mongolia</option>
	                    <option value="MO"'.(substr_count($this->account->country_list,'MO')?' selected':'').'>Macao</option>
	                    <option value="MP"'.(substr_count($this->account->country_list,'MP')?' selected':'').'>Northern Mariana Islands</option>
	                    <option value="MQ"'.(substr_count($this->account->country_list,'MQ')?' selected':'').'>Martinique</option>
	                    <option value="MR"'.(substr_count($this->account->country_list,'MR')?' selected':'').'>Mauritania</option>
	                    <option value="MS"'.(substr_count($this->account->country_list,'MS')?' selected':'').'>Montserrat</option>
	                    <option value="MT"'.(substr_count($this->account->country_list,'MT')?' selected':'').'>Malta</option>
	                    <option value="MU"'.(substr_count($this->account->country_list,'MU')?' selected':'').'>Mauritius</option>
	                    <option value="MV"'.(substr_count($this->account->country_list,'MV')?' selected':'').'>Maldives</option>
	                    <option value="MW"'.(substr_count($this->account->country_list,'MW')?' selected':'').'>Malawi</option>
	                    <option value="MX"'.(substr_count($this->account->country_list,'MX')?' selected':'').'>Mexico</option>
	                    <option value="MY"'.(substr_count($this->account->country_list,'MY')?' selected':'').'>Malaysia</option>
	                    <option value="MZ"'.(substr_count($this->account->country_list,'MZ')?' selected':'').'>Mozambique</option>
	                    <option value="NA"'.(substr_count($this->account->country_list,'NA')?' selected':'').'>Namibia</option>
	                    <option value="NC"'.(substr_count($this->account->country_list,'NC')?' selected':'').'>New Caledonia</option>
	                    <option value="NE"'.(substr_count($this->account->country_list,'NE')?' selected':'').'>Niger</option>
	                    <option value="NF"'.(substr_count($this->account->country_list,'NF')?' selected':'').'>Norfolk Island</option>
	                    <option value="NG"'.(substr_count($this->account->country_list,'NG')?' selected':'').'>Nigeria</option>
	                    <option value="NI"'.(substr_count($this->account->country_list,'NI')?' selected':'').'>Nicaragua</option>
	                    <option value="NL"'.(substr_count($this->account->country_list,'NL')?' selected':'').'>Netherlands</option>
	                    <option value="NO"'.(substr_count($this->account->country_list,'NO')?' selected':'').'>Norway</option>
	                    <option value="NP"'.(substr_count($this->account->country_list,'NP')?' selected':'').'>Nepal</option>
	                    <option value="NR"'.(substr_count($this->account->country_list,'NR')?' selected':'').'>Nauru</option>
	                    <option value="NU"'.(substr_count($this->account->country_list,'NU')?' selected':'').'>Niue</option>
	                    <option value="NZ"'.(substr_count($this->account->country_list,'NZ')?' selected':'').'>New Zealand</option>
	                    <option value="OM"'.(substr_count($this->account->country_list,'OM')?' selected':'').'>Oman</option>
	                    <option value="PA"'.(substr_count($this->account->country_list,'PA')?' selected':'').'>Panama</option>
	                    <option value="PE"'.(substr_count($this->account->country_list,'PE')?' selected':'').'>Peru</option>
	                    <option value="PF"'.(substr_count($this->account->country_list,'PF')?' selected':'').'>French Polynesia</option>
	                    <option value="PG"'.(substr_count($this->account->country_list,'PG')?' selected':'').'>Papua New Guinea</option>
	                    <option value="PH"'.(substr_count($this->account->country_list,'PH')?' selected':'').'>Philippines</option>
	                    <option value="PK"'.(substr_count($this->account->country_list,'PK')?' selected':'').'>Pakistan</option>
	                    <option value="PL"'.(substr_count($this->account->country_list,'PL')?' selected':'').'>Poland</option>
	                    <option value="PM"'.(substr_count($this->account->country_list,'PM')?' selected':'').'>Saint Pierre and Miquelon</option>
	                    <option value="PN"'.(substr_count($this->account->country_list,'PN')?' selected':'').'>Pitcairn</option>
	                    <option value="PR"'.(substr_count($this->account->country_list,'PR')?' selected':'').'>Puerto Rico</option>
	                    <option value="PS"'.(substr_count($this->account->country_list,'PS')?' selected':'').'>Palestinian Territory</option>
	                    <option value="PT"'.(substr_count($this->account->country_list,'PT')?' selected':'').'>Portugal</option>
	                    <option value="PW"'.(substr_count($this->account->country_list,'PW')?' selected':'').'>Palau</option>
	                    <option value="PY"'.(substr_count($this->account->country_list,'PY')?' selected':'').'>Paraguay</option>
	                    <option value="QA"'.(substr_count($this->account->country_list,'QA')?' selected':'').'>Qatar</option>
	                    <option value="RE"'.(substr_count($this->account->country_list,'RE')?' selected':'').'>Reunion</option>
	                    <option value="RO"'.(substr_count($this->account->country_list,'RO')?' selected':'').'>Romania</option>
	                    <option value="RS"'.(substr_count($this->account->country_list,'RS')?' selected':'').'>Serbia</option>
	                    <option value="RU"'.(substr_count($this->account->country_list,'RU')?' selected':'').'>Russian Federation</option>
	                    <option value="RW"'.(substr_count($this->account->country_list,'RW')?' selected':'').'>Rwanda</option>
	                    <option value="SA"'.(substr_count($this->account->country_list,'SA')?' selected':'').'>Saudi Arabia</option>
	                    <option value="SB"'.(substr_count($this->account->country_list,'SB')?' selected':'').'>Solomon Islands</option>
	                    <option value="SC"'.(substr_count($this->account->country_list,'SC')?' selected':'').'>Seychelles</option>
	                    <option value="SD"'.(substr_count($this->account->country_list,'SD')?' selected':'').'>Sudan</option>
	                    <option value="SE"'.(substr_count($this->account->country_list,'SE')?' selected':'').'>Sweden</option>
	                    <option value="SG"'.(substr_count($this->account->country_list,'SG')?' selected':'').'>Singapore</option>
	                    <option value="SH"'.(substr_count($this->account->country_list,'SH')?' selected':'').'>Saint Helena</option>
	                    <option value="SI"'.(substr_count($this->account->country_list,'SI')?' selected':'').'>Slovenia</option>
	                    <option value="SJ"'.(substr_count($this->account->country_list,'SJ')?' selected':'').'>Svalbard and Jan Mayen</option>
	                    <option value="SK"'.(substr_count($this->account->country_list,'SK')?' selected':'').'>Slovakia</option>
	                    <option value="SL"'.(substr_count($this->account->country_list,'SL')?' selected':'').'>Sierra Leone</option>
	                    <option value="SM"'.(substr_count($this->account->country_list,'SM')?' selected':'').'>San Marino</option>
	                    <option value="SN"'.(substr_count($this->account->country_list,'SN')?' selected':'').'>Senegal</option>
	                    <option value="SO"'.(substr_count($this->account->country_list,'SO')?' selected':'').'>Somalia</option>
	                    <option value="SR"'.(substr_count($this->account->country_list,'SR')?' selected':'').'>Suriname</option>
	                    <option value="ST"'.(substr_count($this->account->country_list,'ST')?' selected':'').'>Sao Tome and Principe</option>
	                    <option value="SV"'.(substr_count($this->account->country_list,'SV')?' selected':'').'>El Salvador</option>
	                    <option value="SY"'.(substr_count($this->account->country_list,'SY')?' selected':'').'>Syrian Arab Republic</option>
	                    <option value="SZ"'.(substr_count($this->account->country_list,'SZ')?' selected':'').'>Swaziland</option>
	                    <option value="TC"'.(substr_count($this->account->country_list,'TC')?' selected':'').'>Turks and Caicos Islands</option>
	                    <option value="TD"'.(substr_count($this->account->country_list,'TD')?' selected':'').'>Chad</option>
	                    <option value="TF"'.(substr_count($this->account->country_list,'TF')?' selected':'').'>French Southern Territories</option>
	                    <option value="TG"'.(substr_count($this->account->country_list,'TG')?' selected':'').'>Togo</option>
	                    <option value="TH"'.(substr_count($this->account->country_list,'TH')?' selected':'').'>Thailand</option>
	                    <option value="TJ"'.(substr_count($this->account->country_list,'TJ')?' selected':'').'>Tajikistan</option>
	                    <option value="TK"'.(substr_count($this->account->country_list,'TK')?' selected':'').'>Tokelau</option>
	                    <option value="TL"'.(substr_count($this->account->country_list,'TL')?' selected':'').'>Timor-Leste</option>
	                    <option value="TM"'.(substr_count($this->account->country_list,'TM')?' selected':'').'>Turkmenistan</option>
	                    <option value="TN"'.(substr_count($this->account->country_list,'TN')?' selected':'').'>Tunisia</option>
	                    <option value="TO"'.(substr_count($this->account->country_list,'TO')?' selected':'').'>Tonga</option>
	                    <option value="TR"'.(substr_count($this->account->country_list,'TR')?' selected':'').'>Turkey</option>
	                    <option value="TT"'.(substr_count($this->account->country_list,'TT')?' selected':'').'>Trinidad and Tobago</option>
	                    <option value="TV"'.(substr_count($this->account->country_list,'TV')?' selected':'').'>Tuvalu</option>
	                    <option value="TW"'.(substr_count($this->account->country_list,'TW')?' selected':'').'>Taiwan</option>
	                    <option value="TZ"'.(substr_count($this->account->country_list,'TZ')?' selected':'').'>Tanzania, United Republic of</option>
	                    <option value="UA"'.(substr_count($this->account->country_list,'UA')?' selected':'').'>Ukraine</option>
	                    <option value="UG"'.(substr_count($this->account->country_list,'UG')?' selected':'').'>Uganda</option>
	                    <option value="UM"'.(substr_count($this->account->country_list,'UM')?' selected':'').'>United States Minor Outlying Islands</option>
	                    <option value="US"'.(substr_count($this->account->country_list,'US')?' selected':'').'>United States</option>
	                    <option value="UY"'.(substr_count($this->account->country_list,'UY')?' selected':'').'>Uruguay</option>
	                    <option value="UZ"'.(substr_count($this->account->country_list,'UZ')?' selected':'').'>Uzbekistan</option>
	                    <option value="VA"'.(substr_count($this->account->country_list,'VA')?' selected':'').'>Holy See (Vatican City State)</option>
	                    <option value="VC"'.(substr_count($this->account->country_list,'VC')?' selected':'').'>Saint Vincent and the Grenadines</option>
	                    <option value="VE"'.(substr_count($this->account->country_list,'VE')?' selected':'').'>Venezuela</option>
	                    <option value="VG"'.(substr_count($this->account->country_list,'VG')?' selected':'').'>Virgin Islands, British</option>
	                    <option value="VI"'.(substr_count($this->account->country_list,'VI')?' selected':'').'>Virgin Islands, U.S.</option>
	                    <option value="VN"'.(substr_count($this->account->country_list,'VN')?' selected':'').'>Vietnam</option>
	                    <option value="VU"'.(substr_count($this->account->country_list,'VU')?' selected':'').'>Vanuatu</option>
	                    <option value="WF"'.(substr_count($this->account->country_list,'WF')?' selected':'').'>Wallis and Futuna</option>
	                    <option value="WS"'.(substr_count($this->account->country_list,'WS')?' selected':'').'>Samoa</option>
	                    <option value="YE"'.(substr_count($this->account->country_list,'YE')?' selected':'').'>Yemen</option>
	                    <option value="YT"'.(substr_count($this->account->country_list,'YT')?' selected':'').'>Mayotte</option>
	                    <option value="ZA"'.(substr_count($this->account->country_list,'ZA')?' selected':'').'>South Africa</option>
	                    <option value="ZM"'.(substr_count($this->account->country_list,'ZM')?' selected':'').'>Zambia</option>
	                    <option value="ZW"'.(substr_count($this->account->country_list,'ZW')?' selected':'').'>Zimbabwe</option>
	                </select><br/><br />
	                <div style="width: 40%; float: left;"><a href="javascript:void(0)" onclick="sl_select(\'all\',\'c\');return false;"><img src="'.$this->filepath.'/images/elements_selection.png" align="top" alt="Select all countries (SEE WARNING BELOW)" title="Select all countries (SEE WARNING BELOW)" /> Select All</a></div><div style="width: 50%; float: left;"><a href="javascript:void(0)" onclick="sl_select(\'none\',\'c\');return false;"><img src="'.$this->filepath.'/images/selection_delete.png" align="top" alt="Deselect all countries" title="Deselect all countries" /> Select None</a><br/></div>
	                <label for="sl_country404" style="width:200px !important;float:left;">Country Block Page<sup style="color: #ff0000; font-weight: bold;">*</sup></label><br/><br/><br style="clear: both;"/>
	                <input id="sl_country404" style="clear: both;" name="country404" type="text" value="'.$this->account->country_404.'" size="30" maxlength="150" class="textfield" /><br />
	                </div>'."\n";
	                $output .= $this->EndModule();
	                $output .= '                        <div style="clear:both;"></div>'."\n";
	                $output .= '                    </div>'."\n";
	                $output .= '                </div>'."\n";
	                $output .= '                <div class="s5_bblack_bl"></div>'."\n";
	                $output .= '                <div class="s5_bblack_bm"></div>'."\n";
	                $output .= '                <div class="s5_bblack_br"></div>'."\n";
	                $output .= '                <div style="clear:both;"></div>'."\n";
	                $output .= '                <div class="s5_leftshadow"></div>'."\n";
	                $output .= '                <div class="s5_rightshadow"></div>'."\n";
	                $output .= '            </div>'."\n";
	                $output .= '            <!-- End Bottom Modules -->'."\n";
	                $output .= '            <div style="clear:both;"></div>'."\n";
            }
            //WHITE LIST, BLACK LIST, SAFE LIST, CUSTOM SCANNER
            {
            	$custom_lists = $this->sl_post_request('remote4.php','act=get_custom_lists&host='.$this->host);

				$output .= '    <!-- Bottom Modules -->'."\n";
	            $output .= '        <div class="s5_wrap">'."\n";
	            $output .= '            <div class="s5_bblack_tl"></div>'."\n";
	            $output .= '            <div class="s5_bblack_tm"></div>'."\n";
	            $output .= '            <div class="s5_bblack_tr"></div>'."\n";
	            $output .= '            <div style="clear:both;"></div>'."\n";
	            $output .= '            <div class="s5_bblack_outter">'."\n";
	            $output .= '                <div class="s5_backmiddlemiddle" style="padding-left:8px;">'."\n";





	            $output .= $this->ModuleStart("1", "25", "", "White List", "user", TRUE);
                $output .= '<div style="padding-left:15px;margin-bottom:24px;">';
                $output .= '<div id="sl_whitelist">
                				<div style="min-height:70px;">If you add an IP to the Whitelist, the user will have unrestricted access to your site.<br/><br/></div>
                                Add IP<sup style="color: #ff0000; font-weight: bold;">****</sup> :<br /><input id="sl_ip" name="whitelist_add" type="text" size="28px" maxlength="50" style="width:170px;" /><br/>
                                <label onclick="setTimeout(\'reset_chkbox_imgs(22)\',0)" id="for_e22" for="e22" class="unchecked"><span style="margin-left: 20px;">Remove Selected IP\'s</span><input type="checkbox" name="whitelist_rem_check" id="e22"/></label>
                                <select multiple="multiple" size="10" style="width:170px;margin:0px 0 0px 0;" id="whitelist_remove" name="whitelist_rem[]">'."\n";

                $whitelist = $custom_lists[1];
                if(empty($whitelist)){
                    $output .= '<option value="x">Whitelist not created yet</option>';
                } else {
                    $whitelist_arr = substr_count($whitelist, '^') ? explode('^', $whitelist) : array($whitelist);
                    for($i=0;$i<count($whitelist_arr);$i++){
                        $output .= '<option value="'.$whitelist_arr[$i].'">'.$whitelist_arr[$i].'</option>';
                    }
                }
                $output .= '</select><br/><br />
                            <div style="width: 50%; float: left;"><a href="javascript:void(0)" onclick="sl_select(\'all\',\'w\');return false;"><img src="'.$this->filepath.'/images/elements_selection.png" align="top" alt="Select all IP\'s" title="Select all IP\'s" /> Select All</a></div><div style="width: 50%; float: right;"><a href="javascript:void(0)" onclick="sl_select(\'none\',\'w\');return false;"><img src="'.$this->filepath.'/images/selection_delete.png" align="top" alt="Deselect all IP\'s" title="Deselect all IP\'s" /> Select None</a><br/></div>
                        </div>'."\n";
                $output .= '</div>'."\n";
                $output .= $this->EndModule();





                $output .= $this->ModuleStart("2", "25", "", "Black List", "user", TRUE);
                $output .= '<div style="padding-left:15px;margin-bottom:24px;">';
                $output .= '<div id="sl_blacklist">
                				<div style="min-height:70px;">If you add an IP to the Blacklist, the user will be permanently banned from your site.<br/><br/></div>
                                Add IP<sup style="color: #ff0000; font-weight: bold;">****</sup> :<br /><input id="sl_black" name="blacklist_add" type="text" size="28px" maxlength="50" style="width:170px;" /><br/>
                                <label onclick="setTimeout(\'reset_chkbox_imgs(23)\',0)" id="for_e23" for="e23" class="unchecked"><span style="margin-left: 20px;">Remove Selected IP\'s</span><input type="checkbox" name="blacklist_rem_check" id="e23"/></label>
                                <select multiple="multiple" size="10" style="width:170px;margin:0px 0 0px 0;" id="blacklist_remove" name="blacklist_rem[]">'."\n";

                $blacklist = $custom_lists[2];
                if(empty($blacklist)){
                    $output .= '<option value="x">Blacklist not created yet</option>';
                } else {
                    $blacklist_arr = substr_count($blacklist, '^') ? explode('^', $blacklist) : array($blacklist);
                    for($i=0;$i<count($blacklist_arr);$i++){
                        $output .= '<option value="'.$blacklist_arr[$i].'">'.$blacklist_arr[$i].'</option>';
                    }
                }
                $output .= '</select><br/><br />
                            <div style="width: 50%; float: left;"><a href="javascript:void(0)" onclick="sl_select(\'all\',\'b\');return false;"><img src="'.$this->filepath.'/images/elements_selection.png" align="top" alt="Select all IP\'s" title="Select all IP\'s" /> Select All</a></div><div style="width: 50%; float: right;"><a href="javascript:void(0)" onclick="sl_select(\'none\',\'b\');return false;"><img src="'.$this->filepath.'/images/selection_delete.png" align="top" alt="Deselect all IP\'s" title="Deselect all IP\'s" /> Select None</a><br/></div>
                        </div>'."\n";
                $output .= '</div>'."\n";
                $output .= $this->EndModule();






                $output .= $this->ModuleStart("3", "25", "", "Safe List", "user", TRUE);
                $output .= '<div style="padding-left:15px;margin-bottom:24px;">';
                $output .= '<div id="sl_safelist">
                				<div style="min-height:70px;">The Safelist allows you to NOT scan a given URL variable. For example, you could enter "error" to avoid scanning the error value.<br/><br/></div>
                                Add Variable<sup style="color: #ff0000; font-weight: bold;">****</sup> :<br /><input id="sl_safe" name="safelist_add" type="text" size="28px" maxlength="50" style="width:170px;" /><br/>
                                <label onclick="setTimeout(\'reset_chkbox_imgs(24)\',0)" id="for_e24" for="e24" class="unchecked"><span style="margin-left: 20px;">Remove Selected Vars</span><input type="checkbox" name="safelist_rem_check" id="e24"/></label>
                                <select multiple="multiple" size="10" style="width:170px;margin:0px 0 0px 0;" id="safelist_remove" name="safelist_rem[]">'."\n";

                $safelist = $custom_lists[3];
                if(empty($safelist)){
                    $output .= '<option value="x">Safe List not created yet</option>';
                } else {
                    $safelist_arr = substr_count($safelist, '^') ? explode('^', $safelist) : array($safelist);
                    for($i=0;$i<count($safelist_arr);$i++){
                        $output .= '<option value="'.$safelist_arr[$i].'">'.$safelist_arr[$i].'</option>';
                    }
                }
                $output .= '</select><br/><br />
                            <div style="width: 50%; float: left;"><a href="javascript:void(0)" onclick="sl_select(\'all\',\'s\');return false;"><img src="'.$this->filepath.'/images/elements_selection.png" align="top" alt="Select all variables" title="Select all variables" /> Select All</a></div><div style="width: 50%; float: right;"><a href="javascript:void(0)" onclick="sl_select(\'none\',\'s\');return false;"><img src="'.$this->filepath.'/images/selection_delete.png" align="top" alt="Deselect all variables" title="Deselect all variables" /> Select None</a><br/></div>
                        </div>'."\n";
                $output .= '</div>'."\n";
                $output .= $this->EndModule();







                $output .= $this->ModuleStart("4", "25", "", "Custom Scanner", "user", TRUE);
                $output .= '<div style="padding-left:15px;margin-bottom:24px;">';
                $output .= '<div id="sl_customlist">
                				<div style="min-height:70px;">The Custom Scanner allows you to specify custom terms you would like to block. If the specified term is found in the URL, the user will be blocked and a report generated.</div>
                                Add Term<sup style="color: #ff0000; font-weight: bold;">****</sup> :<br /><input id="sl_custom" name="customlist_add" type="text" size="28px" maxlength="50" style="width:170px;" /><br/>
                                <label onclick="setTimeout(\'reset_chkbox_imgs(25)\',0)" id="for_e25" for="e25" class="unchecked"><span style="margin-left: 20px;">Remove Selected terms</span><input type="checkbox" name="customlist_rem_check" id="e25"/></label>
                                <select multiple="multiple" size="10" style="width:170px;margin:0px 0 0px 0;" id="customlist_remove" name="customlist_rem[]">'."\n";

                $customlist = $custom_lists[4];
                if(empty($customlist)){
                    $output .= '<option value="x">Custom terms not created yet</option>';
                } else {
                    $customlist_arr = substr_count($customlist, '#sl#') ? explode('#sl#', $customlist) : array($customlist);
                    for($i=0;$i<count($customlist_arr);$i++){
                        $output .= '<option value="'.$customlist_arr[$i].'">'.$customlist_arr[$i].'</option>';
                    }
                }
                $output .= '</select><br/><br />
                            <div style="width: 50%; float: left;"><a href="javascript:void(0)" onclick="sl_select(\'all\',\'t\');return false;"><img src="'.$this->filepath.'/images/elements_selection.png" align="top" alt="Select all terms" title="Select all terms" /> Select All</a></div><div style="width: 50%; float: right;"><a href="javascript:void(0)" onclick="sl_select(\'none\',\'t\');return false;"><img src="'.$this->filepath.'/images/selection_delete.png" align="top" alt="Deselect all terms" title="Deselect all terms" /> Select None</a><br/></div>
                        </div>'."\n";
                $output .= '</div>'."\n";
                $output .= $this->EndModule();




                $output .= '                        <div style="clear:both;"></div>'."\n";
                $output .= '                    </div>'."\n";
                $output .= '                </div>'."\n";
                $output .= '                <div class="s5_bblack_bl"></div>'."\n";
                $output .= '                <div class="s5_bblack_bm"></div>'."\n";
                $output .= '                <div class="s5_bblack_br"></div>'."\n";
                $output .= '                <div style="clear:both;"></div>'."\n";
                $output .= '                <div class="s5_leftshadow"></div>'."\n";
                $output .= '                <div class="s5_rightshadow"></div>'."\n";
                $output .= '            </div>'."\n";
                $output .= '            <!-- End Bottom Modules -->'."\n";
                $output .= '            <div style="clear:both;"></div>'."\n";
            }
            //SPAM FILTER SETTINGS - CHECK FOR JOOMLA
            if($this->is_joomla() || $this->is_WordPress()){
            	//header
            	{
					$output .= '    <!-- Bottom Modules -->'."\n";
		            $output .= '        <div class="s5_wrap">'."\n";
		            $output .= '            <div class="s5_bblack_tl"></div>'."\n";
		            $output .= '            <div class="s5_bblack_tm"></div>'."\n";
		            $output .= '            <div class="s5_bblack_tr"></div>'."\n";
		            $output .= '            <div style="clear:both;"></div>'."\n";
		            $output .= '            <div class="s5_bblack_outter">'."\n";
		            $output .= '                <div class="s5_backmiddlemiddle" style="padding-left:8px;">'."\n";
				}

	            //EMail List
	            {
		            $output .= $this->ModuleStart("1", "25", "", "E-Mail List", "user");

	                $output .= '<div style="padding-left:15px;margin-bottom:24px;">';
	                $output .= '<div id="sl_spamEMailList">
                					<div style="min-height:70px;">Users with these E-Mails address are unable to register.<br/><br/></div>
	                                Add E-Mail:<br />
	                                <input id="sl_spamEmail" name="spamEMail_add" type="text" size="28px" maxlength="50" style="width:170px;" /><br/>
	                                <label onclick="setTimeout(\'reset_chkbox_imgs(41)\',0)" id="for_e41" for="e41" class="unchecked"><span style="margin-left: 20px;">Remove Selected E-Mails</span><input type="checkbox" name="spamEMail_rem_check" id="e41"/></label>
	                                <select multiple="multiple" size="10" style="width:170px;margin:0px 0 0px 0;" id="spamEMails_remove" name="spamFilterEmail_rem[]">'."\n";


	                $rs = $this->QueryDB("SELECT id, term FROM !spamfilter WHERE type=1 ORDER BY term ASC");
	                
	                if(count($rs) > 0){
	                	foreach($rs as $r){
	                		$output .= '<option value="'.$r[0].'">'.$r[1].'</option>';
						}
					}
					else {
						$output .= '<option value="x"><em>No entries.</em></option>';
					}

	                $output .= '</select><br/><br />
	                            <div style="width: 50%; float: left;"><a href="javascript:void(0)" onclick="sl_select(\'all\',\'spamEmail\');return false;"><img src="'.$this->filepath.'/images/elements_selection.png" align="top" alt="Select all IP\'s" title="Select all IP\'s" /> Select All</a></div><div style="width: 50%; float: right;"><a href="javascript:void(0)" onclick="sl_select(\'none\',\'spamEmail\');return false;"><img src="'.$this->filepath.'/images/selection_delete.png" align="top" alt="Deselect all IP\'s" title="Deselect all IP\'s" /> Select None</a><br/></div>
	                        </div>'."\n";
	                $output .= '</div>'."\n";
	                $output .= $this->EndModule();
				}
				//Username List
	            {
		            $output .= $this->ModuleStart("2", "25", "", "Username List", "user");

	                $output .= '<div style="padding-left:15px;margin-bottom:24px;">';
	                $output .= '<div id="sl_spamUsernameList">
                					<div style="min-height:70px;">Prevent registration of these usernames.<br/><br/></div>
	                                Add Username:<br />
	                                <input id="sl_spamUsers" name="spamUsername_add" type="text" size="28px" maxlength="50" style="width:170px;" /><br/>
	                                <label onclick="setTimeout(\'reset_chkbox_imgs(42)\',0)" id="for_e42" for="e42" class="unchecked">
	                                	<span style="margin-left: 20px;">Remove Selected names</span><input type="checkbox" name="spamUsername_rem_check" id="e42"/>
	                                </label>
	                                <select multiple="multiple" size="10" style="width:170px;margin:0px 0 0px 0;" id="spamUsernames_remove" name="spamFilterUsername_rem[]">'."\n";


	                $rs = $this->QueryDB("SELECT id, term FROM !spamfilter WHERE type=2 ORDER BY term ASC");

	                if(count($rs) > 0){
	                	foreach($rs as $r){
	                		$output .= '<option value="'.$r[0].'">'.$r[1].'</option>';
						}
					}
					else {
						$output .= '<option value="x"><em>No entries.</em></option>';
					}

	                $output .= '</select><br/><br />
	                            <div style="width: 50%; float: left;"><a href="javascript:void(0)" onclick="sl_select(\'all\',\'spamUsername\');return false;"><img src="'.$this->filepath.'/images/elements_selection.png" align="top" alt="Select all IP\'s" title="Select all IP\'s" /> Select All</a></div><div style="width: 50%; float: right;"><a href="javascript:void(0)" onclick="sl_select(\'none\',\'spamUsername\');return false;"><img src="'.$this->filepath.'/images/selection_delete.png" align="top" alt="Deselect all IP\'s" title="Deselect all IP\'s" /> Select None</a><br/></div>
	                        </div>'."\n";
	                $output .= '</div>'."\n";
	                $output .= $this->EndModule();
				}
				//IP List
	            {
		            $output .= $this->ModuleStart("3", "25", "", "IP List", "user");

	                $output .= '<div style="padding-left:15px;margin-bottom:24px;">';
	                $output .= '<div id="sl_spamIPList">
                					<div style="min-height:70px;">Prevent registration from these IPs.<br/><br/></div>
	                                Add IP:<br />
	                                <input id="sl_spamIPs" name="spamIP_add" type="text" size="28px" maxlength="50" style="width:170px;" /><br/>
	                                <label onclick="setTimeout(\'reset_chkbox_imgs(43)\',0)" id="for_e43" for="e43" class="unchecked">
	                                	<span style="margin-left: 20px;">Remove Selected IPs</span><input type="checkbox" name="spamIP_rem_check" id="e43"/>
	                                </label>
	                                <select multiple="multiple" size="10" style="width:170px;margin:0px 0 0px 0;" id="spamIps_remove" name="spamFilterIp_rem[]">'."\n";


	                $rs = $this->QueryDB("SELECT id, term FROM !spamfilter WHERE type=3 ORDER BY term ASC");

	                if(count($rs) > 0){
	                	foreach($rs as $r){
	                		$output .= '<option value="'.$r[0].'">'.$r[1].'</option>';
						}
					}
					else {
						$output .= '<option value="x"><em>No entries.</em></option>';
					}

	                $output .= '</select><br/><br />
	                            <div style="width: 50%; float: left;"><a href="javascript:void(0)" onclick="sl_select(\'all\',\'spamIp\');return false;"><img src="'.$this->filepath.'/images/elements_selection.png" align="top" alt="Select all IP\'s" title="Select all IP\'s" /> Select All</a></div><div style="width: 50%; float: right;"><a href="javascript:void(0)" onclick="sl_select(\'none\',\'spamIp\');return false;"><img src="'.$this->filepath.'/images/selection_delete.png" align="top" alt="Deselect all IP\'s" title="Deselect all IP\'s" /> Select None</a><br/></div>
	                        </div>'."\n";
	                $output .= '</div>'."\n";
	                $output .= $this->EndModule();
				}
				//Term List
	            {
		            $output .= $this->ModuleStart("4", "25", "", "Term List", "user", TRUE);

	                $output .= '<div style="padding-left:15px;margin-bottom:24px;">';
	                $output .= '<div id="sl_spamUsernameList">
                					<div style="min-height:70px;">Prevent registration if any of these terms are found. Use a "~" to assign a censored feedback word.<br/><br/></div>
	                                Add Term:<br />
	                                <input id="sl_spamTerm" name="spamTerm_add" type="text" size="28px" maxlength="50" style="width:170px;" /><br/>
	                                <label onclick="setTimeout(\'reset_chkbox_imgs(44)\',0)" id="for_e44" for="e44" class="unchecked">
	                                	<span style="margin-left: 20px;">Remove Selected Terms</span><input type="checkbox" name="spamTerm_rem_check" id="e44"/>
	                                </label>
	                                <select multiple="multiple" size="10" style="width:170px;margin:0px 0 0px 0;" id="spamTerms_remove" name="spamFilterTerm_rem[]">'."\n";

	                $rs = $this->QueryDB("SELECT id, term FROM !spamfilter WHERE type=4 ORDER BY term ASC");

	                if(count($rs) > 0){
	                	foreach($rs as $r){
	                		$output .= '<option value="'.$r[0].'">'.$r[1].'</option>';
						}
					}
					else {
						$output .= '<option value="x"><em>No entries.</em></option>';
					}

	                $output .= '</select><br/><br />
	                            <div style="width: 50%; float: left;"><a href="javascript:void(0)" onclick="sl_select(\'all\',\'spamTerm\');return false;"><img src="'.$this->filepath.'/images/elements_selection.png" align="top" alt="Select all IP\'s" title="Select all IP\'s" /> Select All</a></div><div style="width: 50%; float: right;"><a href="javascript:void(0)" onclick="sl_select(\'none\',\'spamTerm\');return false;"><img src="'.$this->filepath.'/images/selection_delete.png" align="top" alt="Deselect all IP\'s" title="Deselect all IP\'s" /> Select None</a><br/></div>
	                        </div>'."\n";
	                $output .= '</div>'."\n";
	                $output .= $this->EndModule();
				}
			
				if(!isset($spamFilterEnabled)){
					$rs = $this->QueryDB("SELECT time FROM !spamfilter WHERE type=0 AND term='#Enabled#'");
					$spamFilterEnabled = true;
					if(count($rs) > 0)
						$spamFilterEnabled = (intval($rs[0][0]) == 1);
					else
						$this->QueryDB("INSERT INTO !spamfilter VALUES(null, 1, 0, '#Enabled#')", false);	
				}

				$output .= "<div style='margin-left: 20px; padding-bottom: 10px;'>";
				$output .= "	Registration Filter System:";
				$output .= "	<select name='sl_spamFilterEnabled' id='sl_spamFilterEnabled'>";
				$output .= "		<option value='1' ".(($spamFilterEnabled) ? "SELECTED" : "").">On</option>";
				$output .= "		<option value='0' ".(($spamFilterEnabled) ? "" : "SELECTED").">Off</option>";
				$output .= "	</select>";
				$output .= "</div>";

				//footer
				{
	                $output .= '                        <div style="clear:both;"></div>'."\n";
	                $output .= '                    </div>'."\n";
	                $output .= '                </div>'."\n";
	                $output .= '                <div class="s5_bblack_bl"></div>'."\n";
	                $output .= '                <div class="s5_bblack_bm"></div>'."\n";
	                $output .= '                <div class="s5_bblack_br"></div>'."\n";
	                $output .= '                <div style="clear:both;"></div>'."\n";
	                $output .= '                <div class="s5_leftshadow"></div>'."\n";
	                $output .= '                <div class="s5_rightshadow"></div>'."\n";
	                $output .= '            </div>'."\n";
	                $output .= '            <!-- End Bottom Modules -->'."\n";
	                $output .= '            <div style="clear:both;"></div>'."\n";
				}
			}
            //POST PASSWORD (BYPASS EDITOR)
            {
				$output .= '        <!-- Adverts -->';
	            $output .= '        <div class="s5_wrap" >';
	            $output .= '            <div class="s5_w_modwrap">';
	            $output .= '                <div class="s5_backmiddlemiddle2">';
	            $output .= $this->ModuleStart("1", "100", "", "Bypass Post XSS Filter (advanced)", "advert", TRUE);


	            //check for sl_config
	            if($this->config_exists()){
					include_once($this->config_fp);
	            } else {
					$output .= 'Could not create configuration file. <b>This is only required if you would like to BYPASS the Post XSS Filter.</b><br/>
								Here are some possible problems and solutions:<br/><br/>
								<b>Incorrect permissions:</b> The folder, '.$this->sl_get_path().' should be set to 755 permission level. If this is currently set at 755, read on.<br/><br/>
								<b>Incorrect ownership:</b> The folder, '.$this->sl_get_path().' should be "owned" by the username that you use to log into your server (cPanel for example). Changing the ownership requires shell (ssh) access on a Linux server, and access to IIS on a Windows server<br/><br/>
								If you are still having trouble, you can <b>temporarily</b> change the folder permissions on '.$this->sl_get_path().' to 777 so that the file can be created. Once created, the folder should be set back to 755.';
	            }
	            //check for bypass ARRAYS
	            if((isset($this->bypass_arr) && is_array($this->bypass_arr) && count($this->bypass_arr)>0) || (isset($this->dir_bypass_arr) && is_array($this->dir_bypass_arr) && count($this->dir_bypass_arr)>0)){
					//write the JS code for the editor

					//DIR BYPASS

					if(count($this->dir_bypass_arr)){
						$js_arr2 = 'Array(';
						foreach($this->dir_bypass_arr as $dir){
							$dir = addcslashes($dir,"'\"");
							$js_arr2 .= $js_arr2=='Array(' ? "'$dir'" : ",'$dir'";
						}
						$js_arr2 .= ')';
					} else {
						$js_arr2 = 'null';
					}

					//VAR BYPASS

					if(count($this->bypass_arr)){
						$js_arr = 'Array(';
						/*
							Array(Array('bypass','true'),Array(Array('var1','var2'),Array('pas1','pas2')))
						*/
						$count = 0;
						foreach($this->bypass_arr as $item){
							$js_arr .= $count++>0 ? ',' : '';
							//$item is an array with 'var' and 'val'
							if(is_array($item['var'])){
								//if var is an array, val will be an array of same length
								//var and val are now lists for the AND statements
								$js_arr .= "Array(Array(";
								$x = 0;
								foreach($item['var'] as $v){
									$js_arr .= $x++>0 ? ',' : '';
									$js_arr .= "'$v'";
								}
								$js_arr .= "),Array(";
								$x = 0;
								foreach($item['val'] as $v){
									$js_arr .= $x++>0 ? ',' : '';
									$js_arr .= "'$v'";
								}
								$js_arr .= "))";
							} elseif(is_string($item['var'])){
								//its a string so put it
								//Array('','')
								$js_arr .= "Array('".$item['var']."','".$item['val']."')";
							}

						}
						$js_arr .= ')';
					} else {
						$js_arr = 'null';
					}




					$output .= '<div id="sl_bypass_wizard_container">
								<div>You have established the following bypasses: (to remove something, leave it blank and click Save Bypass, or <a href="javascript:void(0)" onclick="sl_wizard.display();return false;">click to reset</a>)<a href="javascript:void(0)" onclick="sl_wizard.new_or();return false;" style="float:right">Add an OR statement</a></div><br/>
								<div id="sl_bypass_wizard">
	            					<script type="text/javascript">
	            					<!--
	            						sl_wizard = new sl_bypass_editor();
	            						sl_wizard.arr = '.$js_arr.';
	            						sl_wizard.dirArr = '.$js_arr2.';
	            						sl_wizard.display();
	            					// -->
	            					</script>
	            				</div><br/>
	            				<input type="button" value="Save Bypass" onclick="sl_wizard.save(this)" /> (this does not save anything you may have modified in your account or program settings)
	            				<br/><br/>Or you can <a href="javascript:void(0)" onclick="sl_wizard.start(1);return false;">click here to start the wizard.</a>
	            				</div>'."\n";
	            } else {
	            	//give option to start wizard
					$output .= '<div id="sl_bypass_wizard_container">
								<div id="sl_bypass_wizard">
	            					You are currently only bypassing the Post XSS Filter in your admin section (this is by default). To bypass another part of your website, <a href="javascript:void(0)" onclick="window[\'sl_wizard\']=new sl_bypass_editor();sl_wizard.start(1);return false;">click here to start the wizard.</a>
	            				</div>
	            				</div>'."\n";
	            }
	            $output .= $this->EndModule();
	            $output .= '            <div style="clear:both;"></div>'."\n";
	            $output .= '        </div>'."\n";
	            $output .= '    </div>'."\n";
	            $output .= '    <div class="s5_w_modbl"></div>'."\n";
	            $output .= '    <div class="s5_w_modbm"></div>'."\n";
	            $output .= '    <div class="s5_w_modbr"></div>'."\n";
	            $output .= '    <div style="clear:both;"></div>'."\n";
	            $output .= '    <div class="s5_leftshadow" ></div>'."\n";
	            $output .= '    <div class="s5_rightshadow" ></div>'."\n";
	            $output .= '    <!-- End Adverts -->'."\n";
	            $output .= '    <div style="clear:both;"></div>'."\n";
            }

            ///// PROGRAM SETTINGS
            {
                $output .= '    <!-- Bottom Modules -->'."\n";
                $output .= '        <div class="s5_wrap">'."\n";
                $output .= '            <div class="s5_bblack_tl"></div>'."\n";
                $output .= '            <div class="s5_bblack_tm"></div>'."\n";
                $output .= '            <div class="s5_bblack_tr"></div>'."\n";
                $output .= '            <div style="clear:both;"></div>'."\n";
                $output .= '            <div class="s5_bblack_outter">'."\n";
                $output .= '                <div class="s5_backmiddlemiddle" style="padding-left:8px;">'."\n";

                $output .= $this->ModuleStart("1", "50", "", "Save Account Settings", "user", FALSE);
                    $output .= '<div><img src="'.$this->filepath.'/images/sl_logo.png" border="0" /></div><br />'."\n";
                    $output .= 'Using the save button will save all of the data at once. If you have changed things that you do not want to save, please use the reset button to reset all fields to their previous position and modify only the items you would like to save.<br /><br /> Using the help icons located in each box will take you from this screen. If you click on a help icon any changes you have made will be lost until the save button is pressed.<br /><br />By click on save you agree to the terms of service in our <a href="'.$this->sl_make_link('help').'&id=user_agreement">User Agreement</a><br /><br />'."\n";
                    $output .= '<fieldset>
                                    <input type="hidden" name="domain" value="'.$this->account->domain.'" />';
                    $output .= '    <input type="submit" name="sl_submit" value="Save" class="submit" />&nbsp;';
                    $output .= '    <input type="reset" name="reset" value="Reset" class="submit" />&nbsp;
                                    <input type="button" value="Default" class="submit" onclick="sl_restore_defaults();return false;" />';
                    $output .= '</fieldset>';
                $output .= $this->EndModule();
                
            }
            {
                $output .= $this->ModuleStart("2", "50", "", "Information Section", "user", FALSE);
                $tmpword = !empty($this->account->accessword) ? '<span style="color: #0F9800; font-weight: bold;">http://www.'.$_SERVER['HTTP_HOST'].'/administrator?'.$this->account->accessword.'</span>' : '<span style="color: #0F9800; font-weight: bold;">'.$_SERVER['HTTP_HOST'].'/administrator?exampleword'.'</span>';
                if (!preg_match("/sa/", $this->account->acct_type)){
                    $output .= '            <span style="color: #fff; font-weight: bold;">NOTE </span> SecureLive has detected your IP address as <span style="color:#FFF"><b>'.$this->ip.'</b></span><br /><br />'."\n";
                }
                $output .= '            <span style="color: #fff; font-weight: bold;">NOTE</span><sup style="color: #ff0000; font-weight: bold;">*</sup> Your Custom 404 Page will need to be a real URL using the http. An example would be <span style="color: #FFF;">http://www.yourdomain.com/leavemealone.html</span><br /><br />'."\n";
                if (preg_match("/sa/", $this->account->acct_type)){
                    $output .= '            <span style="color: #fff; font-weight: bold;">NOTE</span><sup style="color: #ff0000; font-weight: bold;">**</sup> Access word is not available in SecureAnalytics. To obtain this feature, please purchase your copy of SecureLive today.<br /><br />'."\n";
                } else {
                    $output .= '            <span style="color: #fff; font-weight: bold;">NOTE</span><sup style="color: #ff0000; font-weight: bold;">**</sup> Your access word is not a password and will be visible to SecureLive and anyone who accesses this page. By using an access word you will need to <br />access your administrator section by adding ?[access word] for example:<br />'.$tmpword.'<br /><br />'."\n";
                }
                $output .= '            <span style="color: #fff; font-weight: bold;">NOTE</span><sup style="color: #ff0000; font-weight: bold;">***</sup> With the Frame Buster enabled, your website will not be able to be shown in a frame or on another website. This is highly recommended so that your website cannot be stolen or manipulated by a frame.<br /><br />'."\n";
                $output .= '            <span style="color: #fff; font-weight: bold;">NOTE</span><sup style="color: #ff0000; font-weight: bold;">****</sup> To remove an entry from the custom lists, first select the entries you wish to remove, and then click the red X to change to a green checkmark and click on save.<br /><br />'."\n";
                $output .= '            <span style="color: #29B400; font-weight: bold;">QA</span><sup style="color: #0F9800; font-weight: bold;">?</sup> CAUTION! Enabling debug mode will put a SecureLive debug header at the top of your website and enable all error reporting. This could cause your website to malfunction, so please leave this disabled unless it is absolutely necessary.<br /><br />'."\n";
                $output .= '            <span style="color: #29B400; font-weight: bold;">QA</span><sup style="color: #0F9800; font-weight: bold;">?</sup> The IP addresses in the Last 5 Attacks are clickable to give you more detailed information about the attack. You may also delete that attack if it was a mistake.<br /><br />'."\n";
                $output .= $this->EndModule();
                $output .= '                        <div style="clear:both;"></div>'."\n";
                $output .= '                    </div>'."\n";
                $output .= '                </div>'."\n";
                $output .= '                <div class="s5_bblack_bl"></div>'."\n";
                $output .= '                <div class="s5_bblack_bm"></div>'."\n";
                $output .= '                <div class="s5_bblack_br"></div>'."\n";
                $output .= '                <div style="clear:both;"></div>'."\n";
                $output .= '                <div class="s5_leftshadow"></div>'."\n";
                $output .= '                <div class="s5_rightshadow"></div>'."\n";
                $output .= '            </div>'."\n";
                $output .= '            <!-- End Bottom Modules -->'."\n";
                $output .= '            <div style="clear:both;"></div>'."\n";
                $output .= "</form>";
            }
			
			$outputMessage = isset($outputMessage) ? $outputMessage : 'DONE';
			return "$outputMessage*sl^module#message*".$output;
		}
		private function ip_lookup_module(){
			$str = '';
			if(isset($_POST['ip'])){
		        $ip = $_POST['ip'];
		        $ok_str = '0123456789.';
		        $tempvar = '';
		        for($i=0;$i<strlen($ip);$i++){
		            if(substr_count($ok_str,substr($ip,$i,1))){
		                $tempvar .= substr($ip,$i,1);
		            }
		        }
		        $ip = $tempvar;
		    } else {
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
		    //get info
		    $sURL = array('act'=>'ip_tool','ip'=>$ip,'host'=>$this->host);
		    $retData = $this->sl_post_request('remote4.php', http_build_query($sURL,'','&'));
		    if(isset($retData[1])){
		        $address = $retData[0];
		        $host = $retData[1];
		        $isp = $retData[2];
		        $org = $retData[3];
		        $city = $retData[4];
		        $region = $retData[5];
		        $zip = $retData[6];
		        $areacode = $retData[7];
		        $country = $retData[8];
		        $latlong = $retData[9];
		    } else {
		        $address = $retData[0];
		        $host = null; $isp = null; $org = null; $city = null; $region = null; $zip = null; $areacode = null; $country = null; $latlong = null;
		    }
		    if($address == 'No Results'){
		        $num = 100;
			} else {
				$num = 50;
			}
			$clrip = '';
	        $str .= '        <!-- Adverts -->';
	        $str .= '        <div class="s5_wrap" >';
	        $str .= '            <div class="s5_w_modwrap">';
	        $str .= '                <div class="s5_backmiddlemiddle2">';

		    $str .= $this->ModuleStart("1", $num, "-light", "IP Lookup Tool", "advert", FALSE);



		    //display info (form, data & map)

		    $str .= 'Use this page to lookup information on any IP address.<br/><br/>
		                <div>
		                    <form action="#" onsubmit="sl_gateway.open(\'tools\',this);return false;" method="post">
		                        <input type="text" name="ip" value="Enter an IP address" size="30" onfocus="this.value=this.value==\'Enter an IP address\'?\'\':this.value;" onblur="this.value=this.value==\'\'?\'Enter an IP address\':this.value;"/>
		                        <input type="submit" value="Get Info"/>
		                    </form>
		                </div>
		                <br/>
		                <div>'."\n";
		        if ($this->validateIpAddress($address)){
		            $clrip .= '057121';
		        } else {
		            $clrip .= 'ED1717';
		        }

		    $str .= '    <table style="font-size:12px;font-stretch:wider;">
		        			<tr>
		        				<td><b>IP:</b></td>
		        				<td><span style="color:#'.$clrip.';">'.$address.'</span></td>
		        			</tr>'."\n";
		    if($address != 'No Results'){
			    $str .= "	<tr>
			        			<td><b>IPv6:</b></td>
			        			<td><span style=\"color:#$clrip;\">".$this->IPv4To6($address)."</span></td>
			        		</tr>
			        		<tr>
			        			<td><b>Host:</b></td>
			        			<td><span style=\"color:#$clrip;\">$host</span></td>
			        		</tr>
			        		<tr>
			        			<td><b>ISP:</b></td>
			        			<td>$isp</td>
			        		</tr>
			        		<tr>
			        			<td><b>Org:</b></td>
			        			<td>$org</td>
			        		</tr>
			        		<tr>
			        			<td><b>City:</b></td>
			        			<td>$city</td>
			        		</tr>
			        		<tr>
			        			<td><b>State:</b></td>
			        			<td>$region</td>
			        		</tr>
			        		<tr>
			        			<td><b>Zip:</b></td>
			        			<td>$zip</td>
			        		</tr>
			        		<tr>
			        			<td><b>Area Code:</b></td>
			        			<td>$areacode</td>
			        		</tr>
			        		<tr>
			        			<td><b>Country:</b></td>
			        			<td>$country</td>
			        		</tr>
			        		<tr>
			        			<td><b>Coordinates:</b></td>
			        			<td>$latlong</td>
			        		</tr>
			        	</table>
			        	</div><br/>";



			    //////////////////////////////////////// MAP
			    $str .= $this->EndModule();
			    $str .= $this->ModuleStart("1", "50", "-light", "Geolocation Map", "advert", TRUE);
			    $str .= '<script type="text/javascript">
	        				<!-- 
	        				//need to get rid of this and use http://maps.google.com/maps/api/js?sensor=false once google fixes the bug with the getScript function
							window.google = window.google || {};
							google.maps = google.maps || {};
							(function() {
								function getScript(src) {
									scriptElement = document.createElement("script");
									scriptElement.setAttribute("src", src);
									document.body.appendChild(scriptElement);
								}

								var modules = google.maps.modules = {};
								google.maps.__gjsload__ = function(name, text) {
									modules[name] = text;
								};

								google.maps.Load = function(apiLoad) {
									delete google.maps.Load;
									apiLoad([null,[[["http://mt0.google.com/vt?lyrs=m@138\u0026src=api\u0026hl=en-US\u0026","http://mt1.google.com/vt?lyrs=m@138\u0026src=api\u0026hl=en-US\u0026"],null,"foo"],[["http://khm0.google.com/kh?v=74\u0026hl=en-US\u0026","http://khm1.google.com/kh?v=74\u0026hl=en-US\u0026"],null,"foo",null,1],[["http://mt0.google.com/vt?lyrs=h@138\u0026src=api\u0026hl=en-US\u0026","http://mt1.google.com/vt?lyrs=h@138\u0026src=api\u0026hl=en-US\u0026"],null,"foo","imgtp=png32\u0026"],[["http://mt0.google.com/vt?lyrs=t@126,r@138\u0026src=api\u0026hl=en-US\u0026","http://mt1.google.com/vt?lyrs=t@126,r@138\u0026src=api\u0026hl=en-US\u0026"],null,"foo"],null,[[null,0,7,7,[[[330000000,1246050000],[386200000,1293600000]],[[366500000,1297000000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026"]],[null,0,8,9,[[[330000000,1246050000],[386200000,1279600000]],[[345000000,1279600000],[386200000,1286700000]],[[348900000,1286700000],[386200000,1293600000]],[[354690000,1293600000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026"]],[null,0,10,19,[[[329890840,1246055600],[386930130,1284960940]],[[344646740,1284960940],[386930130,1288476560]],[[350277470,1288476560],[386930130,1310531620]],[[370277730,1310531620],[386930130,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026"]],[null,3,7,7,[[[330000000,1246050000],[386200000,1293600000]],[[366500000,1297000000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026"]],[null,3,8,9,[[[330000000,1246050000],[386200000,1279600000]],[[345000000,1279600000],[386200000,1286700000]],[[348900000,1286700000],[386200000,1293600000]],[[354690000,1293600000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026"]],[null,3,10,null,[[[329890840,1246055600],[386930130,1284960940]],[[344646740,1284960940],[386930130,1288476560]],[[350277470,1288476560],[386930130,1310531620]],[[370277730,1310531620],[386930130,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026"]]],[["http://cbk0.google.com/cbk?","http://cbk1.google.com/cbk?"],null,"foo"],[["http://khmdb0.google.com/kh?v=33\u0026hl=en-US\u0026","http://khmdb1.google.com/kh?v=33\u0026hl=en-US\u0026"],null,"foo"],[["http://mt0.google.com/mapslt?hl=en-US\u0026","http://mt1.google.com/mapslt?hl=en-US\u0026"],null,"foo"],[["http://mt0.google.com/mapslt/ft?hl=en-US\u0026","http://mt1.google.com/mapslt/ft?hl=en-US\u0026"],null,"foo"]],["en-US","US",null,0,null,"http://maps.google.com","http://maps.gstatic.com/intl/en_us/mapfiles/","http://gg.google.com","https://maps.googleapis.com","http://maps.googleapis.com"],["http://maps.gstatic.com/intl/en_us/mapfiles/api-3/3/0","3.3.0"],[1229228594],1,null,null,null,null,0,""], loadScriptTime);
								};
								var loadScriptTime = (new Date).getTime();
								//put this directly below now
								//getScript("http://maps.gstatic.com/intl/en_us/mapfiles/api-3/3/0/main.js");
							})();
							//-->
				        </script>
				        <script type="text/javascript" src="http://maps.gstatic.com/intl/en_us/mapfiles/api-3/3/0/main.js"></script>
			                <div id="map_canvas" style="width:400px; height:190px;"></div>
			                    <script type="text/javascript">
			                        function initialize_map() {
			                            var prev_info = null;
			                            var center = new google.maps.LatLng('.$latlong.');
			                            var myOptions = {
			                                scrollwheel:false,
			                                mapTypeControl: true,
			                                mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
			                                navigationControl: true,
			                                navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
			                                zoom: 4,
			                                center: center,
			                                mapTypeId: google.maps.MapTypeId.ROADMAP};
			                            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);'."\n";
			    $str .= '            var pos_1 = new google.maps.LatLng('.$latlong.');
			                            var attack_1= new google.maps.Marker({
			                                position: pos_1,
			                                map: map,
			                                title:"'.$address.'"'."\n";
			        //only put icons if not opera
			        if(!preg_match("/opera/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
			            $str .= '            ,icon: "'.$this->filepath.'/images/blocked_map_img.png"'."\n";
			        }
			    $str .= '            });'."\n";
			    $str .= '        }
			                        //initialize_map();
			                        </script>
			                        <br/><br/>'."\n";
		    } else {
		        $str .= '</table></div><br/>'."\n";
		    }

	        $str .= $this->EndModule();
	        $str .= '            <div style="clear:both;"></div>'."\n";
	        $str .= '        </div>'."\n";
	        $str .= '    </div>'."\n";
	        $str .= '    <div class="s5_w_modbl"></div>'."\n";
	        $str .= '    <div class="s5_w_modbm"></div>'."\n";
	        $str .= '    <div class="s5_w_modbr"></div>'."\n";
	        $str .= '    <div style="clear:both;"></div>'."\n";
	        $str .= '    <div class="s5_leftshadow" ></div>'."\n";
	        $str .= '    <div class="s5_rightshadow" ></div>'."\n";
	        $str .= '    <!-- End Adverts -->'."\n";
	        $str .= '    <div style="clear:both;"></div>'."\n";
	            
	        return "DONE*sl^module#message*$str";
		}
		private function converter_validator_module(){
			$str = '';
			{
				$str .= '    <!-- Bottom Modules -->'."\n";
	            $str .= '        <div class="s5_wrap">'."\n";
	            $str .= '            <div class="s5_bblack_tl"></div>'."\n";
	            $str .= '            <div class="s5_bblack_tm"></div>'."\n";
	            $str .= '            <div class="s5_bblack_tr"></div>'."\n";
	            $str .= '            <div style="clear:both;"></div>'."\n";
	            $str .= '            <div class="s5_bblack_outter">'."\n";
	            $str .= '                <div class="s5_backmiddlemiddle" style="padding-left:8px;">'."\n";
	            $str .= '<div style="padding-top:6px;">';
	            $str .= $this->ModuleStart("1", "100", "", "URL Converter / Validator", "user", TRUE);
	            $str .= '</div>';

	            $results = '';
	            $text = isset($_POST['sl_text']) ? $_POST['sl_text'] : '';
	            //converter
	            if(isset($_POST['sl_converter'])){
					$results .= 'Results:<br/><br/>';
					$results .= htmlentities($this->utf8RawUrlDecode($text));
	            }
	            //form
	            $str .= '<form action="#" onsubmit="sl_gateway.open(\'tools\',this);return false;" method="post">'."\n";
				$str .= '	<input name="sl_text" id="sl_text" type="text" style="width:890px" value="'.str_replace('"','%22',$text).'" /><br/><br/>'."\n";
				$str .= '	<input name="sl_converter" type="submit" value="Convert" /> (decode a URL)  '."\n";
				$str .= '	<input name="sl_validator" type="button" value="Validate" onclick="Validator.validate();return false;" /> (highlight code that would be blocked from the URL)'."\n";
				$str .= '</form><br/>'."\n";
				$str .= '<div id="validator_output">'."\n";
				if(!empty($results)){
					$str .= '<div style="background-color:white;padding:5px;color:black;">'.$results.'<br/><br/></div><br/>'."\n";
				}
				$str .= '</div>';


				$str .= $this->EndModule();
		        $str .= '                        <div style="clear:both;"></div>'."\n";
		        $str .= '                    </div>'."\n";
		        $str .= '                </div>'."\n";
		        $str .= '                <div class="s5_bblack_bl"></div>'."\n";
		        $str .= '                <div class="s5_bblack_bm"></div>'."\n";
		        $str .= '                <div class="s5_bblack_br"></div>'."\n";
		        $str .= '                <div style="clear:both;"></div>'."\n";
		        $str .= '                <div class="s5_leftshadow"></div>'."\n";
		        $str .= '                <div class="s5_rightshadow"></div>'."\n";
		        $str .= '            </div>'."\n";
		        $str .= '            <!-- End Bottom Modules -->'."\n";
		        $str .= '            <div style="clear:both;"></div>'."\n";
			}
			return "DONE*sl^module#message*$str";
		}
		private function file_scanner_module(){
			$str='';
			{
				$str .= '        <!-- Adverts -->';
		        $str .= '        <div class="s5_wrap" >';
		        $str .= '            <div class="s5_w_modwrap">';
		        $str .= '                <div class="s5_backmiddlemiddle2">';
		        $str .= $this->ModuleStart("1", "100", "-light", "File Scanner", "advert", TRUE);

		        $rootContents = array();
		        $helperFile = dirname(__FILE__).'/inc/sl_scan_helper.php';
		        $helperFile = str_replace('\\','/',$helperFile);

		        if(file_exists($helperFile)){
					if(is_writable($helperFile)){
						$contents = file_get_contents($helperFile);
						$term = "lastscan = '";
						$start = strpos($contents,$term)+strlen($term);
						$length = strpos($contents,"'",$start) - $start;
						$lastscan = substr($contents,$start,$length);
						$term = "rootdir = '";
						$start = strpos($contents,$term)+strlen($term);
						$length = strpos($contents,"'",$start) - $start;
						$root = substr($contents,$start,$length);
						$term = "exclude = '";
						$start = strpos($contents,$term)+strlen($term);
						$length = strpos($contents,"'",$start) - $start;
						$exclude = substr($contents,$start,$length);
						$ok = 'ok';
					} else {
						$ok = 'unwritableFile';
						$lastscan = '';
						$root = str_replace('\\','/',dirname(__FILE__)).'/inc';
						$exclude = '';
					}
		        } else {
					if(is_writable(dirname($helperFile))){
						//create the file or give unwritableFolder
						$fp = @fopen($helperFile, 'wb');
						if($fp){
							$ok = 'ok';
							$lastscan = 'never';
							$root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
							$exclude = '';
							fwrite($fp, "<?php\n");
						    fwrite($fp, "/*\n");
						    fwrite($fp, "--config data--\n");
						    fwrite($fp, "lastscan = '$lastscan'\n");
						    fwrite($fp, "rootdir = '$root'\n");
						    fwrite($fp, "exclude = ''\n");
						    fwrite($fp, "--begin scan image--\n");
						    fwrite($fp, "*/\n");
						    fwrite($fp, "?>");
						    fclose($fp);
						} else {
							$ok = 'unwritableFolder';
							$lastscan = 'never';
							$root = str_replace('\\','/',dirname(__FILE__)).'/inc';
							$exclude = '';
						}
					} else {
						$ok = 'unwritableFolder';
						$lastscan = '';
						$root = str_replace('\\','/',dirname(__FILE__)).'/inc';
						$exclude = '';
					}
		        }

		        //get safe files list
		        if($ok == 'ok'){
		        	if($this->config_exists()){
		        		//protect scanner with cookie auth
		        		$auth = '';
		        		if($this->config_exists()){
							include($this->config_fp);
							if(isset($secret)){
								$auth = md5($secret);
							} else {
								@unlink($this->config_fp);
								if($this->config_exists()){
									if(isset($secret)){
										$auth = md5($secret);
									}
								}
							}
						}
						#setcookie('sl_scanner',$auth,0,'/'); removing old auth - in JS below

						$contents = file_get_contents($this->config_fp);
		        		$start = strpos($contents,'/*start_safe_files')+strlen('/*start_safe_files');
		        		$len = strpos($contents,'end_safe_files*/') - $start;
						$safeFiles = trim(substr($contents,$start,$len));
						$safeFiles = substr_count($safeFiles,' ') ? explode(' ',$safeFiles) : (empty($safeFiles) ? null : array($safeFiles));
						if($safeFiles){
							$ext = array_shift($safeFiles);
							$s = "'$ext'";
							foreach($safeFiles as $ext){
								$s .= ",'$ext'";
							}
							$safeFiles = $s;
						}

						//get root contents for displaying
				        if(!empty($root)){
					        $rootContents = array();
					        $thisdir = @scandir($root);
					        if(!$thisdir){
								$root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
					        }
					        $thisdir = @scandir($root);
					        foreach($thisdir as $item){
					            if($item!='.' && $item!='..' && @is_dir($root.'/'.$item)){
					                array_push($rootContents, $root.'/'.$item);
					            }
					        }
				        }
		        	} else {
		        		$ok = 'unwritableFolder';
						$lastscan = '';
						$root = str_replace('\\','/',dirname($this->config_fp));
						$exclude = '';
						$safeFiles = '';
		        	}
		        } else {
					$safeFiles = '';
		        }

				//$str .= '<div id="sl_popup" style="display:none;z-index:9999;position:absolute;left:5px;top:30px;"></div>
				$str .= '<div id="sl_popup" style="display:none;z-index:9999;position:fixed;left:50%;margin-left:-454px;top:30px;"></div>
						<div id="titleButton"></div>
						<div id="actioncenter">
            				<img src="'.$this->filepath.'/images/malicious.png" border="0" width="64px" onclick="SL_Scanner.goTo(\'scanner=malScan\')" alt="Malicious Code Scanner" title="Malicious Code Scanner" style="cursor:pointer;" />
            				<img src="'.$this->filepath.'/images/changes.png" border="0" width="64px" onclick="SL_Scanner.goTo(\'scanner=timeScan\')" alt="File Changes Scanner" title="File Changes Scanner" style="cursor:pointer;" />
            				<img src="'.$this->filepath.'/images/filenames.png" border="0" width="64px" onclick="SL_Scanner.goTo(\'scanner=nameScan\')" alt="File Name Scanner" title="File Name Scanner" style="cursor:pointer;" />
            				<img src="'.$this->filepath.'/images/dbscan.png" border="0" width="64px" onclick="SL_Scanner.goTo(\'scanner=dbScan\')" alt="Database Scanner" title="Database Scanner" style="cursor:pointer;" />
            				<img src="'.$this->filepath.'/images/base64calc.png" border="0" width="64px" onclick="SL_Scanner.openBase64Converter()" alt="Base64 Decoder/Encoder" title="Base64 Decoder/Encoder" style="cursor:pointer;" />
            			</div>
						<div id="headerBarStatus"></div>
						<div id="sl_scanner_output"></div>';
				$scanner = isset($_POST['scanner']) ? $_POST['scanner'] : '';
				$str .= '<script type="text/javascript">
							<!--
							document.cookie = "sl_scanner='.$auth.'; path=/";
							sl_url2 = sl_url+"/";
							sl_url3 = sl_url2+"inc/";
							SL_Scanner.safeFiles = Array('.$safeFiles.');
							SL_Scanner.showMenu("'.$ok.'", "'.$lastscan.'", "'.$root.'", "'.implode("|",$rootContents).'", "'.$exclude.'","'.$scanner.'");
							// -->
						</script>';

				$str .= $this->EndModule();
			    $str .= '            <div style="clear:both;"></div>'."\n";
			    $str .= '        </div>'."\n";
			    $str .= '    </div>'."\n";
			    $str .= '    <div class="s5_w_modbl"></div>'."\n";
			    $str .= '    <div class="s5_w_modbm"></div>'."\n";
			    $str .= '    <div class="s5_w_modbr"></div>'."\n";
			    $str .= '    <div style="clear:both;"></div>'."\n";
			    $str .= '    <div class="s5_leftshadow" ></div>'."\n";
			    $str .= '    <div class="s5_rightshadow" ></div>'."\n";
			    $str .= '    <!-- End Adverts -->'."\n";
			    $str .= '    <div style="clear:both;"></div>'."\n";
			}
			return "DONE*sl^module#message*$str";
		}
		private function map_averages_module(){
			$str = '';
			{
				$retData = $this->sl_post_request('remote4.php', "act=get_attacks&what=map&host=".$this->host);
	            $retData = $retData[0]!="true" ? array() : $retData;
	            $str .= '        <!-- Top Modules -->'."\n";
	            $str .= '        <div class="s5_wrap">'."\n";
	            $str .= '            <div class="s5_toplefrig">'."\n";
	            $str .= '                <div id="s5_topleft" style="width:460px;">'."\n";
	            $str .= '                    <div class="module">'."\n";
	            $str .= '                        <div>'."\n";
	            $str .= '                            <div>'."\n";
	            $str .= '                                <div style="width:460px;">'."\n";
	            $str .= '<script type="text/javascript">
	        				<!-- 
	        				//need to get rid of this and use http://maps.google.com/maps/api/js?sensor=false once google fixes the bug with the getScript function
							window.google = window.google || {};
							google.maps = google.maps || {};
							(function() {
								function getScript(src) {
									scriptElement = document.createElement("script");
									scriptElement.setAttribute("src", src);
									document.body.appendChild(scriptElement);
								}

								var modules = google.maps.modules = {};
								google.maps.__gjsload__ = function(name, text) {
									modules[name] = text;
								};

								google.maps.Load = function(apiLoad) {
									delete google.maps.Load;
									apiLoad([null,[[["http://mt0.google.com/vt?lyrs=m@138\u0026src=api\u0026hl=en-US\u0026","http://mt1.google.com/vt?lyrs=m@138\u0026src=api\u0026hl=en-US\u0026"],null,"foo"],[["http://khm0.google.com/kh?v=74\u0026hl=en-US\u0026","http://khm1.google.com/kh?v=74\u0026hl=en-US\u0026"],null,"foo",null,1],[["http://mt0.google.com/vt?lyrs=h@138\u0026src=api\u0026hl=en-US\u0026","http://mt1.google.com/vt?lyrs=h@138\u0026src=api\u0026hl=en-US\u0026"],null,"foo","imgtp=png32\u0026"],[["http://mt0.google.com/vt?lyrs=t@126,r@138\u0026src=api\u0026hl=en-US\u0026","http://mt1.google.com/vt?lyrs=t@126,r@138\u0026src=api\u0026hl=en-US\u0026"],null,"foo"],null,[[null,0,7,7,[[[330000000,1246050000],[386200000,1293600000]],[[366500000,1297000000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026"]],[null,0,8,9,[[[330000000,1246050000],[386200000,1279600000]],[[345000000,1279600000],[386200000,1286700000]],[[348900000,1286700000],[386200000,1293600000]],[[354690000,1293600000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026"]],[null,0,10,19,[[[329890840,1246055600],[386930130,1284960940]],[[344646740,1284960940],[386930130,1288476560]],[[350277470,1288476560],[386930130,1310531620]],[[370277730,1310531620],[386930130,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1.12\u0026hl=en-US\u0026"]],[null,3,7,7,[[[330000000,1246050000],[386200000,1293600000]],[[366500000,1297000000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026"]],[null,3,8,9,[[[330000000,1246050000],[386200000,1279600000]],[[345000000,1279600000],[386200000,1286700000]],[[348900000,1286700000],[386200000,1293600000]],[[354690000,1293600000],[386200000,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026"]],[null,3,10,null,[[[329890840,1246055600],[386930130,1284960940]],[[344646740,1284960940],[386930130,1288476560]],[[350277470,1288476560],[386930130,1310531620]],[[370277730,1310531620],[386930130,1320034790]]],["http://mt0.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026","http://mt1.gmaptiles.co.kr/mt?v=kr1p.12\u0026hl=en-US\u0026"]]],[["http://cbk0.google.com/cbk?","http://cbk1.google.com/cbk?"],null,"foo"],[["http://khmdb0.google.com/kh?v=33\u0026hl=en-US\u0026","http://khmdb1.google.com/kh?v=33\u0026hl=en-US\u0026"],null,"foo"],[["http://mt0.google.com/mapslt?hl=en-US\u0026","http://mt1.google.com/mapslt?hl=en-US\u0026"],null,"foo"],[["http://mt0.google.com/mapslt/ft?hl=en-US\u0026","http://mt1.google.com/mapslt/ft?hl=en-US\u0026"],null,"foo"]],["en-US","US",null,0,null,"http://maps.google.com","http://maps.gstatic.com/intl/en_us/mapfiles/","http://gg.google.com","https://maps.googleapis.com","http://maps.googleapis.com"],["http://maps.gstatic.com/intl/en_us/mapfiles/api-3/3/0","3.3.0"],[1229228594],1,null,null,null,null,0,""], loadScriptTime);
								};
								var loadScriptTime = (new Date).getTime();
								//getScript("http://maps.gstatic.com/intl/en_us/mapfiles/api-3/3/0/main.js");
							})();
							//-->
				        </script>
				        <script type="text/javascript" src="http://maps.gstatic.com/intl/en_us/mapfiles/api-3/3/0/main.js"></script>
	                        <div id="map_canvas" style="width:440px; height:385px;"></div>
	                            <script type="text/javascript">
	                                function initialize_map(){
	                                    var prev_info = null;
	                                    var center = new google.maps.LatLng(37.37014476413668, 21.97268124999999);
	                                    var myOptions = {
	                                        scrollwheel:false,
	                                        mapTypeControl: true,
	                                        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
	                                        navigationControl: true,
	                                        navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
	                                        zoom: 1,
	                                        center: center,
	                                        mapTypeId: google.maps.MapTypeId.ROADMAP};
	                                    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);'."\n";
	            for($i=1;$i<count($retData);$i++){ //begin loop
	                $atk = isset($retData[$i]) ? $retData[$i] : null;
	                if($atk == 'end' || empty($atk)){
	                    break;
	                }
	                $temp = explode('~',$atk);
	                $ip = $temp[0];
	                $lat_long = $temp[1];
	                if(strlen($lat_long)<5){
	                    continue;
	                }
	                $when = date("m/d/Y H:i:s",intval($temp[2]));
	                $level = $temp[3];
	                $why = $temp[4];
	            	$str .= '        var pos_'.$i.' = new google.maps.LatLng('.$lat_long.');
	                                    var content_'.$i.' = "<strong>IP: </strong>'.$ip.'<br/><strong>When: </strong>'.$when.'<br /><strong>Threat Level: </strong>'.$level.'<br /><strong>Why Blocked: </strong>'.$why.'";
	                                    var info_'.$i.' = new google.maps.InfoWindow({
	                                        position: pos_'.$i.',
	                                        content: content_'.$i.',
	                                        maxWidth: 400});
	                                    var attack_'.$i.'= new google.maps.Marker({
	                                        position: pos_'.$i.',
	                                        map: map,
	                                        title:"'.$why.'"'."\n";
	                //only put icons if not opera
	                if(!preg_match("/opera/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
	                    $str .= '            ,icon: "'.$this->filepath.'/images/blocked_map_img.png"'."\n";
	                }
	            	$str .= '        });
	                                    google.maps.event.addListener(attack_'.$i.', \'click\', function() {
	                                        if(prev_info){
	                                            prev_info.close(map);
	                                        }
	                                        info_'.$i.'.open(map);
	                                        prev_info = info_'.$i.';
	                                    });'."\n";
	            }
	            $str .= '        }
	            				//initialize_map();
	                            </script>
	                            <br/><br/>'."\n";
	            $str .= '                                </div>';
	            $str .= '                            </div>';
	            $str .= '                        </div>';
	            $str .= '                    </div>';
	            $str .= '                </div>';
	            $str .= $this->topRightStart($this->account->domain);
				/*************************************************************************************************/
				$retData = $this->sl_post_request('remote4.php',"act=get_attacks&what=count&host=".$this->host);
				if($retData[0]=='true'){
					$seconds = time() - intval($this->account->start_time);
					$days = ceil($seconds/(60*60*24));
					$ipban = intval($retData[1]);
					$avg1 = number_format($ipban/$days,1);
					$dups = intval($retData[2]);
					$avg2 = number_format($dups/$days,1);
					$bad_bots = intval($retData[3]);
					$avg3 = number_format($bad_bots/$days,1);
				} else {
					$ipban = 0;
					$avg1 = 0;
					$dups = 0;
					$avg2 = 0;
					$bad_bots = 0;
					$avg3 = 0;
				}

            	$str .= "<table width=\"100%\" style=\"font-size:14px;\">
            				<tr>
            					<td colspan=\"3\"><h1>Attack Averages</h1></td>
            				</tr>
            				<tr>
            					<td colspan=\"3\">&nbsp;</td>
            				</tr>
            				<tr>
            					<td>&nbsp;</td>
            					<td align=\"center\">Total</td>
            					<td align=\"center\">Average Per Day</td>
            				</tr>
            				<tr>
            					<td>Blacklisted IPs</td>
            					<td align=\"center\">$ipban</td>
            					<td align=\"center\">$avg1</td>
            				</tr>
            				<tr>
            					<td>Duplicate IPs</td>
            					<td align=\"center\">$dups</td>
            					<td align=\"center\">$avg2</td>
            				</tr>
            				<tr>
            					<td>Bot Attacks</td>
            					<td align=\"center\">$bad_bots</td>
            					<td align=\"center\">$avg3</td>
            				</tr>
            			</table>";


                $str .= $this->topRightEnd ();
                $str .= '                <div style="clear:both;"></div>';
                $str .= '            </div>';
                $str .= '        </div>';
                $str .= '        <!-- End Top Modules -->';
                $str .= '        <div style="clear:both;"></div>';
            }
            return "DONE*sl^module#message*$str";
		}
		private function charts_calendar_module(){
			$str = '';
			{
				$str .= '        <!-- Adverts -->';
		        $str .= '        <div class="s5_wrap" >';
		        $str .= '            <div class="s5_w_modwrap">';
		        $str .= '                <div class="s5_backmiddlemiddle2">';
			    $str .= $this->ModuleStart("1", '50', "-light", "Attack Charts", "advert", true);
			    /****************************************/
			    $retData = $this->sl_post_request('remote4.php',"act=get_attacks&what=charts&host=".$this->host);
	            if($retData[0]=='true'){
	                $str .= str_replace('~',"|",$retData[1]);
	            }

				$str .= $this->EndModule();
				$str .= $this->ModuleStart("1", "50", "-light", "Attack Calendar", "advert", TRUE);
				/****************************************/
				$str .= '<div style="border: 1px solid #ccc !important; margin-left: -20px; width: 460px;min-height:326px;background-color:#fff;">
	                        <div id="sl_calendar_holder"></div>
	                        <noscript>Javascript must be enabled to view the calendar.</noscript>
	                    </div>'."\n";
		        $str .= $this->EndModule();
		        $str .= '            <div style="clear:both;"></div>'."\n";
		        $str .= '        </div>'."\n";
		        $str .= '    </div>'."\n";
		        $str .= '    <div class="s5_w_modbl"></div>'."\n";
		        $str .= '    <div class="s5_w_modbm"></div>'."\n";
		        $str .= '    <div class="s5_w_modbr"></div>'."\n";
		        $str .= '    <div style="clear:both;"></div>'."\n";
		        $str .= '    <div class="s5_leftshadow" ></div>'."\n";
		        $str .= '    <div class="s5_rightshadow" ></div>'."\n";
		        $str .= '    <!-- End Adverts -->'."\n";
		        $str .= '    <div style="clear:both;"></div>'."\n";
            }
			return "DONE*sl^module#message*$str";
		}
		private function attack_log_module(){
			$str = '';
			//logs
			{
				//Stores the IP string to search for or false
				$search = (isset($_POST['IpSearch']) && trim($_POST['IpSearch']) != "" ) ? $_POST['IpSearch'] : false;
				$remIP  = (isset($_POST['IpRemove']) && trim($_POST['IpRemove']) != "" ) ? $_POST['IpRemove'] : false;
								
				if($remIP !== false){
					$arr = array('act'=>'get_attacks','host'=>$this->host,'what'=>'remove', 'ip'=>$remIP);
					$check = $this->sl_post_request('remote4.php',http_build_query($arr,'','&'));
				}
				if(isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['selected_attacks']) && !empty($_POST['selected_attacks'])){
					$sURL = array('act'=>'remove_attack','host'=>$this->host);
					foreach($_POST['selected_attacks'] as $attack){
						$sURL['id'][] = $attack;
					}
					$check = $this->sl_post_request('remote4.php', http_build_query($sURL,'','&'));
				}
					
				
	            $str .= '        <!-- Adverts -->';
	            $str .= '        <div class="s5_wrap" >';
	            $str .= '            <div class="s5_w_modwrap">';
	            $str .= '                <div class="s5_backmiddlemiddle2">';
	            $str .= $this->ModuleStart("1", "100", "-light", "Attack Log <div style='float: right; clear: none; margin-right: 37px;'><a href=\"#\" onclick=\"sl_gateway.open('attacklog','&export_log=1');return false;\"><img src='".$this->filepath."/images/cvs_icon.png' style='margin-top: -4px;' /></a></div>", "advert", TRUE);
	            //$str .= '					<div id="" style="display:none;"></div>'."\n";
	            $str .= ' 					<form id="frmAttacks" style="clear: none;" method="POST" action="#" onsubmit="sl_gateway.open(\'attacklog\',this);return false;">'."\n";
	            $str .= '					<input type="hidden" name="action" value="delete"/>'."\n";
	            $str .= '                    <table>'."\n";
	            $str .= '                        <tr>'."\n";
	            $str .= '                            	 <td><span style="color:#000; font-weight: bold"><input type="checkbox" onclick="sl_Attacks_toggleSelectAll(this);" id="cbToogleSelectAll"/></span></td>'."\n";
	            $str .= '                            	 <td><span style="color:#000; font-weight: bold">#</span></td>'."\n";
	                $str .= '                            <td><span style="color:#000; font-weight: bold">IP Address</span></td>'."\n";
	                $str .= '                            <td><span style="color:#000; font-weight: bold">Attack Type</span></td>'."\n";
	                $str .= '                            <td><span style="color:#000; font-weight: bold">Attack ID</span></td>'."\n";
	                $str .= '                            <td><span style="color:#000; font-weight: bold">Threat Level</span></td>'."\n";
	                $str .= '                            <td><span style="color:#000; font-weight: bold">Date</span></td>'."\n";
	                $str .= '                            <td><span style="color:#000; font-weight: bold">Time</span></td>'."\n";
	            $str .= '                        </tr>'."\n";
	            $length = 30;
	            $start = isset($_POST['id']) ? $_POST['id'] : null;
	            $start = floor($start/30);
	            $start *= 30;
	            //call
	            if($search){
	            	$arr = array('act'=>'get_attacks','host'=>$this->host,'what'=>'search','where'=>$start, 'ip'=>$search);
				}
	            else {
	            	$arr = array('act'=>'get_attacks','host'=>$this->host,'what'=>'logs','where'=>$start);
				}
	            $retData = $this->sl_post_request('remote4.php',http_build_query($arr,'','&'));
	            //loop
	            $total = $retData[1];
	            for($i=2;$i<count($retData)-1;$i++){ //begin loop
	                $counter = $total-$i+2-$start;

	                $atk_arr = explode('~',$retData[$i]);
	                $atk_id = $atk_arr[0];
	                $atk_ip = $atk_arr[1];
	                $atk_date = intval($atk_arr[2]);
	                $atk_type = $atk_arr[3];
	                $threat_level = $atk_arr[4];
	                $country = $atk_arr[5];
	                $atk_ccflag = $this->sl_convert_country($country);

	                $atk_info = explode("~", $this->sl_attack_breakdown($atk_type));
	                $atk_color = $atk_info[0];
	                $why = $atk_info[1];
	                $atk_desc = $atk_info[2];

	                $atk_str = explode("#", $atk_type);
	                $atk_name = str_replace(" - id", "", $atk_str[0]);
	                if(substr_count($atk_str[1],' ')){
	                	$atk_typeid = @trim(reset(explode(' ',$atk_str[1])), '.');
					} else {
						$atk_typeid = trim($atk_str[1], '.');
					}
	                

	                $atk_dte = date("m/d/Y",$atk_date);
	                $atk_tme = date("H:i:s",$atk_date);

	                $str .= '                        <tr>'."\n";
	                $str .= '							 <td width="20px"><input value="'.$atk_id.'~'.$atk_ip.'" type="checkbox" name="selected_attacks[]" id="cbAttack_'.$i.'" /></td>'."\n";
	                $str .= '                            <td width="40px"><span style="color:'.$atk_color.'; font-weight: bold">'.$counter.'</span></td>'."\n";
	                $str .= '                            <td width="125px">'.(!empty($atk_ccflag) ? '<img src="'.$this->filepath.'/images/flags/'.$atk_ccflag.'" alt="'.$country.'" title="'.$country.'" />' : '').' <a href="#" onclick="sl_gateway.open(\'details\',\'&id='.$atk_id.'~'.$atk_ip.'\');return false;"><span style="color:#000; font-weight: bold"><acronym title="View details about '.$atk_ip.'">'.$atk_ip.'</acronym></span></a></td>'."\n";
	                $str .= '                            <td width="400px"><span style="color:'.$atk_color.'; font-weight: bold">'.$this->nicetrim($atk_name, 50).'</span></td>'."\n";
	                $str .= '                            <td width="125px"><span style="color:'.$atk_color.'; font-weight: bold">'.$atk_typeid.'</span></td>'."\n";
	                $str .= '                            <td width="125px" align="center"><acronym title="Threat: '.$threat_level.'">'.$this->LinkThreatLevel($threat_level).'</acronym></td>'."\n";
	                $str .= '                            <td width="100px"><span style="color:'.$atk_color.'; font-weight: bold">'.$atk_dte.'</span></td>'."\n";
	                $str .= '                            <td width="100px"><span style="color:'.$atk_color.'; font-weight: bold">'.$atk_tme.'</span></td>'."\n";
	                $str .= '                        </tr>'."\n";
	            }//  loop though query result to generate TRs
	            
	            $str .= '                        <tr>'."\n";
	            $str .= '                            <td colspan="7" align="right">'."\n";
	        	$str .= '                                  <input type="submit" name="sl_remove_selected" value="Remove Selected" class="submit" style="width: 135px; cursor: pointer; background-image: url(\''.$this->filepath.'/images/submit_long.png\');" onclick="sl_prompt=prompt(\'If you really want to remove this attack from the blacklist, type SECURELIVE in the box and press OK.\');return sl_prompt&&sl_prompt.toLowerCase()==\'securelive\'?true:false;">'."\n";
	            if($start+$length<$total){
	            	$str .= '                               '.($start-$length >= 0 ? '<a href="#" onclick="sl_gateway.open(\'attacklog\',\'&id='.($start-$length).'\');return false;">BACK</a>&nbsp;' : '').$this->sl_page_selector($start, $length, $total).'&nbsp;<a href="#" onclick="sl_gateway.open(\'attacklog\',\'&id='.($start+$length).'\');return false;">MORE</a></td>'."\n";
	            } elseif($start-$length>=0){
	            	$str .= '								<a href="#" onclick="sl_gateway.open(\'attacklog\',\'&id='.($start-$length).'\');return false;">BACK</a>&nbsp;'.$this->sl_page_selector($start, $length, $total)."\n";
	            }
	            $str .= '								</td>'."\n";
	            $str .= '							</tr>'."\n";
	            $str .= '                    </table>'."\n";
	            $str .= ' 			     </form>'."\n";
	            $str .= $this->EndModule();
	            $str .= '            <div style="clear:both;"></div>'."\n";
	            $str .= '        </div>'."\n";
	            $str .= '    </div>'."\n";
	            $str .= '    <div class="s5_w_modbl"></div>'."\n";
	            $str .= '    <div class="s5_w_modbm"></div>'."\n";
	            $str .= '    <div class="s5_w_modbr"></div>'."\n";
	            $str .= '    <div style="clear:both;"></div>'."\n";
	            $str .= '    <div class="s5_leftshadow" ></div>'."\n";
	            $str .= '    <div class="s5_rightshadow" ></div>'."\n";
	            $str .= '    <!-- End Adverts -->'."\n";
	            $str .= '    <div style="clear:both;"></div>'."\n";
	            $str .= '    <!-- Bottom Modules -->'."\n";
	            $str .= '        <div class="s5_wrap">'."\n";
	            $str .= '            <div class="s5_bblack_tl"></div>'."\n";
	            $str .= '            <div class="s5_bblack_tm"></div>'."\n";
	            $str .= '            <div class="s5_bblack_tr"></div>'."\n";
	            $str .= '            <div style="clear:both;"></div>'."\n";
	            $str .= '            <div class="s5_bblack_outter">'."\n";
	            $str .= '                <div class="s5_backmiddlemiddle" style="padding-left:8px;">'."\n";
	            $str .= $this->ModuleStart("1", "100", "", "Information Section", "user", FALSE);
	            $str .= '            <span style="color: #fff; font-weight: bold;">NOTE</span><sup style="color: #ff0000; font-weight: bold;">*</sup> Click on the IP Address to see more detailed information about the attack<br /><br />'."\n";
	            $str .= '			 <div style="margin-bottom: 10px;">'."\n";
	            $str .= '				<table>'."\n";
	            $str .= '					<tbody>'."\n";
	            $str .= '						<tr>'."\n";
	            $str .= '							<td>'."\n";
	            $str .= '			 					<form id="frmIpSearch" style="clear: none;" method="POST" action="#" onsubmit="sl_gateway.open(\'attacklog\',this);return false;">'."\n";
	            $str .= '			 						<div style="clear: none;">Find Attacks By IP:</div>'."\n";
	            $str .= '			 						<input type="text" id="sl_IpSearch" name="IpSearch" value="" />'."\n";
	            $str .= '			 						<input type="submit" value="Search" />'."\n";
	            $str .= '			 					</form>'."\n";
	            $str .= '							</td>'."\n";
	            $str .= '							<td>'."\n";
	            $str .= '			 					<form id="frmIpRemove" style="clear: none;" margin-left: 8px;" method="POST" action="#" onsubmit="sl_prompt=prompt(\'If you really want to remove all instances of this IP, type SECURELIVE in the box and press OK.\');if(!sl_prompt||sl_prompt.toLowerCase()!=\'securelive\'){return false;};sl_gateway.open(\'attacklog\',this);return false;">'."\n";
	            $str .= '							 		<div style="clear: none;">Remove Attacks By IP:</div>'."\n";
	            $str .= '							 		<input type="text" id="sl_IpRemove" name="IpRemove" value="" />'."\n";
	            $str .= '							 		<input type="submit" value="Remove" />'."\n";
	            $str .= '							 	</form>'."\n";
	            $str .= '							</td>'."\n";
	            $str .= '						</tr>'."\n";
	            $str .= '					</tbody>'."\n";
	            $str .= '				</table>'."\n";
	            
	            
	            
	            $str .= '			 </div>'."\n";
	            $str .= $this->EndModule();
	            $str .= '                        <div style="clear:both;"></div>'."\n";
	            $str .= '                    </div>'."\n";
	            $str .= '                </div>'."\n";
	            $str .= '                <div class="s5_bblack_bl"></div>'."\n";
	            $str .= '                <div class="s5_bblack_bm"></div>'."\n";
	            $str .= '                <div class="s5_bblack_br"></div>'."\n";
	            $str .= '                <div style="clear:both;"></div>'."\n";
	            $str .= '                <div class="s5_leftshadow"></div>'."\n";
	            $str .= '                <div class="s5_rightshadow"></div>'."\n";
	            $str .= '            </div>'."\n";
	            $str .= '            <!-- End Bottom Modules -->'."\n";
	            $str .= '            <div style="clear:both;"></div>'."\n";
            }
            //Export
            {
            	if(isset($_POST['export_log'])){
					//Create file...
					$tmpFile = dirname(__FILE__)."/attack_log.php";
					if(file_exists($tmpFile))
						unlink($tmpFile);
            		$f_handel = fOpen($tmpFile,"w");
            		$writeBlock = "<?php
            				header(\"Content-type: application/octet-stream\");
            				header(\"Content-Disposition: attachment; filename=attack_log.csv\");
            			?>#ID,#IP,#Unix Time,#Real Time,#Reason,#Threat,#Country\n";

            		//Loop...
		            for($i = 2; $i < count($retData) -1; $i++){
		            	
		            	$parts = explode("~",$retData[$i]);
		            	
		            	$line = "";
		            	for($pi = 0; $pi < count($parts); $pi++){
		            		$line .= str_replace(",",".",$parts[$pi]).",";
		            		
		            		if($pi == 2){
		            			$line .= str_replace(",",".", date("r", $parts[$pi])).",";	
							}
						}
		            	
		            	$writeBlock .= trim(rtrim($line,","))."\n";
		            	//$writeBlock .= str_replace("~",",", str_replace(",", " ", $retData[$i]))."\n";
					}
					$writeBlock .= "<?php @unlink(__FILE__); ?>";
            		fwrite($f_handel, $writeBlock);
					fClose($f_handel);

					//Java start download
					$dir = $this->sl_get_path()."/attack_log.php";
					$str .= '
						<script type="text/javascript">
							window.open("'.$dir.'");
						</script>
					';
				}
			}
			return "DONE*sl^module#message*$str";
		}
		private function diagnostics_module(){
			$output = '';
			//standard diagnostics
            {
	            $sl_timer = microtime(true);
	            $account = $this->sl_post_request('remote4.php', "act=test_account&host=".$this->host);
	            $sl_timer = microtime(true) - $sl_timer;

		        //curl check
		        $curl = (function_exists('curl_init') && function_exists('curl_exec'));
		        //fopen check
		        $ini_vals = array(1,'1','on','On','ON',true,'true','True','TRUE');
		        $fopen = (function_exists('fopen') && in_array(ini_get('allow_url_fopen'), $ini_vals));

	            $acct_active = $account[0]; // true or reason
				$connected = $this->connected; // type
				$dominfo = $account[1]; //sub~dom
				$php_ver = phpversion(); //actual value
				$client_ip = $account[3];//from our servers, not account
				$client_host = $account[4]; //from our servers, not account
				$file = __FILE__; //abspath
				$docRoot = $_SERVER['DOCUMENT_ROOT'];

				$ver_msg = $this->versionMessage ? $this->versionMessage : $this->getVersionMessage();


		        $output .= '        <!-- Adverts -->';
		        $output .= '        <div class="s5_wrap" >';
		        $output .= '            <div class="s5_w_modwrap">';
		        $output .= '                <div class="s5_backmiddlemiddle2">';
			    $output .= $this->ModuleStart("1", '50', "-light", "Account Verification", "advert", FALSE);
			    /****************************************/
			    //domain
			    //subdomain
			    //active
			    //version
			    $temp = explode('~',$dominfo);
			    $subdomain = $temp[0];
			    $domain = $temp[1];
			    $active = $acct_active=='true' ? 'ACTIVE' : 'DISABLED';
			    $output .= "<br/>Account for <b>$domain</b> is $active<br/><br/>";
			    if($acct_active!='true'){
					$output .= "Reason: $acct_active<br/><br/>";
			    }
			    if(!empty($subdomain)){
					$output .= "Subdomain $subdomain is being used.<br/><br/>";
			    }
			    $output .= "Your version of SecureLive is -$ver_msg";

				$output .= $this->EndModule();
				$output .= $this->ModuleStart("1", "50", "-light", "Test SecureLive", "advert", TRUE);
				/****************************************/
				//ajax test
				$output .= '<br/><input type="button" value="Click to Test" onclick="SL_Test.test(this)" /><br/><br/>';
				$output .= '<div id="sl_test_output"></div>';

		        $output .= $this->EndModule();
		        $output .= '            <div style="clear:both;"></div>'."\n";
		        $output .= '        </div>'."\n";
		        $output .= '    </div>'."\n";
		        $output .= '    <div class="s5_w_modbl"></div>'."\n";
		        $output .= '    <div class="s5_w_modbm"></div>'."\n";
		        $output .= '    <div class="s5_w_modbr"></div>'."\n";
		        $output .= '    <div style="clear:both;"></div>'."\n";
		        $output .= '    <div class="s5_leftshadow" ></div>'."\n";
		        $output .= '    <div class="s5_rightshadow" ></div>'."\n";
		        $output .= '    <!-- End Adverts -->'."\n";
		        $output .= '    <div style="clear:both;"></div>'."\n";
				/////////////////////////////////////////////////////
		        $output .= '    <!-- Bottom Modules -->'."\n";
	            $output .= '        <div class="s5_wrap">'."\n";
	            $output .= '            <div class="s5_bblack_tl"></div>'."\n";
	            $output .= '            <div class="s5_bblack_tm"></div>'."\n";
	            $output .= '            <div class="s5_bblack_tr"></div>'."\n";
	            $output .= '            <div style="clear:both;"></div>'."\n";
	            $output .= '            <div class="s5_bblack_outter">'."\n";
	            $output .= '                <div class="s5_backmiddlemiddle" style="padding-left:8px;">'."\n";
	            $output .= '<div style="padding-top:6px;">';
	            $output .= $this->ModuleStart("1", "50", "", "Connection Info", "user", TRUE);
			    /****************************************/
			    //connection method
			    //speed grade
			    //ip and host
			    if($sl_timer < 0.1){
					$grade = "A+ ($sl_timer seconds)";
			    } elseif($sl_timer < 0.2){
					$grade = "A ($sl_timer seconds)";
			    } elseif($sl_timer < 0.3){
					$grade = "A- ($sl_timer seconds)";
			    } elseif($sl_timer < 0.4){
					$grade = "B+ ($sl_timer seconds)";
			    } elseif($sl_timer < 0.5){
					$grade = "B ($sl_timer seconds)";
			    } elseif($sl_timer < 1){
					$grade = "B- ($sl_timer seconds)";
			    } elseif($sl_timer < 1.5){
					$grade = "C+ ($sl_timer seconds)";
			    } elseif($sl_timer < 2){
					$grade = "C ($sl_timer seconds)";
			    } elseif($sl_timer < 2.5){
					$grade = "C- ($sl_timer seconds)";
			    } elseif($sl_timer < 3){
					$grade = "D+ ($sl_timer seconds)";
			    } elseif($sl_timer < 3.5){
					$grade = "D ($sl_timer seconds)";
			    } elseif($sl_timer < 4){
					$grade = "D- ($sl_timer seconds)";
			    } else {
					$grade = "F ($sl_timer seconds)";
			    }
			    $output .= "Connection Method: $connected<br/><br/>";
			    $output .= "Connection Grade: $grade<br/><br/>";
			    $output .= "Remote IP: $client_ip<br/><br/>";
			    $output .= "Remote Host: $client_host<br/><br/>";

				$output .= $this->EndModule();
				$output .= $this->ModuleStart("1", "50", "", "Server Info", "user", TRUE);
				/****************************************/
				$output .= "PHP version: $php_ver<br/><br/>";
				if($curl){
					$output .= "cURL: enabled<br/><br/>";
				} else {
					$output .= "cURL: disabled<br/><br/>";
				}
				if($fopen){
					$output .= "fopen: enabled<br/><br/>";
				} else {
					$output .= "fopen: disabled<br/><br/>";
				}
				$output .= "Document Root: $docRoot<br/><br/>";
				$output .= "Absolute File Path: $file<br/><br/>";

		        $output .= $this->EndModule();
		        $output .= '                        <div style="clear:both;"></div>'."\n";
		        $output .= '                    </div>'."\n";
		        $output .= '                </div>'."\n";
		        $output .= '                <div class="s5_bblack_bl"></div>'."\n";
		        $output .= '                <div class="s5_bblack_bm"></div>'."\n";
		        $output .= '                <div class="s5_bblack_br"></div>'."\n";
		        $output .= '                <div style="clear:both;"></div>'."\n";
		        $output .= '                <div class="s5_leftshadow"></div>'."\n";
		        $output .= '                <div class="s5_rightshadow"></div>'."\n";
		        $output .= '            </div>'."\n";
		        $output .= '            <!-- End Bottom Modules -->'."\n";
		        $output .= '            <div style="clear:both;"></div>'."\n";
			}
            //CMS specific diagnostics
            {
            	if(!defined('DS')){define( 'DS', DIRECTORY_SEPARATOR );}
				if(!defined('JPATH_BASE')){define('JPATH_BASE', $_SERVER['DOCUMENT_ROOT']);}
				$jFile1 = JPATH_BASE .DS.'includes'.DS.'defines.php';
				$jFile2 = JPATH_BASE .DS.'includes'.DS.'framework.php';
				
				if($this->is_joomla() && file_exists($jFile1) && file_exists($jFile2)){
					
					define( '_JEXEC', 1 );
					include ( $jFile1 );
					include ( $jFile2 );
					
					$this->mainframe =& JFactory::getApplication('site');
					
	                $output .= '        <!-- Adverts -->';
	                $output .= '        <div class="s5_wrap" >';
	                $output .= '            <div class="s5_w_modwrap">';
	                $output .= '                <div class="s5_backmiddlemiddle2">';
	                $output .= $this->ModuleStart("1", "100", "", "Component Diagnosis", "advert", TRUE);

					//check components for bridges
	                $components = JComponentHelper::_Load();
	                $unprotected = array();
	                foreach($components as $com){
						if(substr_count(strtolower($com->name),'bridge')){
							array_push($unprotected,$com->name);
						}
	                }
	                if(count($unprotected)>0 && substr_count($this->account->acct_type,'sj')){
						//show which components and recommend...
						$output .= "Component Scan complete! We detected <b>possible vulnerabilities</b> with the following:<br/><br/>\n";
						foreach($unprotected as $name){
							$output .= "Component: <b>$name</b> is a bridge<br/>\n";
						}
						$output .= "<br/>This means that the components listed \"bridge\" 3rd-party software with Joomla, and SecureJoomla does not protect software that is run outside of Joomla (or that can be accessed outside of Joomla). We recommend that you either upgrade to SecureLive Max, Server Edition, or discontinue use of the 3rd party software that is bridged into Joomla.";
	                } elseif(substr_count($this->account->acct_type,'slm')){
						$output .= "Component Scan complete! You are using SecureLive Server-Edition, so all of your components are currently being protected by SecureLive.\n";
	                } else {
						//say they all passed
						$output .= "Component Scan complete! We did not find any bridges, so all of your components are currently being protected by SecureLive.\n";
	                }

	                $output .= $this->EndModule();
	                $output .= '            <div style="clear:both;"></div>'."\n";
	                $output .= '        </div>'."\n";
	                $output .= '    </div>'."\n";
	                $output .= '    <div class="s5_w_modbl"></div>'."\n";
	                $output .= '    <div class="s5_w_modbm"></div>'."\n";
	                $output .= '    <div class="s5_w_modbr"></div>'."\n";
	                $output .= '    <div style="clear:both;"></div>'."\n";
	                $output .= '    <div class="s5_leftshadow" ></div>'."\n";
	                $output .= '    <div class="s5_rightshadow" ></div>'."\n";
	                $output .= '    <!-- End Adverts -->'."\n";
	                $output .= '    <div style="clear:both;"></div>'."\n";
	                
	                global $sl_admin;
					$sl_admin = $this;
	                
	            }
            }
			return "DONE*sl^module#message*$output";
		}
		private function tickets_module(){
			//the ticket pages are kept in the ajax response this page just sets it up for ajax use
			$preHTML = '        <!-- Adverts -->
								<script type="text/javascript">
									<!--
									memos = new sl_memos();
									//-->
								</script>';
			$preHTML .= '        <div class="s5_wrap" >';
			$preHTML .= '            <div class="s5_w_modwrap">';
			$preHTML .= '                <div class="s5_backmiddlemiddle2">';
			$preHTML .= $this->ModuleStart("1", "100", "", "Support Tickets", "advert", TRUE);
			$preHTML .= '<div id="portal_menu" style="text-align:right;"></div><div id="stats_div">';

			$postHTML = '</div>'.$this->EndModule();
			$postHTML .= '            <div style="clear:both;"></div>'."\n";
			$postHTML .= '        </div>'."\n";
			$postHTML .= '    </div>'."\n";
			$postHTML .= '    <div class="s5_w_modbl"></div>'."\n";
			$postHTML .= '    <div class="s5_w_modbm"></div>'."\n";
			$postHTML .= '    <div class="s5_w_modbr"></div>'."\n";
			$postHTML .= '    <div style="clear:both;"></div>'."\n";
			$postHTML .= '    <div class="s5_leftshadow" ></div>'."\n";
			$postHTML .= '    <div class="s5_rightshadow" ></div>'."\n";
			$postHTML .= '    <!-- End Adverts -->'."\n";
			$postHTML .= '    <div style="clear:both;"></div>'."\n";

			return "DONE*sl^module#message*".$preHTML.$this->ajax_response('inbox').$postHTML;
		}
		private function addons_module(){
			$arr = array('act'=>'get_addons','host'=>$this->host);
		    $response = $this->sl_post_request('remote4.php',http_build_query($arr,'','&'));
		    $response = implode("|",$response);
		    $key = substr($response,0,10);
		    $addons = substr($response,10);
		    $str = '';
		    if($this->is_valid_help($key) && !empty($addons)){
		        $addons = str_replace('<?php','',$addons);
		        $addons = str_replace('?>','',$addons);
				eval($addons);
		    } else {
		        $str .= '        <!-- Adverts -->';
			    $str .= '        <div class="s5_wrap" >';
			    $str .= '            <div class="s5_w_modwrap">';
			    $str .= '                <div class="s5_backmiddlemiddle2">';
			    $str .= $this->ModuleStart("1", "100", "", "SecureLive Additional Products and Services", "advert", false);

				$str .= 'The addons page could not be loaded at this time.';

				$str .= $this->EndModule();
			    $str .= '            <div style="clear:both;"></div>'."\n";
			    $str .= '        </div>'."\n";
			    $str .= '    </div>'."\n";
			    $str .= '    <div class="s5_w_modbl"></div>'."\n";
			    $str .= '    <div class="s5_w_modbm"></div>'."\n";
			    $str .= '    <div class="s5_w_modbr"></div>'."\n";
			    $str .= '    <div style="clear:both;"></div>'."\n";
			    $str .= '    <div class="s5_leftshadow" ></div>'."\n";
			    $str .= '    <div class="s5_rightshadow" ></div>'."\n";
			    $str .= '    <!-- End Adverts -->'."\n";
			    $str .= '    <div style="clear:both;"></div>'."\n";
		    }
		    return "DONE*sl^module#message*$str";
		}
		private function help_module(){
			$arr = array('act'=>'get_help2','host'=>$this->host);
		    $response = $this->sl_post_request('remote4.php',http_build_query($arr,'','&'));
		    $response = implode("|",$response);
		    $key = substr($response,0,10);
		    $help = substr($response,10);
		    $output = '';
		    if($this->is_valid_help($key) && !empty($help)){
		        $help = str_replace('<?php','',$help);
		        $help = str_replace('?>','',$help);
				eval($help);
		    } else {
		        $output .= '        <!-- Adverts -->';
			    $output .= '        <div class="s5_wrap" >';
			    $output .= '            <div class="s5_w_modwrap">';
			    $output .= '                <div class="s5_backmiddlemiddle2">';
			    $output .= $this->ModuleStart("1", "100", "", "SecureLive Help", "advert", false);

				$output .= 'The help page could not be loaded at this time.';

				$output .= $this->EndModule();
			    $output .= '            <div style="clear:both;"></div>'."\n";
			    $output .= '        </div>'."\n";
			    $output .= '    </div>'."\n";
			    $output .= '    <div class="s5_w_modbl"></div>'."\n";
			    $output .= '    <div class="s5_w_modbm"></div>'."\n";
			    $output .= '    <div class="s5_w_modbr"></div>'."\n";
			    $output .= '    <div style="clear:both;"></div>'."\n";
			    $output .= '    <div class="s5_leftshadow" ></div>'."\n";
			    $output .= '    <div class="s5_rightshadow" ></div>'."\n";
			    $output .= '    <!-- End Adverts -->'."\n";
			    $output .= '    <div style="clear:both;"></div>'."\n";
			}
			return "DONE*sl^module#message*$output";
		}
		private function update_module(){
			$message = '';
			$results = '';
			$adminInstalled = false;
			$coreInstalled = false;
			$ver_html = $this->sl_post_request('current_version.inc', 'file');
	        $cur_sl_engine_ver = trim($ver_html[0]);
	        $cur_sl_admin_ver = trim($ver_html[1]);
			
			###################################################TRY ADMIN
			if(version_compare($this->sl_admin_ver,$cur_sl_admin_ver,'<')){
				$installPath = '../';
				$filename = 'sl_admin'.$this->sl_admin_ver.'-'.$cur_sl_admin_ver.'.zip';
				$url = "http://www.securelivesw.com/downloads/$filename";
				
				#get the file
				if(function_exists('curl_init') && function_exists('curl_exec')){
	                $ch = curl_init($url);
	                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        // return web page
	                curl_setopt($ch, CURLOPT_HEADER, false);            // don't return headers
	                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);    // dont follow redirects
	                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 9);        // timeout on connect
	                curl_setopt($ch, CURLOPT_TIMEOUT, 16);                // timeout on response
	                curl_setopt($ch, CURLOPT_ENCODING, "");                // handle all encodings
	                curl_setopt($ch, CURLOPT_USERAGENT, "SecureLive 8.2 Auto Update"); // who am i
	                $archive = curl_exec($ch);
	                curl_close($ch);
	            } else {
	                $archive = @file_get_contents($url);
	            }
	            #got it?
	            if($archive){
					@file_put_contents($filename,$archive);
					#put it?
					if(file_exists($filename)){
						#zip class puts files
						require_once('inc/pclzip.lib.php');
						$archive = new PclZip($filename);
						if($archive->extract(PCLZIP_OPT_PATH, $installPath, PCLZIP_OPT_REPLACE_NEWER) == 0){
							$message = 'FAILED';
							$results .= "<p><font color='red'>Error: Unable to unzip admin archive</font></p>";
						} else {
							$message = 'DONE';
							$adminInstalled = true;
						}
						@unlink($filename);
					} else {
						$message = 'FAILED';
						$results .= "<p><font color='red'>Error: Unable to write admin zip file</font></p>";
					}
	            } else {
					$message = 'FAILED';
					$results .= "<p><font color='red'>Error: Unable to download admin zip</font></p>";
	            }
			} else {
				$message = 'DONE';
				$results .= "<p><font color='red'>Notice: No need to update admin</font></p>";
			}

			###############################################################CORE
			
			
			if(version_compare($this->sl_engine_ver,$cur_sl_engine_ver,'<')){
				$installPath = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']).'/../';
				$filename = 'securelive_max'.$this->sl_engine_ver.'-'.$cur_sl_engine_ver.'.zip';
				$url = "http://www.securelivesw.com/downloads/$filename";
				
				if(!file_exists($installPath.'securelive_max')){
					$installPath = strstr(str_replace('\\','/',__FILE__),'public_html',true);
				}
				
				if(file_exists($installPath.'securelive_max')){
					#get the file
					if(function_exists('curl_init') && function_exists('curl_exec')){
		                $ch = curl_init($url);
		                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        // return web page
		                curl_setopt($ch, CURLOPT_HEADER, false);            // don't return headers
		                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);    // dont follow redirects
		                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 9);        // timeout on connect
		                curl_setopt($ch, CURLOPT_TIMEOUT, 16);                // timeout on response
		                curl_setopt($ch, CURLOPT_ENCODING, "");                // handle all encodings
		                curl_setopt($ch, CURLOPT_USERAGENT, "SecureLive 8.2 Auto Update"); // who am i
		                $archive = curl_exec($ch);
		                curl_close($ch);
		            } else {
		                $archive = @file_get_contents($url);
		            }
		            #got it?
		            if($archive){
						@file_put_contents($filename,$archive);
						#put it?
						if(file_exists($filename)){
							#zip class puts files
							require_once('inc/pclzip.lib.php');
							$archive = new PclZip($filename);
							if($archive->extract(PCLZIP_OPT_PATH, $installPath, PCLZIP_OPT_REPLACE_NEWER) == 0){
								$message = 'FAILED';
								$results .= "<p><font color='red'>Error: Unable to unzip core archive</font></p>";
							} else {
								$message = 'DONE';
								$adminInstalled = true;
							}
							@unlink($filename);
						} else {
							$message = 'FAILED';
							$results .= "<p><font color='red'>Error: Unable to write core zip file</font></p>";
						}
		            } else {
						$message = 'FAILED';
						$results .= "<p><font color='red'>Error: Unable to download core zip</font></p>";
		            }
				} else {
					$message = 'FAILED';
					$results .= "<p><font color='red'>Error: Could not find current core files. Try update from primary domain on server account.</font></p>";
				}
			} else {
				$message = 'DONE';
				$results .= "<p><font color='red'>Notice: No need to update core</font></p>";
			}
			
				
				
			
			
			######################################################DONE
			if($adminInstalled || $coreInstalled){
				$results .= '<script type="text/javascript">sl_force_logout.start(3);</script>';
				$results .= "<p><font color='red'>Success! Your software will automatically log out in <b id=\"sl_force_logout_counter\"></b></font></p>";
			}
			
			
			$output = '        <!-- Adverts -->';
	        $output .= '        <div class="s5_wrap" >';
	        $output .= '            <div class="s5_w_modwrap">';
	        $output .= '                <div class="s5_backmiddlemiddle2">';
	        $output .= $this->ModuleStart("1", "100", "", "System Update", "advert", false);

	        $output .= "		$results";

	        $output .= $this->EndModule();
	        $output .= '            <div style="clear:both;"></div>'."\n";
	        $output .= '        </div>'."\n";
	        $output .= '    </div>'."\n";
	        $output .= '    <div class="s5_w_modbl"></div>'."\n";
	        $output .= '    <div class="s5_w_modbm"></div>'."\n";
	        $output .= '    <div class="s5_w_modbr"></div>'."\n";
	        $output .= '    <div style="clear:both;"></div>'."\n";
	        $output .= '    <div class="s5_leftshadow" ></div>'."\n";
	        $output .= '    <div class="s5_rightshadow" ></div>'."\n";
	        $output .= '    <!-- End Adverts -->'."\n";
	        $output .= '    <div style="clear:both;"></div>'."\n";
			
			return "$message*sl^module#message*$output";
		}

		public function is_page_req(){
			$page = isset($_REQUEST['sl_page']) ? $_REQUEST['sl_page'] : null;
			return ($page=='ajax_module');
		}
		public function page_response(){
			#no auth to exec help, no html given
			if(isset($_GET['sl_module']) && $_GET['sl_module']=='help'){
				$this->help_module();
				return 'Restricted Access';
			}
			#authenticate
			if(!isset($_COOKIE['sl_ajax_auth']) || $this->get_secret()===null || $_COOKIE['sl_ajax_auth']!=$this->get_secret()){
				return 'Unauthorized Request';
	    	}
	    	$module = isset($_POST['sl_module']) ? preg_replace("/[^a-zA-Z0-9_]/",'',$_POST['sl_module']) : null;
			define('SL_Admin',true);
	    	#now return the selected function
	    	return $this->{$module.'_module'}();

		}
		public function loader(){
			/* JS cookie w/ date
			var date = new Date();
			date.setTime(date.getTime()+(24*60*60*1000));
			document.cookie = "sl_ajax_auth='.$this->get_secret().'; expires="+date.toGMTString()+"; path=/";
			*/
			defined('SL_Admin') or die('Restricted Access');
			return '<div id="sl_black_fade" style="display:none;">
						<div id="sl_backdrop_content_wrapper">
							<div>Loading your settings, please wait...</div>
							<a href="javascript:void(0)" onclick="sl_gateway.loader.cancel();return false;" style="position:absolute;top:10px;right:10px;color:#ffffff !important;">CANCEL</a>
							<div id="sl_backdrop_content"></div>
							<div id="sl_loader_graphic"></div>
						</div>
					</div>
					<div id="sl_admin_gateway" style="position:relative;"></div>
					<script type="text/javascript" src="'.$this->sl_get_path().'/inc/sl_gateway.js"></script>
					<script type="text/javascript">
						jQuery.noConflict();
						document.cookie = "sl_ajax_auth='.$this->get_secret().'; path=/";
	                    sl_url = "'.$this->filepath.'";
	                    jQuery(document).ready(function(){sl_gateway.loader.init();});
					</script>';
		}
	}
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
?>