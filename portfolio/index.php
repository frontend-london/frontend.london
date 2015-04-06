<?

	$directory = substr($_SERVER["SCRIPT_NAME"], 0, -strlen('index.php'));
	$full_url = trim(substr($_SERVER["REQUEST_URI"], strlen($directory)), '/');
    $url = $full_url;
    $second_url = substr(strstr($url, '/'), 1);
    if(strpos($second_url, '/')>0) {
        $third_url = substr($second_url, strpos($second_url,'/')+1);
        $second_url = substr($second_url,0,strpos($second_url,'/'));
    }

    if(strpos($url, '/')) $url = substr($url, 0, strpos($url, '/'));

    $error = false;

    switch ($url) {
        case 'smashintracks.com':
            $image = 'smashintracks';
            break;
        case 'details':
            echo 'test2';
            break;
        default:
            echo 'default';
            $error = true;
    }

    if ( !$error ) {
        include('template.html');
    }


?>