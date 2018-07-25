{if isset($savedok)}
{if $savedok eq 'ok'}<ps-alert-success>{l s='Guardado con exito' mod='qvopaymentgateway'}</ps-alert-success> {/if}
{/if}

<div class="panel panel-def" icon="icon-cogs" img="" header="">
<br />
<div class="panel-heading p-title"> <h4 class="panel-title p-title">{l s='QVO – Pago a través de Webpay Plus' mod='qvopaymentgateway'} </h4></div>
<img style="margin-bottom:20px; display: block;" src="{$logoimage|escape:'htmlall':'UTF-8'}">

<form class="form-horizontal" method="POST" action="">
<ps-input-text name="QVO_WEBPAY_PLUS_TITLE" label="Título" size="60" value="{$QVO_WEBPAY_PLUS_TITLE|escape:'htmlall':'UTF-8'}" required-input="false" hint="{l s='Display title of QVO Webpay plus module while checkout.' mod='qvopaymentgateway'}" fixed-width="xxl"></ps-input-text>
<ps-input-text name="QVO_WEBPAY_PLUS_DESCR" label="Descripción" size="60" value="{$QVO_WEBPAY_PLUS_DESCR|escape:'htmlall':'UTF-8'}" required-input="false" hint="{l s=' Display description of Qvo Webpay plus module while checkout. ' mod='qvopaymentgateway'}" fixed-width="xxl"></ps-input-text>
<br />
<ps-switch name="QVO_WEBPAY_PLUS_PAYMENT_MODE" label="{l s='Ambiente' mod='qvopaymentgateway'}" yes="Producción" no="Prueba" {if $QVO_WEBPAY_PLUS_PAYMENT_MODE eq 1} active="true" {/if} fixed-width="xxl"></ps-switch>
<ps-input-text name="QVO_WEBPAY_PLUS_API_TOKEN_TEST" label="API Token Prueba" size="60" value="{$QVO_WEBPAY_PLUS_API_TOKEN_TEST|escape:'htmlall':'UTF-8'}" required-input="false" hint="{l s='Sandbox API Token' mod='qvopaymentgateway'}" fixed-width="xxl"></ps-input-text>
<ps-input-text name="QVO_WEBPAY_PLUS_API_TOKEN_LIVE" label="API Token Producción" size="60" value="{$QVO_WEBPAY_PLUS_API_TOKEN_LIVE|escape:'htmlall':'UTF-8'}" required-input="true" hint="{l s='Live API Token' mod='qvopaymentgateway'}" fixed-width="xxl"></ps-input-text>

<hr>

    <ps-panel-footer>
        <ps-panel-footer-submit title="save" icon="process-icon-save" direction="right" name="qvopaymentconfiguration"></ps-panel-footer-submit>
    </ps-panel-footer>

</form>
</div>
