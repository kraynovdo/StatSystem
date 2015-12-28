<?php
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

    function common_dateToSQL($date) {
        $arr = explode('.', $date);
        $date = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        if ($date == '--') $date = '0000-00-00';
        return $date;
    }

    function common_GUID() {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    function common_loadFile($name, $CONSTPath) {
        if (is_uploaded_file($_FILES[$name]["tmp_name"])) {
            $fname = $_FILES[$name]['name'];
            $arr = explode('.', $fname);
            $ext = strtolower(end($arr));
            $uploaddir = $_SERVER['DOCUMENT_ROOT'] . $CONSTPath;
            $uploadfile = common_GUID();
            $respath = $uploaddir.'/upload/'.$uploadfile;

            if (!(move_uploaded_file($_FILES[$name]['tmp_name'], $respath.'.'.$ext))) {
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
                return $uploadfile . '.' . $ext;
            }
        }
        else return '';
    }

    function common_cropandresize($path, $w, $h, $x, $y, $ext) {
        switch ($ext) {
            case 'gif' : $img_src = imagecreatefromgif($path.'.'.$ext); break;
            case 'jpg' : $img_src = imagecreatefromjpeg($path.'.'.$ext); break;
            case 'png' : $img_src = imagecreatefrompng($path.'.'.$ext); break;
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
        unlink($path. '.' . $ext);
        switch ($ext) {
            case 'gif' : imagegif($img_dst, $path. '.' . $ext, 90); break;
            case 'jpg' : imagejpeg($img_dst, $path. '.' . $ext, 90); break;
            case 'png' : imagepng($img_dst, $path. '.' . $ext, 9); break;
        }

    }

    function common_sendmail($to, $subject,$message) {
        $headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: delivery@amfoot.net\r\n";

        mail($to, $subject, $message, $headers);
    }