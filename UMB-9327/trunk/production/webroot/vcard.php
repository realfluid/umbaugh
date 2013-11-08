<?php
header("Content-Type: text/x-vcard .vcf");
$fn = substr($_GET['fn'], 0, strpos($_GET['fn'], ","));
?>
BEGIN:VCARD
VERSION:2.1
FN:<?php echo $fn."\n" ?>
ORG:Umbaugh
ROLE:<?php echo $_GET['title']."\n"; ?>
<?php if($_GET['tel']) :?>TEL;WORK;<?php echo $_GET['tel']."\n" ?><?php endif; ?>
<?php if($_GET['email']) :?>EMAIL;PREF;INTERNET;<?php echo $_GET['email']."\n" ?><?php endif; ?>
REV:<?php echo date("Ymd"); ?>T<?php echo date("His"); ?> Z
END:VCARD
