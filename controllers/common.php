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
        $dataset = $queryresult->fetchAll();
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
        if (strlen(array_search($value, $arrKnown))) {
            return $arrNeeded[array_search($value, $arrKnown)];
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

    function common_dateFromSQL($dateSrc) {
        $date = '';
        if ($dateSrc) {
            $date_arr = explode('-', $dateSrc);
            $date = $date_arr[2] . '.' . $date_arr[1] . '.' . $date_arr[0];
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

    function common_loadFile($name, $CONSTPath, $filename = null) {
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
                        $_POST[$name . '_cropY'], $ext);
                }
                return $uploadfile;
            }
        }
        else return '';
    }

    function common_cropandresize($path, $w, $h, $x, $y, $ext) {
        switch ($ext) {
            case 'gif' : $img_src = imagecreatefromgif($path); break;
            case 'jpeg' : case 'jpg' : $img_src = imagecreatefromjpeg($path); break;
            case 'png' : $img_src = imagecreatefrompng($path); break;
        }
        if ($w > $h) {
            $coef = 1;
            if ($w > 600) {
                $coef = 600 / $w;
            }
        }
        else {
            $coef = 1;
            if ($h > 600) {
                $coef = 600 / $h;
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
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }

