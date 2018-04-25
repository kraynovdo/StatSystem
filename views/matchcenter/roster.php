<?include '_head.php'?>
<?
    function initials($record) {
        return $record['surname'] . ' ' . $record['name'];
    }
?>
<div class="fafr-minWidth fafr-maxWidth">
    <table class="match-table">
        <colgroup>
            <col width="50%"/>
            <col width="50%"/>
        </colgroup>
        <tr>
        <td class="fafr-topValign match-tableLeft">

            <?
                $roster = $answer['team1roster'];
                $rosterFace = $answer['face1'];
                $teamID = $answer['maininfo']['team1'];
                $rlogo = $answer['maininfo']['t1logo'];
                include '_matchroster.php';
            ?>

        </td>
        <td class="fafr-topValign match-tableRight">
            <?
                $roster = $answer['team2roster'];
                $rosterFace = $answer['face2'];
                $teamID = $answer['maininfo']['team2'];
                $rlogo = $answer['maininfo']['t2logo'];
                include '_matchroster.php';
            ?>
        </td>
    </tr>
    </table>
</div>