@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="pagetitle">
<h1>Videography</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Videography</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Video</h5>

          <form class="row g-3" action="{{ route('admin.videos.update', [$video->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <input type="hidden" name="id" value="{{$video->id}}">
              <div class="col-md-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="title" value="{{ $video->title }}" class="form-control" required>
              </div>
              <div class="col-md-12">
                  <input type="file" name="video" accept="video/*">
                  <div>&nbsp;</div>
                  <div>&nbsp;</div>
                  @if($video->video != null)
                  <div>
                      <video width="320" height="240" controls>
                          <source src="{{ $video->video }}" type="{{ $video->mime_type }}">
                          Your browser does not support the video tag.
                      </video>
                      
                  </div>
                  @endif
              </div>

              <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
              </div>
          </form>


        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script type="text/javascript">

    var uploadedPhotosMap = {}
    Dropzone.options.photosDropzone = {
    url: '{{ route('admin.videos.storeMedia') }}',
    maxFilesize: 200, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif,.webp',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
      uploadedPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPhotosMap[file.name]
      }
      $('form').find('input[name="photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
      var files =
        {!! json_encode($video->photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.original_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="photos[]" value="' + file.file_name + '">')
        }
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
    }


    function deleteVideo(videoId) {
        if (confirm('Are you sure you want to delete this video?')) {
            $.ajax({
                url: '{{ route('admin.videos.ajaxDelete', ['id' => '__videoId__']) }}'.replace('__videoId__', videoId),
                type: 'DELETE',
                data:{
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Optionally, you can remove the deleted video from the view
                    alert(response.message);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error deleting video. Please try again.');
                }
            });
        }
    }

    $(".addmore_customer").click(function(){

        //$("#vendorDiv").clone().insertAfter("div.vendorDiv:last");
    
        $block = $("#customerDiv").clone();
        $(".listaddons", $block).remove();
        $(".btn-addmore", $block).html('<span class="addcnt"><img src="/backend/assets/img/delete.png" width="24px"> Remove</span>');
        $(".btn-addmore", $block).addClass('remove_customer').removeClass('addmore_customer');
        //block.children(".addmore_vendor").text("REMOVE");
        $block.find("input").val("");
        $block.find("textarea").val("");
        $block.find(".about_package").val("");
        $block.insertAfter("div.customerDiv:last");
        
    });


    $("body").on("click",".remove_customer",function(e){
      
      $(this).parents('.customerDiv').remove();

      var id = $(this).data("id");
      var token = $("meta[name='csrf-token']").attr("content");
   

    });

</script>

@endsection