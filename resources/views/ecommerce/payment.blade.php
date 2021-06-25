@extends('layouts.ecommerce')

@section('title', "Neko eCommerce - Best solution for Accessories")

@section('user_defined_style')
  <link href="{{ asset('ecommerce/css/checkout.css') }}" rel="stylesheet">
  <link href="{{ asset('ecommerce/css/cart.css') }}" rel="stylesheet">
  <link href="{{ asset('ecommerce/css/listing.css') }}" rel="stylesheet">
  <link href="{{ asset('ecommerce/css/custom.css') }}" rel="stylesheet">
@endsection


@section('content')
  <main class="bg_gray">
  	<div class="container margin_30">
  		<div class="page_header">
		    <h1>Checkout</h1>
	     </div>
       <!-- /page_header -->
			<div class="row">
        <div class="col-lg-8 col-md-7 col-sm-12 ">
          {{-- Billing information --}}
          <div class="billing-information-box box_general">
            <h5 class="mb-4">Billing address</h5>
            <div class="billing-information">
              <h6>Your Full Name <span class="badge badge-info p-1 ml-2">Primary</span></h6>
              <div>Jl. Nama jalan dan No. 9999 Kec. Mana</div>
              <div>Kab. Siapa, Sumatera Utara. 20345</div>
              <button type="button" class="btn_1 gray my-3 p-2" name="button">Change</button>
            </div>
          </div>

          {{-- Item list --}}
          <div class="item-list-checkout-box box_general">
            <div class="item-list-checkout mb-3">
              <table class="table table-striped cart-list">
              	<thead>
              		<tr>
              			<th>Product</th>
              			<th>Price</th>
              			<th>Quantity</th>
              			<th>Subtotal</th>
              		</tr>
              	</thead>
              	<tbody>
              		<tr>
              			<td>
              				<div class="thumb_cart">
              					<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1.jpg') }}" class="lazy" alt="Image">
              				</div>
              				<span class="item_cart"><a href="" class="product-link">Armor Air x Fear</a></span>
              			</td>
              			<td>
              				<strong>$140.00</strong>
              			</td>
              			<td>
              				<strong>1</strong>
              			</td>
              			<td>
              				<strong>$140.00</strong>
              			</td>
              		</tr>
              		<tr>
              			<td>
              				<div class="thumb_cart">
              					<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/2.jpg') }}" class="lazy" alt="Image">
              				</div>
              				<span class="item_cart"><a href="" class="product-link">Armor Okwahn II</a></span>
              			</td>
              			<td>
              				<strong>$110.00</strong>
              			</td>
              			<td>
              				<strong>1</strong>
              			</td>
              			<td>
              				<strong>$110.00</strong>
              			</td>
              		</tr>
              		<tr>
              			<td>
              				<div class="thumb_cart">
              					<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/3.jpg') }}" class="lazy" alt="Image">
              				</div>
              				<span class="item_cart"><a href="" class="product-link">Armor Air Wildwood ACG</a></span>
              			</td>
              			<td>
              				<strong>$90.00</strong>
              			</td>

              			<td>
              				<strong>1</strong>
              			</td>
              			<td>
              				<strong>$90.00</strong>
              			</td>
              		</tr>
              	</tbody>
              </table>
            </div>
          </div>

          {{-- Shipping method selection --}}
          <div class="shipping-method-box box_general">
            <h5 class="mb-4">Choose a shipping method</h5>
            <div class="shipping-method mb-3">
              {{-- Standard --}}
              <div class="filter_col shipping-method-filter">
                <div class="filter_type version_2">
                  <h4><a href="#filter_1" data-toggle="collapse" class="opened">Standard</a></h4>
                  <div class="collapse show" id="filter_1">
                    <ul>
                      <li>
                        <label class="container_radio">Standard Regular <small>5 Hari | Rp.30.000</small>
                          <input type="radio" name="shipping_method" checked>
                          <span class="checkmark"></span>
                        </label>
                      </li>
                      <li>
                        <label class="container_radio">J&T Regular <small>7 Hari | Rp.30.000</small>
                          <input type="radio" name="shipping_method">
                          <span class="checkmark"></span>
                        </label>
                      </li>
                      <li>
                        <label class="container_radio">Ninja Van Regular <small>3 Hari | Rp.40.000</small>
                          <input type="radio" name="shipping_method">
                          <span class="checkmark"></span>
                        </label>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              {{-- Express --}}
              <div class="filter_col shipping-method-filter">
                <div class="filter_type version_2">
                  <h4><a href="#filter_2" data-toggle="collapse" aria-expanded="false" class="collapsed">Express</a></h4>
                  <div class="collapse" id="filter_2">
                    <ul>
                      <li>
                        <label class="container_radio">Standard Regular <small>5 Hari | Rp.30.000</small>
                          <input type="radio" name="shipping_method">
                          <span class="checkmark"></span>
                        </label>
                      </li>
                      <li>
                        <label class="container_radio">J&T Regular <small>7 Hari | Rp.30.000</small>
                          <input type="radio" name="shipping_method">
                          <span class="checkmark"></span>
                        </label>
                      </li>
                      <li>
                        <label class="container_radio">Ninja Van Regular <small>3 Hari | Rp.40.000</small>
                          <input type="radio" name="shipping_method">
                          <span class="checkmark"></span>
                        </label>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-12">
          <div class="box_general">
            {{-- Summary --}}
            <div class="summary-box">
              <h5 class="pb-4">Summary</h5>
              <div class="summary mt-3">
                <ul>
    							<li class="clearfix"><em><strong>Subtotal</strong></em>  <span>$450.00</span></li>
    							<li class="clearfix"><em><strong>Shipping</strong></em> <span>$0</span></li>
    						</ul>
                <div class="total clearfix">TOTAL <span>$450.00</span></div>
              </div>

              <h5 class="mt-5">Choose payment method</h5>
              <div class="payment-method-box">
                <p>Please select your payment method and easy for it.</p>
                <ul class="payment-method-list">
                  <li>
                    <label class="container_radio">
                      <span class="payment-item-row">
                        <i class="ri-bank-card-line mr-1 payment-item-icon"></i>
                        <span class="payment-item-name">Credit Card</span>
                      </span>
                      <input type="radio" name="payments_method">
                      <span class="checkmark"></span>
                    </label>
                  </li>
                  <li>
                    <label class="container_radio">
                      <span class="payment-item-row">
                        <i class="ri-paypal-line mr-1 payment-item-icon"></i>
                        <span class="payment-item-name">Paypal</span>
                      </span>
                      <input type="radio" name="payments_method">
                      <span class="checkmark"></span>
                    </label>
                  </li>
                  <li>
                    <label class="container_radio">
                      <span class="payment-item-row">
                        <i class="ri-currency-line mr-1 payment-item-icon"></i>
                        <span class="payment-item-name">Cash on Delivery</span>
                      </span>
                      <input type="radio" name="payments_method">
                      <span class="checkmark"></span>
                    </label>
                  </li>
                  <li>
                    <label class="container_radio">
                      <span class="payment-item-row">
                        <i class="ri-bank-line mr-1 payment-item-icon"></i>
                        <span class="payment-item-name">Bank Transfer</span>
                      </span>
                      <input type="radio" name="payments_method">
                      <span class="checkmark"></span>
                    </label>
                  </li>
                </ul>
                <a href="confirm.html" class="btn_1 full-width mb-4 mt-3">Confirm and Pay</a>
              </div>
            </div>
          </div>
        </div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</main>
  <!-- /main -->

  <!-- Modal Payments Method-->
	<div class="modal fade" id="payments_method" tabindex="-1" role="dialog" aria-labelledby="payments_method_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
  		<div class="modal-content">
  		  <div class="modal-header">
    			<h5 class="modal-title" id="payments_method_title">Payments Methods</h5>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    			  <span aria-hidden="true">&times;</span>
    			</button>
  		  </div>
  		  <div class="modal-body">
          <p>Lorem ipsum dolor sit amet, oratio possim ius cu. Labore prompta nominavi sea ei. Sea no animal saperet gloriatur, ius iusto ullamcorper ad. Qui ignota reformidans ei, vix in elit conceptam adipiscing, quaestio repudiandae delicatissimi vis ei. Fabulas accusamus no has.</p>
          <p>Et nam vidit zril, pri elaboraret suscipiantur ut. Duo mucius gloriatur at, in vis integre labitur dolores, mei omnis utinam labitur id. An eum prodesset appellantur. Ut alia nemore mei, at velit veniam vix, nonumy propriae conclusionemque ea cum.</p>
  		  </div>
  		</div>
    </div>
	</div>
@endsection


@section('user_defined_script')
  <script>
    // Other address Panel
    $('#other_addr input').on("change", function (){
      if(this.checked)
        $('#other_addr_c').fadeIn('fast');
      else
        $('#other_addr_c').fadeOut('fast');
    });
</script>
@endsection
