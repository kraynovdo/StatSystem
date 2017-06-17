<?
    echo $p_page.' - '.$p_limit . ' - '.$p_count;
    $numPages = ceil($p_count / $p_limit);

    $cifers = [];

    array_push($cifers, 0);

?>
