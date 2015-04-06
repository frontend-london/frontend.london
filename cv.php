<?
/*
 * Wyświetla plik z CV i wysyła email o zainteresowaniu moim CV do mnie ;)
 */

    define( "_24dQeygXmNLjVtLDWh46FOEw1jWrktja9sNZ", 1);
    require('include/config.php');
    
    /*
     * Increase counter
     */
    $counter_src = 'files/cv_counter.txt';
    $counter = file_get_contents($counter_src);
    $counter = (int)$counter+1;
    file_put_contents($counter_src, $counter);

    /*
     * Sends email
     */
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {  // when proxy
        $post_ip = $_SERVER['HTTP_X_FORWARDED_FOR'].' ('.$_SERVER['REMOTE_ADDR'].')'; 
    } else { 
        $post_ip = $_SERVER['REMOTE_ADDR'];
    } 
    
    $version = $_GET['version'];
    if($version=='en') {
        $version_text = 'angielskiej';
    } else { // pl
        $version_text = 'polskiej';
    }
 
    $post_ip = $_SERVER['REMOTE_ADDR'];    
    $to = 'Piotr Kołodziejczyk <contact@frontend.london>';
    $subject = 'Pobrano CV ze strony frontend.london!';   
    ob_start();
    include("templates/downloaded_cv.phtml");
    $message = ob_get_contents();
    

//    exit();
    
    ob_end_clean();

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
//            $headers .= "To: Piotr Kołodziejczyk <$to>\r\n";
    $headers .= "From: Frontend.London<no-reply@frontend.london>\r\n";

    @mail ($to , $subject , $message , $headers);

    


    /*
     * Wyświetlenie PDF'a
     */
    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="cv.pdf"');
    if($version=='en') {
        readfile('files/cv_peter_kolodziejczyk.pdf');
    } else {
        readfile('files/cv_piotr_kolodziejczyk.pdf');
    }
    
?>