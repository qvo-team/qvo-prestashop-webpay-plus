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
 <p class="well">{l s='Hay un problema con esta pasarela de pagos, por favor elija otra opción' mod='qvopaymentgateway'} </p>

</div>

{/block}
