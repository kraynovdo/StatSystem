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
        <div class="listview-item">
            <div class="team-req_name">
                <?=$comps[$i]['name']?>(<?=$comps[$i]['yearB']?>)
            </div>
            <div class="team-req_links">
                <a class="team-req_link" href="//<?=$link?>/?r=request/fill&team=<?=$_GET['team']?>&comp=<?=$comps[$i]['id']?>">Заявка</a>
                <a class="team-req_link" href="//<?=$link?>/?r=roster/fill&team=<?=$_GET['team']?>&comp=<?=$comps[$i]['id']?>">Состав</a>
            </div>
        </div>
    <?}?>
    <br/><br/>
<?}?>