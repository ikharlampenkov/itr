<legend>Добавить пользователя</legend>

<form action="<?php echo $this->url(array('controller' => $controller,'action' => 'add'])}" method="post">
    <table>
        <tr>
            <td class="ttovar" width="200">Логин</td>
            <td class="ttovar"><input name="data[login]" value=""/></td>
        </tr>
        <tr>
            <td class="ttovar">Пароль</td>
            <td class="ttovar"><input name="data[password]" value=""/></td>
        </tr>
        <tr>
            <td class="ttovar">Дата создания</td>
            <td class="ttovar"><input name="data[date_create]" value="<?php echo $smarty.now|date_format:"%d.%m.%Y %H:%M:%S"}" class="datepicker"/></td>
        </tr>
        <tr>
            <td class="ttovar">Роль</td>
            <td class="ttovar"><select name="data[role_id]">
            <?php echo foreach from=$userRoleList item=role}
                <option value="<?php echo $role->id}"><?php echo $role->title}</option>
            <?php echo /foreach}
            </select>
            </td>
        </tr>
    </table>
    <input id="save" name="save" type="submit" value="Сохранить"/>
</form>