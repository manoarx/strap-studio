@extends('layouts.backend')

@section('styles')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="pagetitle">
<h1>Products</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.students.index',['schoolid' => $product->student->school_id]) }}">Students</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.products.index',['studentid' => $product->student_id]) }}">Products</a></li>
  <li class="breadcrumb-item active">Edit Products</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Products</h5>

          <form class="row g-3" action="{{ route('admin.products.update', [$product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="student_id" value="{{$product->student_id ?? ''}}">
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Title</label>
              <input type="text" name="title" class="form-control" value="{{ old('title', isset($product) ? $product->title : '') }}">
            </div>
            <div class="col-md-4">
              <label for="inputEmail4" class="form-label">Hard Copy Amount</label>
              <input type="number" name="hard_copy_amount" class="form-control" value="{{ old('hard_copy_amount', isset($product) ? $product->hard_copy_amount : '') }}">
            </div>
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Addon (Digital) Title</label>
              <input type="text" name="digital_title" class="form-control" value="{{ old('digital_title', isset($product) ? $product->digital_title : '') }}">
            </div>
            <div class="col-md-4">
              <label for="inputPassword4" class="form-label">Addon (Digital) Amount</label>
              <input type="number" name="digital_amount" class="form-control" value="{{ old('digital_amount', isset($product) ? $product->digital_amount : '') }}">
            </div>
            <div class="col-md-12">
              <label for="inputAddress" class="form-label">Description</label>
              <!-- TinyMCE Editor -->
              <textarea name="desc" class="tinymce-editor">{!! old('desc', isset($product) ? $product->desc : '') !!}</textarea>
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Image</label>
              <div class="needsclick dropzone" id="photos-dropzone">

              </div>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.4/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script type="text/javascript">
    tinymce.init({
      selector: 'textarea.tinymce-editor',
      height: 250,
      menubar: true,
      plugins: [
          'advlist autolink lists link charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime image media table paste code wordcount'
      ],
      toolbar: 'undo redo | fontfamily fontsize blocks | formatselect | ' +
          'bold italic underline strikethrough backcolor | alignleft aligncenter ' +
          'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ' +
          'removeformat | insertfile image media template link anchor codesample | ltr rtl',
      content_css: '//cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.4/skins/lightgray/content.inline.min.css',
      templates: [{
        title: 'New Table',
        description: 'creates a new table',
        content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
      },
      {
        title: 'Starting my story',
        description: 'A cure for writers block',
        content: 'Once upon a time...'
      },
      {
        title: 'New list with dates',
        description: 'New List with dates',
        content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
      }],
      template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
      template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
    });


    var uploadedPhotosMap = {}
    Dropzone.options.photosDropzone = {
    url: '{{ route('admin.products.storeMedia') }}',
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
        {!! json_encode($product->photos) !!}
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

</script>

@endsection