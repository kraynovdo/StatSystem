<?php
    class BaseController {
        protected $dbConnect;
        protected $CONSTPath;
        public function __construct($dbConnect, $CONSTPath) {
            $this->dbConnect = $dbConnect;
            $this->CONSTPath = $CONSTPath;

        }
        public function _query($query, $queryParams = array()) {
            $queryresult = $this->dbConnect->prepare($query);
            $queryresult->execute($queryParams);
            return $queryresult;
        }
        public function _getlist($query, $queryParams = array()) {
            $queryresult = $this->_query($query, $queryParams);
            $dataset = $queryresult->fetchAll();
            return $dataset;
        }
        public function _getrecord($query, $queryParams = array()) {
            $ds = common_getlist($query, $queryParams);
            return $ds[0];
        }
    }

    //OK
    function common_getlist($dbConnect, $query, $queryParams = array()) {
        $queryresult = common_query($dbConnect, $query, $queryParams);
        $dataset = $queryresult->fetchAll(PDO::FETCH_ASSOC);
        return $dataset;
    }

    function common_getrecord($dbConnect, $query, $queryParams = array()) {
        $ds = common_getlist($dbConnect, $query, $queryParams);
        return $ds[0];
    }

    function common_query($dbConnect, $query, $queryParams = array()) {
        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute($queryParams);
        return $queryresult;
    }

    function common_request($methodUrl) {
        $lang = 0; // russian
        $headerOptions = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                    "Cookie: remixlang=$lang\r\n"
            )
        );
        //$methodUrl = 'http://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=1000';
        $streamContext = stream_context_create($headerOptions);
        $json = file_get_contents($methodUrl, false, $streamContext);
        $arr = json_decode($json, true);
        return  $arr;
    }

    function common_twins($needed, $known, $value) {
        $arrNeeded = explode(",", $needed);
        $arrKnown = explode(",", $known);
        $search = array_search($value, $arrKnown);
        if (strlen($search)) {
            return $arrNeeded[$search];
        }
        else {
            return '';
        }

    }

    function common_dateToSQL($date) {
        $arr = explode('.', $date);
        $date = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        if ($date == '--') $date = '0000-00-00';
        return $date;
    }

    function common_dateFromSQL($dateSrc, $short=false) {
        $date = '';
        if ($dateSrc) {
            $date_arr = explode('-', $dateSrc);
            if ($short) {
                $date = $date_arr[2] . '.' . $date_arr[1];
            }
            else {
                $date = $date_arr[2] . '.' . $date_arr[1] . '.' . $date_arr[0];
            }

        }
        return $date;
    }

    function common_GUID() {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    function common_wordForm($num, $word1, $word2, $word3) {
        $ost100 = abs($num % 100);
        $ost10 = abs($num % 10);
        if ($ost100 >= 11 && $ost100 <= 14) {
            return $word3;
        }
        if ($ost10 == 1) {
            return $word1;
        }
        if ($ost10 >= 2 && $ost10 <= 4) {
            return $word2;
        }
        return $word3;
    }

    function common_loadFile($name, $CONSTPath, $filename = null, $max = 600) {
        if (is_uploaded_file($_FILES[$name]["tmp_name"])) {
            $fname = $_FILES[$name]['name'];
            $arr = explode('.', $fname);
            $ext = strtolower(end($arr));
            $uploaddir = $_SERVER['DOCUMENT_ROOT'] . $CONSTPath;
            if ($filename) {
                $uploadfile = $filename;
            }
            else {
                $uploadfile = common_GUID().'.'.$ext;
            }
            $respath = $uploaddir.'/upload/'.$uploadfile;

            if (!(move_uploaded_file($_FILES[$name]['tmp_name'], $respath))) {
                $_SESSION['error'] = "Ошибка загрузки файла ".$fname;
                return '';
            }
            else {
                if ($_POST[$name . '_cropWidth']) {
                    common_cropandresize($respath,
                        $_POST[$name . '_cropWidth'],
                        $_POST[$name . '_cropHeight'],
                        $_POST[$name . '_cropX'],
                        $_POST[$name . '_cropY'], $ext, $max);
                }
                return $uploadfile;
            }
        }
        else return '';
    }

    function common_cropandresize($path, $w, $h, $x, $y, $ext, $max) {
        switch ($ext) {
            case 'gif' : $img_src = imagecreatefromgif($path); break;
            case 'jpeg' : case 'jpg' : $img_src = imagecreatefromjpeg($path); break;
            case 'png' : $img_src = imagecreatefrompng($path); break;
        }
        if ($w > $h) {
            $coef = 1;
            if ($w > $max) {
                $coef = $max / $w;
            }
        }
        else {
            $coef = 1;
            if ($h > $max) {
                $coef = $max / $h;
            }
        }
        $img_dst = imagecreatetruecolor(round($w * $coef), round($h * $coef));
        if ($ext == 'png') {
            imagesavealpha($img_dst, true);
            $trans_colour = imagecolorallocatealpha($img_dst, 0, 0, 0, 127);
            imagefill($img_dst, 0, 0, $trans_colour);
        }
        imagecopyresampled($img_dst, $img_src, 0, 0, $x, $y, round($w * $coef), round($h * $coef), $w, $h);
        unlink($path);
        switch ($ext) {
            case 'gif' : imagegif($img_dst, $path, 90); break;
            case 'jpg' : case 'jpeg' : imagejpeg($img_dst, $path, 90); break;
            case 'png' : imagepng($img_dst, $path, 9); break;
        }

    }

    function common_sendmail($to, $subject,$message) {
        $headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: delivery@amfoot.ru\r\n";

        mail($to, $subject, $message, $headers);
    }

    function common_translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya', ' ' => '_'
        );
        return strtr($string, $converter);
    }


    function common_phone($str) {
        $re = "/(\\+\\d{1})(\\d{3})(\\d{3})(\\d{2})(\\d{2})/";
        $subst = '$1 ($2) $3 $4 $5';

        return preg_replace($re, $subst, $str);
    }

    function common_youtubeCode($link) {
        $code = '';
        if (strpos($link, 'youtu.be')) {
            $pos = strripos($link, '/');
            $code = mb_substr($link, $pos+1);

        } else if (strpos($link, 'youtube.com')) {
            $pos = strripos($link, '?v=');
            $code = mb_substr($link, $pos+3);
            $pos = strripos($code, '&');
            if ($pos && $pos > 0) {
                $code = mb_substr($code, 0, $pos);
            }
        }
        return $code;
    }

    function common_getPlayer($link, $w, $h) {
        if (strpos($link, 'youtu.be')) {
            $pos = strripos($link, '/');
            $code = mb_substr($link, $pos+1);
            $player = '<iframe width="' . $w . '" height="' . $h . '" src="https://www.youtube.com/embed/' . $code . '?>" frameborder="0" allowfullscreen></iframe>';

        } else if (strpos($link, 'youtube.com')) {
            $pos = strripos($link, '?v=');
            $code = mb_substr($link, $pos+3);
            $pos = strripos($code, '&');
            if ($pos && $pos > 0) {
                $code = mb_substr($code, 0, $pos);
            }
            $player = '<iframe width="' . $w . '" height="' . $h . '" src="https://www.youtube.com/embed/' . $code . '?>" frameborder="0" allowfullscreen></iframe>';
        }
        else {
            $player = '';
        }
        return $player;
    }