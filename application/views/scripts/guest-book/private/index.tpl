{include file="private/head.tpl"}
<table class="dsg" cellpadding="0">
  <tr>
    <td valign="top" class="pad">

    
<h1 class="title">Консультации</h1>

<h4>Выберите услугу</h4>

<table border="0" class="catfirst" align="center">
    <tr>
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

    </td>
  </tr>
</table>
{include file="private/foot.tpl"}