@extends('layouts.admin')

@section('page_title', "Products")

@section('extend_style')
<!-- page style -->
<link href="{{ asset('vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('ecommerce/css/custom.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb_item')
<a href="{{ route('admin.dashboard')}}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
{{-- <a class="breadcrumb-item" href="#">Tables</a> --}}
<span class="breadcrumb-item active">Product</span>
@endsection

@section('content')

<div class="card">
  <div class="card-body">
    @if (session('status'))
    <div class="alert alert-success">
      <div class="d-flex justify-content-start">
        <span class="alert-icon m-r-20 font-size-30">
          <i class="anticon anticon-check-circle"></i>
        </span>
        <div>
          <h5 class="alert-heading">Success</h5>
          <p>{{ session('status') }}</p>
        </div>
      </div>
    </div>
    @endif
    <div class="d-flex row">
      <div class="col-sm-12 col-md-3 col-lg-3">
        <div class="input-affix m-b-10">
          <i class="prefix-icon anticon anticon-search"></i>
          <input type="text" class="form-control" id="products-search" placeholder="Search by name">
        </div>
      </div>

      <div class="col-sm-12 col-md-9 col-lg-9 text-right">
        <a href="{{route('product.create')}}" class="btn btn-primary"><i class="far fa-plus-square mr-1"></i> Add Product</a>
      </div>
    </div>
    <div class="table-responsive">
      <table id="products-data-table" class="table">
        <thead>
          <tr class="text-center">
            <th>No</th>
            <th>Product Name </th>
            <th>Brand</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Color</th>
            <th>Description</th>
            <th>Created at</th>
            <th ></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data->products as $product)
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td style="white-space: wrap !important; ">
                <a href="{{ route('product.inspect', $product->id) }}">
                  {{$product->product_name}}
                </a>
              </td>
              <td>{{ $product->brand }}</td>
              <td>{{ $product->product_category }}</td>
              <td class="text-center">{{ $product->unit }}</td>
              @php
                $colors_data = explode(";", $product->color)
              @endphp
              <td class="text-center">
                @foreach ($colors_data as $color)
                  <span class="color_box mr-2" data-toggle="tooltip" data-placement="bottom" title="{{ ucwords($color) }}" style="background:{{str_replace(' ', '', ucwords($color))}};"></span>
                @endforeach
              </td>
              <td>
                <?php echo substr($product->description, 0, 20) . '...' ?>
              </td>
              <td class="text-center">{{ $product->created_at }}</td>
              <td style="white-space: nowrap !important; ">
                <a href="{{route('product.edit', ['id' => $product->id]) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>

                <meta name="csrf-token" content="{{ csrf_token() }}"/>
                <button type="button" class="btn btn-sm btn-danger btn-delete" id="" data-id="{{$product->id}}"><i class="far fa-trash-alt"></i></button>
                {{-- <form class="d-inline-block" action="{{route('product.delete', $product->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="far fa-trash-alt"></i></button>
                </form> --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@section('extend_script')
<!-- page js -->
<script src="{{ asset('vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/datatables/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript">
  // TODO : Perlu diganti dari Categories jadi Product
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var _search = $('#products-search').val();
      var _dataName = data[1]; // use data for the age column
      var _dataBrand = data[2]; // use data for the age column
      var _dataCategory = data[3]; // use data for the age column
      if (
        _dataName.toLowerCase().includes(_search.toLowerCase()) ||
        _dataBrand.toLowerCase().includes(_search.toLowerCase()) ||
        _dataCategory.toLowerCase().includes(_search.toLowerCase())
      )
        {
        // console.log([_search, _dataName, _dataBrand, _dataCategory]);
          return true;
        }
      return false;
    }
  );

  $(document).ready(function() {
    var products_table = $('#products-data-table').DataTable({
      "columns": [{
          'searchable': false,
          'orderable': true,
        },
        {
          'searchable': true,
          'orderable': true,
        },
        {
          'searchable': true,
          'orderable': true,
        },
        {
          'searchable': true,
          'orderable': true,
        },
        {
          'searchable': false,
          'orderable': false,
        },
        {
          'searchable': false,
          'orderable': false,
        },
        {
          'searchable': false,
          'orderable': false,
        },
        {
          'searchable': false,
          'orderable': false,
        },
        {
          'searchable': false,
          'orderable': false,
        },
      ],
      lengthChange: false,
      // searching : false
    });
    $('#products-data-table_wrapper').children().first().remove();

    $('#products-search').keyup(function() {
      products_table.search($(this).val()).draw();
    });
    $('.btn-delete').click(function() {
      swal({
          title: "Anda yakin ingin menghapus data ini?",
          text: "Setelah dihapus, data tidak dapat dikembalikan!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
              url: "/manage/product/delete/" + id,
              type: 'DELETE',
              data: {
                "id": id,
                "_token": token,
              },
              success: function() {
                swal("Data berhasil dihapus!", {
                  icon: "success",
                });
                setTimeout(function() {
                  top.location.href = '';
                }, 1000);
              }
            });
          } else {
            swal("Penghapusan batal!");
          }
        });
    });
  });
</script>
@endsection
