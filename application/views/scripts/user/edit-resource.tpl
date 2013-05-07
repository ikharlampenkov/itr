<legend class="heading">Редактировать ресурс</legend>

<?php echo if isset($exception_msg)}
<div>Ошибка: <?php echo $exception_msg}</div><br/>
<?php echo /if}

<form action="<?php echo $this->url(array('controller' => $controller,'action' => 'editResource', 'id' => $resource->id])}" method="post">
    <table>
        <tr>
            <td class="ttovar" width="200">Название</td>
            <td class="ttovar"><input name="data[title]" value="<?php echo $resource->title}"/></td>
        </tr>
        <tr>
            <td class="ttovar" width="200">Русское название</td>
            <td class="ttovar"><input name="data[rtitle]" value="<?php echo $resource->rtitle}"/></td>
        </tr>
    </table>
    <input id="save" name="save" type="submit" value="Сохранить"/>
</form>