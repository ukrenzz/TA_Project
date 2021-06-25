@extends('layouts.admin')

@section('page_title', "Categories")

@section('extend_style')
  <!-- page style -->
  <link href="{{ asset('vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb_item')
  <a href="{{ route('admin.dashboard')}}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
  <span class="breadcrumb-item active">Categories</span>
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
              <input type="text" class="form-control" id="categories-name-search" placeholder="Search by name">
          </div>
        </div>

        <div class="col-sm-12 col-md-9 col-lg-9 text-right">
          <a href="{{route('category.create')}}" class="btn btn-primary"><i class="far fa-plus-square mr-1"></i> Add Categories</a>
        </div>
      </div>
      <div class="table-responsive">
        <table id="categories-data-table" class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Category Name</th>
              <th>Description</th>
              <th>Created at</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data->categories_data as $categories_item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $categories_item->name }}</td>
                <td>{{ $categories_item->description }}</td>
                <td>{{ $categories_item->created_at }}</td>
                <td>
                  <a href="{{route('category.edit', ['id' => $categories_item->id]) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>

                  <meta name="csrf-token" content="{{ csrf_token() }}">
                  <button type="button" class="btn btn-sm btn-danger btn-delete" id="" data-id="{{$categories_item->id}}"><i class="far fa-trash-alt"></i></button>
                  {{-- <form class="d-inline-block" action="{{route('category.delete', $categories_item->id) }}" method="post">
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
    $.fn.dataTable.ext.search.push(
      function( settings, data, dataIndex ) {
        var _search = $('#categories-name-search').val();
        var _dataName = data[1]; // use data for the age column
        var _dataDesc = data[2]; // use data for the age column
        console.log([_search, _dataName, _dataDesc]);
        if (_dataName.includes(_search) || _dataDesc.includes(_search))
        {
          return true;
        }
        return false;
      }
    );

    $(document).ready(function() {
      var categories_table = $('#categories-data-table').DataTable({
        "columnDefs": [ {
          "targets": [1, 3],
          'searchable' : true,
          'orderable'  : true,
        } ],
        "columnDefs": [ {
          "targets": 2,
          'searchable' : true,
          'orderable'  : false,
        } ],
        "columns" : [
          {
            'searchable' : false,
            'orderable'  : true,
          },
          {},
          {
            'searchable' : true,
            'orderable'  : false,
          },
          {},
          {
            'searchable' : false,
            'orderable'  : false,
          }
        ],
        lengthChange : false,
        // searching : false
      });
      $('#categories-data-table_wrapper').children().first().remove();

      $('#categories-name-search').keyup( function() {
        categories_table.search( $(this).val() ).draw();
      } );
      $('.btn-delete').click(function(){
        swal({
          title: "Are you sure want to delete this data?",
          text: "Data is lost forever after delete",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax(
              {
                url: "category/delete/"+id,
                type: 'DELETE',
                data: {
                  "id": id,
                  "_token": token,
                },
                success: function (){
                  swal("Delete success!", {
                    icon: "success",
                  });
                  setTimeout(function () {
                      top.location.href = '';
                  }, 1000);
                }
              });
            } else {
              swal("Delete canceled!");
            }
          });
      });
    } );
  </script>
@endsection
