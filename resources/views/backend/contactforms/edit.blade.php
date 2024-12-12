@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="pagetitle">
<h1>News</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">News</a></li>
  <li class="breadcrumb-item active">Edit News</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit News</h5>

          <form class="row g-3" action="{{ route('admin.news.update', [$news->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-6">
              <label for="inputAddress" class="form-label">Category</label>
              <select name="cat_id" id="category" class="form-select">
                <option selected>--Select Category--</option>
                @foreach($categories as $category)
                <option value="{{$category->id ?? ''}}" {{ (isset($news) && $news->cat_id ? $news->cat_id : old('cat_id')) == $category->id ? 'selected' : '' }}>{{$category->name ?? ''}}</option>
                @endforeach
                <!-- <option value="First Team" {{ (isset($news) && $news->category ? $news->category : old('category')) == 'First Team' ? 'selected' : '' }}>First Team</option>
                <option value="Academy" {{ (isset($news) && $news->category ? $news->category : old('category')) == 'Academy' ? 'selected' : '' }}>Academy</option>
                <option value="Other Sports" {{ (isset($news) && $news->category ? $news->category : old('category')) == 'Other Sports' ? 'selected' : '' }}>Other Sports</option>
                <option value="Community Activities" {{ (isset($news) && $news->category ? $news->category : old('category')) == 'Community Activities' ? 'selected' : '' }}>Community Activities</option> -->
              </select>
            </div>
            <div class="col-md-6">
              <label for="inputAddress" class="form-label">Sub Category</label>
              <select name="sub_catid" id="subcategory" class="form-select">
                <option value="" selected>--Select Sub Category--</option>
                @foreach($subcategories as $subcategory)
                <option value="{{$subcategory->id ?? ''}}" {{ (isset($news) && $news->sub_catid ? $news->sub_catid : old('sub_catid')) == $subcategory->id ? 'selected' : '' }}>{{$subcategory->name ?? ''}}</option>
                @endforeach
              </select>
              <!-- <input type="text" name="sub_category" class="form-control" placeholder="1234 Main St" value="{{ old('sub_category', isset($news) ? $news->sub_category : '') }}"> -->
            </div>
            <!-- <div class="col-sm-6">
              <label class="form-label">SubCategory Image / Icon</label>
              <input type="hidden" name="subcatphoto" value="{{$news->subcatphoto ?? ''}}">
              <input type="file" name="subcatimages" class="form-control" id="formFile">
              @if($news->subcatphoto)
              <a href="{{URL::asset('upload/images/'.$news->subcatphoto)}}" target="_blank" class="pc">View</a>
              @endif
            </div> -->
            <div class="col-md-6">
              <label for="inputNanme4" class="form-label">Title</label>
              <input type="text" name="title" class="form-control" value="{{ old('title', isset($news) ? $news->title : '') }}" required>
            </div>
            <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Author</label>
              <input type="text" name="author" class="form-control" value="{{ old('author', isset($news) ? $news->author : '') }}">
            </div>
            <div class="col-md-6">
              <label for="inputPassword4" class="form-label">Date</label>
              <input type="date" name="date" class="form-control" value="{{ old('date', isset($news) ? $news->date : '') }}">
            </div>
            <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Image Caption</label>
              <input type="text" name="img_caption" class="form-control" value="{{ old('img_caption', isset($news) ? $news->img_caption : '') }}">
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Image</label>
              <div class="needsclick dropzone" id="photos-dropzone">

              </div>
            </div>
            <div class="col-md-12">
              <label for="inputPassword4" class="form-label">Short Description</label>
              <textarea name="short_desc" class="form-control" style="height: 100px">{{ old('short_desc', isset($news) ? $news->short_desc : '') }}</textarea>
            </div>
            <div class="col-md-12">
              <label for="inputAddress" class="form-label">Description</label>
              <!-- TinyMCE Editor -->
              <textarea name="desc" class="tinymce-editor">{{ old('desc', isset($news) ? $news->desc : '') }}</textarea>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.4/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $('#category').on('change',function(e){
          console.log(e);
          var cat_id = e.target.value;
          //console.log(cat_id);
          //ajax
          $.get('/ajax-subcat?cat_id='+ cat_id,function(data){
              //success data
             //console.log(data);
              var subcat =  $('#subcategory').empty();
              $.each(data,function(create,subcatObj){
                  var option = $('<option/>', {id:create, value:subcatObj});
                  subcat.append('<option value ="'+subcatObj.id+'">'+subcatObj.name+'</option>');
              });
          });
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
        {!! json_encode($news->photos) !!}
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