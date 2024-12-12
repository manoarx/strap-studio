@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')
<div class="pagetitle">
<h1>Schools</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">Schools</li>
</ol>
</nav>
</div><!-- End Page Title -->
<!-- <div class="text-right d-flex">
    <a href="{{ route('admin.schools.create') }}" type="button" class="btn btn-primary ms-auto me-0">Add schools</a>
</div> -->
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Schools List</h5>

          <!-- Table with hoverable rows -->
          <table class="table table-hover table-bordered table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($schools as $key => $school)
              <tr data-entry-id="{{ $school->id }}">
                <th scope="row">{{ ($key+1) ?? '' }}</th>
                <td>{{ $school->school_name ?? '' }}</td>
                <td><img src="{{ (!empty($school->image)) ? asset($school->image) : url('upload/no_image.jpg') }}" style="width: 70px; height:40px;" >  </td>
                <td>
                  <button type="button" class="btn btn-sm btn-primary" onclick="$('#file-upload-modal').modal('show'); $('#school-id').val({{ $school->id }})">Import</button>

                  <a class="btn btn-sm btn-info" href="{{ route('admin.schools.edit', $school->id) }}">
                      Edit
                  </a>
                  @if(count($school->student) > 0) 
                  <a class="btn btn-sm btn-info" href="{{ route('admin.students.index',['schoolid' => $school->id]) }}">
                      View Students
                  </a>
                  <a class="btn btn-sm btn-info" href="{{ route('admin.bulkproducts.index',['schoolid' => $school->id]) }}">
                      Bulk Products
                  </a>
                  <button type="button" class="btn btn-sm btn-primary" onclick="$('#add-product-modal').modal('show'); $('#student-id').val(0); $('#schoolid').val({{ $school->id }});"> Add Product</button>

                  <a class="btn btn-sm btn-danger" href="{{ route('admin.schools.deleteproduct',$school->id) }}" id="deleteproduct" >Delete Product</a>
                  @endif
                  <a class="btn btn-sm btn-danger" href="{{ route('admin.schools.delete',$school->id) }}" id="delete" >Delete</a>
                  <!-- <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                  </form> -->
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- End Table with hoverable rows -->

        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Schools</h5>

          <form id="myForm" class="row g-3" action="{{ route("admin.schools.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-12">
              <label for="school_name" class="form-label">Name</label>
              <input type="text" name="school_name" class="form-control">
            </div>
            <div class="form-group col-md-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" name="address" class="form-control">
            </div>
            <div class="form-group col-md-12">
              <label for="email" class="form-label">Email</label>
              <input type="text" name="email" class="form-control">
            </div>
            <div class="form-group col-md-12">
              <label for="contact_number" class="form-label">Contact Number</label>
              <input type="text" name="contact_number" class="form-control">
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Image</label>
              <input type="file" name="image" class="form-control"  id="image"   />
            </div>
            <div class="col-md-12">
              <label for="desc" class="form-label"></label>
              <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="Admin" style="width:100px; height: 100px;"  >
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
<div class="modal fade" id="file-upload-modal" tabindex="-1" aria-labelledby="file-upload-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.studentsimport') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="file-upload-modal-label">Import File</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
          <input type="hidden" name="school_id" id="school-id">
          <input type="file" name="file">
          
      </div>
      <div class="modal-footer">
        <div id="importloader" class="text-center d-none">
            <i class="fa fa-spinner fa-spin"></i> <img src="/backend/assets/img/loading.gif" height="44px">
          </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" onclick="showLoader()">Import</button>
      </div>
    </div>
    </form>
  </div>
</div>
<div class="modal fade" id="add-product-modal" tabindex="-1" aria-labelledby="add-product-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add-product-modal-label">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="school_id" id="schoolid">
          <input type="hidden" name="student_id" id="student-id">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                      <label for="inputNanme4" class="form-label">Year</label>
                      <select name="year" class="form-select">
                        <option value="0">All Year</option>
                        @foreach ($years as $yearlist)
                        <option value="{{$yearlist->year ?? ''}}">{{$yearlist->year ?? ''}}</option>
                        @endforeach
                      </select>
                    </div>
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
  var dataTable;
  var basePath ="{{url('/')}}";
  $(document).ready(function() {
    dataTable = $('#table').DataTable({
      pageLength: 10,
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)



    $('#image').change(function(e){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#showImage').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.target.files['0']);
    });


    $('#myForm').validate({
        rules: {
            name: {
                required : true,
            }, 
        },
        messages :{
            name: {
                required : 'Please Enter school Name',
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
</script>
<script>
  function showLoader() {
    $('#importloader').removeClass('d-none');
  }
  
  function hideLoader() {
    $('#importloader').addClass('d-none');
  }
  
  $(document).ready(function() {
    $('form').on('submit', function() {
      showLoader();
    });
    
    $('#importModal').on('hidden.bs.modal', function () {
      hideLoader();
    });
  });
</script>

@endsection