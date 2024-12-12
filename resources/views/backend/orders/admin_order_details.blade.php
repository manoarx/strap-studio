@extends('layouts.backend')

@section('styles')


@endsection

@section('content')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Admin Order Details</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Admin Order Details</li>
							</ol>
						</nav>
					</div>
				 
				</div>
				<!--end breadcrumb-->
				 
				<hr/>


<div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
					<!--  <div class="col">
					<div class="card">
               <div class="card-header"><h4>Shipping Details</h4> </div> 
               <hr>
              <div class="card-body">
                 <table class="table" style="background:#F4F6FA;font-weight: 600;">
                    <tr>
                        <th>Shipping Name:</th>
                        <th>{{ $order->name }}</th>
                    </tr>

                    <tr>
                        <th>Shipping Phone:</th>
                        <th>{{ $order->phone }}</th>
                    </tr>

                    <tr>
                        <th>Shipping Email:</th>
                        <th>{{ $order->email }}</th>
                    </tr>

                     <tr>
                        <th>Shipping Address:</th>
                        <th>{{ $order->adress }}</th>
                    </tr>



                     <tr>
                        <th>Post Code  :</th>
                         <th>{{ $order->post_code }}</th>
                    </tr>

                     <tr>
                        <th>Order Date   :</th>
                        <th>{{ $order->order_date }}</th>
                    </tr>
                    
                </table>
                   
               </div>

            </div>
					</div> -->


					<div class="col">
					 <div class="card">
               <div class="card-header"><h4>Order Details
                <span class="text-danger">Invoice : {{ $order->invoice_no }} </span></h4>
                </div> 
               <hr>
               <div class="card-body">
                <table class="table" style="background:#F4F6FA;font-weight: 600;">
                    @if($order->user->school_id != "")
                    <tr>
                        <th> Parent Name :</th>
                        <th>{{ $order->user->name }}</th>
                    </tr>
                    
                    <tr>
                        <th> School Name :</th>
                        <th>{{ $order->user->school->school_name ?? '' }}</th>
                    </tr>
                    @else
                    <tr>
                        <th>Name :</th>
                        <th>{{ $order->user->name }}</th>
                    </tr>
                    @endif
                    <tr>
                        <th>Phone :</th>
                      <th>{{ $order->user->phone }}</th>
                    </tr>
                    <tr>
                        <th>Email :</th>
                      <th>{{ $order->user->email }}</th>
                    </tr>
                    <tr>
                        <th>Payment Type:</th>
                       <th>{{ $order->payment_method }}</th>
                    </tr>


                    <tr>
                        <th>Transx ID:</th>
                       <th>{{ $order->transaction_id }}</th>
                    </tr>

                    <tr>
                        <th>Invoice:</th>
                       <th class="text-danger">{{ $order->invoice_no }}</th>
                    </tr>

                    <tr>
                        <th>Order Amount:</th>
                         <th>AED {{ $order->amount }}</th>
                    </tr>

                    <tr>
                        <th>Order Date   :</th>
                        <th>{{ $order->order_date }}</th>
                    </tr>

                     <tr>
                        <th>Order Status:</th>
                        @if($order->status == 'pending')
                        <th><span class="badge bg-danger" style="font-size: 15px;">Pending </span></th>
                        @else 
                        <th><span class="badge bg-success" style="font-size: 15px;">Confirmed</span></th>
                        @endif
                    </tr>


     <tr>
                        <th> </th>
      <th>
        @if($order->status == 'pending')
        <a href="{{ route('admin.pending-confirm',$order->id) }}" class="btn btn-block btn-success" id="confirm" >Confirm Order</a>
        @endif


      	<!-- @if($order->status == 'pending')
      	<a href="{{ route('admin.pending-confirm',$order->id) }}" class="btn btn-block btn-success" id="confirm" >Confirm Order</a>
      	
      	@elseif($order->status == 'confirm')
		<a href="{{ route('admin.confirm-processing',$order->id) }}" class="btn btn-block btn-success" id="processing" >Processing Order</a>
		
		@elseif($order->status == 'processing')
		<a href="{{ route('admin.processing-delivered',$order->id) }}" class="btn btn-block btn-success" id="delivered" >Delivered Order</a>
      	@endif
        @if($order->status != 'cancel')
        <a href="{{ route('admin.order-cancel',$order->id) }}" class="btn btn-block btn-danger" id="cancel" >Cancel Order</a>
      	@endif -->


      	 </th>
       </tr>
                    
                </table>
                   
               </div>

            </div>
					</div>
				</div>


			 
 


<div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-1">
					<div class="col">
						<div class="card">
					 

<div class="table-responsive">
<table class="table" style="font-weight: 600;"  >
    <tbody>
        <tr>
            <!-- <td class="col-md-1">
                <label>Image </label>
            </td> -->
            <td class="col-md-2">
                <label>Type </label>
            </td>
            <td class="col-md-2">
                <label>Product Name </label>
            </td>
            <td class="col-md-2">
                <label>Date  </label>
            </td>
            <td class="col-md-1">
                <label>Time Start</label>
            </td>
            <td class="col-md-1">
                <label>Time End </label>
            </td>
            <td class="col-md-1">
                <label>Quantity </label>
            </td>

            <td class="col-md-3">
                <label>Price  </label>
            </td> 

        </tr>


        @foreach($orderItem as $item)
        @php
        if($item->product_type == 'workshop') {
          $itemtype = $item->workshop;
        } elseif($item->product_type == 'service') {
          $itemtype = $item->servicepackage->service;
        } elseif($item->product_type == 'studiorental') {
          $itemtype = $item->studiorental;
        } else {
          $itemtype = $item->product;
        } 
        @endphp
         <tr>
   
            <td class="col-md-2">
                <label>{{ ucwords($item->product_type) }}</label>
            </td>

            <td class="col-md-2">
                <label>{{ $itemtype->title ?? '' }} 
                    @if($item->product_type == 'service')
                    <br>{{ $item->servicepackage->package_name ?? '' }}  <br>{{ $item->option->option_name ?? '' }}  @if($item->addon)<br>{{ $item->addon->addon_name ?? '' }} - (Quantity - {{ $item->addon_qty ?? '1' }}) @endif
                    @endif
                </label>
            </td>
            @if($item->booked_date == NULL)
             <td class="col-md-2">
                <label>... </label>
            </td>
            @else
                <td class="col-md-2">
                <label>{{ $item->booked_date }} </label>
            </td>
            @endif
            

            @if($item->booked_stime == NULL)
             <td class="col-md-1">
                <label>.... </label>
            </td>
            @else
            <td class="col-md-1">
                <label>{{ $item->booked_stime }} </label>
            </td>
            @endif
            
            @if($item->booked_etime == NULL)
             <td class="col-md-1">
                <label>.... </label>
            </td>
            @else
            <td class="col-md-1">
                <label>{{ $item->booked_etime }} </label>
            </td>
            @endif
            <td class="col-md-1">
                <label>{{ $item->qty }} </label>
            </td>

            <td class="col-md-3">
                <label>AED {{ $item->price }} <br> Total = AED {{ $item->price * $item->qty }}   </label>
            </td> 

        </tr>
        @endforeach

    </tbody>
</table>
                        
                    </div>



						</div>
					</div>
				 
				</div>





				 
			</div> 

@endsection