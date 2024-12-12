@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="pagetitle">
<h1>Portfolios</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.portfolios.index') }}">Portfolios</a></li>
  <li class="breadcrumb-item active">Edit Portfolios</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Portfolios</h5>

          <form class="row g-3" action="{{ route('admin.portfolios.update', [$portfolio->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Name</label>
              <input type="text" name="name" class="form-control" value="{{ old('name', isset($portfolio) ? $portfolio->name : '') }}" required>
            </div>
            <!-- <div class="form-group col-md-12">
              <label for="type" class="form-label">Type</label>
              <select name="type" class="form-select mb-3" aria-label="Default select example" required disabled>
              <option selected="">Select Type</option>
              <option value="image" {{ $portfolio->type == 'image' ? 'selected' : '' }}>Image</option>
              <option value="video" {{ $portfolio->type == 'video' ? 'selected' : '' }}>Video</option>
              </select>
            </div> -->
            <input type="hidden" name="type" value="image">
            @if($portfolio->type == 'image')
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Image</label>
              <div class="needsclick dropzone" id="photos-dropzone">

              </div>
            </div>
            @else
              @php
              $id = $portfolio->id;
              $portfolioVideos=App\Models\PortfolioVideos::where('portfolio_id',$id)->get();
              @endphp
              <input type="hidden" name="portfolio_id" value="{{$portfolio->id ?? ''}}">
              @if(count($portfolioVideos) > 0)
              @foreach($portfolioVideos as $key => $portfolioVideo)
              <div class="row customerDiv" id="customerDiv">
                <input type="hidden" name="portfolio_video_id[]" value="{{$portfolioVideo->id ?? ''}}">
                <div class="col-sm-9">
                  <div class="row g-3">
                    <div class="col-sm-12">
                      <label class="form-label">Youtube URL</label>
                      <input type="text" name="youtube_url[]" value="{{$portfolioVideo->youtube_url ?? ''}}" class="form-control">
                    </div>
                    
                  </div>

                </div>

                <div class="col-sm-3">


                   @if($key==0)
                  <a href="javaScript:void(0)" class="addmore_customer btn-addmore"><span class="addcnt"><img src="/backend/assets/img/add.png" width="24px"> Add More</span></a>
                  @else
                  <a href="javaScript:void(0)" data-id="{{ $portfolio->id }}" class="remove_customer btn-addmore"><span class="addcnt"><img src="/backend/assets/img/delete.png" width="24px"> Remove</span></a>
                  @endif
                </div>
                
                <div class="col-md-12">
                    <hr class="grey" />
                </div>
              </div>
              @endforeach
              @else
              <div class="row customerDiv" id="customerDiv">
                <div class="col-sm-9">
                  <div class="row g-3">
                    <div class="col-sm-12">
                      <label class="form-label">Youtube URL</label>
                      <input type="text" name="youtube_url[]" class="form-control">
                    </div>
                    
                  </div>

                </div>

                <div class="col-sm-3">


                  <a href="javaScript:void(0)" class="addmore_customer btn-addmore"><span class="addcnt"><img src="/backend/assets/img/add.png" width="24px"> Add More</span></a>
                </div>
                
                <div class="col-md-12">
                    <hr class="grey" />
                </div>
              </div>
              @endif
            @endif
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
    url: '{{ route('admin.portfolios.storeMedia') }}',
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
        {!! json_encode($portfolio->photos) !!}
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