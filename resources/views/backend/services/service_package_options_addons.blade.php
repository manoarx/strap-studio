@extends('layouts.backend')

@section('styles')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

@endsection

@section('content')

<div class="pagetitle">
<h1>Service Package</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
  <li class="breadcrumb-item">Service Package</li>
  <li class="breadcrumb-item active">Add Service Package Options / Addons</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Service Package</h5>

          <form class="row g-3" action="{{ route('admin.services.optionsaddonupdate', [$id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="service_id" value="{{ old('service_id', isset($id) ? $id : '') }}">

            @if(count($packages) > 0)
            @foreach($packages as $key => $package)
              
              <div class="row customerDiv" id="customerDiv">
                <input type="hidden" name="package_id[]" value="{{$package->id ?? ''}}">
                <div class="col-sm-12">
                  <div class="row g-3">
                    <div class="col-sm-6">
                      <label class="form-label"><b>Package Name : {{$package->package_name ?? ''}}</b></label>
                      <input type="hidden" name="package_name[]" value="{{$package->package_name ?? ''}}" class="form-control" >
                    </div>
                    <!-- <div class="col-sm-6">
                      <label class="form-label">Price</label>
                      <input type="text" name="price[]" value="{{$package->price ?? ''}}"class="form-control" disabled>
                    </div> -->
                  </div>
                  <div class="row">

                    <div class="col-md-6 listaddons">



                      <!--addons start-->
                      @php
                      $servicepackageaddons = App\Models\ServicePackageAddons::where('service_id',$id)->where('service_package_id',$package->id)->orderBy('id','ASC')->get();
                      @endphp
                      @if(count($servicepackageaddons) > 0)
                      @foreach($servicepackageaddons as $akey => $servicepackageaddon)
                      <div class="row addonsDiv" id="addonsDiv">
                        <input type="hidden" name="package_addons_id[{{$package->id ?? ''}}][]" value="{{$servicepackageaddon->id ?? ''}}">
                        <div class="col-sm-10">
                          <div class="row g-3">
                               <div class="col-sm-8">
                              <label class="form-label">Addon Name</label>
                              <input type="text" name="addon_name[{{$package->id ?? ''}}][]" value="{{$servicepackageaddon->addon_name ?? ''}}" class="form-control">
                            </div>
                            <div class="col-sm-4">
                              <label class="form-label">Price</label>
                              <input type="text" name="addon_price[{{$package->id ?? ''}}][]" value="{{$servicepackageaddon->addon_price ?? ''}}" class="form-control">
                            </div>

                          </div>
     
                        </div>

                        <div class="col-sm-2">

                          @if($akey==0)
                          <br>
                          <a href="javaScript:void(0)" class="addmore_addons addonsbtn-addmore"><span class="addonscnt"><img src="/backend/assets/img/add.png" width="24px">&nbsp;</span></a>
                          @else
                          <br>
                          <a href="javaScript:void(0)" data-id="{{ $package->id }}" class="remove_addons addonsbtn-addmore"><span class="addcnt"><img src="/backend/assets/img/delete.png" width="24px"> &nbsp;</span></a>
                          @endif
                        </div>
     
                      </div>
                      <!--addons end-->
                      @endforeach
                      @else
                      <div class="row addonsDiv" id="addonsDiv">
                        <div class="col-sm-10">
                          <div class="row g-3">
                               <div class="col-sm-8">
                              <label class="form-label">Addon Name</label>
                              <input type="text" name="addon_name[{{$package->id ?? ''}}][]" value="" class="form-control">
                            </div>
                            <div class="col-sm-4">
                              <label class="form-label">Price</label>
                              <input type="text" name="addon_price[{{$package->id ?? ''}}][]" value="" class="form-control">
                            </div>

                          </div>
     
                        </div>

                        <div class="col-sm-2">
                          <br>
                          <a href="javaScript:void(0)" class="addmore_addons addonsbtn-addmore"><span class="addonscnt"><img src="/backend/assets/img/add.png" width="24px">&nbsp;</span></a>

                        </div>
     
                      </div>


                      @endif


                    </div>
                    <div class="col-md-6 listaddons">
                      <!--options start-->
                      @php
                      $servicepackageoptions = App\Models\ServicePackageOptions::where('service_id',$id)->where('service_package_id',$package->id)->orderBy('id','ASC')->get();
                      @endphp
                      @if(count($servicepackageoptions) > 0)
                      @foreach($servicepackageoptions as $akey => $servicepackageoption)
                      <div class="row optionsDiv" id="optionsDiv">
                        <input type="hidden" name="package_options_id[{{$package->id ?? ''}}][]" value="{{$servicepackageoption->id ?? ''}}">
                        <div class="col-sm-10">
                          <div class="row g-3">
                               <div class="col-sm-8">
                              <label class="form-label">Option Name</label>
                              <input type="text" name="option_name[{{$package->id ?? ''}}][]" value="{{$servicepackageoption->option_name ?? ''}}" class="form-control">
                            </div>
                            <div class="col-sm-4">
                              <label class="form-label">Price</label>
                              <input type="text" name="option_price[{{$package->id ?? ''}}][]" value="{{$servicepackageoption->option_price ?? ''}}" class="form-control">
                            </div>

                          </div>
     
                        </div>

                        <div class="col-sm-2">

                          @if($akey==0)
                          <br>
                          <a href="javaScript:void(0)" class="addmore_options optionsbtn-addmore"><span class="optionscnt"><img src="/backend/assets/img/add.png" width="24px">&nbsp;</span></a>
                          @else
                          <br>
                          <a href="javaScript:void(0)" data-id="{{ $package->id }}" class="remove_options optionsbtn-addmore"><span class="addcnt"><img src="/backend/assets/img/delete.png" width="24px"> &nbsp;</span></a>
                          @endif
                        </div>
     
                      </div>
                      <!--options end-->
                      @endforeach
                      @else
                      <div class="row optionsDiv" id="optionsDiv">
                        <div class="col-sm-10">
                          <div class="row g-3">
                               <div class="col-sm-8">
                              <label class="form-label">Option Name</label>
                              <input type="text" name="option_name[{{$package->id ?? ''}}][]" value="" class="form-control">
                            </div>
                            <div class="col-sm-4">
                              <label class="form-label">Price</label>
                              <input type="text" name="option_price[{{$package->id ?? ''}}][]" value="" class="form-control">
                            </div>

                          </div>
     
                        </div>

                        <div class="col-sm-2">

                          <a href="javaScript:void(0)" class="addmore_options optionsbtn-addmore"><span class="optionscnt"><img src="/backend/assets/img/add.png" width="24px">&nbsp;</span></a>

                        </div>
     
                      </div>


                      @endif

                    </div>
                  </div>
                </div>

                
                
              </div>
              <div class="col-md-12">
                    <hr class="grey" />
                </div>
            @endforeach
            @endif

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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.4/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $(".addmore_addons").click(function(){
        
            $block = $(this).closest("#addonsDiv").clone();
            $(".pc", $block).remove();
            $(".addonsbtn-addmore", $block).html('<span class="addonscnt"><img src="/backend/assets/img/delete.png" width="24px"> &nbsp;</span>');
            $(".addonsbtn-addmore", $block).addClass('remove_addons').removeClass('addmore_addons');
            //block.children(".addmore_vendor").text("REMOVE");
            $block.find("input").val("");
            //$block.insertAfter("div.addonsDiv:last");
            var $container =$(this).closest('.addonsDiv');
            $block.insertAfter($container);
        });

        $("body").on("click",".remove_addons",function(e){
          
          $(this).parents('.addonsDiv').remove();

          var id = $(this).data("id");
          var token = $("meta[name='csrf-token']").attr("content");
       

        });




        $(".addmore_options").click(function(){
        
            $block = $(this).closest("#optionsDiv").clone();
            $(".pc", $block).remove();
            $(".optionsbtn-addmore", $block).html('<span class="optionscnt"><img src="/backend/assets/img/delete.png" width="24px"> &nbsp;</span>');
            $(".optionsbtn-addmore", $block).addClass('remove_options').removeClass('addmore_options');
            //block.children(".addmore_vendor").text("REMOVE");
            $block.find("input").val("");
            //$block.insertAfter("div.optionsDiv:last");
            var $container =$(this).closest('.optionsDiv');
            $block.insertAfter($container);
        });

        $("body").on("click",".remove_options",function(e){
          
          $(this).parents('.optionsDiv').remove();

          var id = $(this).data("id");
          var token = $("meta[name='csrf-token']").attr("content");
       

        });

    });




</script>

@endsection