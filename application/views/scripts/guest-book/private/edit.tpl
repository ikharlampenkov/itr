{include file="private/head.tpl"}
<table class="dsg" cellpadding="0">
  <tr>
    <td class="pad" valign="top">
    
<h1 class="title">Консультации: {if $gmsg.catalogid == 0}Общие вопросы{else}{$gmsg.rubric}{/if}</h1>
<a href="javascript:history.back()" class="home"><< Вернуться назад</a><br>

<form method="POST">
<b>Имя: </b><input type="text" name="data[name]" value="{$gmsg.name}" class="text"><br>

<br><b>Услуга: </b><select name=data[catalogid] style="width:100%">
     <option value="0">Общие вопросы</option>
     {html_options values=$rubrics.id selected=$gmsg.catalogid output=$rubrics.name}
     </select></br>
     
<br><b>Врач: </b><br/>
{html_radios name=data[doctorid] values=$doctor.id output=$doctor.fio selected=$gmsg.doctorid separator="<br/>"}
{*
<select name=data[doctorid] style="width:100%">
     {html_options values=$doctor.id selected=$gmsg.doctorid output=$doctor.fio}
     </select>*}
</br>
     
{if $gmsg.email}<br><b>E-mail: </b> <input type="text" name="date[email]" value="{$gmsg.email}" class="text"></br>{/if}

<br><b>Сообщение: </b><br>
<textarea name="date[message]" class="text2">{$gmsg.message}</textarea><br>

<br><b>Ответ:</b><br>
<input type="hidden" name="data[id]" value="{$gmsg.id}">
<textarea name="data[answer]" class="text2">{$gmsg.answer}</textarea><br>

<br><b>Утверждено: </b><input type="checkbox" name="data[moderate]"{if $gmsg.moderate == 1}checked{/if} class="textw14"><br>
<br><input type="submit" name="action" value="Сохранить" class="textw100">
</form>

    </td>
  </tr>
</table>
{include file="private/foot.tpl"}