<? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/competition/_adminNavig.php');?>
<h3>Заявки на турниры</h3>
<?for ($i = 0; $i < count($answer['roster']); $i++){?>
	<div class="listview-item roster-complist roster-complist_confirm-<?=$answer['roster'][$i]['confirm']?>">
		<div class="team-req_name">
			<?=$answer['roster'][$i]['rus_name']?>
		</div>
		<div class="team-req_links">
			<a class="team-req_link" href="/?r=request/fill&team=<?=$answer['roster'][$i]['id']?>&comp=<?=$_GET['comp']?>">Заявка</a>
			<a class="team-req_link" href="/?r=roster/fill&team=<?=$answer['roster'][$i]['id']?>&comp=<?=$_GET['comp']?>">Состав</a>
		</div>
	</div>
<?}?>