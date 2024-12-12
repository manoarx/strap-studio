@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="pagetitle">
<h1>Coupons</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Coupons</a></li>
  <li class="breadcrumb-item active">Edit Coupons</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Coupons</h5>

          <form id="myForm" class="row g-3" action="{{ route('admin.coupons.update', [$coupon->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $coupon->id }}">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{$coupon->name}}">
            </div>

            <div class="form-group">
                <label>Code</label>
                <input type="text" class="form-control" name="code" value="{{$coupon->code}}">
            </div>


            <!-- <div class="form-group">
                <label>Quantity</label>
                <input type="text" class="form-control" name="quantity" value="{{$coupon->quantity}}">
            </div>

            <div class="form-group">
                <label>Max Use Per Person</label>
                <input type="text" class="form-control" name="max_use" value="{{$coupon->max_use}}">
            </div> -->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="{{$coupon->start_date}}" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" class="form-control" name="end_date" value="{{$coupon->end_date}}" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
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
                              <option {{$coupon->discount_type == 'percent' ? 'selected' : ''}} value="percent">Percentage (%)</option>
                              <option {{$coupon->discount_type == 'amount' ? 'selected' : ''}} value="amount">Amount</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Discount Value</label>
                            <input type="text" class="form-control" name="discount" value="{{$coupon->discount}}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="inputState">Status</label>
                <select id="inputState" class="form-control" name="status">
                  <option {{$coupon->status == 1 ? 'selected' : ''}} value="1">Active</option>
                  <option {{$coupon->status == 0 ? 'selected' : ''}} value="0">Inactive</option>
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

<script type="text/javascript">
    $(document).ready(function (){
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