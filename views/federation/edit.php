<h2>Редактирование федерации</h2>
<?$federation = $answer['federation'];?>
<form action="/?r=federation/update" method="post" enctype="multipart/form-data">
    <? include '_maininfo.php'?>
    <table class="federation_contactsTable">
        <colgroup>
            <col width="33%"/>
            <col width="33%"/>
            <col width="34%"/>
        </colgroup>
        <tbody>
            <tr>
                <td>
                    <div class="main-fieldWrapper">
                        <label class="main-label_top">Ссылка вконтакте</label>
                        <input class="federation-contactField" type="text" name="vk_link" value="<?=$federation['vk_link']?>"/>
                    </div>
                </td>
                <td>
                    <div class="main-fieldWrapper">
                        <label class="main-label_top">Instagram</label>
                        <input class="federation-contactField" type="text" name="inst_link" value="<?=$federation['inst_link']?>"/>
                    </div>
                </td>
                <td>
                    <div class="main-fieldWrapper">
                        <label class="main-label_top">Twitter</label>
                        <input class="federation-contactField"  type="text" name="twitter" value="<?=$federation['twitter']?>"/>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <? include '_addr.php'?>
    <input type="hidden" name="federation" value="<?=$_GET['federation']?>"/>
    <input type="button" class="main-btn main-submit roster-submit" value="Готово"/>
</form>