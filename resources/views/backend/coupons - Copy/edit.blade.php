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
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Coupon Name</label>
              <input type="text" name="coupon_name" class="form-control" value="{{ old('coupon_name', isset($coupon) ? $coupon->coupon_name : '') }}" required>
            </div>
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Coupon Discount(%)</label>
              <input type="text" name="coupon_discount" class="form-control" value="{{ old('coupon_discount', isset($coupon) ? $coupon->coupon_discount : '') }}" required>
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Coupon Validity Date</label>
              <input type="date" name="coupon_validity" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control"  value="{{ old('coupon_validity', isset($coupon) ? $coupon->coupon_validity : '') }}" required />
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