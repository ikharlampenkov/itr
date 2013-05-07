<legend class="heading">Добавить атрибут</legend>

<?php echo if isset($exception_msg)}
<div>Ошибка: <?php echo $exception_msg}</div><br/>
<?php echo /if}

<form action="<?php echo $this->url(array('controller' => $controller,'action' => 'addAttributeHash'])}" method="post">
    <table width="100%">
        <tr>
            <td class="ttovar_title">Ключ</td>
            <td class="ttovar"><input name="data[attribute_key]" value="<?php echo $hash->attributeKey}"/></td>
        </tr>
        <tr>
            <td class="ttovar_title">Описание</td>
            <td class="ttovar"><input name="data[title]" value="<?php echo $hash->title}"/></td>
        </tr>
        <tr>
            <td class="ttovar_title">Тип</td>
            <td class="ttovar">
                <select name="data[type_id]">
                <?php echo foreach from=$attributeTypeList item=attributeType}
                    <option value="<?php echo $attributeType->id}"><?php echo $attributeType->title}</option>
                <?php echo /foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td class="ttovar_title">Список значений (через ||) </td>
            <td class="ttovar"><input name="data[list_value]" value="<?php echo $hash->listValue}"/></td>
        </tr>
    </table>
    <input id="save" name="save" type="submit" value="Сохранить"/>
</form>