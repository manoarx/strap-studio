@extends('layouts.backend')

@section('styles')

<link href="{{ asset('backend/assets/date-pick/bootstrap-datepicker.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endsection

@section('content')
<div class="pagetitle">
<h1>Confirmed Orders</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">Confirmed Orders</li>
</ol>
</nav>
</div>
<div>&nbsp;</div>

<div class="enqry">
<div class="card col-xl-12 col-lg-12">
                <div class="row">
                    <form action="" method="get">
                        <div class="dropouter d-flex">

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

<div class="page-content">

				 
				<hr/>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Confirmed Orders List</h5>
						<div class="table-responsive">
							<table id="table" class="table table-striped table-bordered" style="width:100%">
								<thead>
			<tr>
				<th>Sl</th>
				<th>Date </th>
				<th>Type</th>
				<th>Customer Name </th>
				<th>Address </th>
				<th>Phone </th>
				<th>Order No </th>
				<th>Invoice </th>
				<th>Amount </th>
				<th>Payment </th>
				<th>State </th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
	@foreach($orders as $key => $item)		
			<tr>
				<td> {{ $key+1 }} </td>
				<td>{{ $item->order_date }}</td>
				<td>{{ ucwords($item->notes) ?? ''}}</td>
				<td>{{$item->name ?? ''}}</td>
				<td>{{ $item->adress ?? '' }}</td>
				<td>{{ $item->phone ?? '' }}</td>
				<td>#{{ $item->id }}</td>
				<td>{{ $item->invoice_no }}</td>
				<td>AED {{ $item->amount }}</td>
				<td>{{ $item->payment_method }}</td>
                <td> 
                	<span class="badge rounded-pill bg-success"> {{ $item->status }}</span>
                </td> 
				
				<td>
					@if($item->status == 'pending')
			      	<a href="{{ route('admin.pending-confirm',$item->id) }}" class="btn btn-sm btn-success" id="confirm" >Confirm Order</a>
			      	
			      	@elseif($item->status == 'confirm')
					<a href="{{ route('admin.confirm-processing',$item->id) }}" class="btn btn-sm btn-success" id="processing" >Process Order</a>
					
					@elseif($item->status == 'processing')
					<a href="{{ route('admin.processing-delivered',$item->id) }}" class="btn btn-sm btn-success" id="delivered" >Delivered Order</a>
			      	@endif
<a href="{{ route('admin.order.details',$item->id) }}" class="btn btn-info btn-sm" title="Details">View </a>

<!-- <a href="{{ route('admin.invoice.download',$item->id) }}" class="btn btn-danger btn-sm" title="Invoice Pdf">Download </a> -->
<a href="javascript:void(0);" class="btn btn-danger btn-sm download_invoice" data-enid="{{ Crypt::encrypt($item->id) }}" data-id="{{ $item->id }}" title="Invoice Pdf">{{ invoiceButtonText($item->id) }} </a>
 

				</td> 
			</tr>
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




@endsection
@section('scripts')
<script src="{{ asset('backend/assets/date-pick/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('backend/assets/js/rp-quickbooks.js') }}"></script>
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
      dom: 'Bfrtip',
      buttons: [
      	{
           extend: 'copy',           
           exportOptions: {
                columns: [1,2,3,4,5,6,7,8] // indexes of the columns that should be printed,
            }                      // Exclude indexes that you don't want to print.
       },
       {
           extend: 'print',
           exportOptions: {
                columns: [1,2,3,4,5,6,7,8] 
            }

       },
       {
           extend: 'pdf',           
           exportOptions: {
                columns: [1,2,3,4,5,6,7,8] // indexes of the columns that should be printed,
            }                      // Exclude indexes that you don't want to print.
       },
       {
           extend: 'csv',
           exportOptions: {
                columns: [1,2,3,4,5,6,7,8] 
            }

       },
       {
           extend: 'excel',
           exportOptions: {
                columns: [1,2,3,4,5,6,7,8] 
            }
       }         
    	] 
    });

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)



  });
</script>
@endsection