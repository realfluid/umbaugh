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

	error_reporting(E_ALL);
    ini_set('display_errors', 0);
    
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
    
    $what = isset($_REQUEST['what']) ? $_REQUEST['what'] : null;
	$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
    
	$auth = false;
	$lib = new adminFuncs();
	if($lib->config_exists()){
		include($lib->config_fp);
		if(isset($secret)){
			$auth = md5($secret);
		} else {
			@unlink($lib->config_fp);
			if($lib->config_exists()){
				if(isset($secret)){
					$auth = md5($secret);
				}
			}
		}
	}
	
	$authorized = ($auth && $auth==$_COOKIE['sl_scanner']);
	
	if(!$authorized && $what!='timestamp'){
		die("Restricted Access");
	}

    set_time_limit(120);

	if(isset($_POST['sl_page']) && $_POST['sl_page']=='ajax'){
		$str = '';
		if($what == 'dir_tree'){
		    $where = isset($_POST['where']) ? $_POST['where'] : null;
		    $show_arr = array();
		    $thisdir = @scandir($where);
		    if($thisdir){
				foreach($thisdir as $item){
			        if(is_dir($where.'/'.$item) && $item!='.' && $item!='..'){
			            array_push($show_arr, $where.'/'.$item);
			        }
			    }
			    $str .= implode("|",$show_arr);
		    }
		}
		elseif($what == 'new_dir_tree'){
		    $helperFile = dirname(__FILE__).'/sl_scan_helper.php';
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

			$root = isset($_POST['where']) ? $_POST['where'] : str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);

			$rootContents = array();
			$thisdir = @scandir($root);
			if(!$thisdir){
				$root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
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
			$onlyCustom = isset($_POST['onlyCustom']) && $_POST['onlyCustom']==1 ? true : false;
			//get list of terms
			if(!$onlyCustom){
				$funcs = new adminFuncs();
				$arr = array('act'=>'get_mal_scan','host'=>$host);
				$response = $funcs->sl_post_request('remote4.php',http_build_query($arr,'','&'));
				$response = implode("|",$response);
				$response = explode('#sl#',$response);
				if($response[0]=='true'){
					array_shift($response);
					$terms = $response;
				} else {
					$terms = array();
				}
			} else {
				$terms = array();
			}
			
			
			if(!is_dir($root)){
				$root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
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
		elseif($what == 'file_editor'){
			//get vars
			$file = isset($_POST['file']) ? $_POST['file'] : false;
			$line = isset($_POST['line']) ? $_POST['line'] : false;

			$fileEditor = new FileEditor($file,$line);
			if($fileEditor->opening()){
				$str = $fileEditor->open();
			}
		}
		elseif($what == 'count_files'){
			$exclude = isset($_POST['exclude']) ? (substr_count($_POST['exclude'],"|") ? explode("|",$_POST['exclude']) : array($_POST['exclude'])) : array();
			$root = isset($_POST['root']) ? $_POST['root'] : str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
			if(!is_dir($root)){
				$root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
			}
			$str .= count_files($root,$exclude);
		}
		elseif($what=='base64decode' || $what=='base64encode'){
			$text = isset($_POST['text']) ? urldecode($_POST['text']) : '';
			if($what=='base64decode'){
				$str .= htmlentities(base64_decode($text));
			} else {
				$str .= htmlentities(base64_encode($text));
			}
		}
		elseif($what=='fileNameScan'){
			$root = isset($_POST['root']) ? $_POST['root'] : str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
			if(!is_dir($root)){$root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);}
			$exclude = isset($_POST['exclude']) ? (substr_count($_POST['exclude'],"|") ? explode("|",$_POST['exclude']) : array($_POST['exclude'])) : array();
			$exclude = array_filter($exclude);
			$names = isset($_POST['names']) ? $_POST['names'] : array();
			$onlyCustom = isset($_POST['onlyCustom']) && $_POST['onlyCustom']==1 ? true : false;
			if(!$onlyCustom){
				//get names from server
				$funcs = new adminFuncs();
				$arr = array('act'=>'get_filename_scan','host'=>$host);
				$response = $funcs->sl_post_request('remote4.php',http_build_query($arr,'','&'));
				if(substr($response[0],0,4)=='true'){
					//add to array
					$response = implode("|",$response);
					$response = explode('#sl#',$response);
					$response = array_filter($response);
					array_shift($response);
					foreach($response as $name){
						array_push($names,$name);
					}
					$names = array_filter($names);
				} else {
					$str .= $response[0];
				}
			}
			
			//do function if names
			if(count($names)>0){
				$nameFinder = new fileNameScanner();
				$str .= $nameFinder->scan($root,$exclude,$names);
			} else {
				$str .= 'No file names were specified to search for.';
			}
		}
		elseif($what=='savePage'){
			$content = isset($_POST['content']) ? base64_decode($_POST['content']) : '';
			//remove the javascript from content
			if(strpos($content,'SL_Scanner.showMenu')!==false){
				$part1 = substr($content,0,strpos($content,'SL_Scanner.showMenu'));
				$part2 = substr($content,strpos($content,'");',strpos($content,'SL_Scanner.showMenu'))+strlen('");'));
				$content = $part1.$part2;
			}
			
			$head = "<html>\n";
			$head .= "	<head>\n";
			$head .= "		<title>SecureLive Malicous Code Scan Results for ".$_SERVER['HTTP_HOST']." on ".date("m/d/Y H:i:s")."</title>\n";
			$head .= "		<link rel=\"stylesheet\" type=\"text/css\" href=\"css/scanner.css\">\n";
			$head .= "		<!--[if lt IE 8]>\n";
			$head .= "		<link rel=\"stylesheet\" type=\"text/css\" href=\"css/ie7.css\">\n";
			$head .= "		<![endif]-->\n";
			$head .= "		<!--[if gte IE 8]>\n";
			$head .= "		<link rel=\"stylesheet\" type=\"text/css\" href=\"css/ie8.css\">\n";
			$head .= "		<![endif]-->\n";
			$head .= '		<script type="text/javascript" src="js/mootools-release-1.11.js"></script>'."\n";
			$head .= '		<script type="text/javascript" src="js/sl_scanner.js"></script>'."\n";
			$head .= "	</head>\n";
			$head .= "	<body>\n";
			
			$foot = "	</body>\n";
			$foot .= "</html>\n";
			
			$page = $head.$content.$foot;
			$fileName = 'sl_report_'.date("mdy-His").'.html';
			
			$thisDir = str_replace('\\','/',dirname(__FILE__));
			
			if(is_dir($thisDir)){
				$fp = fopen("$thisDir/$fileName",'wb');
			} else {
				//try to make it
				$check = mkdir($thisDir);
				if($check){
					$fp = fopen("$thisDir/$fileName",'wb');
				} else {
					$fp = false;
				}
			}
			
			
			if($fp){
				fwrite($fp,$page);
				fclose($fp);
				$str .= '<div align="center"><h4>Scan Complete!</h4></div>';
				$str .= "<br/><br/><div align=\"center\"><b>Your report has been saved</b> to $fileName ".' <a href="'.$fileName.'" target="_blank" alt="View File" title="View File"><img src="images/external.gif" border="0" /></a></div>';
			} else {
				$str .= '<div align="center"><h4>Scan Complete!</h4></div>';
				$str .= "<b>Unable to save the results</b> to a file in ".str_replace('\\','/',dirname(__FILE__)).". If you would like to save this file, you will need to set the folder to unrestricted permissions, press the \"Try Again\" button below. Once created, you need to restore your previous folder permissions to ensure security.<br/><br/>";
				$str .= '<input type="button" value="Try Again" onclick="SL_Scanner.retrySavePage(this)" />';
			}
		}
		elseif($what=='sl_reports'){
			//give list of reports
			$dirContents = scandir(str_replace('\\','/',dirname(__FILE__)));
			foreach($dirContents as $item){
				if(strpos($item,'sl_report_')==0 && strrpos($item,'.html')==strlen($item)-strlen('.html')){
					//get date and time
					$start = strpos($item,'sl_report_')+strlen('sl_report_');
					$len = strlen($item) - $start - strlen('.html');
					$temp = explode('-',substr($item,$start,$len));
					$date1 = $temp[0];
					$time1 = $temp[1];
					$date = substr($date1,0,2).'/'.substr($date1,2,2).'/'.substr($date1,4,2);
					$time = substr($time1,0,2).':'.substr($time1,2,2).':'.substr($time1,4,2);
					$str .= "<b>Date:</b> $date <b>Time:</b> $time - <a href=\"$item\" target=\"_blank\">$item</a> <img src=\"images/delete2.png\" border=\"0\" style=\"cursor:pointer;\" onclick=\"SL_Scanner.deleteReport('$item',this)\" alt=\"Delete This Report\" title=\"Delete This Report\" /><br/><br/>";
				}
			}
			if($str==''){
				$str .= 'There are currently no reports to show.';
			}
		}
		elseif($what=='delete_report'){
			//delete the file
			$file = isset($_POST['file']) ? $_POST['file'] : false;
			$deleted = 'File Delete Results: ';
			if($file && is_file(str_replace('\\','/',dirname(__FILE__)).'/'.$file) && strpos($file,'sl_report_')==0 && strrpos($file,'.html')==strlen($file)-strlen('.html')){
				$check = unlink(str_replace('\\','/',dirname(__FILE__)).'/'.$file);
				if($check){
					$deleted .= "File $file was deleted successfully!<br/><br/>";
				} else {
					$deleted .= "File $file could not be deleted.<br/><br/>";
				}
			} else {
				$deleted .= "Filename not recognized.<br/><br/>";
			}
			//show results of delete
			$str .= $deleted;
			//give list of reports
			$dirContents = scandir(str_replace('\\','/',dirname(__FILE__)));
			foreach($dirContents as $item){
				if(strpos($item,'sl_report_')==0 && strrpos($item,'.html')==strlen($item)-strlen('.html')){
					//get date and time
					$start = strpos($item,'sl_report_')+strlen('sl_report_');
					$len = strlen($item) - $start - strlen('.html');
					$temp = explode('-',substr($item,$start,$len));
					$date1 = $temp[0];
					$time1 = $temp[1];
					$date = substr($date1,0,2).'/'.substr($date1,2,2).'/'.substr($date1,4,2);
					$time = substr($time1,0,2).':'.substr($time1,2,2).':'.substr($time1,4,2);
					$str .= "<b>Date:</b> $date <b>Time:</b> $time - <a href=\"$item\" target=\"_blank\">$item</a> <img src=\"images/delete2.png\" border=\"0\" style=\"cursor:pointer;\" onclick=\"SL_Scanner.deleteReport('$item',this)\" alt=\"Delete This Report\" title=\"Delete This Report\" /><br/><br/>";
				}
			}
			if($str==''){
				$str .= 'There are currently no reports to show.';
			}
		}
		elseif($what=='dbScan'){
			$ok = true;
			$arr = array('host','db','user','pass','terms');
			foreach($arr as $s){
				${$s} = isset($_POST[$s]) ? $_POST[$s] : false;
				if(!${$s}){
					$ok = false;
				}
				if(is_array(${$s})){
					foreach(${$s} as $k=>$v){
						${$s}[$k] = base64_decode($v);
					}
				} else {
					${$s} = base64_decode(${$s});
				}
			}
			if($ok){
				//try to connect
				$cid = @mysql_connect($host,$user,$pass);
				if(!$cid){
					$str .= 'There was an error connecting to the mySQL server with the given login information: '.@mysql_error($cid);
				} else {
					$check = @mysql_select_db($db,$cid);
					if(!$check){
						$str .= 'There was an error connecting to the specified database: '.mysql_error($cid);
					} else {
						$results = array();
						$tables = array();
						$result = mysql_query('show tables',$cid);
						while($row = mysql_fetch_array($result)){
							array_push($tables,reset($row));
						}
						foreach($tables as $table){
							$columns = array();
							$result = mysql_query("show columns from $table",$cid);
							while($row = mysql_fetch_array($result)){
								array_push($columns,reset($row));
							}
							foreach($terms as $term){
								$safeTerm = mysql_real_escape_string($term,$cid);
								$fieldSQL = '';
								foreach($columns as $column){
									if($fieldSQL!=''){
										$fieldSQL .= ' or ';
									}
									$fieldSQL .= "$column like '%$safeTerm%' ";
								}
								$result = mysql_query("select * from $table where $fieldSQL",$cid);
								while($row = @mysql_fetch_array($result)){
									if(!isset($results[$term])){
										$results[$term] = array();
										$results[$term][$table] = array($row);
									} else {
										if(!isset($results[$safeTerm][$table])){
											$results[$term][$table] = array($row);
										} else {
											array_push($results[$safeTerm][$table],$row);
										}
									}
								}
							}
						}
						foreach($results as $term=>$tables){
							$str .= "<div class=\"termcell\"><b>search term: ".htmlentities($term)."</b>";
							foreach($tables as $table=>$rows){
								$str .= "<div class=\"tablecell\">table: $table";
								foreach($rows as $row){
									$str .= "<div class=\"rowcell\">row id: ".htmlentities(reset($row));
									$fields = '';
									foreach($row as $column=>$value){
										if(is_string($column) && stristr($value,$term)){
											$fields .= $fields=='' ? $column : ", $column";
										}
									}
									$str .= "	<div class=\"columncell\">found in fields: $fields</div>";
									$str .= "</div>";
								}
								$str .= "</div>";
							}
							$str .= "</div>";
						}
						if(count($results)==0){
							$str .= 'No Results';
						}
					}
				}
			} else {
				$str .= 'Sorry, but it looks like we did not receive all the required information. Please try your scan again.';
			}
		}
		echo $str;
	}
	elseif($what=='timestamp'){
		$email = isset($_GET['email']) ? $_GET['email'] : false;
		$root = isset($_GET['root']) ? $_GET['root'] : $_SERVER['DOCUMENT_ROOT'];
		$exclude = isset($_REQUEST['exclude']) ? $_REQUEST['exclude'] : '';
		$scanner = new FileTimeScanner($email,$root,$exclude);
		$response = $scanner->scan();
		#require auth for output
		if($authorized){
			echo ($response);
		}
	}
	elseif($what=='mal_scan'){
		//set vars
		$dir = isset($_POST['dir']) ? $_POST['dir'] : null;
		$file = isset($_POST['file']) ? $_POST['file'] : false;
		$terms = isset($_POST['terms']) ? $_POST['terms'] : false;

		$ini_vals = array('on','On','ON',1,'1','true','True','TRUE');
		if(in_array(ini_get('magic_quotes_gpc'),$ini_vals) && $terms){
			$dir = stripslashes($dir);
			$file = stripslashes($file);
			$terms = stripslashes($terms);
		}

		if($dir && is_dir($dir)){
			$dirDirs = array();
			$dirFiles = array();
			$thisdir = scandir($dir);
		    foreach($thisdir as $item){
		        if(is_dir($dir.'/'.$item) && $item!='.' && $item!='..'){
		            array_push($dirDirs, $dir.'/'.$item);
		        }
		        elseif(is_file($dir.'/'.$item) && $item!='.' && $item!='..'){
		            array_push($dirFiles, $dir.'/'.$item);
		        }
		    }
			$dirDirs = implode("|",$dirDirs);
			$dirFiles = implode("|",$dirFiles);
		} else {
			$dirDirs = '';
			$dirFiles = '';
		}
		if($file){
			$fileWarnings = doMalScan($file,$terms);
			if($fileWarnings){
				$fileWarnings = implode("^sl^",$fileWarnings);
			} else {
				$fileWarnings = '';
			}
		} else {
			$fileWarnings = '';
		}

		echo "$dirDirs#sl#$dirFiles#sl#$fileWarnings";
	}
	else {
		echo "Invalid Request";
	}

	class FileTimeScanner{
		public $email;
		public $root;
		public $excludePaths;
		private $helperFile;
		public function FileTimeScanner($email,$root,$exclude){
			$helperFile = dirname(__FILE__).'/sl_scan_helper.php';
		    $this->helperFile = str_replace('\\','/',$helperFile);

			$this->email = $email;
			if($root=='*last*' || $exclude=='*last*'){
				//get from config
				$contents = file_get_contents($helperFile);
				$term = "lastscan = '";
				$start = strpos($contents,$term)+strlen($term);
				$length = strpos($contents,"'",$start) - $start;
				$lastscan = substr($contents,$start,$length);
				$term = "rootdir = '";
				$start = strpos($contents,$term)+strlen($term);
				$length = strpos($contents,"'",$start) - $start;
				$rootOLD = substr($contents,$start,$length);
				$term = "exclude = '";
				$start = strpos($contents,$term)+strlen($term);
				$length = strpos($contents,"'",$start) - $start;
				$excludeOLD = substr($contents,$start,$length);
				$ok = 'ok';
			}
			if($root=='*last*'){
				$this->root = $rootOLD;
			} else {
				$this->root = ($root);
			}
			if(!is_dir(dirname($this->root))){
				$this->root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
			}
			if($exclude=='*last*'){
				$exclude = $excludeOLD;
			}
			$excludePaths = substr_count($exclude, "|") ? explode("|", $exclude) : array($exclude);
    		$this->excludePaths = array_filter($excludePaths);
		}
		public function scan(){
			$dirListing = $this->list_directory($this->root);// Get recursive file/directory listing

			$total = count($dirListing);
			$count = 0;
			$warn_count = 0;
			$currentDirListing = array();

			// Loop through listing and remove files within exclude paths
		    foreach ($dirListing as $key => $item) {
		        $scanPath = true;
		        if (count($this->excludePaths)>0) {
		            for($i=0; $scanPath == true && $i < count($this->excludePaths); $i++){
		                $temp = $this->root . trim($this->excludePaths[$i]);
		                if (strpos($item, $temp) !== false) { $scanPath = false; } // File is in exclude path, ignore it
		            }
		        }
		        if ($scanPath) {
		            $count++;
		            $percent = floor($count / $total * 100);
		            $fileperms = substr(decoct(fileperms($item)),3);

		            // Test for changes to file via file timestamp
		            $currentDirListing[str_replace($this->root, '', $item)] = filemtime($item)."|$fileperms";
		        }
		        unset($dirListing[$key]);
		    }

		    //////////////////loading previous scan...
		    $previousDirListing = array();
		    $code = file_get_contents($this->helperFile);
		    $code = str_replace('*/','',$code);
		    $code = str_replace('?>','',$code);

		    $term = "lastscan = '";
			$start = strpos($code,$term)+strlen($term);
			$length = strpos($code,"'",$start) - $start;
			$lastscan = substr($code,$start,$length);

		    $start = strpos($code, '--begin scan image--')+20;
		    $prev = substr($code, $start);
		    $temparr = explode("\n", $prev);
		    $temparr = array_filter($temparr);
		    for($i=0;$i<=count($temparr);$i++){
		        if(isset($temparr[$i]) && substr_count($temparr[$i],"!*!")){
		            $temp = explode("!*!", $temparr[$i]);
		            $key = $temp[0];
		            $val = $temp[1];
		            $previousDirListing[$key] = $val;
		        }
		    }
		    /////////////////////////////////saving...
		    $fp = fopen('sl_scan_helper.php', 'wb');
		    fwrite($fp, "<?php\n");
		    fwrite($fp, "/*\n");
		    fwrite($fp, "--config data--\n");
		    fwrite($fp, "lastscan = '".date("M-d-Y, H:i:s")."'\n");
		    fwrite($fp, "rootdir = '".$this->root."'\n");
		    fwrite($fp, "exclude = '".implode("|",$this->excludePaths)."'\n");
		    fwrite($fp, "--begin scan image--\n");
		    foreach($currentDirListing as $key => $val){
		        fwrite($fp, $key . '!*!' . $val . "\n");
		    }
		    fwrite($fp, "*/\n");
		    fwrite($fp, "?>");
		    fclose($fp);

		    /////////////////////////////////////////////////////comparing...
		    $diff = array();
		    $diff['addedFiles'] = array_diff_key($currentDirListing, $previousDirListing); // If files were added, create array of those files
		    $diff['removedFiles'] = array_diff_key($previousDirListing, $currentDirListing); // If files were removed, create array of those files
		    $diff['changedFiles'] = array_diff($currentDirListing, $previousDirListing); // Compare previous scan to this scan, create array of files changed
		    //remove old arrays
		    unset($currentDirListing);
		    unset($previousDirListing);
		    //
		    foreach ($diff['addedFiles'] as $file=>$v) { // Remove list of added files from changed files to prevent duplication in the email
		        unset($diff['changedFiles'][$file]);
		    }
		    foreach ($diff['removedFiles'] as $file=>$v) { // Remove list of deleted files from changes files to prevent duplication in the email
		        unset($diff['changedFiles'][$file]);
		    }
		    $diff['addedFiles'] = array_filter($diff['addedFiles']);//clear null
		    $diff['removedFiles'] = array_filter($diff['removedFiles']);//clear null
		    $diff['changedFiles'] = array_filter($diff['changedFiles']);//clear null

		    ///////////////////////////////////////////////////////////////////////////////done! & email
		    $output = '';
		    $output .= '<b>Scan Complete for '.$_SERVER['HTTP_HOST'].'</b> starting in directory "'.$this->root.'"<br/><br/>'."\n";
		    $output .= 'Results based on previous scan from <b>'.$lastscan.'</b><br/><br/>'."\n";

		    if(count($diff['addedFiles']) > 0){
		        $output .= '<br/><div id="added_files" style="color:white;background-color:red;padding:3px;">Added Files: '.count($diff['addedFiles']).'</div><br/><div id="added_files_div">'."\n";
		        foreach($diff['addedFiles'] as $key => $val){
		            $output .= $key.'<br/>'."\n";
		        }
		        $output .= '</div>';
		    }
		    if(count($diff['removedFiles']) > 0){
		        $output .= '<br/><div id="removed_files" style="color:white;background-color:red;padding:3px;">Removed Files: '.count($diff['removedFiles']).'</div><br/><div id="removed_files_div">'."\n";
		        foreach($diff['removedFiles'] as $key => $val){
		            $output .= $key.'<br/>'."\n";
		        }
		        $output .= '</div>';
		    }
		    if(count($diff['changedFiles']) > 0){
		        $output .= '<br/><div id="changed_files" style="color:white;background-color:red;padding:3px;">Changed Files: '.count($diff['changedFiles']).'</div><br/><div id="changed_files_div">'."\n";
		        foreach($diff['changedFiles'] as $key => $val){
		            $output .= $key.'<br/>'."\n";
		        }
		        $output .= '</div>';
		    }
			if (count($diff['addedFiles']) > 0 || count($diff['removedFiles']) > 0 || count($diff['changedFiles']) > 0) {
		        if(!empty($this->email)){
		        	mail($this->email,'SecureLive has scanned your files for changes',$output,"From: SecureLive Security Advisory <security@securelive.net>\nMIME-Version: 1.0\nContent-type: text/html; charset=iso-8859-1");
					$output .= '<br/><br/><b>A copy of this report has been sent to: '.$this->email.'</b>';
		        }
		    }
		    return $output;

		}
		public function list_directory($dir) {
	        $file_list = '';
	        $stack[] = $dir;

	        $count = 1;

	        while ($stack) {
	            $current_dir = array_pop($stack);
	            $scanPath = true;
	            if (count($this->excludePaths)>0) { // If exclude paths are specified, check for them///
	                for($i=0; $scanPath == true && $i < count($this->excludePaths); $i++){///
	                    $temp = $this->root . trim($this->excludePaths[$i]);
	                    if (strpos($current_dir, $temp) !== false) { $scanPath = false; } // File/Directory is in exclude path, ignore it
	                }
	            }
	            if (($dh = @opendir($current_dir)) && $scanPath == true) {
	                while (($file = readdir($dh)) !== false) {
	                    if ($file !== '.' AND $file !== '..') {
	                        $current_file = "{$current_dir}/{$file}";
	                        if (is_file($current_file)) {
	                            $file_list[] = "{$current_dir}/{$file}";
	                        } elseif (is_dir($current_file)) {
	                            $stack[] = $current_file;
	                        }
	                    }
	                }
	            }
	            @closedir($dh);
	        }
	        return $file_list;
	    }
	}
	function doMalScan($file,$terms1){
		//explode terms
		$terms1 = explode('#sl#',$terms1);
		//$terms1 = array_filter($terms1);
		$terms = array();
		$descriptions = array();
		for($i=0;$i<count($terms1);$i++){
			if($terms1[$i]==''){continue;}
			if(substr_count($terms1[$i],'^sl^')){
				$temp = explode('^sl^',$terms1[$i]);
				array_push($terms,$temp[0]);
				array_push($descriptions,$temp[1]);
			} else {
				//is custom term...strip /..../i for displaying
				$temp = $terms1[$i];
				$strippedTerm = substr($temp,1);
				$strippedTerm = substr($strippedTerm,0,-2);
				$defaultDescription = '<div class="alert"><div class="typo-icon">Found custom term <b>'.htmlentities($strippedTerm).'</b>';
				array_push($terms,preg_quote($temp));
				array_push($descriptions,$defaultDescription);
			}
			
			
		}
		
		$funcs = new adminFuncs();
		$filepath = $funcs->sl_get_path();
		if(substr($filepath,-3)=='inc'){
			$img1 = '<span>&nbsp;&nbsp;</span><a href="javascript:void(0)" onclick="SL_Scanner.findOpenFile(this);return false;"><img src="'.$filepath.'/../images/view.png" border="0" alt="Click to inspect the file" title="Click to inspect the file" /></a>';
			$img2 = '<span>&nbsp;&nbsp;</span><a href="javascript:void(0)" onclick="SL_Scanner.rem(this,2);return false;"><img src="'.$filepath.'/../images/delete2.png" border="0" alt="Click to remove this notice" title="Click to remove this notice" /></a>';
		} else {
			$img1 = '<span>&nbsp;&nbsp;</span><a href="javascript:void(0)" onclick="SL_Scanner.findOpenFile(this);return false;"><img src="'.$filepath.'/images/view.png" border="0" alt="Click to inspect the file" title="Click to inspect the file" /></a>';
			$img2 = '<span>&nbsp;&nbsp;</span><a href="javascript:void(0)" onclick="SL_Scanner.rem(this,2);return false;"><img src="'.$filepath.'/images/delete2.png" border="0" alt="Click to remove this notice" title="Click to remove this notice" /></a>';
		}
		$warnings = array();
		$lines = @file($file);
		if($lines !== false){
			$currentLine = 0;
			foreach($lines as $line){
				$currentLine++;
				for($i=0;$i<count($terms);$i++){
					$term = $terms[$i];
					$desc = $descriptions[$i];
					if(preg_match($term, $line)){
						array_push($warnings,"$desc<span style=\"font-weight: bold;\"> On Line #$currentLine</span><span style=\"font-weight: bold;\"> located here :$file</span>$img1$img2</div></div>");
					}
				}
			}
			if(count($warnings)>0){
				return $warnings;
			} else {
				return false;
			}
		} else {
			return array("<div class=\"alert\"><div class=\"typo-icon\">Unable to open file: <span style=\"font-weight: bold;\"> $file</span>$img2</div></div>");
		}
		
	}
	class FileEditor{
		public $file;
		public $line;
		public function FileEditor($file,$line){
			$this->file = $file;
			$this->line = $line!==false ? intval($line) :false;
		}
		public function opening(){
			return (isset($_POST['action']) && $_POST['action']=='open');
		}
		public function open(){
			//auth to prevent theft
			$auth = 'not authorized';
			$lib = new adminFuncs();
			if($lib->config_exists()){
				include($lib->config_fp);
				if(isset($secret)){
					$auth = md5($secret);
				} else {
					@unlink($lib->config_fp);
					if($lib->config_exists()){
						if(isset($secret)){
							$auth = md5($secret);
						}
					}
				}
			}
			
			if($auth==$_COOKIE['sl_scanner']){
				//open the file, put line numbers, and go to the current line if there is one
				if(is_file($this->file)){
					$lines = file($this->file);
					$text = '';
					$currentLine = 0;
					foreach($lines as $line){
						$currentLine++;
						
						//figure out spaces
						$totalLen = strlen(''.count($lines));
						$thisLen = strlen("$currentLine");
						$add = $totalLen-$thisLen+1;
						$spaces = '';
						for($i=0;$i<$add;$i++){
							$spaces .= '&nbsp;';
						}
						
						if($this->line && $this->line==$currentLine){
							$text .= "<b style=\"color:red;\">"."$currentLine.$spaces".str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",htmlentities($line))."</b>";
						} else {
							$text .= "$currentLine.$spaces".str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",htmlentities($line));
						}
					}
					return '<div class="textarea">File last modified: '.date("m/d/Y H:i:s",filectime($this->file)).'<br/><br/>'.str_replace("\n",'<br/>',$text).'</div>';
				} else {
					return 'The requested file could not be found.';
				}
			} else {
				return 'Your session could not be authenticated.';
			}
		}
	}
	function count_files($root, $exclude){
		$fileCount = 0;
		$dirCount = 0;
	    $stack[] = $root;
	    $badDirs = '';
	    while ($stack) {
	        $current_dir = array_pop($stack);
	        $scanPath = true;
	        if (count($exclude)>0) { // If exclude paths are specified, check for them///
	            for($i=0; $scanPath == true && $i < count($exclude); $i++){///
	                $temp = $root . trim($exclude[$i]);
	                if (strpos($current_dir, $temp) !== false) {
	                	$scanPath = false; 
	                }
	            }
	        }
	        if (($dh = @opendir($current_dir)) && $scanPath == true) {
	            while (($file = readdir($dh)) !== false) {
	                if ($file !== '.' AND $file !== '..') {
	                    $current_file = "{$current_dir}/{$file}";
	                    if (is_file($current_file)) {
	                        $fileCount++;
	                    } elseif (is_dir($current_file)) {
	                    	$dirOK = true;
	                    	if (count($exclude)>0) { // If exclude paths are specified, check for them///
					            for($i=0; $dirOK == true && $i < count($exclude); $i++){///
					                $temp = $root . trim($exclude[$i]);
					                if (strpos($current_file, $temp) !== false) {
	                					$dirOK = false;
					                }
					            }
					        } 
					        if($dirOK){
								$stack[] = $current_file;
	                        	$dirCount++;
					        }
	                    }
	                }
	            }
	            closedir($dh);
	        } else {
				$badDirs .= strlen($badDirs) > 0 ? '<br/><br/>'.$current_dir : '<br/>'.$current_dir;
	        }
	    }
	    return "$badDirs|$fileCount|$dirCount";
	}
	class fileNameScanner{
		public function scan($root,$exclude,$names){
			$fileList = array();
			$stack[] = $root;
		    while($stack) {
		        $current_dir = array_pop($stack);
		        $scanPath = true;
		        if (count($exclude)>0) { // If exclude paths are specified, check for them///
		            for($i=0; $scanPath == true && $i < count($exclude); $i++){///
		                $temp = $root . trim($exclude[$i]);
		                if (strpos($current_dir, $temp) !== false) {
	                		$scanPath = false; 
		                }
		            }
		        }
		        if (($dh = @opendir($current_dir)) && $scanPath == true) {
		            while (($file = readdir($dh)) !== false) {
		                if ($file !== '.' AND $file !== '..') {
		                    $current_file = "{$current_dir}/{$file}";
		                    if (is_file($current_file)) {
		                        if($this->match(basename($current_file),$names)){
									array_push($fileList,'<div onclick="SL_Scanner.openFile(\''.$current_file.'\',false)" style="cursor:pointer;">'.dirname($current_file).'/<b>'.basename($current_file).'</b></div>');
		                        }
		                    } elseif (is_dir($current_file)) {
	                    		$stack[] = $current_file;
		                    }
		                }
		            }
		        }
		        @closedir($dh);
		    }
		    if(count($fileList)>0){
				return "The following files matched your search:<br/><br/>".implode("\n",$fileList);
		    } else {
				return "No files matched your search.";
		    }
		}
		private function match($file,$names){
			foreach($names as $name){
				$matched = true;
				if(substr_count($name,'*')){
					$parts = explode("*",$name);

					$remainder = $file;
					for($i=0;$i<count($parts) && $matched;$i++){
						$part = $parts[$i];
						if($part==''){
							continue;
						} else {
							if(substr_count($part,'?')){
								$subParts = explode('?',$part);
								$q_count = -1;
								for($j=0;$j<count($subParts) && $matched;$j++){
									$subPart = $subParts[$j];
									$q_count++;
									if($subPart=='' && $j<count($subParts)-1){
										continue;
									} else {
										if(strripos($remainder,$subPart)!==false && stripos($remainder,$subPart)<=$q_count){
											//see if at end - looking at end of parts not subparts
											if($i==count($parts)-1 && $j==count($subParts)-1 && strlen($remainder) > strlen($subPart)+$q_count){
												$matched = false;
												break;
											}
											$q_count = 0;
											$remainder = substr($remainder,stripos($remainder,$subPart)+strlen($subPart));
							
										} elseif(strripos($remainder,$subPart)!==false && strlen($remainder)-strripos($remainder,$subPart)<=strlen($subPart)+$q_count){
											if($i==count($parts)-1 && $j==count($subParts)-1 && strlen($remainder)-strripos($remainder,$subPart)>strlen($subPart)+$q_count){
												$matched = false;
												break;
											}
											$q_count = 0;
											$remainder = substr($remainder,stripos($remainder,$subPart)+strlen($subPart));
										} else {
											if($q_count == 0){
												$remainder = substr($remainder,stripos($remainder,$subPart)+strlen($subPart));
											} else {
												$matched = false;
												break;
											}
										}
									}
								}
							} else {
								//see if part at start or after *
								if((stripos($remainder,$part)===0 && $i==0) || (stripos($remainder,$part)!==false && $i>0)){
									//remove any before match and see if at end
									$remainder = substr($remainder,stripos($remainder,$part));
									if($i==count($parts)-1 && strlen($remainder) > strlen($part)){
										$matched = false;
										break;
									}
									$remainder = substr($remainder,stripos($remainder,$part)+strlen($part));
								} else {
									$matched = false;
									break;
								}
							}
						}
					}
				} else {
					if(substr_count($name,'?')){
						//only has ?
						$parts = explode("?",$name);
						
						$q_count = -1;
						$remainder = $file;
						for($i=0;$i<count($parts) && $matched;$i++){
							$part = $parts[$i];
							$q_count++;
							if($part=='' && $i<count($parts)-1){
								continue;
							} else {
								
								if(stripos($remainder,$part)<=$q_count && stripos($remainder,$part)!==false){
									//see if at end
									if($i==count($parts)-1 && strlen($remainder) > strlen($part)+$q_count){
										
										$matched = false;
										break;
									}
									$q_count = 0;
									$remainder = substr($remainder,stripos($remainder,$part)+strlen($part));
								} else {
									if($part==''){
										$q_count = 0;
										$remainder = substr($remainder,1);
									} else {
										$matched = false;
										break;
									}
								}
							}
						}
					} else {
						//no modifiers
						$matched = false;
						if($file==$name){
							return true;
						}
					}
				}
				if($matched){
					return true;
				}
			}
			return false;
		}
	}
?>