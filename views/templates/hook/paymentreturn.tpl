{if $status == 'ok'}
<p class="completed-pay">
	<h2>{l s='Su orden en ' mod='qvopaymentgateway'} {$shop_name|escape:'htmlall':'utf-8'} {l s='Esta completa.' mod='qvopaymentgateway'} </h2>
		<br />
		- {l s='Monto' mod='qvopaymentgateway'} <span class="price"><strong>{$total_to_pay|escape:'htmlall':'utf-8'}</strong></span>
		{if !isset($reference)}
			<br /><br />- {l s='Tu número de orden es' mod='qvopaymentgateway'} {$id_order|escape:'htmlall':'utf-8'}
		{else}
			<br /><br />- {l s='Tu referencia de pedido es ' mod='qvopaymentgateway'} <strong> {$reference|escape:'htmlall':'utf-8'} </strong>
		{/if}

		<br /><br />{l s='Si tiene preguntas, comentarios o inquietudes, póngase en contacto con nuestro' mod='qvopaymentgateway'} <a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='experto equipo de soporte al cliente' mod='qvopaymentgateway'}</a>.
	</p>
{else}
	<p class="warning">
		{l s='Notamos un problema con su pedido. Si cree que esto es un error, no dude en ponerse en contacto con nuestro' mod='qvopaymentgateway'}
		<a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='experto equipo de soporte al cliente' mod='qvopaymentgateway'}</a>.
	</p>
{/if}
