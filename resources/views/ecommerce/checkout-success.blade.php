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
      <h1>Order Success</h1>
    </div>
    <!-- /page_header -->
    <div class="row">
      <div class="col-lg-8 col-md-7 col-sm-12 ">
        {{-- Order information --}}
        <div class="billing-information-box box_general">
          <h5 class="mb-4">Thanks for Your Order</h5>
          <div class="billing-information">
            <h6>Status <span class="badge badge-info p-1 ml-2">Sending </span></h6>
            <div>Please prepare your money. </div>
            <div>Your order will be sent to your address in 3 days.</div>
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
                <li class="clearfix"><em><strong>Subtotal</strong></em> <span>$450.00</span></li>
                <li class="clearfix"><em><strong>Shipping</strong></em> <span>$0</span></li>
              </ul>
              <div class="total clearfix">TOTAL <span>$450.00</span></div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<!-- /main -->
@endsection


@section('user_defined_script')
<script>
  // Other address Panel
  $('#other_addr input').on("change", function() {
    if (this.checked)
      $('#other_addr_c').fadeIn('fast');
    else
      $('#other_addr_c').fadeOut('fast');
  });
</script>
@endsection