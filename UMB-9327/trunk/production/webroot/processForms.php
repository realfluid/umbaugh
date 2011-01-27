<?php

if(isset($_POST)) {

    $to = 'koen@go-online.be';
    $from = 'no-reply@umbaugh.com';
    $subject = 'Message from the website';

    $header = 'From: ' . $from;

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
        echo 'ok';
        die();
        header( 'Location: http://' . $_POST['redirect'] ) ;
    }
} else {
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] ) ;
}