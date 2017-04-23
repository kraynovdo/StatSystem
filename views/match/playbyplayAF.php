<?
    include '_head.php';
    $event = $answer['event'];
    $admin = ($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 5);
?>
<h2>Ход игры</h2>
<?include '_eventListAF.php'?>

