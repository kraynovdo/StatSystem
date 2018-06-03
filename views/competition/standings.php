<div class="fafr-minWidth fafr-maxWidth">
    <?if ($answer['href']) {?>
        <img style="width:100%" src="//<?=$HOST?>/upload/<?=$answer['href']?>"/>
    <?} else {?>
        <h3>Таблица очень скоро будет здесь</h3>
    <?}?>

    <?if ($_SESSION['userType'] == 3) {?>
        <div>
            <br/>
            <a class="fafr-link" href="/?r=standings/edit&comp=<?=$_GET['comp']?>">Загрузить изображение</a>
        </div>
    <?}?>
</div>