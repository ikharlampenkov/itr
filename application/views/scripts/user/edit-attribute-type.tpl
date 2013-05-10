<legend class="heading">Редактировать тип атрибута</legend>

<?php echo if isset($exception_msg) ?>
<div>Ошибка: <?php echo $exception_msg ?></div><br/>
<?php endif ?>

<form class="form-horizontal" action="<?php echo $this->url(array('controller' => 'user','action' => 'editAttributeType', 'id' => $type->id)); ?>" method="post">
    <table class="table table-bordered">
        <tr>
            <td class="ttovar_title">Название</td>
            <td class="ttovar"><input name="data[title]" value="<?php echo $type->title ?>"/></td>
        </tr>
        <tr>
            <td class="ttovar_title">Описание</td>
            <td class="ttovar"><input name="data[description]" value="<?php echo $type->description ?>"/></td>
        </tr>
        <tr>
            <td class="ttovar_title">Обработчик</td>
            <td class="ttovar"><input name="data[handler]" value="<?php echo $type->handler ?>"/></td>
        </tr>
    </table>
    <input id="save" name="save" type="submit" value="Сохранить"/>
</form>