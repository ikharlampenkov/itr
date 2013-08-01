{include file="public/head.tpl"}
<table class="dsg" cellpadding="0">
  <tr>
    <td class="pad" valign="top">
   

<h1 class="title">Консультации: {if $openid==0}Общие вопросы{else}{$rubric.name}{/if}</h1>

<a href="{$siteurl}consult/" style="font-size:12px;">< вернуться назад</a><br><br>

<a href="javascript:openMessageForm();" id="message_form_button">{if !isset($doctorid)}Задать вопрос &darr;{else}Скрыть форму &uarr;{/if}</a><br><br>

<table width="100%" id="message_form" {if !isset($doctorid)}style="display:none;"{/if}>
<form method="POST" name="consult_form" onsubmit="return tryFunc(this);">
<input type="hidden" name="data[catalogid]" value="{if $openid==0}0{else}{$rubric.id}{/if}">
  <tr>
    <td>ФИО</td>
  </tr>
  <tr>
    <td><input type="text" name="data[name]" value="" class="text" id="name"></td>
  </tr>
  <tr>  
    <td>E-mail</td>
  </tr>
  <tr>
    <td><input type="text" name="data[email]" value="" class="text" id="email"></td>
  </tr>
  {*
  <tr>
    <td>Услуга</td>
  </tr>
  <tr>
    <td>
     <select name=data[catalogid] style="width:100%">
     {html_options values=$rubrics.id selected=$rubric.ownerid output=$rubrics.name}
     </select></td>
  </tr>
  *}
  <tr>
    <td>Врач</td>
  </tr>
  <tr>
    <td>
     {section name=_doctorid loop=$doctor.count}
      <label><input type="radio" name="data[doctorid]" value="{$doctor.id[_doctorid]}" {if $doctor.id[_doctorid] == $doctorid || $doctor.id[_doctorid] == 0}checked="checked"{/if} />
      {if $doctor.id[_doctorid] != 0}<a href="{$siteurl}doctors/{$doctor.id[_doctorid]}/" target="_blank">{$doctor.fio[_doctorid]}</a>{else}{$doctor.fio[_doctorid]}{/if}</label><br/>
      {/section}
     {*if !isset($doctorid)}
     {html_radios name=data[doctorid] values=$doctor.id output=$doctor.fio selected=0 separator="<br/>"}
     {else}
     {html_radios name=data[doctorid] values=$doctor.id output=$doctor.fio selected=$doctorid separator="<br/>"}
     {/if*}
     {*<select name=data[doctorid] style="width:100%">
     {html_options values=$doctor.id selected=$rubric.ownerid output=$doctor.fio}
     </select>*}</td>
  </tr>
  <tr>
    <td colspan="3">Сообщение</td>
  </tr>
  <tr>
    <td colspan="3"><textarea name="data[message]" class="text2" id="message"></textarea></td>
  </tr>
  <tr>
    <td colspan="3"><input type="submit" name="action" value="Отправить" class="textw80"></td>
  </tr>
</form>  
</table>

{if isset($gmsgs) && !empty($gmsgs)}
<h4>Сообщения</h4>

{foreach from=$gmsgs item=gmsg name=_gmsg}
<div class="bold">Имя: {$gmsg.name}</div>
{if $gmsg.catalogid}<b>Услуга: </b><a href="{$siteurl}catalog/{$gmsg.catalogid}/">{$gmsg.rubric}</a></br>{/if}
{if $gmsg.doctorid}<b>Доктор: </b><a href="{$siteurl}doctors/{$gmsg.doctorid}/">{$gmsg.doctor}</a></br>{/if}
<b>Сообщение: </b><div>{$gmsg.message}</div>
{if $gmsg.answer}<b>Ответ: </b><div>{$gmsg.answer}</div>{/if}
{if !$smarty.foreach._gmsg.last}<hr class="sep">{/if}
{/foreach}
<br><br>
{/if}

    </td>
  </tr>
</table>
{include file="public/foot.tpl"}

