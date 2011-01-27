<?php

if(isset($_POST)) {

    $to = 'koen@go-online.be';
    $from = 'no-reply@umbaugh.com';
    $subject = 'Message from the website';

    $header = 'From: ' . $from;
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $file = 'wp-includes/mails/' . time() . '.txt';
    $fileStream = fopen($file, 'w+') or die("couldn't open file ");;




    $table = '<table>';
    foreach($_POST as $key => $value)
    {
        if($key != 'redirect') {
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
        header( 'Location: http://' . $_POST['redirect'] ) ;
    }
} else {
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] ) ;
}