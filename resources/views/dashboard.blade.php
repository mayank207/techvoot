@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="product-tab" data-toggle="tab" data-target="#product" type="button" role="tab" aria-controls="home" aria-selected="true">Products</button>
                </li>
                @if(Auth::user()->is_admin == 1)
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="brand-tab" data-toggle="tab" data-target="#brand" type="button" role="tab" aria-controls="profile" aria-selected="false">Brands</button>
                </li>
                @endif
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
                    <table class="table" id="dataTableProducts">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade" id="brand" role="tabpanel" aria-labelledby="brand-tab">
                    <table class="table" id="dataTableBrands">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
              </div>
            <!-- Brand Modal -->
            <div class="modal fade" id="editbrandModal" tabindex="-1" role="dialog" aria-labelledby="brandModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="brandModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="editbrandform" method="POST">
                            <input type="hidden" name="brandid" id="brandid" value="">
                            <input type="text" class="form-control" name="editbrandname" id="editbrandname" placeholder="Enter Name">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                    {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
                </div>
            </div>


            <!-- Brand Modal -->
            <div class="modal fade" id="editproductModal" tabindex="-1" role="dialog" aria-labelledby="brandModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="brandModalLabel">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="editproductform"  method="POST">
                            <input type="hidden" name="productid" id="productid" value="">
                            <input type="text" class="form-control" name="editproductname" id="editproductname" placeholder="Enter Name">
                            <input type="text" class="form-control" name="editproductprice" id="editproductprice" placeholder="Enter Price">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
@section('external-scripts')
<script>
    // $(function () {
        // $('#contact-tab').tab('show');
    // });



    $(document).ready(function () {


  var _token = $("meta[name='_token']").attr('content');
  var _base_url = $("meta[name='_base_url']").attr('content');
  var product_controller_url="{{route('products.index')}}";
  var brand_controller_url="{{route('brands.index')}}";

  var editproduct_controller_url="{{route('products.edit')}}";
  var editbrand_controller_url="{{route('brands.edit')}}";

  var updateproduct_controller_url="{{route('products.update')}}";
  var updatebrand_controller_url="{{route('brands.update')}}";

  var deleteproduct_controller_url="{{route('products.delete')}}";
  var deleteebrand_controller_url="{{route('brands.delete')}}";

  displayProduct();

    function displayProduct(){
        // $('#dataTableProducts').destroy();
        $('#dataTableProducts').DataTable({
            destroy:true,
            "columns": [
                {data: 'id', name: 'id' },
                {data: 'name', name: 'name' },
                {data: 'price', name: 'price' },
                {data: "action", "name": "action", "className": "text-center"}
            ],
            "processing": true,
            "responsive": true,
            'language': {
                'loadingRecords': '&nbsp;',
                "emptyTable": "No Records Found...",
                'processing': '<div id="loader-div"><div id="loader"></div></div>'
            },
            "iDisplayLength": 10,
            "serverSide": true,
            "ajax": {
                url: product_controller_url,

                dataType: "json",
            },
            "order": [[0, "desc"]], //Set Default Column Tobe Sorted
            "columnDefs": [
                {
                    "targets": [0],
                    "searchable": false,
                    "visible": false
                },
            //   {
            //       "targets": [1],
            //       "searchable": false,
            //       "bSortable": false
            //   },
            //   {
            //       "targets": [2],
            //       "searchable": true,
            //       "bSortable": true
            //   },
            //   {
            //       "targets": [3],
            //       "searchable": false,
            //       "bSortable": false
            //   },
            ],
            "scrollCollapse": true,
            "paging": true
        });
    }
    function displayBrand(){
        // $('#dataTableBrands').destroy();
        $('#dataTableBrands').DataTable({
            destroy:true,
            "columns": [
                {data: 'id', name: 'id' },
                {data: 'name', name: 'name' },
                {data: "action", "name": "action", "className": "text-center"}
            ],
            "processing": true,
            "responsive": true,
            'language': {
                'loadingRecords': '&nbsp;',
                "emptyTable": "No Records Found...",
                'processing': '<div id="loader-div"><div id="loader"></div></div>'
            },
            "iDisplayLength": 10,
            "serverSide": true,
            "ajax": {
                url: brand_controller_url,

                dataType: "json",
            },
            "order": [[0, "desc"]], //Set Default Column Tobe Sorted
            "columnDefs": [
                {
                    "targets": [0],
                    "searchable": false,
                    "visible": false
                },
            //   {
            //       "targets": [1],
            //       "searchable": false,
            //       "bSortable": false
            //   },
            //   {
            //       "targets": [2],
            //       "searchable": true,
            //       "bSortable": true
            //   },
            //   {
            //       "targets": [3],
            //       "searchable": false,
            //       "bSortable": false
            //   },



            ],

            //"scrollY": "800px",
            "scrollCollapse": true,
            "paging": true
        });
    }

    $('.nav-tabs #product-tab').on('show.bs.tab', function(){
        displayProduct();
    });

    $('.nav-tabs #brand-tab').on('show.bs.tab', function(){
        displayBrand();
    });

    $(document).on('click','#editproduct',function (e) {
        e.preventDefault();
        $('#editproductModal').modal('show');
        var id=$(this).attr('data-id');
        $.ajax({
            url : editproduct_controller_url+'/'+id,
            method : 'get',
            success:function(data){
                if(data.success){
                    $('#productid').val(data.data.id);
                    $('#editproductname').val(data.data.name);
                    $('#editproductprice').val(data.data.price);
                }
            }
        });
    });

    $(document).on('click','#editbrand',function (e) {
        e.preventDefault();
        $('#editbrandModal').modal('show');
        var id=$(this).attr('data-id');
        $.ajax({
            url : editbrand_controller_url+'/'+id,
            method : 'get',
            success:function(data){
                if(data.success){
                    $('#brandid').val(data.data.id);
                    $('#editbrandname').val(data.data.name);
                }
            }
        });
    });

    // Update submit product form
    $(document).on('submit','#editproductform',function (e) {
        e.preventDefault();
        $.ajax({
            url:updateproduct_controller_url,
            method:'post',
            data:$('#editproductform').serialize(),
            success:function(data){
                if(data.success){
                    $('#dataTableProducts').DataTable().draw();
                    $('#editproductModal').modal('hide');
                    toastr.success(data.data.message);
                }
            }
        });
    });


    // Update submit brand form
    $(document).on('submit','#editbrandform',function (e) {
        e.preventDefault();
        $.ajax({
            url:updatebrand_controller_url,
            method:'post',
            data:$('#editbrandform').serialize(),
            success:function(data){
                if(data.success){
                    $('#dataTableBrands').DataTable().draw();
                    $('#editbrandModal').modal('hide');
                    toastr.success(data.data.message);
                }
            }
        });
    });


  $('.fileinput .remove').on('click', function () {
      $(this).closest('.fileinput').fileinput('clear');
  });

//   $.ajaxSetup({
//       headers: {
//           'X-CSRF-TOKEN': $("meta[name='_token']").attr('content')
//       }
//   });


// Delete Brand
  $(document).on('click', '#deletebrand', function () {
    var id=$(this).attr('data-id');
    $.ajax({
        url:deletebrand_controller_url,
        method:'post',
        data:{id:id},
        success:function(data){
            toastr.success(data.message);
        }
      });
  });

// Delete Product
$(document).on('click', '#deleteproduct', function () {
  var id=$(this).attr('data-id');
  $.ajax({
      url:deleteproduct_controller_url,
      method:'post',
      data:{id:id},
      success:function(data){
          toastr.success(data.message);
      }
    });
});



});


</script>
@endsection
