<?php
$file = "../../uploads/".$_GET['html'];
if(is_file($file)) echo file_get_contents($file);
?>
