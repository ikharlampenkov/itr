{include file="private/head.tpl"}
<table class="dsg" cellpadding="0">
  <tr>
    <td valign="top" class="pad">

<h1 class="title">Консультации: {if $openid==0}Общие вопросы{else}{$rubric.name}{/if}</h1>

<a href="{$siteurl}consult/" style="font-size:12px;">< вернуться назад</a><br><br>

{foreach from=$gmsgs item=gmsg name=_gmsg}
<div onmouseover="if(_ON_MENU!=1)selElement(this);" onmouseout="if(_ON_MENU!=1)deSelElement(this);" 
        onclick="showMenu(this, '{$siteurl}consult/?id={$gmsg.id}&open={$openid}','{$siteurl}consult/?id={$gmsg.id}&open={$openid}','{$siteurl}consult/?del={$gmsg.id}&open={$openid}');" 
        style="width:100%;border:0px solid #aaaaaa" id="div_{$smarty.foreach._gmsg.iteration}">
<a href="{$siteurl}consult/?id={$gmsg.id}&open={$openid}">{$gmsg.name}</a><br>
{if $gmsg.catalogid}<b>Услуга: </b>{$gmsg.rubric}</br>{/if}
{if $gmsg.doctorid}<b>Доктор: </b>{$gmsg.doctor}</br>{/if}
{if $gmsg.email}<b>E-mail: </b>{$gmsg.email}</br>{/if}
{$gmsg.message}</br>
{if $gmsg.answer}<b>Ответ: </b>{$gmsg.answer}<br>
<b>Утверждено: </b>{if $gmsg.moderate == 1}Да{else}Нет{/if}
{/if}
</div>
{if !$smarty.foreach._gmsg.last}<hr class="sep">{/if}
{/foreach}

    </td>
  </tr>
</table>
{include file="private/foot.tpl"}