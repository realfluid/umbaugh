<?php
$random_hash = md5(date('r', time()));
if(isset($_POST)) {
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
        
        $attachment = chunk_split(base64_encode(file_get_contents($tmpFile))); 
        
    }
    $to = 'webmanager@quinlanmarketing.com';

    if($_POST['form'] == 'contact-us') {$to .= ', ContactUs@umbaugh.com'; }
    if($_POST['form'] == 'join-us') {  $to .= ', careers@umbaugh.com';}

    $from = 'no-reply@umbaugh.com';
    $subject = 'Message from the website';

    $header = "MIME-Version: 1.0\r\n";
    $header .= "From: " . $from . "\r\n";
    if(isset($_FILES) == '') {
    	$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
    } else {
    	$headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"\r\n"; 
    }
    $file = 'wp-includes/mails/' . $_POST['form'] . '-' . time() . '.txt';
    $fileStream = fopen($file, 'w+') or die("couldn't open file ");

ob_start(); //Turn on output buffering 
?> 
--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Hello World!!! 
This is simple text email message. 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h2>Hello World!</h2> 
<p>This is something with <b>HTML</b> formatting.</p> 
<?php
    $message .= '<table>';

    foreach($_POST as $key => $value)
    {
        if($key != 'redirect' || $key != 'submit') {
            $name = explode('-',$key);
            $message .=
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
    $message.="<tr><td>Filename</td>";
    $message.="<td>".$_FILES['file']['name']."</td></tr>";

    $message .= '</table>';
    fclose($fileStream);
?>

--PHP-alt-<?php echo $random_hash; ?>-- 

--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: application/zip; name="attachment.zip"  
Content-Transfer-Encoding: base64  
Content-Disposition: attachment  

<?php echo $attachment; ?> 
--PHP-mixed-<?php echo $random_hash; ?>-- 

<?php 
//copy current buffer contents into $message variable and delete current output buffer 
$message = ob_get_clean(); 
    
    
    if(mail($to,$subject,$table,$header)) {
        header( 'Location: http://www.umbaugh.com/thank-you' ) ;
    }
    

    if(isset($_FILES) != '') {
        // Clean up
        if (isset($tmpFile) && file_exists($tmpFile))
            unlink($tmpFile);

        if (isset($tmpDir) && file_exists($tmpDir))
            rmdir($tmpDir);
    }
} else {
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] ) ;
}