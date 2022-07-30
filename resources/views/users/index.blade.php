@extends('layouts.main')

@section('content')
<div class="container">
    <a href="{{ route('users.create') }} " class="btn btn-primary">Add User</a>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table id="dataTableUsers">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Action</th>
                    </tr>
            </table>
        </div>
    </div>
</div>

@endsection
@section('external-scripts')
<script>
    
  var user_controller_url="{{route('users.lists')}}";
$('#dataTableUsers').DataTable({
            destroy:true,
            "columns": [
                {data: 'id', name: 'id' },
                {data: 'name', name: 'name' },
                {data: 'email', name: 'email' },
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
                url: user_controller_url,
        
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
</script>
@endsection