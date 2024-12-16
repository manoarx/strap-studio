@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="pagetitle">
    <h1>Services</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
            <li class="breadcrumb-item active">Edit Services</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Services</h5>

                    <form class="row g-3" action="{{ route('admin.services.update', [$service->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', isset($service) ? $service->title : '') }}" required>
                        </div>
                        <div class="col-md-12">
                            <label for="short_title" class="form-label">Short Title</label>
                            <textarea name="short_title" class="form-control summernote"
                                style="height: 100px">{{ old('short_title', isset($service) ? $service->short_title : '') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Images</label>
                            <div class="needsclick dropzone" id="photos-dropzone">

                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="title" class="form-label">Portfolio Url</label>
                            <input type="text" name="portfolio_url" class="form-control"
                                value="{{ old('portfolio_url', isset($service) ? $service->portfolio_url : '') }}">
                        </div>
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="image" />
                        </div>
                        <div class="col-md-12">
                            <label for="inputPassword4" class="form-label"></label>
                            <img id="showImage" src="{{ asset($service->main_image)   }}" alt="Admin"
                                style="width:100px; height: 100px;">
                        </div>


                        <div class="col-md-12">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" value="{{old('meta_title', $service->meta_title)}}" id="meta_title" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control"
                                style="height: 100px">{{old('meta_description', $service->meta_description)}}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <textarea name="meta_keywords" id="meta_keywords" class="form-control"
                                style="height: 100px">{{old('meta_keywords', $service->meta_keywords)}}</textarea>
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

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $('.summernote').summernote({
        height: 200
    });
  });

    var uploadedPhotosMap = {}
    Dropzone.options.photosDropzone = {
    url: '{{ route('admin.services.storeMedia') }}',
    maxFilesize: 20, // MB
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
        {!! json_encode($service->photos) !!}
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

    $(document).ready(function(){
      $('#image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
          $('#showImage').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
      });
    });
</script>

@endsection
