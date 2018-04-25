<?include '_head.php'?>
<?
    function initials($record) {
        return $record['surname'] . ' ' . $record['name'];
    }
?>
<div class="fafr-minWidth fafr-maxWidth">
    <table class="match-roster_table">
        <colgroup>
            <col width="50%"/>
            <col width="50%"/>
        </colgroup>
        <tr>
        <td class="fafr-topValign match-roster_tableLeft">

            <?
                $roster = $answer['team1roster'];
                $rosterFace = $answer['face1'];
                $teamID = $answer['maininfo']['team1'];
                $rlogo = $answer['maininfo']['t1logo'];
                include '_matchroster.php';
            ?>

        </td>
        <td class="fafr-topValign match-roster_tableRight">
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