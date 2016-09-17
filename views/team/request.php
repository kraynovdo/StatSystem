<?$comps = $answer['comps']; if (count($comps)) {?>
    <h2>Заявки на турниры</h2>
    <?for ($i = 0; $i < count($comps); $i++){?>
        <?if ($comps[$i]['link']) {
            $link = $comps[$i]['link'] . '.' . $HOST;
        }
        else {
            $link = $HOST;
        }
        ?>
        <div class="listview-item"><a href="//<?=$link?>/?r=roster/fill&team=<?=$_GET['team']?>&comp=<?=$comps[$i]['id']?>"><?=$comps[$i]['name']?> (<?=$comps[$i]['yearB']?>)</a></div>
    <?}?>
    <br/><br/>
<?}?>