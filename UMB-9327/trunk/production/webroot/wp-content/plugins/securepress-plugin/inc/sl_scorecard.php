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

	/**
	*	SecureLive Score Card Addon Pack for SecureLive 8.x
	* 	This will rate your server and SecureLive activity
	* 	into a number from 0.1 to 9.9. 0.1 is the lowest
	* 	and best possible score. Scoring will come from the
	* 	values found in the php.ini file and the ability
	* 	for SecureLive to run and function properly. Other
	* 	factors may include, the number of attacks on your
	* 	site, and the location of some of these attacks.
	*/

	defined('SL_Admin_scorecard') or die('Restricted Access');
	$n = "\n";
	$pass = array();
	$warnings = array();
	$critical = array();
	$phpscore = 0.0;
	$slscore = 0.0;
	$cmsscore = 0.0;
	
	//$rs = $this->QueryDB("SELECT `time` FROM !spamfilter WHERE type=0 AND term='#Enabled#'", true);
	$spamFilterEnabled = (count($rs = $this->QueryDB("SELECT `time` FROM !spamfilter WHERE type=0 AND term='#Enabled#'", true)) > 0) ? ($rs[0][0] == "1") : false;
	
	$versions = $this->sl_post_request('current_version.inc', "file");
	
	/**
	*	Get PHP.ini True/False Settings, start scoring from these values
	*/
	{
		if(getPHPiniValues('allow_url_fopen')){
			array_push($warnings, "<b>allow_url_fopen</b> - If enabled, allow_url_fopen allows PHP's file functions, such as file_get_contents() and the include and require statements can retrieve data from remote locations, like an FTP or web site. Programmers frequently forget this and don't do proper input filtering when passing user-provided data to these functions, opening them up to code injection vulnerabilities. A large number of code injection vulnerabilities reported in PHP-based web applications are caused by the combination of enabling allow_url_fopen and bad input filtering. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=allow_url_fopen\");return false;'>What do I do?</a>");
			$phpscore += 0.5;
		} else {
			array_push($pass, "allow_url_fopen  - Allows PHP's file functions, such as file_get_contents() and the include and require statements can retrieve data from remote locations, like an FTP or web site. Programmers frequently forget this and don't do proper input filtering when passing user-provided data to these functions, opening them up to code injection vulnerabilities. A large number of code injection vulnerabilities reported in PHP-based web applications are caused by the combination of enabling allow_url_fopen and bad input filtering.");
		}

		if(getPHPiniValues('allow_url_include')){
			array_push($warnings, "<b>allow_url_include</b> - If disabled, allow_url_include bars remote file access via the include and require statements, but leaves it available for other file functions like fopen() and file_get_contents. include and require  are the most common attack points for code injection attempts, so this setting plugs that particular hole without affecting the remote file access capabilities of the standard file functions. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=allow_url_include\");return false;'>What do I do?</a>");
			$phpscore += 1.8;
		} else {
			array_push($pass, "allow_url_include - If disabled, allow_url_include bars remote file access via the include and require statements, but leaves it available for other file functions like fopen() and file_get_contents. include and require  are the most common attack points for code injection attempts, so this setting plugs that particular hole without affecting the remote file access capabilities of the standard file functions.");
		}

		if(getPHPiniValues('display_errors')){
			array_push($warnings, "<b>display_errors </b> - The display_errors directive determines whether error messages should be sent to the browser. These messages frequently contain sensitive information about your web application environment, and should never be presented to untrusted sources. display_errors is on by default. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=display_errors\");return false;'>What do I do?</a>");
			$phpscore +=  0.15;
		} else {
			array_push($pass, "display_errors - The display_errors directive determines whether error messages should be sent to the browser. These messages frequently contain sensitive information about your web application environment, and should never be presented to untrusted sources. display_errors is on by default.");
		}

		if(getPHPiniValues('expose_php')){
			array_push($warnings, "<b>expose_php</b> - When enabled, expose_php reports in every request that PHP is being used to process the request, and what version of PHP is installed. Malicious users looking for potentially vulnerable targets can use this to identify a weakness. expose_php is enabled by default. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=expose_php\");return false;'>What do I do?</a>");
			$phpscore += 0.15;
		} else {
			array_push($pass, "expose_php - When enabled, expose_php reports in every request that PHP is being used to process the request, and what version of PHP is installed. Malicious users looking for potentially vulnerable targets can use this to identify a weakness. expose_php is enabled by default.");
		}

		if(getPHPiniValues('file_uploads')){
			array_push($warnings, "<b>file_uploads</b> - When you allow files to be uploaded to your system you assume a number of risks, files may not be what the appear (executables masquerading as images, php scripts uploaded and moved to a location where they may be run, et-cetera). If your site doesn't actually require file uploads, disabling this will prevent files from being accepted inadvertently. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=file_uploads\");return false;'>What do I do?</a>");
			$phpscore += 0.2;
		} else {
			array_push($pass, "file_uploads - When you allow files to be uploaded to your system you assume a number of risks, files may not be what the appear (executables masquerading as images, php scripts uploaded and moved to a location where they may be run, et-cetera). If your site doesn't actually require file uploads, disabling this will prevent files from being accepted inadvertently.");
		}

		if(getPHPiniValues('magic_quotes_gpc')){
			array_push($warnings, "<b>magic_quotes_gpc</b> - The magic quotes option was introduced to help protect developers from SQL injection attacks. It effectively executes addslashes() on all information received over GET, POST or COOKIE. Unfortunately this protection isn't perfect: there are a series of other characters that databases interpret as special not covered by this function. In addition, data not sent direct to databases must un-escaped before it can be used. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=magic_quotes_gpc\");return false;'>What do I do?</a>");
			$phpscore += 0.9;
		} else {
			array_push($pass, "magic_quotes_gpc - The magic quotes option was introduced to help protect developers from SQL injection attacks. It effectively executes addslashes() on all information received over GET, POST or COOKIE. Unfortunately this protection isn't perfect: there are a series of other characters that databases interpret as special not covered by this function. In addition, data not sent direct to databases must un-escaped before it can be used.");
		}

		if(getPHPiniValues('open_basedir')){
			array_push($pass, "open_basedir  - open_basedir limits the PHP process from accessing files outside of specifically designated directories. Remember this setting will only affect PHP scripts. Applications written in other languages (Perl, Python, Ruby, etc.) will not be affected.");
		} else {
			array_push($warnings, "<b>open_basedir</b> - open_basedir limits the PHP process from accessing files outside of specifically designated directories. Remember this setting will only affect PHP scripts. Applications written in other languages (Perl, Python, Ruby, etc.) will not be affected. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=open_basedir\");return false;'>What do I do?</a>");
			$phpscore += 1.6;
		}

		if(getPHPiniValues('register_globals')){
			array_push($warnings, "<b>register_globals</b> - When register_globals is enabled, PHP will automatically create variables in the global scope for any value passed in GET, POST or COOKIE. This, combined with the use of variables without initialization, has lead to numerous security vulnerabilities. Since application developers should be aware when accessing tainted user input, it is better practice to access the variables through their respective super globals. <br /><br />register_globals will not be available in PHP 6. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=register_globals\");return false;'>What do I do?</a>");
			$phpscore += 0.4;
		} else {
			array_push($pass, "register_globals - When register_globals is enabled, PHP will automatically create variables in the global scope for any value passed in GET, POST or COOKIE. This, combined with the use of variables without initialization, has lead to numerous security vulnerabilities. Since application developers should be aware when accessing tainted user input, it is better practice to access the variables through their respective super globals. <br /><br />register_globals will not be available in PHP 6.");
		}

		if(getPHPiniValues('session.use_trans_sid')){
			array_push($warnings, "<b>session.use_trans_sid</b> - When use_trans_sid is enabled, PHP will pass the session ID via the URL. This makes it far easier for a malicious party to obtain an active session ID and hijack the session. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=session.use_trans_sid\");return false;'>What do I do?</a>");
			$phpscore += .8;
		} else {
			array_push($pass, "session.use_trans_sid  - When use_trans_sid is enabled, PHP will pass the session ID via the URL. This makes it far easier for a malicious party to obtain an active session ID and hijack the session.");
		}

		if(getPHPiniValues('cgi.force_redirect')){
			array_push($pass, "cgi.force_redirect - In a typical Apache+PHP-CGI setup, the PHP binary is located underneath the web site's document root.<br /><br />By default, cgi.force_redirect is enabled.<br /><br />Note that some web servers, like IIS and OmniHTTPD, require cgi.force_redirect to be disabled.");
		} else {
			array_push($warnings, "<b>cgi.force_redirect</b> - In a typical Apache+PHP-CGI setup, the PHP binary is located underneath the web site's document root.<br /><br />By default, cgi.force_redirect is enabled.<br /><br />Note that some web servers, like IIS and OmniHTTPD, require cgi.force_redirect to be disabled. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=cgi.force_redirect\");return false;'>What do I do?</a>");
			$phpscore += 1.9;
		}
	}

	/**
	*	Gather PHP and cURL versions, test for other outdated information
	* 	on the server which may or maynot be changed.
	*/
	{
		if (version_compare(PHP_VERSION, '5.1.6', '>=')){
			array_push($pass, "php_version - You are running PHP 5.1.6 or greater.");
		} else {
			array_push($warnings, "<b>php_version</b> - You are running PHP 5.1.5 or lower. A security hole is present in the cURL functions that allow it to bypass safe_mode and open_basedir restrictions. Contact your host to update your version of PHP. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=php_version\");return false;'>What do I do?</a>");
			$slscore += 1.2;
		}

		if (strpos(realpath("./"), get_current_user())) {
			array_push($pass, "suphp - SuPHP allows scripts to be executated with the permissions of their owner.");
		} else {
			array_push($warnings, "suphp  - SuPHP allows scripts to be ran with the permissions of there owner. Contact your host about getting SuPHP installed on your system. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=SuPHP\");return false;'>What do I do?</a>");
			$slscore += .7;
		}
	}

	/**
	*	Gather Information about SecureLive's setup, inform them for each
	* 	item that is not correct. Including E-Mails and other system
	* 	settings
	*/
	{
		# Is this a Server Edition
		if(empty($this->account->se_primary)){
			// $output .= "No SE Owner<br/>\n";
		} else {
			// $output .= $this->account->se_primary."<br/>\n";
			if(strpos(getPHPiniValues('auto_prepend_file'), "sl8")){
				array_push($pass, "sl8 - Your version of SecureLive is up-to-date.");
			} else {
				array_push($warnings, "<b>sl8</b> - Your version of SecureLive is outdated. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=SL_Version\");return false;'>What do I do?</a>");
				$slscore += 9.9;
			}

		}

		# Is suPHP running?
		if (in_array("suphp", $pass)){
			# Check for 777 files and folders - Score 1.9 for each max 9.5
		} else {
			# Check for 777 files and folders - Score 0.1 for each max 0.5
		}

		# Check for disabled important E-Mail settings - Score 0.15 for each
		{
			if (strpos($this->account->email_select, "sh")!==false){
				array_push($pass, "shellattacks - Attacks of this type will send an attack report.");
			} else {
				array_push($warnings, "<b>shellattacks</b> - Reporting option for this type of attack has been disabled. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=e-mail_report\");return false;'>What do I do?</a>");
				$slscore += .15;
			}

			if (strpos($this->account->email_select, "si")!==false){
				array_push($pass, "sqlinjection - Attacks of this type will send an attack report.");
			} else {
				array_push($warnings, "<b>sqlinjection</b> - Reporting option for this type of attack has been disabled. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=e-mail_report\");return false;'>What do I do?</a>");
				$slscore += .15;
			}

			if (strpos($this->account->email_select, "pi")!==false){
				array_push($pass, "phpinjection - Attacks of this type will send an attack report.");
			} else {
				array_push($warnings, "<b>phpinjection</b> - Reporting option for this type of attack has been disabled. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=e-mail_report\");return false;'>What do I do?</a>");
				$slscore += .15;
			}

			if (strpos($this->account->email_select, "xa")!==false){
				array_push($pass, "xssinjection - Attacks of this type will send an attack report.");
			} else {
				array_push($warnings, "<b>xssinjection</b> - Reporting option for this type of attack has been disabled. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=e-mail_report\");return false;'>What do I do?</a>");
				$slscore += .15;
			}

			if (strpos($this->account->email_select, "fi")!==false){
				array_push($pass, "remotefileincludes - Attacks of this type will send an attack report.");
			} else {
				array_push($warnings, "<b>remotefileincludes</b> - Reporting option for this type of attack has been disabled. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=e-mail_report\");return false;'>What do I do?</a>");
				$slscore += .15;
			}

			if (strpos($this->account->email_select, "ta")!==false){
				array_push($pass, "transversalattacks - Attacks of this type will send an attack report.");
			} else {
				array_push($warnings, "<b>transversalattacks</b> - Reporting option for this type of attack has been disabled. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=e-mail_report\");return false;'>What do I do?</a>");
				$slscore += .15;
			}

			if (strpos($this->account->email_select, "px")!==false){
				array_push($pass, "postxss - Attacks of this type will send an attack report.");
			} else {
				array_push($warnings, "<b>postxss</b> - Reporting option for this type of attack has been disabled. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=e-mail_report\");return false;'>What do I do?</a>");
				$slscore += .15;
			}

			if (strpos($this->account->email_select, "fl")!==false){
				array_push($pass, "floodlimit - Attacks of this type will send an attack report.");
			} else {
				array_push($warnings, "<b>floodlimit</b> - Reporting option for this type of attack has been disabled <a href='#' onclick='sl_gateway.open(\"help\",\"&id=e-mail_report\");return false;'>What do I do?</a>.");
				$slscore += .15;
			}

			if (strpos($this->account->email_select, "sa")!==false){
				array_push($pass, "serverattacks - Attacks of this type will send an attack report.");
			} else {
				array_push($warnings, "<b>serverattacks</b> - Reporting option for this type of attack has been disabled. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=e-mail_report\");return false;'>What do I do?</a>");
				$slscore += .15;
			}

			if (strpos($this->account->email_select, "na")!==false){
				array_push($pass, "nestingattacks - Attacks of this type will send an attack report.");
			} else {
				array_push($warnings, "<b>nestingattacks</b> - Reporting option for this type of attack has been disabled. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=e-mail_report\");return false;'>What do I do?</a>");
				$slscore += .15;
			}

		}

		# Check for autoDiagnostics query string - Score 9.9

		# Registration checking on
		if ($spamFilterEnabled){
			array_push($pass, "Spam E-Mail User Registration enabled.");
		} else {
			array_push($warnings, "<b>Spam User Registration</b> - is currently disabled, although this is a low score, this will eliminate many of the known spammers that are trying to register on your site. You may use the boxes on the System Overview page to add or remove any values. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=term_list\");return false;'>What do I do?</a>");
			$slscore += .25;
		}

		# Check for latest version - Score 6.8

		# Check for Name, Phone Number, Reporting E-Mail, Contact E-Mail - Score 3.2
		if ($this->account->fname == "" || $this->account->lname == "" || $this->account->phone == "" || $this->account->c_email == "" || $this->account->r_email == ""){
			if ($this->account->fname == ""){
				array_push($warnings, "<b>Account First Name</b> - missing inforamtion. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=account_information\");return false;'>What do I do?</a>");
			} else {
				array_push($pass, "Account First Name - given.");
			}
			if ($this->account->lname == ""){
				array_push($warnings, "<b>Account Last Name</b> - missing inforamtion. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=account_information\");return false;'>What do I do?</a>");
			} else {
				array_push($pass, "Account Last Name - given.");
			}
			if ($this->account->phone == ""){
				array_push($warnings, "<b>Account Phone</b> - missing inforamtion. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=account_information\");return false;'>What do I do?</a>");
			} else {
				array_push($pass, "Account Phone - given.");
			}
			if ($this->account->c_email == ""){
				array_push($warnings, "<b>Account Contact E-Mail</b> - missing inforamtion. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=account_information\");return false;'>What do I do?</a>");
			} else {
				array_push($pass, "Account Contact E-Mail - given.");
			}
			if ($this->account->r_email == ""){
				array_push($warnings, "<b>Account Reporting E-Mail</b> - missing inforamtion. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=account_information\");return false;'>What do I do?</a>");
			} else {
				array_push($pass, "Account Reporting E-Mail - given.");
			}
			$slscore += 3.2;
		}

		# Check for access word  - Score 0.9
		if ($this->account->accessword == ""){
			array_push($warnings, "<b>accessword</b> - Setting an accessword allows you to hide your CMS administrator login page. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=program_settings\");return false;'>What do I do?</a>");
			$slscore += .9;
		} else {
			array_push($pass, "accessword - Your CMS administrator login page is hidden by an accessword.");
		}

		# Check for Bot Blocking  - Score 0.4
		if ($this->account->bot_lvl == "1"){
			array_push($warnings, "<b>Bots</b> - Current settings don't prevent bad bots. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=program_settings\");return false;'>What do I do?</a>");
			$slscore += .4;
		} else {
			array_push($pass, "Bots - Current Settings prevent bad bots.");
		}

		# Check for Frame Buster - Score 0.35
		if ($this->account->frame_buster == "0"){
			array_push($warnings, "<b>frame_buster</b> - Your page can currently be loaded on an external webpage in an IFrame tag. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=program_settings\");return false;'>What do I do?</a>");
			$slscore += .35;
		} else {
			array_push($pass, "frame_buster - Your page cannot be loaded onto an external webpage in an IFrame tag.");
		}

		# Check for Debug Mode - Score 3.7
		if ($this->account->debug=="1"){
			array_push($warnings, "<b>debug<b/> - Debug mode allows for faster diagnostics of your SecureLive install, but should remain off. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=program_settings\");return false;'>What do I do?</a>");
			$slscore += 3.7;
		} else {
			array_push($pass, "debug - Debug mode allows for faster diagnostics of your SecureLive install, but should remain off.");
		}

		# Check for Debug Mode - Score 1.7  ------ Duplicate?
		/*if ($this->account->debug=="1"){
			array_push($warnings, "debug");
			$slscore += 3.7;
		} else {
			array_push($pass, "debug");
		}*/

		# Check for File Scanner ever ran? - $slscore 2.2





		#NEED TO SET SECRET DESCRIPTION BELOW..................





		#CHECK CONFIG SETTINGS, bypass_arr, dir_bypass_arr, secret
		$secret_description = "if the secret word is not set....need temporary 777 folder at ".dirname($this->config_fp);

		if($this->config_exists()){
			include($this->config_fp);

			# Check for Bypass Filter settings - Score 0.3 for each
			if(isset($this->bypass_arr) && count($this->bypass_arr)){
				array_push($warnings, "bypass|".count($this->bypass_arr)."<a href='#' onclick='sl_gateway.open(\"help\",\"&id=bypass_post\");return false;'>What do I do?</a>");
				$slscore += (0.3*count($this->bypass_arr));
			}
			if(isset($this->dir_bypass_arr) && count($this->dir_bypass_arr)){
				array_push($warnings, "dir_bypass|".count($this->dir_bypass_arr)."<a href='#' onclick='sl_gateway.open(\"help\",\"&id=bypass_post\");return false;'>What do I do?</a>");
				$slscore += (0.3*count($this->dir_bypass_arr));
			}

			#check for secret word
			if(!isset($secret) || empty($secret)){
				#try to delete the file and create a secret word
				@unlink($this->config_fp);
				if($this->config_exists()){#attempts to create it
					include($this->config_fp);
					#now check secret again
					if(!isset($secret) || empty($secret)){
						#no secret word set in config file
						array_push($warnings, $secret_description);
						$slscore += 7;
					}
				} else {
					#no secret word set in config file
					array_push($warnings, $secret_description);
					$slscore += 7;
				}
			}

		} else {
			#no secret word set in config file
			array_push($warnings, $secret_description);
			$slscore += 7;
		}
	}

	/**
	*	Gather information specific to Joomla
	*/
	{
		
		
		/*
		
		#CHECK FOR JOOMLA
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
					
					
					
					*/
		
		
		if ($this->is_joomla()) {
			# Test for Server Edition installed as well

			//Get user 62
			{
				$db =& JFactory::getDBO();
				$db->setQuery("SELECT usertype FROM #__users WHERE id=62");
				$db->query();
				$rs = $db->loadRowList();
			}
			
			// If still active, needs to be disabled and admin should use another uid for their account.
			if (count($rs) == 0 || $rs[0] == "Registered") {
				array_push($pass, "The standard Joomla ID #62 admin user has changed.");
			} else {
				array_push($warnings, "The standard Joomla ID #62 is still in use, Create a new user, give that user super admin access, then remove super admin access from user ID 62 and set to usertype to 'Registered'. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=admin_62\");return false;'>What do I do?</a>");
				$cmsscore += 3.9;
				if(!isset($user) || $user == null){
					$user =& JFactory::getUser();
				}
				if ($user->username == strtolower("admin")){
					array_push($warnings, "The standard Joomla \"ADMIN\" name is still in use, this should be the first thing changed once you have finished installing Joomla and gained access to the administrator back end. This username will make it easy for hackers to attack your site. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=admin_62\");return false;'>What do I do?</a>");
					$cmsscore += 3.9;
				}
			}

			# Joomla's htaccess active
			if (file_exists(JPATH_SITE."/.htaccess")) {
				array_push($pass, "Joomla root HTACCESS exists.");
			} else {
				array_push($warnings, "<b>htaccess</b> - is not found in the Joomla root folder. Rename the htaccess.txt to .htaccess. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=jroot_htaccess\");return false;'>What do I do?</a>");
				$cmsscore += .9;
			}

			# Joomla's the latest version
			if(defined("JVERSION")){

				if($versions !== false){
					$josVers = explode(",",$versions[5]);
					
					if (in_array(JVERSION,$josVers)) {
						array_push($pass, "Joomla install is a recommended version.");
					} else {
						array_push($warnings, "Joomla install v".JVERSION." is not a recommended version. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=J_Version\");return false;'>What do I do?</a>");
						$cmsscore += 1.2;
					}
				}
				else {
					array_push($warnings, "Joomla install could not be validated as a recommended version, failed to connect to server.");
				}
			}
			
			# Is the Meta Tag Joomla Description turned off or different

			# Is there a Password protecting the admin directory

			# Does the database contain JOS_ for the prefix

			# Connection Speed to SecureLive's servers
			$sl_timer = microtime(true);
			$account = $this->sl_post_request('remote4.php', "act=test_account&host=".$this->host);
	        $sl_timer = microtime(true) - $sl_timer;

			if ($sl_timer > 0 && $sl_timer < 0.3){
				array_push($pass, "Connection speed from your server to SecureLive's server is in great condition, the response times are very fast.");
			}
			if ($sl_timer > 0.3 && $sl_timer < 1){
				array_push($pass, "Connection speed from your server to SecureLive's server is in good condition, the response times are fast.");
			}
			if ($sl_timer > 1 && $sl_timer < 2.5){
				array_push($warnings, "Connection speed from your server to SecureLive's server is in fair condition, the response times should be investigated.");
				$cmsscore += .5;
			}
			if ($sl_timer > 2.5 && $sl_timer < 4){
				array_push($warnings, "Connection speed from your server to SecureLive's server is in poor condition, the response times should be investigated.");
				$cmsscore += 3.5;
			}
			if ($sl_timer > 4){
				array_push($warnings, "Connection speed from your server to SecureLive's server is in very poor condition, there is a problem and should be investigated.");
				$cmsscore += 9.5;
			}

			# Bridge Components installed and Joomla version
			if(substr_count($this->account->acct_type,'slm') == false){
			    $components = JComponentHelper::_Load();
			    $unprotected = array();
			    foreach($components as $com){
					if(substr_count(strtolower($com->name),'bridge')){
						$cmsscore += 4.5;
						array_push($warnings, "<b>".$com->name."</b> is a bridge. Bridged software such as Forums, Galleries or other software that is not installed with the Joomla framework is not protected outside of Joomla. These scripts can be ran independantly from outside of Joomla and SecureLive does not protect these programs. You may change your version of SecureLive to SecureLive Server Edition to protect these types of programs. <a href='#' onclick='sl_gateway.open(\"help\",\"&id=bridge_warn\");return false;'>What do I do?</a>");
					}
			    }
			}
		}
	}

	/**
	* Display the results in a nice rounded card with a score
	*
	* @var float
	*/
	{
		$slscore = round($slscore, 1);
		$phpscore = round($phpscore, 1);
		$cmsscore = round($cmsscore, 1);
		$overallscore = max(array($slscore,$phpscore,$cmsscore));
		$output .= "<div style=\"width: 918px;\">";
		$output .= "	<div style=\"margin-left: 70px; margin-right: auto;\">";
		$output .= "		<div style=\"width: 24%; float: left;\">";
		$output .= displayScore($phpscore, $this->sl_get_path(), "php");
		$output .= "		</div>";
		$output .= "		<div style=\"width: 24%; float: left;\">";
		$output .= displayScore($slscore, $this->sl_get_path(), "sl");
		$output .= "		</div>";
		$output .= "		<div style=\"width: 24%; float: left;\">";
		$output .= displayScore($cmsscore, $this->sl_get_path(), "cms");
		$output .= "		</div>";
		$output .= "		<div style=\"width: 24%; float: left;\">";
		$output .= displayScore($overallscore, $this->sl_get_path(), "overall");
		$output .= "		</div>";
		$output .= "	</div>";
		$output .= "</div>";
		$output .= "<div style=\"clear: both;\"></div>";
		$output .= "<div style=\"width: 918px;\">";
		$output .= displayResults($warnings, $pass);
		$output .= "</div>";
	}

	/**
	* Display the results in a nice looking form
	*
	* @param mixed $bad
	* @param mixed $good
	*/
	function displayResults($bad, $good){
		$n = "\n";
		$message = "";
		//$message .= "<script type=\"text/javascript\" charset=\"utf-8\">var myTabs = new mootabs('myTabs', {height: 440, width:895});</script>".$n;
		$message .= "<div id=\"myTabs\">".$n;
		$message .= "	<ul class=\"mootabs_title\" style=\"background: url('../images/alert-icon.png');\">".$n;
		$message .= "		<li><a id=\"tab1btn\" href=\"#tab1\" class=\"active\">Warnings</a></li>".$n;
		$message .= "		<li><a id=\"tab2btn\" href=\"#tab2\">Approved</a></li>".$n;
		$message .= "	</ul>".$n;
		$message .= "	<div id=\"tab1\" class=\"mootabs_panel active\">".$n;
		$message .= '		<ul id="badlist">'.$n;
		if(count($bad) > 0){
			for ($i=0; $i < count($bad); $i++){
				$message .= '		<li>'.$n;
				$message .= '			'.$bad[$i].$n;
				$message .= '		</li>'.$n;
			}
		}
		else {
			$message .= '		<li>'.$n;
			$message .= '			<em>No Warnings</em>'.$n;
			$message .= '		</li>'.$n;
		}
		$message .= '		</ul>'.$n;
		$message .= "	</div>".$n;
		$message .= "	<div id=\"tab2\" class=\"mootabs_panel\">".$n;
		$message .= '		<ul id="goodlist">'.$n;
		if(count($good) > 0){
			for ($i=0; $i < count($good); $i++){
				$message .= '		<li>'.$n;
				$message .= '			'.$good[$i].$n;
				$message .= '		</li>'.$n;
			}
		}
		else {
			$message .= '		<li>'.$n;
			$message .= '			<strong>Nothing passed inspection!!!</strong>'.$n;
			$message .= '		</li>'.$n;	
		}
		$message .= '		</ul>'.$n;
		$message .= "	</div>".$n;
		$message .= "</div>".$n;
		return $message;
	}

	/**
	* Will display the score card image with the score inside
	* Score's range is 0.0 - 9.9 and 0.0 is the lowest score
	*
	* @param mixed $score
	*/
	function displayScore($score, $path, $system="overall"){
		// Test for $score
		if (is_null($score)){
			return;
		} elseif ($score < 0) {
			$score = 0;
		} elseif  ($score > 9.9) {
			$score = 9.9;
		} elseif (!is_numeric($score)){
			return;
		}

		// convert number to graphic X.X
		if ($score <= 1){
			$scorecard = "risk-low.png";
		}
		if ($score > 1 && $score < 2.6){
			$scorecard = "risk-normal.png";
		}
		if ($score > 2.5 && $score < 4.1){
			$scorecard = "risk-moderate.png";
		}
		if ($score > 4.0 && $score < 7.0){
			$scorecard = "risk-high.png";
		}
		if ($score > 6.9 && $score < 9.8){
			$scorecard = "risk-severe.png";
		}
		if ($score > 9.7 && $score < 10){
			$scorecard = "risk-critical.png";
		}
		$whole = floor($score);
		$decimal = substr($score - floor($score), -1);
		if ($system=="overall"){
			$img = "<div style=\"background-image: url('$path/images/".$scorecard."'); float: left; height: 125px; width: 125px;\">\n";
			$img .= "	<div style=\"margin-top: 40px; margin-left: 10px; width:auto !important;\">";
			$img .= "		Highest Risk Factor";
			$img .= "	</div>";
			$img .= "	<div style=\"padding-top: 8px; padding-left: 34px; width:auto !important;\">\n";
			$img .= "		<img src=\"$path/images/".$whole.".png\" border=\"0\" height=\"35px\" /><img src=\"$path/images/period.png\" border=\"0\" height=\"35px\" /><img src=\"$path/images/".$decimal.".png\" border=\"0\" height=\"35px\" />\n";
			$img .= "	</div>\n";
			$img .= "</div>\n";
		}

		if ($system=="sl"){
			$img = "<div style=\"background-image: url('$path/images/".$scorecard."'); float: left; height: 125px; width: 125px;\">\n";
			$img .= "	<div style=\"margin-top: 40px; margin-left: 6px; width:auto !important;\">";
			$img .= "		SecureLive Risk Factor";
			$img .= "	</div>";
			$img .= "	<div style=\"padding-top: 8px; padding-left: 34px; width:auto !important;\">\n";
			$img .= "		<img src=\"$path/images/".$whole.".png\" border=\"0\" height=\"35px\" /><img src=\"$path/images/period.png\" border=\"0\" height=\"35px\" /><img src=\"$path/images/".$decimal.".png\" border=\"0\" height=\"35px\" />\n";
			$img .= "	</div>\n";
			$img .= "</div>\n";
		}

		if ($system=="cms"){
			$img = "<div style=\"background-image: url('$path/images/".$scorecard."'); float: left; height: 125px; width: 125px;\">\n";
			$img .= "	<div style=\"margin-top: 40px; margin-left: 10px; width:auto !important;\">";
			$img .= "		Site's Risk Factor";
			$img .= "	</div>";
			$img .= "	<div style=\"padding-top: 8px; padding-left: 34px; width:auto !important;\">\n";
			$img .= "		<img src=\"$path/images/".$whole.".png\" border=\"0\" height=\"35px\" /><img src=\"$path/images/period.png\" border=\"0\" height=\"35px\" /><img src=\"$path/images/".$decimal.".png\" border=\"0\" height=\"35px\" />\n";
			$img .= "	</div>\n";
			$img .= "</div>\n";
		}

		if ($system=="php"){
			$img = "<div style=\"background-image: url('$path/images/".$scorecard."'); float: left; height: 125px; width: 125px;\">\n";
			$img .= "	<div style=\"margin-top: 40px; margin-left: 10px; width:auto !important;\">";
			$img .= "		PHP Risk Factor";
			$img .= "	</div>";
			$img .= "	<div style=\"padding-top: 8px; padding-left: 34px; width:auto !important;\">\n";
			$img .= "		<img src=\"$path/images/".$whole.".png\" border=\"0\" height=\"35px\" /><img src=\"$path/images/period.png\" border=\"0\" height=\"35px\" /><img src=\"$path/images/".$decimal.".png\" border=\"0\" height=\"35px\" />\n";
			$img .= "	</div>\n";
			$img .= "</div>\n";
		}
		return $img;
	}

	/**
	* Will get a booleen value and return True or False. If
	* The value is not 1, 0, true, false, on, or off then it
	* will just return the value
	*
	* @param mixed $Key
	* @return string
	*/
	function getPHPiniValues($Key){
		$Val = ini_get($Key);
		switch (strtolower($Val)){
			case 'off':
				return false;
				break;
			case 'on':
				return true;
				break;
			case 'false':
				return false;
				break;
			case 'true':
				return true;
				break;
			case '0':
				return false;
				break;
			case '1':
				return true;
				break;
			case '':
				return false;
				break;
			default:
				return $Val;
		}
	}
?>