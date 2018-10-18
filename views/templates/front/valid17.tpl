{capture name=path}
{l s='QVO WebPay Plus' mod='qvopaymentgateway'}
{/capture}
{extends file='page.tpl'}
{block name="notifications"}{/block}
{block name="page_content"}
<div class="row">
<h3> {l s='Respuesta del Pago' mod='qvopaymentgateway'} </h3>
 {if isset($errbag)}
 {if !empty($errbag)}
 {foreach $errbag as $err}
 <div class="alert alert-danger alert-error" role="alert">{$err|escape:'htmlall':'UTF-8'} </div>
 {/foreach}
 {/if}
 {/if}
 <p class="well">{l s='Su pedido no se pudo completar con esta pasarela de pago, puede seleccionar un método diferente a continuación' mod='qvopaymentgateway'} </p>
<div class="alert alert-info" role="alert"> <a href="{$link->getPageLink('order', true)|escape:'html':'UTF-8'}?step=3" rel="nofollow" title="{l s='other Payment Option' mod='qvopaymentgateway'}">{l s='Other Payment options' mod='qvopaymentgateway'}</a> </div>
</div>

{/block}
