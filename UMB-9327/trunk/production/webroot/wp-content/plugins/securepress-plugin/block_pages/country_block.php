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

    header('HTTP/1.x 404 Not Found');
    echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <html><head>
    <title>404 Not Found</title>
    <script type="text/javascript">
    	function putEmail(){
    		a="blocks";b="securelive";c="net";
    		span = document.createElement("span");
    		span.innerHTML = a+"@"+b+"."+c;
    		elms = document.getElementsByClassName("email");
    		for(i=0;i<elms.length;i++){
    			elms[i].appendChild(span);
    		}
    	}
    </script>
    </head><body onload="putEmail()">
    	<h1>404 Not Found</h1>
        <p><b>Attention:</b> The administrator has blocked your country from gaining access to this network.</p>
        <p>If you feel you have reached this page in error, please contact: <span class="email"></span></p>
        <br/>
        <p>La atención, el administrador de este sitio web ha bloqueado su país de ver esta página. Si cree que esto fue un error, por favor contacto <span class="email"></span></p>
        <br/>
        <p>L\'attention, l\'administrateur de ce site Web a bloqué votre pays de regarder cette page. Si vous croyez que ceci était une erreur, s\'il vous plaît <span class="email"></span> de contact</p>
        <br/>
        <p>L\'attenzione, l\'amministratore di questo sito web ha bloccato il suo paese da osservare questa pagina. Se lei crede che questo sia stato un errore, per favore <span class="email"></span> di contatto</p>
        <br/>
        <p>Aufmerksamkeit, der Verwalter dieser Website haben Ihr Land von Ansehen dieser Seite gehemmt. Wenn Sie glauben, dass dies ein Fehler war, bitte Kontakt <span class="email"></span></p>
        <br/>
        <p>внимание, администратор этого вебсайта блокировал вашу страну от рассмотрения этой страницы. Если Вы полагаете, что это было ошибкой, пожалуйста свяжитесь с <span class="email"></span></p>
    </body></html>'."\n";
    die();
?>