<?php echo if_allowed resource="<?php echo $controller}/index" priv="show-attribute-hash"}
<legend class="heading">Список атрибутов для пользователей</legend>

<table width="100%">
    <tr>
        <td class="ttovar" align="center" colspan="4">
            <img src="/i/add.png"/>&nbsp;<a href="<?php echo $this->url(array('controller' => $controller,'action' => 'addAttributeHash'])}">добавить</a></td>
    </tr>

<?php echo if $attributeHashList!==false}
    <?php echo foreach from=$attributeHashList item=attributeHash}
        <tr>
            <td class="ttovar"><?php echo $attributeHash->title}</td>
            <td class="ttovar"><?php echo $attributeHash->attributeKey}</td>
            <td class="ttovar"><?php echo $attributeHash->type->title}</td>
            <td class="tedit">
                <img src="/i/edit.png"/>&nbsp;<a href="<?php echo $this->url(array('controller' => $controller,'action' => 'editAttributeHash', 'key' => $attributeHash->attributeKey])}">редактировать</a><br/>
                <img src="/i/delete.png"/>&nbsp;<a href="<?php echo $this->url(array('controller' => $controller,'action' => 'deleteAttributeHash', 'key' => $attributeHash->attributeKey])}" onclick="return confirmDelete('<?php echo $attributeHash->title}');" style="color: #830000">удалить</a>
            </td>
        </tr>
    <?php echo /foreach}
<?php echo /if}

</table>
<?php echo /if_allowed}