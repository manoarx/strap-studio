@extends('layouts.backend')

@section('styles')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="pagetitle">
<h1>Service Package</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
  <li class="breadcrumb-item">Service Package</li>
  <li class="breadcrumb-item active">Add Service Package</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Service Package</h5>

          <form class="row g-3" action="{{ route('admin.services.packageupdate', [$id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="service_id" value="{{ old('service_id', isset($id) ? $id : '') }}">

            @if(count($packages) > 0)
            @foreach($packages as $key => $package)
              
              <div class="row customerDiv" id="customerDiv">
                <input type="hidden" name="package_id[]" value="{{$package->id ?? ''}}">
                <div class="col-sm-10">
                  <div class="row g-3">
                    <div class="col-sm-6">
                      <label class="form-label">Package Name</label>
                      <input type="text" name="package_name[]" value="{{$package->package_name ?? ''}}" class="form-control" required>
                    </div>
                    <div class="col-sm-2">
                      <label class="form-label">Price</label>
                      <input type="text" name="price[]" value="{{$package->price ?? ''}}"class="form-control">
                    </div>
                    <div class="col-sm-2">
                      <label class="form-label">Duration (min)</label>
                      <input type="text" name="duration[]" value="{{$package->duration ?? ''}}"class="form-control" placeholder="Eg : 60">
                    </div>
                    <div class="col-sm-2 form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="most_liked[]" value="1" {{  ($package->most_liked == 1 ? 'checked' : '') }}>
                      <input type="hidden" name="most_liked[]" value="0">
                      <label class="form-check-label" for="flexSwitchCheckDefault">Most Liked</label>
                    </div>
                  </div>
                  <div class="row g-3">
                    <div class="col-md-12">
                      <label for="about_course" class="form-label">About Package</label>
                      <textarea id="about_package" name="about_package[]" class="summernote about_package">{{$package->about_package ?? ''}}</textarea>
                    </div>

                  </div>
                </div>

                <div class="col-sm-2">

                  @if($key==0)
                  <a href="javaScript:void(0)" class="addmore_customer btn-addmore"><span class="addcnt"><img src="/backend/assets/img/add.png" width="24px"> Add More</span></a>
                  @else
                  <a href="javaScript:void(0)" data-id="{{ $package->id }}" class="remove_customer btn-addmore"><span class="addcnt"><img src="/backend/assets/img/delete.png" width="24px"> Remove</span></a>
                  @endif
                </div>
                
                <div class="col-md-12">
                    <hr class="grey" />
                </div>
              </div>
            @endforeach
            @else
              <div class="row customerDiv" id="customerDiv">
                <div class="col-sm-10">
                  <div class="row g-3">
                    <div class="col-sm-6">
                      <label class="form-label">Package Name</label>
                      <input type="text" name="package_name[]" class="form-control">
                    </div>
                    <div class="col-sm-3">
                      <label class="form-label">Price</label>
                      <input type="text" name="price[]" class="form-control">
                    </div>
                    <div class="col-sm-3 form-check form-switch">

                      <input class="form-check-input" type="checkbox" name="most_liked[]" value="1" id="flexSwitchCheckDefault">
                      <input type="hidden" name="most_liked[]" value="0">
                      <label class="form-check-label" for="flexSwitchCheckDefault">Most Liked</label>
                    </div>
                  </div>
                  <div class="row g-3">
                    <div class="col-md-12">
                      <label for="about_course" class="form-label">About Package</label>
                      <textarea id="about_package" name="about_package[]" class="summernote about_package"></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-sm-2">


                  <a href="javaScript:void(0)" class="addmore_customer btn-addmore"><span class="addcnt"><img src="/backend/assets/img/add.png" width="24px"> Add More</span></a>
                </div>
                
                <div class="col-md-12">
                    <hr class="grey" />
                </div>
              </div>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.4/tinymce.min.js" referrerpolicy="origin"></script> -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.summernote').summernote({
        height: 300
    });


        $(".addmore_customer").click(function(){

            //$("#vendorDiv").clone().insertAfter("div.vendorDiv:last");
        
            $block = $("#customerDiv").clone();
            $(".listaddons", $block).remove();
            $(".btn-addmore", $block).html('<span class="addcnt"><img src="/backend/assets/img/delete.png" width="24px"> Remove</span>');
            $(".btn-addmore", $block).addClass('remove_customer').removeClass('addmore_customer');
            //block.children(".addmore_vendor").text("REMOVE");
            $block.find("input").val("");
            $block.find("textarea").val("");
            $block.find(".about_package").val("");
            $block.insertAfter("div.customerDiv:last");
            
        });


        $("body").on("click",".remove_customer",function(e){
          
          $(this).parents('.customerDiv').remove();

          var id = $(this).data("id");
          var token = $("meta[name='csrf-token']").attr("content");
       

        });




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