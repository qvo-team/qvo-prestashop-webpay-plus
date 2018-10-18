<style>
.conf
{
	color:green;
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
	font-weight:bold;
	line-height:35px;
}
.error
{
	color:red;
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
	font-weight:bold;
	line-height:35px;
}

</style>
<p><img src="{$module_dir}img/webpay.png" alt="QVO Webplus Payment" class="qvo-logo" /><span style="padding-left:10px; font-size:16px;">{l s='Este módulo le permite aceptar pagos seguros con Transbank WebPay Plus' mod='qvowebpayplus'}</span></p>
<form id="module_form" class="defaultForm form-horizontal" action="{$qvowebpayplus_form|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data" novalidate="">
      {$qvowebpayplus_msg}
      <div class="panel" id="fieldset_0">
        <div class="panel-heading"> <i class="icon-cog"></i>&nbsp;{l s='QVO WebPay Plus - Detalles de configuración' mod='qvowebpayplus'}</div>
        <div class="form-wrapper">
          <div class="form-group">
            <label class="control-label col-lg-3 required">{l s='Título:' mod='qvowebpayplus'}</label>
            <div class="col-lg-9">
              <input name="qvowebpayplus_title" id="qvowebpayplus_title" value="{$qvowebpayplus_title}" class="" required="required" type="text">
              <i>{l s='Mostrar el título del método de pago durante el checkout' mod='qvowebpayplus'}</i>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-3 required">{l s='Descripción:' mod='qvowebpayplus'}</label>
            <div class="col-lg-9">
              <input name="qvowebpayplus_descr" id="qvowebpayplus_descr" value="{$qvowebpayplus_descr}" class="" required="required" type="text">
              <i>{l s='Mostrar la descripción del método de pago durante el checkout' mod='qvowebpayplus'}</i>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-3 required">{l s='API Key Prueba:' mod='qvowebpayplus'}</label>
            <div class="col-lg-9">
              <input name="qvowebpayplus_apikey_test" id="qvowebpayplus_apikey_test" value="{$qvowebpayplus_apikey_test}" class="" required="required" type="text"><i>Tu API Key de Prueba (Puedes encontrarla en la sección <a target="_blank"t href="https://dashboard-test.qvo.cl/dashboard/api">API del dashboard test de QVO</a>)</i>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-3 required">{l s='API Key Producción:' mod='qvowebpayplus'}</label>
            <div class="col-lg-9">
              <input name="qvowebpayplus_apikey_live" id="qvowebpayplus_apikey_live" value="{$qvowebpayplus_apikey_live}" class="" required="required" type="text"><i>Tu API Key de Producción (Puedes encontrarla en la sección <a target="_blank"t href="https://dashboard.qvo.cl/dashboard/api">API del dashboard de producción de QVO</a>)</i>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-3 required">{l s='Entorno:' mod='qvowebpayplus'}</label>
            <div class="col-lg-9">
              <select id="qvowebpayplus_payment_mode" name="qvowebpayplus_payment_mode">
                   <option value="test">{l s='Prueba' mod='qvowebpayplus'}</option>
                   <option value="live">{l s='Producción' mod='qvowebpayplus'}</option>
              </select>
            </div>
          </div>
        </div>
        <!-- /.form-wrapper -->

        <div class="panel-footer">
          <button type="submit" value="1" id="module_form_submit_btn" name="submitQvowebplus" class="btn btn-default pull-right"> <i class="process-icon-save"></i> {l s='Guardar' mod='qvowebpayplus'} </button>
        </div>
      </div>
    </form>
