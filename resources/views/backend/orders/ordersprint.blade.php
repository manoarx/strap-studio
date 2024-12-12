@extends('layouts.backend')

@section('styles')

<link href="{{ asset('backend/assets/date-pick/bootstrap-datepicker.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endsection

@section('content')
<div class="pagetitle">
<h1>Print Orders</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">Print Orders</li>
</ol>
</nav>
</div>
<div>&nbsp;</div>

<div class="enqry">
<div class="card col-xl-12 col-lg-12">
                <div class="row">
                    <form action="" method="get">
                        <div class="dropouter d-flex">
<select name="order_status" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm trnRundPre1">
@if ($order_status ==  'pending')
    <option value="pending" selected>Pending</option>
@else
    <option value="pending">Pending</option>
@endif
@if ($order_status ==  'confirm')
    <option value="confirm" selected>Confirm</option>
@else
    <option value="confirm">Confirm</option>
@endif
<!-- @if ($order_status ==  'processing')
    <option value="processing" selected>Processing</option>
@else
    <option value="processing">Processing</option>
@endif
@if ($order_status ==  'deliverd')
    <option value="deliverd" selected>Deliverd</option>
@else
    <option value="deliverd">Deliverd</option>
@endif
@if ($order_status ==  'cancel')
    <option value="cancel" selected>Cancel</option>
@else
    <option value="cancel">Cancel</option>
@endif -->
</select>
<select name="filter_range" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm trnRundPre1">
<option value="0">All</option>
@if ($filter_range ==  'current_month')
    <option value="current_month" selected>This Month</option>
@else
    <option value="current_month">This Month</option>
@endif
@if ($filter_range ==  'last_month')
    <option value="last_month" selected>Last Month</option>
@else
    <option value="last_month">Last Month</option>
@endif
@if ($filter_range ==  'this_year')
    <option value="this_year" selected>This Year</option>
@else
    <option value="this_year">This Year</option>
@endif
@if ($filter_range ==  'custom')
    <option value="custom" selected>Custom date</option>
@else
    <option value="custom">Custom date</option>
@endif
</select>
<div class="d-none datRange">
    <div class="d-flex input-group input-daterange">
        <div class="d-block trnRundPre mr-2">
            <span class="d-block">
                <input id="startDate1" name="startDate1" type="text" class="form-control text-left" readonly="readonly" placeholder="From" value="{{ old('startDate1') }}" >
            </span>
        </div>
        <div class="d-block trnRundPre ">
            <span class="d-block">
                <input id="endDate1" name="endDate1" type="text" class="form-control text-left" readonly="readonly" placeholder="To" value="{{ old('endDate1') }}">
            </span>
        </div>
    </div>
</div>
<div>&nbsp;<input class="btn btn-danger" type="submit" value="Filter"></div>
</div>
</form>
</div>
</div>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">

				 
				<hr/>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Orders List</h5>
						<div class="table-responsive">
							<table id="table" class="table table-striped table-bordered" style="width:100%">
								<thead>
			<tr>
				<th>Sl</th>
				<th>Order No </th>
				<th>Date </th>
				<th>Name </th>
				<th>Phone </th>
				<th>Email </th>
				<th>Address </th>
				<th>Quantity </th>
				<th>Invoice </th>
				<th>Amount </th>
				<th>Payment </th>
				<th>Order Status </th>
				<th>Action</th> 
			</tr>
		</thead>
		<tbody>
	@foreach($orders as $key => $order)

		@php
		$order_date = $order->order_date;
		$order_id = $order->id;
		$invoice_no = $order->invoice_no;
		$amount = $order->amount;
		$payment_method = $order->payment_method;
		@endphp	

		@foreach($order->orderitem as $item)

			<tr>
				<td> {{ $key+1 }} </td>
				<td>#{{ $order_id ?? '' }}</td>
				<td>{{ $order->order_date ?? '' }}</td>
				<td>{{ $order->name ?? ''}}</td>
				<td>{{ $order->user->phone ?? '' }}</td>
				<td>{{ $order->user->email ?? '' }}</td>
				<td>{{ $order->user->address ?? '' }}</td>
				<td>{{ $item->qty ?? '' }}</td>
				<td>{{ $invoice_no }}</td>
				<td>AED {{ $amount }}</td>
				<td>{{ $payment_method }}</td>
                <td> 
                	<span class="badge rounded-pill bg-success"> {{ $order->status }}</span>
                </td> 
				
				<td>


				<a href="{{ route('admin.order.details',$order->id) }}" class="btn btn-info btn-sm" title="Details">View Order</a>
 

				</td> 
			</tr>
		@endforeach
	@endforeach	 
		 
		</tbody>
		<!-- <tfoot>
			<tr>
				<th>Sl</th>
				<th>Date </th>
				<th>Name </th>
				<th>Invoice </th>
				<th>Amount </th>
				<th>Payment </th>
				<th>State </th>
				<th>Action</th> 
			</tr>
		</tfoot> -->
	</table>

						</div>
					</div>
				</div>
 

				 
			</div>

</div>


@endsection
@section('scripts')
<script src="{{ asset('backend/assets/date-pick/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  var dataTable;
  var basePath ="{{url('/')}}";
  $(document).ready(function() {

  	let filterRange = "{{$filter_range}}"
    if (filterRange === 'custom'){
        $('.datRange').removeClass("d-none");
    }

    try {
        $('.input-daterange').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });
     } catch (er) {}

  
    $('.trnRundPre1').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        if(optionSelected.text()==="Custom date"){
            $('.datRange').removeClass("d-none");
        }else {
            $('.datRange .inpSty').val('');
            $('.datRange').addClass("d-none");
        }
    });
  	$(".datetimepicker").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });

    
    dataTable = $('#table').DataTable({
      pageLength: 10,
      info: false,
      bPaginate: false,
      dom: 'Bfrtip',
      buttons: [
      	{
           extend: 'copy',           
           exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] // indexes of the columns that should be printed,
            }                      // Exclude indexes that you don't want to print.
       },
       {
           extend: 'print',
           exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] 
            }

       },
       {
           extend: 'pdf',           
           exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] // indexes of the columns that should be printed,
            }                      // Exclude indexes that you don't want to print.
       },
       {
           extend: 'csv',
           exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] 
            }

       },
       {
           extend: 'excel',
           exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] 
            }
       }         
    	] 
    });

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)



  });
</script>
@endsection