
{capture name=path}
{l s='QVO Payment Gateway' mod='qvopaymentgateway'}
{/capture}
{extends file='page.tpl'}
{block name="notifications"}{/block}
{block name="page_content"}
<div class="row">
<h3> {l s='Order Payment Option Response' mod='qvopaymentgateway'} </h3>
 {if isset($errbag)}
 {if !empty($errbag)}
 {foreach $errbag as $err}
 <div class="alert alert-danger alert-error" role="alert">{$err|escape:'htmlall':'UTF-8'} </div>
 {/foreach}
 {/if}
 {/if}
 <p class="well">{l s='Hay un error con el proveedor de pagos, por favor selecciona otra opcion' mod='qvopaymentgateway'} </p>

</div>

{/block}
