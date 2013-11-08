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

    setcookie('secureliveBL','',0,'/');
	setcookie('securelive','',0,'/');
    
    echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <html><head>
    <title>'.$_SERVER['HTTP_HOST'].'</title>
    </head><body>
        <p><b>Advisory:</b> Our system has determined your recent activity as unfriendly to our network.<br/>
		This is only a warning and you have not been banned.<br/>
		Further similar attempts may lead to suspension or banning.</p>
		'.$this->blocked_user_form().'
    </body></html>'."\n";
    die();
?>