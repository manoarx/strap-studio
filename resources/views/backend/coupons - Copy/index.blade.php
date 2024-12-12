@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')
<div class="pagetitle">
<h1>Coupons</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">Coupons</li>
</ol>
</nav>
</div><!-- End Page Title -->
<!-- <div class="text-right d-flex">
    <a href="{{ route('admin.coupons.create') }}" type="button" class="btn btn-primary ms-auto me-0">Add Coupons</a>
</div> -->
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Coupons List</h5>

          <!-- Table with hoverable rows -->
          <table class="table table-hover table-bordered table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Coupon Name</th>
                <th scope="col">Coupon Discount</th>
                <th scope="col">Validity</th>
                <th scope="col">Status</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($coupons as $key => $coupon)
              <tr data-entry-id="{{ $coupon->id }}">
                <th scope="row">{{ ($key+1) ?? '' }}</th>
                <td>{{ $coupon->coupon_name ?? '' }}</td>
                <td>{{ $coupon->coupon_discount ?? '' }}%</td>
                <td>{{ Carbon\Carbon::parse($coupon->coupon_validity)->format('D, d F Y') }}</td>
                <td>
                  @if($coupon->coupon_validity >= Carbon\Carbon::now()->format('Y-m-d'))
                  <span class="badge badge-pill badge-success"> Valid </span>
                  @else
                       <span class="badge badge-pill badge-danger"> Invalid </span>
                  @endif
                </td>
                <td>
                  <a class="btn btn-sm btn-info" href="{{ route('admin.coupons.edit', $coupon->id) }}">
                      Edit
                  </a>
                  <a class="btn btn-sm btn-danger" href="{{ route('admin.coupons.delete',$coupon->id) }}" id="delete" >Delete</a>
                  <!-- <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
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
          <h5 class="card-title">Add Coupon</h5>

          <form id="myForm" class="row g-3" action="{{ route("admin.coupons.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-12">
              <label for="name" class="form-label">Coupon Name <span class="text-danger">*</span></label>
              <input type="text" name="coupon_name" class="form-control">
            </div>
            <div class="form-group col-md-12">
              <label for="desc" class="form-label">Coupon Discount(%) <span class="text-danger">*</span></label>
              <input type="text" name="coupon_discount" class="form-control">
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Coupon Validity Date  <span class="text-danger">*</span></label>
              <input type="date" name="coupon_validity" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"   />
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
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
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
            coupon_name: {
                required : true,
            }, 
        },
        messages :{
            coupon_name: {
                required : 'Please Enter Coupon Name',
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
</script>
@endsection