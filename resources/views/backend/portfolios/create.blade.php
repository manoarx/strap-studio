@extends('layouts.backend')

@section('styles')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="pagetitle">
<h1>News</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
  <li class="breadcrumb-item">News</li>
  <li class="breadcrumb-item active">Add News</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">News</h5>

          <form class="row g-3" action="{{ route("admin.news.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6 ui-widget">
              <label for="inputAddress" class="form-label">Category</label>
              <select name="category" class="form-select">
                <option selected>--Select Category--</option>
                <option value="First Team">First Team</option>
                <option value="Academy">Academy</option>
                <option value="Other Sports">Other Sports</option>
                <option value="Community Activities">Community Activities</option>
              </select>
            </div>
            <div class="col-md-6 ui-widget">
              <label for="inputAddress" class="form-label">Sub Category</label>
              <input id="search_text" type="text" name="sub_category" class="form-control" placeholder="Under 18">
            </div>
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Title</label>
              <input type="text" name="title" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Author</label>
              <input type="text" name="author" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="inputPassword4" class="form-label">Date</label>
              <input type="date" name="date" class="form-control">
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Image Caption</label>
              <input type="text" name="img_caption" class="form-control">
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Image</label>
              <div class="needsclick dropzone" id="photos-dropzone">

              </div>
            </div>
            <div class="col-md-12">
              <label for="inputPassword4" class="form-label">Short Description</label>
              <textarea name="short_desc" class="form-control" style="height: 100px"></textarea>
            </div>
            <div class="col-md-12">
              <label for="inputAddress" class="form-label">Description</label>
              <!-- TinyMCE Editor -->
              <textarea name="desc" class="tinymce-editor"></textarea>
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
    $(document).ready(function() {
    src = "{{ route('admin.news.autocomplete') }}";
     $("#search_text").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3,
    });
});

    tinymce.init({
      selector: 'textarea.tinymce-editor',
      height: 500,
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
    url: '{{ route('admin.news.storeMedia') }}',
    maxFiles: 2,
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
      console.log(file)
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
      @if(isset($event) && $event->photos)
      var files =
        {!! json_encode($event->photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="photos[]" value="' + file.file_name + '">')
        }
      @endif
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