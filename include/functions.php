<?	defined( "_24dQeygXmNLjVtLDWh46FOEw1jWrktja9sNZ" ) or die( "Direct Access to this location is not allowed." );

	function printn($string) {
		print($string."\n");
	}

	function polacz_z_baza(&$link) {
		$link=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)
			or die("Nie mogę nawiązać połączenia z bazą danych.");

		mysql_select_db(DB_DATABASE) OR die('Nie udalo mi sie wybrać bazy danych: '.mysql_error());
  	}


	function rozlacz_z_baza(&$link) {
	 	@mysql_close($link);
	}

        function select($select) {
            $wynik = mysql_query($select);
            return mysql_fetch_array($wynik);
        }

  	function zalogowany() {
 		if($_SESSION['zalogowany']==true) {
 			$result = true;
 		} else $result = false;
 			
 		return $result;
 		
 	}

 	/**
	 * Funkcja tworzy miniature z obrazka
	 *
	 * @param int $max_width - (maksymalna) szerokość miniatury
	 * @param int $max_height - (maksymalna) wysokość miniatury
	 * @param string $source - ścieżka do obrazka
	 * @param string $source_type typ obrazka. np 'jpg' albo 'image/jpeg'
	 * @param string $dest - ścieżka docelowa miniaturki
	 * @param string $dest_type typ obrazka. np 'jpg'
	 * @param bool $proportional - czy proporcjonalne mają być boki, czy nie ($max_width * $max_height)
	 * @param bool $powieksz - czy ma powiękaszać gdy obrazek jest mniejszy
	 * @param bool $kadruj - czy ma kadrować obrazek (środek) do określonego rozmiaru
	 */
	function stworz_miniature($max_width, $max_height, $source, $source_type, $dest, $dest_type = 'jpg', $proportional = false, $powieksz = true, $kadruj = false) {
	    $size = getimagesize($source);
	    $w = $size[0];
	    $h = $size[1];
	    switch($source_type) {
	        case 'gif':
	        	$simg = imagecreatefromgif($source);
	        	break;
	        case 'image/gif':
	        	$simg = imagecreatefromgif($source);
	        	break;
	        case 'jpg':
	        	$simg = imagecreatefromjpeg($source);
	        	break;
	        case 'image/jpeg':
	        	$simg = imagecreatefromjpeg($source);
	        	break;
	        case 'image/pjpeg':
	        	$simg = imagecreatefromjpeg($source);
	        	break;
	        case 'png':
	        	$simg = imagecreatefrompng($source);
	        	break;
	        case 'image/png':
	        	$simg = imagecreatefrompng($source);
	        	break;
			default:
	        	$simg = imagecreatefromjpeg($source);
	        	break;
	    }

            if(!$powieksz) {
                if($max_width>$w) {
                    $max_width = $w;
                }
                if($max_height>$h) {
                    $max_height = $h;
                }
            }
	    if (($proportional) && (!$kadruj)) {

	    	$stosunek_szerokosci = $max_width/$w;
	    	$stosunek_wysokosci = $max_height/$h;
	    	if($stosunek_szerokosci<$stosunek_wysokosci) {
                    $max_height = floor($stosunek_szerokosci*$h);
                } else {
                    $max_width = floor($stosunek_wysokosci*$w);
                }
	    }
	    $dimg = imagecreatetruecolor($max_width, $max_height);

            if(($powieksz) && (($max_height>$h) || ($max_width>$w))) {
                 if($max_height>$h) {
                    $new_height = $max_height;
                    $new_width = floor(($new_height/$h) * $w);
                 } else {
                    $new_width = $max_width;
                    $new_height = floor(($new_width/$w) * $h);
                 }

                 $new_simg = imagecreatetruecolor($new_width, $new_height);
                 imagecopyresampled($new_simg, $simg, 0, 0, 0, 0, $new_width, $new_height, $w, $h);
                 $simg = $new_simg;
            }

            if($kadruj) {
		 	$x = 0;
			$y = 0;
			$width_ratio = $w/$max_width;  //>1 dla dużej grafiki
			$height_ratio = $h/$max_height;

			if($width_ratio>$height_ratio) {
                                $old_w = $w;
                                $w = floor($height_ratio*$max_width);
				$y = 0;
				$x = floor(($old_w-$w)/2);
			} else {
                                $old_h = $h;
                                $h = floor($width_ratio*$max_height);
				$x = 0;
				$y = floor(($old_h-$h)/2);
			}
		 	imagecopyresampled($dimg, $simg, 0, 0, $x, $y, $max_width, $max_height, $w, $h);

            } else imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $max_width, $max_height, $w, $h);


            $spnMatrix = array( array(-1,-1,-1,),
                                        array(-1,16,-1,),
                                        array(-1,-1,-1));
            $divisor = 8;
            $offset = 0;
            if(function_exists('imageconvolution')) {
              imageconvolution($dimg, $spnMatrix, $divisor, $offset);
            }
	    switch($dest_type) {
	        case 'gif':
		        imagegif($dimg,$dest,85);
		        break;
	        case 'jpg':
		        imagejpeg($dimg,$dest,85);
		        break;
	        case 'png':
		        imagepng($dimg,$dest,9);
		        break;
	    }
    }

	function generate_url($string)
    {
		$trans0 = array
		(
			'ą' => 'a',
			'ć' => 'c',
			'ę' => 'e',
			'ł' => 'l',
			'ń' => 'n',
			'ó' => 'o',
			'ś' => 's',
			'ź' => 'z',
			'ż' => 'z',
		
			'Ą' => 'A',
			'Ć' => 'C',
			'Ę' => 'E',
			'Ł' => 'L',
			'Ń' => 'N',
			'Ó' => 'O',
			'Ś' => 'S',
			'Ź' => 'Z',
			'Ż' => 'Z',
		);

		
		$trans1 = array
		(
			' ' => '-',
			'.' => '',
			',' => '',
			'!' => '',
			'\'' => '',

			'&amp;' => '',
			'&' => '',		
		);
		
		$trans2 = array
		(
			'-------' => '-',
			'------' => '-',
			'-----' => '-',
			'----' => '-',
			'---' => '-',
			'--' => '-',
		);
		
		$string = trim($string);
		$string = strtr($string, $trans0);
		$string = strtr($string, $trans1);
		$string = strtr($string, $trans2);
		$string = strtolower($string);
		$string = substr($string, 0, 40);
		$string = urlencode($string);
		
		return $string;	
    }	
	
    function escape_data($data) {
    	global $link;
    	if(ini_get('magic_quotes_gpc')) {
    		$data = stripslashes($data);
    	}
    	return mysql_real_escape_string($data, $link);
    }

    function escape_data_text($data) {
    	if(ini_get('magic_quotes_gpc')) {
                return $data;
    	}
    	return addslashes($data);
    }

    function unescape_data($data) {
    	if(ini_get('magic_quotes_gpc')) {
                $data = stripslashes($data);
    	}
    	return $data;
    }

    function mynl2br($text) {
       return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />'));
    }

    function include_default() {
        include('controllers/'.DEFAULT_CONTROLLER.'.php');
    }

    function generuj_long_text_show($text) {
        $replace = array('<p>'=>'<p class="white"><span>', '<p class="white">' => '<p class="white"><span>', '<p class="blue">' => '<p class="blue"><span>', '<p class="brown">' => '<p class="brown"><span>', '</p>' => '</span></p>' );
        $text = strtr($text, $replace);
        //return $text; // todo
        $s = strip_tags($text);
        $array = explode('</p>', $text);
        $i = 0;
        $count_all = 0;
        foreach ($array as $t) {
            $count[$i] = strlen(utf8_decode(trim(strip_tags($t))));
            $count_all+=$count[$i];
            $i++;
        }
        $i_max = $i-1;
        $i = 0;
        $count_all2 = 0;
        foreach ($array as $t) {
            $count_all2+=$count[$i];
            if(($count_all*0.45)<=($count_all2)) {
                $t1.='<div class="column">';
                for($j=0;$j<=$i;$j++) {
                    $t1.= $array[$j].'</p><br>';
                }
                $t1 = substr($t1, 0, -4);
                $t1.='</div>';
                $t1.='<div class="column nomargin">';
                if($i<$i_max) {
                    for($j=$i+1;$j<=$i_max;$j++) {
                        $tmp = trim(strip_tags($array[$j]));
                        if(!empty($tmp)) $t1.= $array[$j].'</p><br>';
                    }
                }
                $t1 = substr($t1, 0, -4);
                $t1.='</div>';
                break;
            }
            $i++;            
        }
        return $t1;
    }

    function generuj_order($category2 = '') {
        global $category;
        if(empty ($category2)) $category2 = $category;
        $wynik = mysql_query("SELECT MAX(id) `m_id` FROM `$category2`");
        $w = mysql_fetch_array($wynik);
        $order = $w['m_id'] + 1;
        return $order;
    }

    function generuj_title_url($title, $id = '', $category2 = '') {
        return generate_url($title);
    }

    function generuj_miesiac($m) {
        $m = (int)$m;
        $months = array('', 'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia');
        $current_month = $months[$m];
        return $current_month;

    }

    function generuj_dzientygodnia($m) {
        $m = (int)$m;
        $weekdays = array('', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');
        $current_weekday = $weekdays[$m];
        return $current_weekday;

    }

    function add_url($text, $url) {
        $array = explode('</p>', $text);
        $array_size = sizeof($array);
        if($array_size>=2) {
            $array[$array_size-2].=' <a href="'.$url.'">more »</a>';
            $return = implode('</p>', $array);
        } else {
            $return = $text.'<a href="'.$url.'">more »</a>';
        }
        return $return;
    }

    function check_email($email) {
//      if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) return false;
//      else return true; // Function eregi() is deprecated 
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function generate_news() {
        $select_news = "SELECT `title`, `url`, `short_text` FROM `aktualnosci` WHERE `active`='1' ORDER BY `date` DESC LIMIT 2";
        $wynik_news = mysql_query($select_news);
        $news = array();
        while($w_news = mysql_fetch_array($wynik_news)) {
            $news[] = $w_news;
        }
        return $news;
    }
    
    function is_ajax() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }
?>