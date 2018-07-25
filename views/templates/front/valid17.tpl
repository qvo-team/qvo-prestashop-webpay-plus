{capture name=path}
{l s='QVO Payment Gateway' mod='qvopaymentgateway'}
{/capture}
{extends file='page.tpl'}
{block name="notifications"}{/block}
{block name="page_content"}
<div class="row">
<h3> {l s='Order Payment Response' mod='qvopaymentgateway'} </h3>
 {if isset($errbag)}
 {if !empty($errbag)}
 {foreach $errbag as $err}
 <div class="alert alert-danger alert-error" role="alert">{$err|escape:'htmlall':'UTF-8'} </div>
 {/foreach}
 {/if}
 {/if}
 <p class="well">{l s='Your order could not be completed with this payment option, you can select a different payment below' mod='qvopaymentgateway'} </p>
<div class="alert alert-info" role="alert"> <a href="{$link->getPageLink('order', true)|escape:'html':'UTF-8'}?step=3" rel="nofollow" title="{l s='other Payment Option' mod='qvopaymentgateway'}">{l s='Other Payment options' mod='qvopaymentgateway'}</a> </div>
</div>

{/block}

