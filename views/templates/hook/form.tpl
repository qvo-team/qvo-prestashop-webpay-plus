<div class="row">
	<div class="col-sm-12">

        <form>
          <ul class="form-list">
            <li class="form-list__row">
              <label>Name</label>
              <input type="text" name="" required="" />
            </li>
            <li class="form-list__row">
              <label>Card Number</label>
              <div id="input--cc" class="creditcard-icon">
                <input type="text" name="cc_number" required="" />
              </div>
            </li>
            <li class="form-list__row form-list__row--inline">
              <div>
                <label>Expiration Date</label>
                <div class="form-list__input-inline">
                  <input type="text" name="cc_month" placeholder="MM"  pattern="\\d*" minlength="2" maxlength="2" required="" />
                  <input type="text" name="cc_year" placeholder="YY"  pattern="\\d*" minlength="2" maxlength="2" required="" />
                </div>
              </div>
              <div>
                <label>
                  CVC

                  <a href="#cvv-modal" class="button--transparent modal-open button--info">
                  
                    <span class="visuallyhidden">What is CVV?</span>
                  </a>
                </label>
                <input type="text" name="cc_cvc" placeholder="123" pattern="\\d*" minlength="3" maxlength="4" required="" />
              </div>
            </li>
            <li class="form-list__row form-list__row--agree">
              <label>
                <input type="checkbox" name="save_cc" checked="checked">
                Save my card for future purchases
              </label>
            </li>
            <li>
              <button type="submit" class="button">Pay Now</button>
            </li>
          </ul>
        </form>

	</div>

</div>