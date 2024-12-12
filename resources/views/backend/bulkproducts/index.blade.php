@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')
@if(count($products) > 0)
<div class="pagetitle">
<h1>Bulk Products</h1>

</div>
<!-- <div class="text-right d-flex">
<button type="button" class="btn btn-sm btn-primary" onclick="$('#file-upload-modal').modal('show'); $('#student-id').val({{ $products[0]->student->id }}); $('#school-id').val({{ $products[0]->student->school->id }});"> Add Product</button>
</div> -->
@endif
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Products List</h5>
          <!-- <button id="delete-selected" class="btn btn-danger">Delete Selected</button> -->
          <div id="loader" style="display:none;"><img src="/backend/assets/img/loading.png"></div>

          <table class="table table-hover table-bordered table-striped" id="table">
            <thead>
              <tr>
                <th scope="col"><input type="checkbox" id="check-all"></th>
                <th scope="col"># </th>
                <th scope="col">Title </th>
                <th scope="col">Hard Copy Amount</th>
                <th scope="col">Addon (Digital) Title</th>
                <th scope="col">Digital Amount</th>
                <th scope="col">Image</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @if(count($products) > 0)
              @foreach($products as $key => $product)
              <tr data-entry-id="{{ $product->id }}">
                <td><input type="checkbox" name="product[]" class="check-item" value="{{ $product->id }}"></td>
                <th scope="row">{{ ($key+1) ?? '' }}</th>
                <td>{{ $product->title ?? '' }}</td>
                <td>{{ $product->hard_copy_amount ?? '' }}</td>
                <td>{{ $product->digital_title ?? '' }}</td>
                <td>{{ $product->digital_amount ?? '' }}</td>
                <td><img src="{{$product->getFirstMediaUrl('photos','thumb') ?? ''}}" /></td>
                <td>
                  <a class="btn btn-sm btn-info" href="{{ url('admin/bulkproducts/edit/'.$product->id) }}">
                      Edit
                  </a>
                  <a class="btn btn-sm btn-danger" href="{{ url('admin/bulkproducts/delete/'.$product->id) }}" id="delete" >Delete</a>
                  <a class="btn btn-sm btn-info" href="{{ url('admin/bulkproductsstudents/'.$product->id) }}">
                      View Students
                  </a>
                  <!-- <form action="{{ url('admin/bulkproducts/delete/'.$product->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                  </form> -->
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
                    <!-- End Table with hoverable rows -->

        </div>
      </div>
    </div>

  </div>
</section>
<div class="modal fade" id="file-upload-modal" tabindex="-1" aria-labelledby="file-upload-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="file-upload-modal-label">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="school_id" id="school-id">
          <input type="hidden" name="student_id" id="student-id">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">

                    <div class="col-md-12">
                      <label for="inputNanme4" class="form-label">Title</label>
                      <input type="text" name="title" class="form-control">
                    </div>
                    <div class="col-md-4">
                      <label for="inputEmail4" class="form-label">Hard Copy Amount</label>
                      <input type="number" name="hard_copy_amount" class="form-control">
                    </div>
                    <div class="col-md-12">
                      <label for="inputNanme4" class="form-label">Addon (Digital) Title</label>
                      <input type="text" name="digital_title" class="form-control">
                    </div>
                    <div class="col-md-4">
                      <label for="inputPassword4" class="form-label">Addon (Digital) Amount</label>
                      <input type="number" name="digital_amount" class="form-control">
                    </div>
                    <div class="col-md-12">
                      <label for="inputEmail4" class="form-label">Image</label>
                      <div class="needsclick dropzone" id="photos-dropzone">

                      </div>
                    </div>
                    <div class="col-md-12">
                      <label for="inputAddress" class="form-label">Description</label>
                      <!-- TinyMCE Editor -->
                      <textarea name="desc" class="tinymce-editor"></textarea>
                    </div>


                </div>
              </div>
            </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
    </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.4/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script>  
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var dataTable;
  var basePath ="{{url('/')}}";
  $(document).ready(function() {
    dataTable = $('#table').on('processing.dt', function (e, settings, processing) {
        $('#loader').toggle(processing);
    }).DataTable({
      processing: true,
      pageLength: 15,
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print', 'delete'
      ],
      initComplete: function() {
            $('#loader').hide();
        },
        drawCallback: function() {
            $('#loader').hide();
        },
        preDrawCallback: function() {
            $('#loader').show();
        }
    });

    $('#check-all').click(function() {
        $('.check-item').prop('checked', $(this).prop('checked'));
    });

    $('#delete-selected').click(function() {
        var ids = [];
        $('.check-item:checked').each(function() {
            ids.push($(this).val());
        });
        if(ids.length > 0) {
          Swal.fire({
             title: 'Are you sure?',
             text: "Are you sure you want to destroy the selected rows permanently?",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.products.massdelete") }}',
                    type: 'DELETE',
                    data: {ids: ids},
                    success: function(response) {
                        Swal.fire(
                           'Deleted!',
                           'Selected records have been deleted.',
                           'success'
                         )
                        window.location.reload();
                    }
                });
               
             }
          }) 

          /*if(confirm("Are you sure you want to destroy the selected rows permanently?")) {
            $.ajax({
                url: '{{ route("admin.products.massdelete") }}',
                type: 'DELETE',
                data: {ids: ids},
                success: function(response) {
                    alert('Selected records have been deleted.');
                    window.location.reload();
                }
            });
          }*/
        }else {
            //alert("Please select at least one row.");
          Swal.fire(
             'Message!',
             'Please select at least one row.',
             'warning'
           )
        }
    });

  });



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
    maxFiles: 20,
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
          this.options.thumbnail.call(this, file, file.original_url)
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