<? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/competition/_adminNavig.php');?>
<h3>Заявки на турниры</h3>
<?for ($i = 0; $i < count($answer['roster']); $i++){?>
	<div class="listview-item">
		<a href="/?r=roster/fill&team=<?=$answer['roster'][$i]['id']?>&comp=<?=$_GET['comp']?>"><?=$answer['roster'][$i]['rus_name']?></a>
	</div>
<?}?>