<section class="m-xl-4">
     {{ Form::open(['route' => ['product.upload_media',5], 'method' => 'POST','class' => 'dropzone','id'=>'dropzoneForm','files'=>'true']) }}
        <div class="fallback progress-bar progress-bar-primary">
            <span class="progress-text"></span>
            <input name="file" type="file" id="file1" class="hide" />
        </div>
    {{Form::close()}}
    <form action="{{route('product.upload_media',15)}}" method ='POST' id="dropzoneForm" class='dropzone' >
        <div class="fallback progress-bar progress-bar-primary">
            <span class="progress-text"></span>
        </div>
    </form>
    <div class="container" id="load-business-media">
        @include('components.show_media')
    </div>

</section>
<script>
       $("#dropzone").dropzone({
                    maxFiles: 2000,
                    url: "/product/upload-media",
                    headers: {
                        'x-csrf-token': document.head.querySelector('meta[name="csrf-token"]').content,
                    },
                    success: function (file, response) {
                        console.log(response);
                    }
                });
</script>
