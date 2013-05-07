<legend>Редактировать пользователя</legend>

<form action="<?php echo $this->url(array('controller' => $controller,'action' => 'edit', 'id' => $user->id])}" method="post">
    <table>
        <tr>
            <td class="ttovar_title">Логин</td>
            <td class="ttovar"><input name="data[login]" value="<?php echo $user->login}"/></td>
        </tr>
        <tr>
            <td class="ttovar">Пароль</td>
            <td class="ttovar"><input name="data[password]" value="<?php echo $user->password}"/></td>
        </tr>
        <tr>
            <td class="ttovar">Дата создания</td>
            <td class="ttovar"><input name="data[date_create]" value="<?php echo $user->datecreate|date_format:"%d.%m.%Y %H:%M"}" class="datepicker"/></td>
        </tr>
        <tr>
            <td class="ttovar">Роль</td>
            <td class="ttovar"><select name="data[role_id]">
            <?php echo foreach from=$userRoleList item=role}
                <option value="<?php echo $role->id}" <?php echo if $user->role->id==$role->id}selected="selected"<?php echo /if}><?php echo $role->title}</option>
            <?php echo /foreach}
            </select>
            </td>
        </tr>
    <?php echo if $attributeHashList!==false}
        <?php echo foreach from=$attributeHashList item=attributeHash}
            <tr>
                <td class="ttovar_title"><?php echo $attributeHash->title}</td>
                <td class="ttovar"><?php echo $attributeHash->type->getHTMLFrom($attributeHash, $user)}</td>
            </tr>
        <?php echo /foreach}
    <?php echo /if}
    </table>
    <input id="save" name="save" type="submit" value="Сохранить"/>
</form>