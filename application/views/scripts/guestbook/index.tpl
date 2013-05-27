{include file="public/head.tpl"}
<table class="dsg" cellpadding="0">
  <tr>
    <td class="pad" valign="top">
   

<h1 class="title">Задать вопрос</h1>

<h4>Выберите услугу</h4>

<table border="0" class="catfirst" align="center">
            {foreach from=$catalog item=dir name=catalog}
              {if ($smarty.foreach.catalog.index%3) == 0}
              <tr> 
              {/if}
                <!--<td height="37" width="40">{if $dir.img}<img src="{$siteurl}{$dir.img}">{else}<img src="{$siteurl}i/in_cat.jpg">{/if}</td>-->
                <td><a href="{$siteurl}consult/{if isset($smarty.get.view)}view/{/if}{$dir.id}/">{$dir.name} ({if isset($ans_count[$dir.id])}{$ans_count[$dir.id]}{else}{0}{/if})</a></td>
              {if ($smarty.foreach.catalog.index+1%3) == 0 && $smarty.foreach.catalog.index !=0}
              </tr> 
              {/if}
            {/foreach}
            </tr>
</table>

<br/>
<a href="{$siteurl}consult/{if isset($smarty.get.view)}view/{/if}0/">Общие вопросы</a>

{*

<h4>Написать сообщение</h4>
<table width="100%">
<form method="POST">
  <tr>
    <td>ФИО</td>
  </tr>
  <tr>
    <td><input type="text" name="data[name]" value="" class="text"></td>  
  </tr>
  <tr>  
    <td>E-mail</td>
  </tr>
  <tr>
    <td><input type="text" name="data[email]" value="" class="text"></td>  
  </tr>
  <tr>
    <td>Услуга</td>
  </tr>
  <tr>
    <td>
     <select name=data[catalogid] style="width:100%">
     {html_options values=$rubrics.id selected=$rubric.ownerid output=$rubrics.name}
     </select></td>
  </tr>
  <tr>
    <td>Врач</td>
  </tr>
  <tr>
    <td>
     <select name=data[doctorid] style="width:100%">
     {html_options values=$doctor.id selected=$rubric.ownerid output=$doctor.fio}
     </select></td>
  </tr>
  <tr>
    <td colspan="3">Сообщение</td>
  </tr>
  <tr>
    <td colspan="3"><textarea name="data[message]" class="text2"></textarea></td>
  </tr>
  <tr>
    <td colspan="3"><input type="submit" name="action" value="Отправить" class="textw80"></td>
  </tr>
</form>  
</table>

<h4>Сообщения</h4>
{if isset($gmsgs) && !empty($gmsgs)}
{foreach from=$gmsgs item=gmsg name=_gmsg}
<div class="bold">Имя: {$gmsg.name}</div>
{if $gmsg.catalogid}<b>Услуга: </b>{$gmsg.rubric}</br>{/if}
{if $gmsg.doctorid}<b>Доктор: </b>{$gmsg.doctor}</br>{/if}
<b>Сообщение: </b><div>{$gmsg.message}</div>
{if $gmsg.answer}<b>Ответ: </b><div>{$gmsg.answer}</div>{/if}
{if !$smarty.foreach._gmsg.last}<hr class="sep">{/if}
{/foreach}
{/if}

*}

    </td>
  </tr>
</table>
{include file="public/foot.tpl"}

