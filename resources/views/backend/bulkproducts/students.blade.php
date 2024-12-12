@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

<style type="text/css">

</style>

@endsection

@section('content')
<div class="pagetitle">
<h1>Students</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.schools.index') }}">Home</a></li>
  <li class="breadcrumb-item active">Students</li>
</ol>
</nav>
</div><!-- End Page Title -->
<!-- <div class="text-right d-flex">
    <a href="{{ route('admin.students.create') }}" type="button" class="btn btn-sm btn-primary ms-auto me-0">Add Students</a>
</div> -->
<div>&nbsp;</div>





<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Students List</h5>

          <div class="">&nbsp;</div>

          <!-- Table with hoverable rows -->
          <!-- <div id="loader" style="display:none;"><img src="/backend/assets/img/loading.png"></div> -->

          <div class="prLdr"  id="loader" style="display: none;">

          <div class="lds-facebook">
            <div></div>
            <div></div>
            <div></div>
          </div>

          </div>

          <table class="table table-hover table-bordered table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">Student Name </th>
                <th scope="col">School</th>
                <th scope="col">Classe</th>
                <th scope="col">Parent Name</th>
                <th scope="col">Parent Email</th>
                <th scope="col">Username</th>
              </tr>
            </thead>
            <tbody>

              @if(count($products) > 0)
              @foreach($products as $key => $product)
              @php
              $student = App\Models\Students::where('id',$product->student_id)->first();
              @endphp
              <tr data-entry-id="">
                <td>{{ $student->student_name ?? '' }} {{ $student->student_last_name ?? '' }}</td>
                <td>{{ $student->school->school_name ?? '' }}</td>
                <td>{{ $student->classe ?? '' }}</td>
                <td>{{ $student->father_name ?? '' }}</td>
                <td>{{ $student->addresse_email ?? '' }}</td>
                <td>{{ $student->user->username ?? '' }}</td>
                
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
                    <div class="col-md-4">
                      <label for="inputPassword4" class="form-label">Addon (Digital) Title</label>
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
    $('.loader').hide();
    // Handle select all checkbox click event
    $('#select-all').click(function() {
        if ($(this).is(':checked')) {
            $('.select-item').prop('checked', true);
        } else {
            $('.select-item').prop('checked', false);
        }
    });

    // Handle individual checkbox click event
    $('.select-item').click(function() {
        updateSelectedItems();
    });
    
    // Function to update the list of selected items
    function updateSelectedItems() {
        var selectedItems = [];
        $('.select-item:checked').each(function() {
            selectedItems.push($(this).val());
        });
        $('#selected-items').val(selectedItems.join(','));
    }

    $('.sendbulkemail').click(function() {
        var userId = $(this).data('user');
        var selectedItems = [];
        $('.select-item:checked').each(function() {
            selectedItems.push($(this).val());
        });
        selectedItems = $.unique(selectedItems);
        console.log(selectedItems);
        $.ajax({
            type: 'POST',
            url: '{{ route('admin.users.sendBulkVerificationEmail') }}',
            data: {
                _token: '{{ csrf_token() }}',
                selected_items: selectedItems
            },
            beforeSend: function() {
                // Show the loader
                $('.loader').show();
            },
            complete: function() {
                // Hide the loader
                $('.loader').hide();
            },
            success: function(response) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: 'Bulk Email sent successfully!',
                  showConfirmButton: false,
                  timer: 1500 // Time in milliseconds
                });
            }
        });
    });

    $('.sendemail').click(function() {
        var userId = $(this).data('user');
        var buttons = $("[data-user='" + userId + "']");
        console.log(userId);
        $.ajax({
            type: 'POST',
            url: '{{ route('admin.users.sendVerificationEmail') }}',
            data: {
                _token: '{{ csrf_token() }}',
                userId: userId
            },
            beforeSend: function() {
                // Show the loader
                $('.loader').show();
            },
            complete: function() {
                // Hide the loader
                $('.loader').hide();
            },
            success: function(response) {
              buttons.text("ReSend Verification Mail");
                //alert(response.message);
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Email sent successfully!',
                showConfirmButton: false,
                timer: 1500 // Time in milliseconds
              });
            }
        });
    });

    dataTable = $('#table').on('processing.dt', function (e, settings, processing) {
        $('.loader').toggle(processing);
    }).DataTable({
      processing: true,
      info: false,
      bPaginate: false,
      searching: false,
      pageLength: 15,
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      initComplete: function() {
            $('.loader').hide();
        },
        drawCallback: function() {
            $('.loader').hide();
        },
        preDrawCallback: function() {
            $('.loader').show();
        }
    });


    // $('#select-all').click(function() {
    //     $('.select-item').prop('checked', $(this).prop('checked'));
    // });

    $('#delete-selected').click(function() {
        var ids = [];
        $('.select-item:checked').each(function() {
            ids.push($(this).data('id'));
            console.log($(this).data('id'));
        });
        if(ids.length > 0) {
          if(confirm("Are you sure you want to destroy the selected rows permanently?")) {
            $.ajax({
                url: '{{ route("admin.students.massdelete") }}',
                type: 'DELETE',
                data: {ids: ids},
                success: function(response) {
                    alert('Selected records have been deleted.');
                    window.location.reload();
                }
            });
          }
        }else {
            alert("Please select at least one row.");
        }
    });
    


    $('#myForm').validate({
        rules: {
            title: {
                required : true,
            }, 
        },
        messages :{
            title: {
                required : 'Please Enter Title',
            },
        },
        errorElement : 'span', 
        errorPlacement: function (error,element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight : function(element, errorClass, validClass){
            $(element).addClass('is-invalid');
        },
        unhighlight : function(element, errorClass, validClass){
            $(element).removeClass('is-invalid');
        },
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