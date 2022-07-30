@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="product-tab" data-toggle="tab" data-target="#product"
                            type="button" role="tab" aria-controls="home" aria-selected="true">Products</button>
                    </li>
                    @if (Auth::user()->is_admin == 1)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="brand-tab" data-toggle="tab" data-target="#brand" type="button"
                                role="tab" aria-controls="profile" aria-selected="false">Brands</button>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="myTabContent">
                    {{-- products List Tab --}}
                    <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
                        <button class="btn btn-primary" data-target="#addproductModal" data-toggle="modal">
                            Add Product
                        </button>
                        <table class="table" id="dataTableProducts">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Brand name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    {{-- End products List Tab --}}

                    {{-- Brands List Tab --}}
                    <div class="tab-pane fade" id="brand" role="tabpanel" aria-labelledby="brand-tab">
                        <button class="btn btn-primary" data-target="#addbrandModal" data-toggle="modal">
                            Add Brand
                        </button>
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
                    {{--End Brands List Tab --}}
                </div>

                <!-- edit Brand Modal -->
                <div class="modal fade" id="editbrandModal" tabindex="-1" role="dialog" aria-labelledby="brandModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="brandModalLabel">Edit Brand</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" id="editbrandform" method="POST">
                                    <input type="hidden" name="brandid" id="brandid" value="">
                                    <input type="text" class="form-control" name="editbrandname" id="editbrandname"
                                        placeholder="Enter Name">
                                        <br>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Edit Brand Modal -->

                <!-- Add Brand Modal -->
                <div class="modal fade" id="addbrandModal" tabindex="-1" role="dialog"
                    aria-labelledby="addbrandModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addbrandModalLabel">Add Brand</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" id="addbrandform" method="POST">
                                    <input type="text" class="form-control" name="addbrandname" id="addbrandname"
                                        placeholder="Enter Name">
                                        <br>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Add Brand Modal -->

                <!--Add product Modal -->
                <div class="modal fade" id="addproductModal" tabindex="-1" role="dialog"
                    aria-labelledby="productModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel">Add Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" id="addproductform" method="POST" enc type="multipart/form-data">

                                    <p class="mt-2">Name: </p>
                                    <input type="text" class="form-control" name="addproductname" id="addproductname"
                                        placeholder="Enter Name">

                                    <p class="mt-2">price: </p>
                                    <input type="text" class="form-control mt-0" name="addproductprice"
                                        id="addproductprice" placeholder="Enter Price">

                                    <p class="mt-2">Brand: </p>
                                    <select class="form-control" name="add_brand" id="add_brand">
                                        @foreach ($brands as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    {{-- <p class="mt-2">Image: </p>
                                    <input type="file" class="form-control" id="add_image" name="add_image[]" multiple> --}}
                                    <br><br>

                                    <button type="submit" class="btn btn-primary mt-2">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End add product modal --}}

                <!--edit product Modal -->
                <div class="modal fade" id="editproductModal" tabindex="-1" role="dialog"
                    aria-labelledby="brandModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="brandModalLabel">Edit Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" id="editproductform" method="POST" enc type="multipart/form-data">
                                    <input type="hidden" name="productid" id="productid" value="">

                                    <p class="mt-2">Name: </p>
                                    <input type="text" class="form-control" name="editproductname"
                                        id="editproductname" placeholder="Enter Name">

                                    <p class="mt-2">Price: </p>
                                    <input type="text" class="form-control" name="editproductprice"
                                        id="editproductprice" placeholder="Enter Price">

                                    <p class="mt-2">Brand: </p>
                                    <select name="edit_brand" class="form-control" id="edit_brand">
                                        @foreach ($brands as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    {{-- <label class="mt-2">Image: </label>
                                    <input type="file" id="image" name="image[]" multiple> --}}
                                    <br><br>

                                    <button type="submit" class="btn btn-primary mt-2">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End edit product modal --}}


            </div>
        </div>
    </div>
@endsection
@section('external-scripts')
    <script>
        $(document).ready(function() {

            //Declare the variables for the call routes
            var _token = $("meta[name='_token']").attr('content');
            var _base_url = $("meta[name='_base_url']").attr('content');
            var product_controller_url = "{{ route('products.index') }}";
            var brand_controller_url = "{{ route('brands.index') }}";

            var editproduct_controller_url = "{{ route('products.edit') }}";
            var editbrand_controller_url = "{{ route('brands.edit') }}";

            var updateproduct_controller_url = "{{ route('products.update') }}";
            var updatebrand_controller_url = "{{ route('brands.update') }}";

            var deleteproduct_controller_url = "{{ route('products.delete') }}";
            var deleteebrand_controller_url = "{{ route('brands.delete') }}";

            var addproduct_controller_url = "{{ route('products.store') }}";
            var addbrand_controller_url = "{{ route('brands.store') }}";
            //end Declare the variables for the call routes

            displayProduct();

             //Display products yajra datatable js
            function displayProduct() {
                $('#dataTableProducts').DataTable({
                    destroy: true,
                    "columns": [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'brand.name',
                        },
                        {
                            data: "action",
                            "name": "action",
                            "className": "text-center"
                        }
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
                    "order": [
                        [0, "desc"]
                    ], //Set Default Column Tobe Sorted
                    "columnDefs": [{
                            "targets": [0],
                            "searchable": false,
                            "visible": false
                        },
                        {
                            "targets": [4],
                            "searchable": false,
                            "sortable": false
                        },
                    ],
                    "scrollCollapse": true,
                    "paging": true
                });
            }
             //Display products yajra datatable js

            //Display brands yajra datatable js
            function displayBrand() {
                $('#dataTableBrands').DataTable({
                    destroy: true,
                    "columns": [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: "action",
                            "name": "action",
                            "className": "text-center"
                        }
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
                    "order": [
                        [0, "desc"]
                    ], //Set Default Column Tobe Sorted
                    "columnDefs": [{
                            "targets": [0],
                            "searchable": false,
                            "visible": false
                        },
                        {
                            "targets": [2],
                            "searchable": false,
                            "sortable": false
                        },
                    ],

                    "scrollCollapse": true,
                    "paging": true
                });
            }
            // end Display brands yajra datatable js

            $('.nav-tabs #product-tab').on('show.bs.tab', function() {
                displayProduct();
            });

            $('.nav-tabs #brand-tab').on('show.bs.tab', function() {
                displayBrand();
            });

            // open the edit product modal
            $(document).on('click', '#editproduct', function(e) {
                e.preventDefault();
                $('#editproductModal').modal('show');
                var id = $(this).attr('data-id');
                $.ajax({
                    url: editproduct_controller_url + '/' + id,
                    method: 'get',
                    success: function(data) {
                        if (data.success) {
                            $('#productid').val(data.data.id);
                            $('#editproductname').val(data.data.name);
                            $('#editproductprice').val(data.data.price);
                            $('#edit_brand option[value=' + data.data.brand_id + ']').attr(
                                'selected', true);
                        }
                    }
                });
            });
            // end open the edit product modal

            // open the edit brand modal
            $(document).on('click', '#editbrand', function(e) {
                e.preventDefault();
                $('#editbrandModal').modal('show');
                var id = $(this).attr('data-id');
                $.ajax({
                    url: editbrand_controller_url + '/' + id,
                    method: 'get',
                    success: function(data) {
                        if (data.success) {
                            $('#brandid').val(data.data.id);
                            $('#editbrandname').val(data.data.name);
                        }
                    }
                });
            });
            // end open the edit brand modal

            // edit product modal ajax & validation
            $("#editproductform").validate({
                rules: {
                    editproductname: {
                        required: true,
                    },
                    editproductprice: {
                        required: true,
                    },
                    edit_brand: {
                        required: true,
                    },
                    // 'images[]': {
                    //     required: true,
                    // }
                },
                messages: {
                    editproductname: {
                        required: "Please add product name",
                    },
                    editproductprice: {
                        required: "Please add procut price",
                    },
                    edit_brand: {
                        required: "Please choose any brand",
                    },
                    // 'image[]': {
                    //     required: "Please upload the image(s)",
                    // }
                },

                submitHandler: function(form, e) {
                    // Update submit product form ajax
                    e.preventDefault();
                    // var formData = new FormData(form);
                    // let TotalFiles = $('#image')[0].files.length; //Total files
                    // let files = $('#image')[0];
                    // for (let i = 0; i < TotalFiles; i++) {
                    //     formData.append('image' + i, files.files[i]);
                    // }
                    // console.log(formData);
                    $.ajax({
                        url: updateproduct_controller_url,
                        method: 'post',
                        data: $('#editproductform').serialize(),
                        success: function(data) {
                            if (data.success) {
                                $('#dataTableProducts').DataTable().draw();
                                $('#editproductModal').modal('hide');
                                toastr.success(data.message);
                            }
                        }
                    });
                }
            });
            // end edit product modal ajax & validation

             // Add product modal ajax & validation
            $("#addproductform").validate({
                rules: {
                    addproductname: {
                        required: true,
                    },
                    addproductprice: {
                        required: true,
                        digits: true,
                    },
                    add_brand: {
                        required: true,
                    },
                    // 'add_images[]': {
                    //     required: true,
                    // }
                },
                messages: {
                    addproductname: {
                        required: "Please add product name",
                    },
                    addproductprice: {
                        required: "Please add procut price",
                        digits: "Please enter valid value",
                    },
                    add_brand: {
                        required: "Please choose any brand",
                    },
                    // 'image[]': {
                    //     required: "Please upload the image(s)",
                    // }
                },

                submitHandler: function(form, e) {
                    // add submit product form
                    e.preventDefault();
                    // var formData = new FormData(form);
                    // let TotalImages = $('#image')[0].files.length; //Total Images
                    // let images = $('#image')[0];
                    // for (let i = 0; i < TotalImages; i++) {
                    //     formData.append('image' + i, images.files[i]);
                    // }
                    // formData.append('TotalImages', TotalImages);
                    // console.log(formData);
                    $.ajax({
                        url: addproduct_controller_url,
                        method: 'post',
                        data: $('#addproductform').serialize(),
                        success: function(data) {
                            if (data.success) {
                                $('#dataTableProducts').DataTable().draw();
                                $(".close").trigger("click");
                                toastr.success(data.message);
                            }
                        }
                    });
                }
            });
            // end edit product modal ajax & validation

            // edit brand modal ajax & validation
            $("#editbrandform").validate({
                rules: {
                    editbrandname: {
                        required: true,
                    },
                },
                messages: {
                    editbrandname: {
                        required: "Please add brand name",
                    },
                },

                submitHandler: function(form, e) {
                    // Update submit brand form
                    e.preventDefault();
                    $.ajax({
                        url: updatebrand_controller_url,
                        method: 'post',
                        data: $('#editbrandform').serialize(),
                        success: function(data) {
                            if (data.success) {
                                $('#dataTableBrands').DataTable().draw();
                                $('#editbrandModal').modal('hide');
                                toastr.success(data.message);
                            }
                        }
                    });

                }
            });
            // end edit brand modal ajax & validation

            // Add brand modal ajax & validation
            $("#addbrandform").validate({
                rules: {
                    addbrandname: {
                        required: true,
                    },
                },
                messages: {
                    addbrandname: {
                        required: "Please enter brand name",
                    },
                },

                submitHandler: function(form, e) {
                    // add submit brand form
                    e.preventDefault();
                    $.ajax({
                        url: addbrand_controller_url,
                        method: 'post',
                        data: $('#addbrandform').serialize(),
                        success: function(data) {
                            if (data.success) {
                                $('#dataTableBrands').DataTable().draw();
                                $(".close").trigger("click");
                                toastr.success(data.message);
                            }
                        }
                    });

                }
            });
            // end Add brand modal ajax & validation


            $('.fileinput .remove').on('click', function() {
                $(this).closest('.fileinput').fileinput('clear');
            });

            // Delete Brand
            $(document).on('click', '#deletebrand', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: deletebrand_controller_url,
                    method: 'post',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        toastr.success(data.message);
                    }
                });
            });
            // end brand delete

            // Delete Product
            $(document).on('click', '#deleteproduct', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: deleteproduct_controller_url,
                    method: 'post',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        toastr.success(data.message);
                    }
                });
            });
            // end Delete Product

            // Close the models
            $(document).on('click', '.close', function close() {
                $('#editproductModal').modal('hide');
                $('#editbrandModal').modal('hide');
            });
            //end close models
        });
    </script>
@endsection
