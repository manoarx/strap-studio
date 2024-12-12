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
                <th scope="col">Name</th>
                <th scope="col">Code</th>
                <th scope="col">Discount Type</th>
                <th scope="col">Discount</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Status</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($coupons as $key => $coupon)
              <tr data-entry-id="{{ $coupon->id }}">
                <th scope="row">{{ ($key+1) ?? '' }}</th>
                <td>{{ $coupon->name ?? '' }}</td>
                <td>{{ $coupon->code ?? '' }}</td>
                <td>{{ $coupon->discount_type ?? '' }}</td>
                <td>{{ $coupon->discount ?? '' }}</td>
                <td>{{ $coupon->start_date ?? '' }}</td>
                <td>{{ $coupon->end_date ?? '' }}</td>
                <td>
                  @if($coupon->status == 1)
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
            <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="">
                        </div>

                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" value="">
                        </div>


                        <!-- <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" class="form-control" name="quantity" value="">
                        </div>

                        <div class="form-group">
                            <label>Max Use Per Person</label>
                            <input type="text" class="form-control" name="max_use" value="">
                        </div> -->

                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                      <input type="date" name="start_date" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"   />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" name="end_date" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"   />
                                </div>
                            </div>

                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputState">Discount Type</label>
                                    <select id="inputState" class="form-control sub-category" name="discount_type">
                                      <option value="percent">Percentage (%)</option>
                                      <option value="amount">Amount</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Discount Value</label>
                                    <input type="text" class="form-control" name="discount" value="">
                                </div>
                            </div>
                        </div>
                      </div>

                        <div class="form-group">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-control" name="status">
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                            </select>
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