<?php echo if_allowed resource="<?php echo $controller}/index" priv="show-attribute-type"}
<legend class="heading">Типы атрибутов</legend>

<table width="100%">
    <tr>
        <td class="ttovar" align="center" colspan="3">
            <img src="/i/add.png"/>&nbsp;<a href="<?php echo $this->url(array('controller' => $controller,'action' => 'addAttributeType'])}">добавить</a></td>
    </tr>

<?php echo if $attributeTypeList!==false}
    <?php echo foreach from=$attributeTypeList item=attributeType}
        <tr>
            <td class="ttovar"><?php echo $attributeType->title}</td>
            <td class="ttovar"><?php echo $attributeType->handler}</td>
            <td class="tedit">
                <img src="/i/edit.png"/>&nbsp;<a href="<?php echo $this->url(array('controller' => $controller,'action' => 'editAttributeType', 'id' => $attributeType->id])}">редактировать</a><br/>
                <img src="/i/delete.png"/>&nbsp;<a href="<?php echo $this->url(array('controller' => $controller,'action' => 'deleteAttributeType', 'id' => $attributeType->id])}" onclick="return confirmDelete('<?php echo $attributeType->title}');" style="color: #830000">удалить</a>
            </td>
        </tr>
    <?php echo /foreach}
<?php echo /if}

</table>
<?php echo /if_allowed}