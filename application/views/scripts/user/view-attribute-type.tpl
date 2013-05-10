<?php echo if_allowed resource="<?php echo 'user' ?>/index" priv="show-attribute-type" ?>
<legend class="heading">Типы атрибутов</legend>

<table class="table table-bordered">
    <tr>
        <td class="ttovar" align="center" colspan="3">
            <img src="/i/add.png"/>&nbsp;<a href="<?php echo $this->url(array('controller' => 'user','action' => 'addAttributeType')); ?>">добавить</a></td>
    </tr>

<?php if($this->attributeTypeList!==false ?>
    <?php echo foreach($this->attributeTypeList as $attributeType ?>
        <tr>
            <td class="ttovar"><?php echo $attributeType->title ?></td>
            <td class="ttovar"><?php echo $attributeType->handler ?></td>
            <td class="tedit">
                <a href="<?php echo $this->url(array('controller' => 'user','action' => 'editAttributeType', 'id' => $attributeType->id)); ?>"><i class="icon-pencil"></a><br/>
                <a href="<?php echo $this->url(array('controller' => 'user','action' => 'deleteAttributeType', 'id' => $attributeType->id)); ?>" onclick="return confirmDelete('<?php echo $attributeType->title ?>');" ><i class="icon-remove"></i></a>
            </td>
        </tr>
    <?php endforeach ?>
<?php endif ?>

</table>
<?php endif_allowed ?>