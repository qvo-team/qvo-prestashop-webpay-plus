 {if $status == 'ok'}
<p class="completed-pay">
	<h2>{l s='Your order on ' mod='qvopaymentgateway'} {$shop_name|escape:'htmlall':'utf-8'} {l s='is complete.' mod='qvopaymentgateway'} </h2>
		<br />
		- {l s='Amount' mod='qvopaymentgateway'} <span class="price"><strong>{$total_to_pay|escape:'htmlall':'utf-8'}</strong></span>
		{if !isset($reference)}
			<br /><br />- {l s='Your order number is ' mod='qvopaymentgateway'} {$id_order|escape:'htmlall':'utf-8'}
		{else}
			<br /><br />- {l s='Your order reference is ' mod='qvopaymentgateway'} <strong> {$reference|escape:'htmlall':'utf-8'} </strong>
		{/if}

		<br /><br />{l s='If you have questions, comments or concerns, please contact our' mod='qvopaymentgateway'} <a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='expert customer support team' mod='qvopaymentgateway'}</a>.
	</p>
{else}
	<p class="warning">
		{l s='We noticed a problem with your order. If you think this is an error, feel free to contact our' mod='qvopaymentgateway'}
		<a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='expert customer support team' mod='qvopaymentgateway'}</a>.
	</p>
{/if}
