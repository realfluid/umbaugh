<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>SecureLive Incident Report</title>
</head>
<body>
	<div style="width:600px; padding:10px; border:1px solid #000">
		<div style="float:left"><span style="padding: 2px 4px; font-family: 'Arial Black',Gadget,sans-serif; font-size: 18px; margin-top: 4px; margin-bottom: 2px; background-color: rgb(255, 0, 0); color: rgb(0, 0, 0);">SECURE</span><span style="padding: 2px 4px; font-family: 'Arial Black',Gadget,sans-serif; font-size: 18px; margin-top: 4px; margin-bottom: 2px; background-color: rgb(0, 0, 0); color: rgb(255, 0, 0); margin-left: 0px;">LIVE</span><span style="border-top: thin dotted black; border-right: thin dotted black; border-bottom: thin dotted black; padding: 1px 3px 1px 4px; font-family: 'Arial Black',Gadget,sans-serif; font-size: 18px; margin-top: 4px; margin-bottom: 2px; color: rgb(255, 0, 0);">Incident Report</span></div>
	    <span style=" float:right; font-size:14px; font-family: Arial Black, Gadget, sans-serif;">{date}</span>
	    <hr style="margin-top:45px;" />
	    <p style="margin-top:0px; margin-left:10px;"><span style="font-size:18px; font-family: Arial Black, Gadget, sans-serif;">{fulldomain}</span></p>
	    <p><span style="font-weight: bold;">Secure<span style="color: #FF0000;">Live</span></span> has blocked an attack on your website's security. All attack details are listed below.</p>
	    
	    
	    <div style="background-color:#{color1};background-image:url(http://www.securelive.net/badges/{colortype}.png);border-bottom:1px solid #{color2};border-right:1px solid #{color2};color:#{color3};">
			<div style="background:transparent url(http://www.securelive.net/badges/{colortype}-icon.png) no-repeat scroll 10px 12px;margin:15px 0;padding:8px 10px 0 36px;">
				<table width="100%">
					<tr>
						<td width="50%">Threat Level: {threat_level}</td>
						<td width="50%">Block Type: {threat_type}</td>
					</tr>
					<tr>
						<td>Attacker IP: {ip}</td>
						<td>Block Count: {num_attacks}</td>
					</tr>
				</table>
			</div>
		</div>
	    
	    <table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-family:Verdana, Geneva, sans-serif; font-size:13px">
	    	<tr>
        		<td width="22%">&nbsp;</td>
        		<td width="78%">&nbsp;</td>
      		</tr>
      		<tr>
        		<td style="border-bottom:1px solid #CCC" align="right"><strong>Why Blocked:</strong></td>
        		<td style="border-bottom:1px solid #CCC">{why}</td>
      		</tr>
      		<tr>
        		<td style="border-bottom:1px solid #CCC" align="right"><strong>Attack Used:</strong></td>
        		<td style="border-bottom:1px solid #CCC">{uri}</td>
      		</tr>
      		<tr>
        		<td style="border-bottom:1px solid #CCC" align="right"><strong>Referrer:</strong></td>
        		<td style="border-bottom:1px solid #CCC">{referrer}&nbsp;</td>
      		</tr>
      		<tr>
        		<td style="border-bottom:1px solid #CCC" align="right"><strong>Browser: </strong></td>
        		<td style="border-bottom:1px solid #CCC">{browser}&nbsp;</td>
      		</tr>
      		<tr>
        		<td style="border-bottom:1px solid #CCC" align="right"><strong>Host: </strong></td>
        		<td style="border-bottom:1px solid #CCC">{host}&nbsp;</td>
      		</tr>
	    </table>
	    <p align="right">Contact SecureLive at <strong>888-300-4546</strong> with any questions.</p>
	</div>
	<div style="font-family: 'Arial Black',Gadget,sans-serif; font-size: 9px; margin-top: 4px; margin-bottom: 2px; color: #333;">
	    To ensure that you continue to receive emails from us, add <a href="mailto:reports@securelivereports.com">reports@securelivereports.com</a>
	    to your Address Book and your Approved Sender list, and have our email address white-listed with your Company.<br />
	    All information in this E-Mail is intended for the recipient only, and is classified as confidential. If you are not the owner, then you
	    have received this E-Mail in error. Please report this error to our support team at:  <a href="mailto:support@securelive.net">support@securelive.net</a>.
	    Use of e-mail is inherently insecure. Confidential information, including account information, and personally identifiable information, should not
	    be transmitted via e-mail, or e-mail attachment. In no event shall SecureLive, LLC or any of its affiliates accept any responsibility for the loss,
	    use or misuse of any information including confidential information, which is sent to them via e-mail, or e-mail attachment. SecureLive, LLC does not
	    guarantee the accuracy of any e-mail or e-mail attachment, that an e-mail will be received by them.<br /><br />
	    SecureLive, LLC is a New York and Ohio based corporation. Toll free number is (888) 300-4546. For calls from outside of the US, please call (567) 208-5301.
	</div>
</body>
</html>