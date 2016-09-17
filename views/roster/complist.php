<h2>Заявки на турниры</h2>
<?for ($i = 0; $i < count($answer['roster']); $i++){?>
	<div class="listview-item">
		<a href="/?r=roster/fill&team=<?=$answer['roster'][$i]['id']?>&comp=<?=$_GET['comp']?>"><?=$answer['roster'][$i]['rus_name']?></a>
	</div>
<?}?>