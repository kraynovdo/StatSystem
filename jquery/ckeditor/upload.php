<?
function getex($filename) {
    $exp = explode(".", $filename);
    return end($exp);
}
header("Content-Type: text/json; charset=utf-8");
if($_FILES['upload'])
{
    if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) )
    {
        $message = "Вы не выбрали файл";
    }
    else if ($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 2050000)
    {
        $message = "Размер файла не соответствует нормам";
    }
    else if (($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png"))
    {
        $message = "Допускается загрузка только картинок JPG и PNG.";
    }
    else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
    {
        $message = "Что-то пошло не так. Попытайтесь загрузить файл ещё раз.";
    }
    else{
        if (strstr($_SERVER['HTTP_HOST'], 'amfoot.net')) {
            $HOST='amfoot.net';
        }
        else if (strstr($_SERVER['HTTP_HOST'], 'amfoot.ru')) {
            $HOST='amfoot.ru';
        }
        $name =rand(1, 1000).'-'.md5($_FILES['upload']['name']).'.'.getex($_FILES['upload']['name']);
        move_uploaded_file($_FILES['upload']['tmp_name'], "../../upload/editor/".$name);
        $full_path = '//'.$HOST.'/upload/editor/'.$name;
        $size=@getimagesize('../../upload/editor/'.$name);
        if($size[0]<50 OR $size[1]<50){
            unlink('../../upload/editor/'.$name);
            $message = "Файл не является допустимым изображением";
            $full_path="";
        }
    }

    $result = array();
    if ($message) {
        $result['uploaded'] = 0;
        $result['error'] = array('message' => $message);
    }
    else {
        $result['uploaded'] = 1;
        $result['fileName'] = $name;
        $result['url'] = $full_path;
    }

    print json_encode($result);
}
else {
    print json_encode(array('empty' => 1));
}

?>