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

	$v = new Validator();	
	unset($v);
	class Validator{
		public $terms;
		public function Validator(){
			if(!isset($_POST['sl_page']) || !isset($_POST['text']) || $_POST['sl_page']!='validator'){
				die('invalid request');
			}
			$arr = array('act'=>'validator','host'=> isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST'),'txt'=>$_POST['text']);
			$this->terms = $this->sl_post_request('remote4.php',http_build_query($arr,'','&'));
			$this->validate();
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
		private function validate(){
			$valid = array_shift($this->terms);
			if($valid=='true'){
                $block_type = array_pop($this->terms);
				$threat_level = array_pop($this->terms);
				echo "<div align='center'>Threat Level: $threat_level<br/><br/>Block Type: $block_type<br/><br/>".$this->highlight_code($this->terms)."</div>";
			} else {
				echo "<div align='center'>$valid</div>";
			}
		}
		public function highlight_code($terms){
    		$pieces = array();
			$haystack_decoded = strtolower(urldecode($_POST['text']));
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
	}
?>