<?
    $post = print_r($_POST, true);
    $post .= "\nIP: ".$_SERVER['REMOTE_ADDR'];
    $to = 'Piotr Kołodziejczyk <contakt@frontend.london>';
    $subject = 'Wiadomość od użytkownika strony frontend.london';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "From: automat@frontend.london\r\n";

    @mail ($to , $subject , $post , $headers);
?>