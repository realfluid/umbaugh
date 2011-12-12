<?php

if(isset($_POST)) {

date_default_timezone_set('America/New_York');

/**
 * Include Zend Framework
 */
set_include_path(get_include_path() . PATH_SEPARATOR . 'library/');
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();


$mail = new Zend_Mail();


    if(isset($_FILES) != '') {
        require 'wp-content/themes/umbaugh/dropbox.php';

        try {
            // Rename uploaded file to reflect original name
            if ($_FILES['file']['error'] !== UPLOAD_ERR_OK)
                throw new Exception('File was not successfully uploaded from your computer.');

            $tmpDir = uniqid('tmp/');
            if (!mkdir($tmpDir))
                throw new Exception('Cannot create temporary directory!');

            if ($_FILES['file']['name'] === "")
                throw new Exception('File name not supplied by the browser.');

            $tmpFile = $tmpDir.'/'.str_replace("/\0", '_', $_FILES['file']['name']);
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $tmpFile))
                throw new Exception('Cannot rename uploaded file!');

            // Upload
            //$uploader = new Dropbox('careers@umbaugh.com','initpass');
            $dropbox = new Dropbox('0b6mkq8ervg1zd5', 'p9tgw4dpb57e0eh');
            $uploader = $dropbox->token('careers@umbaugh.com', 'initpass');

            $dropbox->setOAuthToken($uploader['token']);
            $dropbox->setOAuthTokenSecret($uploader['secret']);
            $response = $dropbox->filesPost('resumes', $tmpFile);

            // output response
            if(!$response['result'] == "winner!") {
                throw new Exception('Error on the upload to Dropbox!');
            }

        } catch(Exception $e) {
            $msg= '<span style="color: red">Error: ' . htmlspecialchars($e->getMessage()) . '</span>';
        }
        if($tmpFile != '') {
            $at = $mail->createAttachment(file_get_contents($tmpFile));
    		$at->disposition = Zend_Mime::DISPOSITION_INLINE;
    		$at->encoding    = Zend_Mime::ENCODING_BASE64;
    		$at->filename	 = $_FILES['file']['name'];
        }
        //if ($_FILES['file']['name'] != "") { $at->filename($_FILES['file']['name']); }
        
        // Clean up
        if (isset($tmpFile) && file_exists($tmpFile))
            unlink($tmpFile);

        if (isset($tmpDir) && file_exists($tmpDir))
            rmdir($tmpDir);
    }
    $mail->addTo('webmanager@quinlanmarketing.com');
	//$mail->addTo('koen@go-online.be');
    if($_POST['form'] == 'join-us') {
        $mail->addTo('careers@umbaugh.com');
    } elseif($_POST['form'] == 'contact-us') {
        $mail->addTo('contactus@umbaugh.com');
        $mail->addTo('seago@umbaugh.com');
        $mail->addTo('long@umbaugh.com');

        if($_POST["accounting-services"] == 'on') {
            $mail->addTo('hedden@umbaugh.com');
        }
        if($_POST["arbitrage-services"] == 'on') {
            $mail->addTo('carter@umbaugh.com');
        }
        if($_POST["debt-management"] == 'on') {
            $mail->addTo('colton@umbaugh.com');
        }
        if($_POST["economic-development"] == 'on') {
            $mail->addTo('matthes@umbaugh.com');
        }
        if($_POST["financial-management"] == 'on') {
            $mail->addTo('clifford@umbaugh.com');
        }
        if($_POST["utility-services"] == 'on') {
            $mail->addTo('miller@umbaugh.com');
        }
    }

    $mail->setFrom('no-reply@umbaugh.com');
    $mail->setSubject('[' . $_POST['form'] . '] Message from the website');
    
    $file = 'wp-includes/mails/' . $_POST['form'] . '-' . time() . '.txt';
    $fileStream = fopen($file, 'w+') or die("couldn't open file ");


    $table = '<table>';

    foreach($_POST as $key => $value)
    {
        if($key != 'redirect' || $key != 'submit') {
            $name = explode('-',$key);
            $table .=
                '<tr>
                    <td>
                       ' . ucfirst(implode(' ', $name)) . '
                    </td>
                    <td>
                       ' . $value .
                    '</td>
                </tr>';

            fwrite($fileStream, ucfirst(implode(' ', $name)) . ': ' . $value . '\n');
        }
    }
    $table.="<tr><td>Filename</td>";
    $table.="<td>".$_FILES['file']['name']."</td></tr>";

    $table .= '</table>';
    fclose($fileStream);
	$mail->setBodyHtml($table);
	//Zend_Debug::dump($mail);
    if($mail->send()) {
        header( 'Location: http://www.umbaugh.com/thank-you' ) ;
    }
    
    

} else {
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] ) ;
}