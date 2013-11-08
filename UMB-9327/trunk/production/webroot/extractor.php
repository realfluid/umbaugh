<?php
	$path = 'sl_admin.zip'; 
	$zip = new ZipArchive;
	$res =0 ; 
	if ($zip->open($path) === true) {
		for($i = 0; $i < $zip->numFiles; $i++) {
              
			$res = $zip->extractTo("./",  array($zip->getNameIndex($i)));
			if (!$res  ) {echo 0; exit();  }
			else {$res = 1; }
			
		}
                   
		$zip->close();
                   
	}
	echo $res; 

?>