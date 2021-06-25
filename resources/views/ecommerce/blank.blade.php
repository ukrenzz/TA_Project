@extends('layouts.ecommerce')

@section('title', "Neko eCommerce - Best solution for Accessories")

@section('user_defined_style')
  <link href="{{ asset('ecommerce/') }}" rel="stylesheet">
  <link href="{{ asset('ecommerce/css/custom.css') }}" rel="stylesheet">
@endsection


@section('content')

  <!-- /main -->
@endsection


@section('user_defined_script')
  <script type="text/javascript" src="{{ asset('ecommerce/') }}"></script>
@endsection
