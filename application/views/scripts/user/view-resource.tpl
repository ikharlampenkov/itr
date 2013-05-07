<?php echo if_allowed resource="<?php echo $controller}/index" priv="show-resource"}
<legend class="heading">Ресурсы</legend>

<table width="100%">
    <tr>
        <td class="ttovar" align="center" colspan="3">
            <img src="/i/add.png"/>&nbsp;<a href="<?php echo $this->url(array('controller' => $controller,'action' => 'addResource'])}">добавить</a></td>
    </tr>

<?php echo if $userResourceList!==false}
    <?php echo foreach from=$userResourceList item=resource}
        <tr>
            <td class="ttovar"><?php echo $resource->rtitle}</td>
            <td class="ttovar"><?php echo $resource->title}</td>
            <td class="tedit">
                <img src="/i/edit.png"/>&nbsp;<a href="<?php echo $this->url(array('controller' => $controller,'action' => 'editResource', 'id' => $resource->id])}">редактировать</a><br/>
                <img src="/i/delete.png"/>&nbsp;<a href="<?php echo $this->url(array('controller' => $controller,'action' => 'deleteResource', 'id' => $resource->id])}" onclick="return confirmDelete('<?php echo $resource->rtitle}');" style="color: #830000">удалить</a></td>
        </tr>
    <?php echo /foreach}
<?php echo /if}

</table>
<?php echo /if_allowed}