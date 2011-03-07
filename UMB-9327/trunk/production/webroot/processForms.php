<?php

if(isset($_POST)) {
    if(isset($_FILES) != '') {
        require 'wp-content/themes/umbaugh/DropboxUploader.php';

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
            $uploader = new DropboxUploader('careers@umbaugh.com','initpass');
            $uploader->upload($tmpFile, 'resumes');

            $msg = "That's right, a new file was uploaded called ".$_FILES['file']['name'];
            $msg.= "\n\n It came from: ".$_POST['email'];
        $msg.= "\n\n And here's what they had to say about it: ".$_POST['comments'];

        mail("dannym@quinlanmarketing.com","New File uploaded at Umbaugh.com",$msg);

            $msg= '<span style="color: green">File successfully uploaded!</span>';
        } catch(Exception $e) {
            $msg= '<span style="color: red">Error: ' . htmlspecialchars($e->getMessage()) . '</span>';
        }

        // Clean up
        if (isset($tmpFile) && file_exists($tmpFile))
            unlink($tmpFile);

        if (isset($tmpDir) && file_exists($tmpDir))
            rmdir($tmpDir);
    }

    //$to = 'careers@umbaugh.com';
    $to = 'koen@go-online.be';
    //$to = 'webmanager@quinlanmarketing.com';
    $from = 'no-reply@umbaugh.com';
    $subject = 'Message from the website';

    $header = "MIME-Version: 1.0\r\n";
    $header .= "From: " . $from . "\r\n";
    $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
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
    $table .= '</table>';
    fclose($fileStream);

    if(mail($to,$subject,$table,$header)) {
        header( 'Location: http://www.umbaugh.com/thank-you' ) ;
    }
} else {
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] ) ;
}