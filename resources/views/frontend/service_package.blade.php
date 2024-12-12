@extends('layouts.frontend')

@section('styles')
<style>
/* Style for the time slot buttons */
#timeslot-container button {
    padding: 8px 16px;
    background-color: #eee;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin: 4px;
    cursor: pointer;
    font-size: 14px;
}

#timeslot-container button:hover {
    background-color: #ddd;
}

.selected-slot {
  background-color: #3a1d1d !important;
  color: red;
  font-weight: bold;
}

.loader {
  border: 8px solid #f3f3f3;
  border-top: 8px solid #3498db;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
  margin: 20px auto;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
@endsection 

@section('content')

<section class="py-3 ">
        <div class="container cMN_wTh py-3">
          <div class="bread_crumz">
            <button class="my-auto home_btn_crum">
              <i class="icon-menu"></i>
            </button>
            <ul>
              <li><a href="{{ route('services') }}">Services</a></li>
              <li>{{ $service->title ?? '' }}</li>
            </ul>
          </div>
        </div>
      </section>

      <section class="">
        <div class="container cMN_wTh pb-3 pb-md-4 pb-lg-5 ">
          <div class="row mb-3 mb-md-4 mb-lg-4">
            <div class="col-lg-6 d-flex">
              <div class="service_pack_L">
                <figure>
                  <img src="{{ isset($service->main_image) ? asset($service->main_image) : '/upload/no_image.jpg'}}">
                </figure>
              </div>
            </div>
            <div class="col-lg-6 d-flex">
              <div class="service_pack_R">

                <h4 class="home_service_header">{{ $service->title ?? '' }}</h4>

                <!-- <p>{{ $service->short_title ?? '' }}</p> -->

                <div class="d-flex flex-column">
                  <div  id="collapseService">
                    <div class="bdy_ofclPz">
                      <p>{!! $service->short_title ?? '' !!}</p>
                    </div>

                    <div class="d-flex w-100 flex-column mt-3 more_shadow">

                    <button class="more_btn  mx-auto" type="button">
                      <span class="toShow">Show less</span>
                      <span class="toHide">Readmore</span>
                      <i class="icon-arrow_down"></i>
                    </button>
                  </div>


                  </div>
                  


                </div>
              </div>
            </div>
          </div>


          <div class="row">
            @foreach($service->photos as $key => $media)
            <div class="col-lg-3 col-md-4 col-sm-6 d-flex col-6">
              <div class="echPrtRt">
                <figure>
                  <img src="{{ $media->getUrl() }}">
                </figure>
              </div>
            </div>
            @endforeach
            <!-- <div class="col-lg-3 col-md-4 col-sm-6 d-flex col-6">
              <div class="echPrtRt">
                <figure>
                  <img src="/frontend/assets/images/portait_02.png">
                </figure>
              </div>
            </div>


            <div class="col-lg-3 col-md-4 col-sm-6 d-flex col-6">
              <div class="echPrtRt">
                <figure>
                  <img src="/frontend/assets/images/portait_03.png">
                </figure>
              </div>
            </div>


            <div class="col-lg-3 col-md-4 col-sm-6 d-flex col-6">
              <div class="echPrtRt">
                <figure>
                  <img src="/frontend/assets/images/portait_04.png">
                </figure>
              </div>
            </div> -->

            <div class="col-sm-12 d-flex pt-3 ">
              @if($service->portfolio_url)
              <a href="{{url('portfolio/'.$service->portfolio_url)}}" class="button_e mx-auto"><span>View Portfolio</span><i class="icon-image"></i></a>
              @else 
              <a href="{{url('portfolio/'.$service->slug)}}" class="button_e mx-auto"><span>View Portfolio</span><i class="icon-image"></i></a>
              @endif
            </div>
          </div>
        </div>
      </section>


      <section class="pacKgz_Wrp
       py-3 py-md-4 py-lg-5 ">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 ">
          <div class="row">

            <div class="col-md-12 pb-3 pb-md-4 pb-lg-5">
              <h4 class="home_service_header">Packages</h4>
            </div>

            @php
            $packages = App\Models\ServicePackages::where('service_id',$service->id)->orderBy('id','ASC')->get();
            @endphp
            @if(count($packages) > 0)
            @foreach($packages as $key => $package)
            <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
              <div class="pacKgz py-3 py-md-4 py-lg-5">
                @if($package->most_liked == 1)
                <div class="pacKgz_info">
                  <h5>Most liked</h5>
                </div>
                @endif
                <h4 class="home_service_header">{{ $package->package_name ?? '' }}</h4>


                <div class="pacKgz_list mt-2 mt-sm-3 pt-2 pt-md-3 pt-md-4">
                  {!! $package->about_package ?? '' !!}
                </div>

                @if(count($package->packageoptions)>0)
                <div class="pacKgz_pricing">
                  <select class="packag_drop">
                    <option data-place="Select Option" data-price="">A</option>
                    @foreach($package->packageoptions as $options)
                    <option data-seloptionid="{{$options->id ?? ''}}" data-pkgid="{{$package->id ?? ''}}" data-amount="{{$options->option_price ?? ''}}" data-place="{{$options->option_name ?? ''}}" data-price="{{$options->option_price ?? ''}} AED">A</option>
                    @endforeach
                    <!-- <option data-place="outdoor" data-price="200 AED">B</option>
                    <option data-place="indoor and outdoor" data-price="300 AED">C</option> -->
                  </select>
                </div>
                @endif
                @if(count($package->packageaddons)>0)
                <div class="pacKgz_addonzz">
                  <select class="packag_addonz updateaddon" multiple="multiple">
                    @foreach($package->packageaddons as $addons)
                    <option data-pkgid="{{$package->id ?? ''}}" data-amount="{{$addons->addon_price ?? ''}}" data-place="{{$addons->addon_name ?? ''}}" data-price="{{$addons->addon_price ?? ''}} AED" value="{{$addons->id ?? ''}}">{{$addons->id ?? ''}}</option>
                    @endforeach
                    <!-- <option data-place="Professional Makeup Optional (Extra) 1 look" data-price="200 AED" value="a2">a2
                    </option>
                    <option data-place="Professional Makeup Optional (Extra) 1 look" data-price="300 AED" value="a3">a3
                    </option> -->
                  </select>
                  <div class="pacKgz_addonzz_placeHldr">
                    <h5>Addons <small>(optional)</small></h5>
                  </div>
                  <div class="adnSelecTd">

                  </div>
                </div>
                @endif

                <div class="pacKgz_add_To">
                  <div class="pacKgz_add_ToTxt">
                    <h5 class="pacKgz_add_ToTxt_tax">Total(excl. vat)</h5>
                    <input type="hidden" id="option_price_{{$package->id ?? ''}}" value="">
                    <input type="hidden" id="addon_price_{{$package->id ?? ''}}" value="">
                    <input type="hidden" id="pkg_price_{{$package->id ?? ''}}" value="{{ $package->price ?? '' }}">
                    <input type="hidden" id="final_price_{{$package->id ?? ''}}" value="">
                    <h4 class="pacKgz_add_ToTxt_price"><span id="totPrice{{$package->id ?? ''}}">{{ $package->price ?? '' }}</span> AED</h4>
                  </div>

     
                  <button type="submit" id="add-to-cart_{{$package->id ?? ''}}" class="button openTSmodal pacKgz_add_ToCart" data-id="{{$package->id ?? ''}}" data-addonid="" data-optionid="" data-totprice="{{ $package->price ?? '' }}" data-title="{{ $service->title ?? '' }} - {{ $package->package_name ?? '' }}" data-type="service" data-duration="{{ $package->duration ?? '' }}">Add to Cart</button>
                  <!-- <a href="#" class="pacKgz_add_ToCart">Add to Cart</a> -->
                </div>


              </div>
            </div>
            @endforeach
            @endif
            


          </div>
        </div>
      </section>

@endsection     

@section('modal')
<!-- Modal -->
<div class="modal fade" id="clndRModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-body position-relative">

        <button type="button" class="btn-close mdl_to_Be_Clzd" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="row mx-0">
          <div class="col-md-8 d-flex px-0">
            <div class="clndr_hlD">
              <div class="clndr_hlD_name">
                <h4 class="popupTitle">Business Portraits - Gold </h4>
              </div>
              <input class="pickUpDate">
            </div>
          </div>
          <div class="col-md-4 d-flex px-0">
            <div class="date_row_Reslt">
              <div class="flex-fill">

                <div class="date_row_Select d-flex">
                  <h4 id="clnDr_day">{{ date('d')}}</h4>
                  <div class="d-flex flex-column my-auto">
                    <h5 id="clnDr_month">{{ date('M')}}</h5>
                    <h5 id="clnDr_year">{{ date('Y')}}</h5>
                  </div>
                </div>

                <div class="time_row_Select">
                  <h4>Select your time</h4>
                </div>
                <div id="loader" class="loader"></div>
                <div id="timeslot-container"></div>
                

              </div>

              <div class="w-100 mt-auto mb-0 d-flex">
                <div class="my-auto date_result_aed">
                  <h4>AED <span class="popupTotalPrice">0</span></h4>
                </div>
                <div class="d-flex my-auto me-0 ms-auto">
                  <input type="hidden" id="selected_date" value="">
                  <input type="hidden" id="selected_time" value="">
                  <button id="tsdiv" data-mpkgId="" data-mpkgType="" data-moptionid="" data-maddonid="" data-mtotprice="" data-mselDate=""  data-mduration="" class="btN_a add-to-cart">Add to Cart </button>
                </div>
              </div>

            </div>

          </div>
        </div>



      </div>

    </div>
  </div>
</div>
@endsection  

@section('scripts')

<script>

  $.ajaxSetup({
      headers:{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
  });

  $(document).on('click', '.openTSmodal', function(e) {

    e.preventDefault();
    var pkgId = $(this).data('id');
    var title = $(this).data('title');
    var pkgType = $(this).data('type');
    var addonid = $(this).data('addonid');
    var optionid = $(this).data('optionid');
    var duration = $(this).data('duration');
    var totprice = parseInt($(this).data('totprice'));

    if (addonid == null) {
        addonid = 0;
    }
    if (optionid == null) {
        optionid = 0;
    }
    console.log('pkgType - '+pkgType);
    console.log('addonid - '+addonid);
    console.log('optionid - '+optionid);
    console.log('totprice - '+totprice);

    // var id = $('#product_id').val();
    // var option_id = $('#option_id').val();
    // var addon_id = $('#addon_id').val();
    if(totprice > 0) {

      $("#clndRModal").modal("show");
      $('.popupTitle').text(title);
      $('.popupTotalPrice').text(totprice);
      
      $('#tsdiv').data('mpkgId',pkgId);
      $('#tsdiv').data('mpkgType',pkgType);
      $('#tsdiv').data('moptionid',optionid);
      $('#tsdiv').data('maddonid',addonid);
      $('#tsdiv').data('mtotprice',totprice);
      $('#tsdiv').data('mduration',duration);

     } else {
        Swal.fire('Choose any option or addons!');
      }
  });

  /// Start Add To Cart Prodcut 
  $(document).on('click', '.add-to-cart', function(e) {

    

    e.preventDefault();
    var pkgId = $(this).data('mpkgId');
    var pkgType = $(this).data('mpkgType');
    var addonid = $(this).data('maddonid');
    var optionid = $(this).data('moptionid');
    var duration = $(this).data('mduration');
    var totprice = parseInt($(this).data('mtotprice'));

    if (addonid == null) {
        addonid = 0;
    }
    if (optionid == null) {
        optionid = 0;
    }
    //var servicetimeValue = $('input[name="servicetime"]:checked').val();;
    //var servicedateValue = $(this).data('mselDate');

    var selected_date = $('#selected_date').val();
    var selected_time = $('#selected_time').val();

    //console.log('servicetimeValue - '+servicetimeValue);
    //console.log('servicedateValue - '+servicedateValue);

    console.log('pkgType - '+pkgType);
    console.log('addonid - '+addonid);
    console.log('optionid - '+optionid);
    console.log('totprice - '+totprice);
    console.log('selected_date - '+selected_date);
    console.log('selected_time - '+selected_time);

    // var id = $('#product_id').val();
    // var option_id = $('#option_id').val();
    // var addon_id = $('#addon_id').val();
    if(selected_date === null || selected_date === "" || selected_date === undefined || selected_time === null || selected_time === "" || selected_time === undefined) {

      if(selected_date === "" && selected_time != "") {
        Swal.fire('Select date!');
      }
      else if(selected_date != "" && selected_time === "") {
        Swal.fire('Select time!');
      } else {
        Swal.fire('Select date and time!');
      }
      

    } else {

      $.ajax({
          type: "POST",
          dataType : 'json',
          data:{
              pkg_type:pkgType, option_id:optionid, addon_id:addonid, totprice:totprice, selected_time:selected_time, selected_date:selected_date, duration:duration
          },
          url: "/cart/servicepackage/store/"+pkgId,
          success:function(data){
            if (data.exists == true) {
              //alert("The selected date and time already exist in the database.");
              Swal.fire(data.error);
            } else {
              $('#cartQty').text(data.cartQty);
              const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success', 
                    showConfirmButton: false,
                    timer: 3000 
              })
              if ($.isEmptyObject(data.error)) {
                      
                      Toast.fire({
                      type: 'success',
                      title: data.success, 
                      })
              }else{
                 
                Toast.fire({
                      type: 'error',
                      title: data.error, 
                      })
              }
            }
          }
       });

    }


  });
  /// End Add To Cart Prodcut 


  function getCurrentDate() {
    var today = new Date();
    var day = today.getDate();
    var month = today.getMonth() + 1; // Months are zero-based
    var year = today.getFullYear();

    // Ensure leading zeros for single digits
    day = day < 10 ? '0' + day : day;
    month = month < 10 ? '0' + month : month;

    return year + '-' + month + '-' + day;
  }



    $(document).ready(function () {

      // sal();
      sal({
        threshold: 0.05,
      });


      // Get the current date
      var currentDate = getCurrentDate();


      let startpicker = flatpickr(".pickUpDate", {
        minDate: new Date(),
        enableTime: false, 
        inline: true,
        dateFormat: "Y-m-d",
        onChange: function (selectedDates, dateStr, instance) {
          $('#tsdiv').data('mselDate',dateStr);
          console.log('onChange - '+dateStr);
          $('#selected_date').val(dateStr);
          //endpicker.set("minDate", dateStr);
          const dateParts = dateStr.split("-");

          $("#clnDr_day").text(dateParts[2]);
          $("#clnDr_month").text(dateParts[1]);
          $("#clnDr_year").text(dateParts[0]);

          var selectedDate = dateStr;
          showLoader();
          //setTimeout(function() {
            getBookedSlots(selectedDate);
            hideLoader();
          //}, 2000);
          //generateTimeSlots();
        },
        onReady: function(selectedDates, dateStr) {
          console.log('onready - '+selectedDates);
            var selectedDate = formatDate(new Date());
            showLoader();
            
              getBookedSlots(selectedDate);
              hideLoader();
            
        },
        onOpen: function (selectedDates, dateStr, instance) {
          var selectedDate = formatDate(new Date());
          showLoader();
          console.log('onOpen - '+selectedDate);
          
            getBookedSlots(selectedDate);
            hideLoader();
          
        },
        disable: [
            function(date) {
                // Disable Sundays (Sunday is represented by 0 in JavaScript's getDay())
                return date.getDay() === 0;
            }
        ]
      });

      function formatDate(date) {
        var year = date.getFullYear();
        var month = ('0' + (date.getMonth() + 1)).slice(-2);
        var day = ('0' + date.getDate()).slice(-2);
        return year + '-' + month + '-' + day;
      }

      function getBookedSlots(selectedDate) {
          var xhr = new XMLHttpRequest();
          var url = "{{ route('get-booked-slots') }}";

          xhr.onreadystatechange = function() {
              if (xhr.readyState === XMLHttpRequest.DONE) {
                  if (xhr.status === 200) {
                      var bookedSlots = JSON.parse(xhr.responseText);
                      
                      generateTimeSlots(selectedDate, bookedSlots);
                  } else {
                      console.log("Error: " + xhr.status);
                  }
              }
          };

          xhr.open("GET", url + "?selectedDate=" + selectedDate);
          xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
          xhr.send();
      }

      function generateTimeSlots(selectedDate, bookedSlots) {

          // Show loader while generating time slots
          //showLoader();

          var timeslotContainer = document.getElementById("timeslot-container");
          timeslotContainer.innerHTML = "";

          var currentTime = new Date(); // Get the current time
          var startTime = new Date(selectedDate);
          startTime.setHours(10, 0, 0); // Set start time to 10:00 AM
          var endTime = new Date(selectedDate);
          endTime.setHours(17, 0, 0); // Set end time to 5:00 PM
          var timeSlotDuration = 30; // Time slot duration in minutes
          var duration = $('#tsdiv').data('mduration');
          console.log('Duration: ' + duration);
          
          var formatOptions = {
            hour: 'numeric',
            minute: 'numeric',
            hour12: false
          };

          while (startTime < endTime) {
              var timeSlotButton = document.createElement("button");
              timeSlotButton.type = "button";
              timeSlotButton.innerHTML = startTime.toLocaleTimeString([], formatOptions);
              timeSlotButton.classList.add("timeslot-button");

              var slotTime = startTime.toLocaleTimeString([], formatOptions);
              var isBooked = isTimeSlotBooked(selectedDate, slotTime, duration, bookedSlots);

              if (currentTime > startTime) {
                timeSlotButton.classList.add("disabled");
                timeSlotButton.disabled = true;
              } else if (isBooked) {
                  timeSlotButton.classList.add("disabled");
                  timeSlotButton.disabled = true;
              } else {
                  timeSlotButton.addEventListener("click", function() {

                      var buttons = document.querySelectorAll('#timeslot-container button');
                      buttons.forEach(function(button) {
                        button.addEventListener('click', function() {
                          // Remove 'selected-slot' class from all buttons
                          buttons.forEach(function(button) {
                            button.classList.remove('selected-slot');
                          });
                          // Add 'selected-slot' class to the currently clicked button
                          this.classList.add('selected-slot');
                        });
                      });

                      // Handle time slot selection here
                      var selectedTime = this.innerHTML;
                      var selectedDateTime = selectedDate + " " + selectedTime;
                      console.log("Selected Date and Time:", selectedDateTime);
                      $('#selected_time').val(selectedTime);

                      this.classList.add('selected-slot');
                  });
              }

              timeslotContainer.appendChild(timeSlotButton);
              
              startTime.setMinutes(startTime.getMinutes() + timeSlotDuration);
              
          }

          // Hide loader when time slots are generated
          //hideLoader();
      }

      function showLoader() {
        // Add code to display a loading spinner or message
        var loader = document.getElementById("loader");
        loader.style.display = "block";
      }

      function hideLoader() {
        // Add code to hide the loading spinner or message
        var loader = document.getElementById("loader");
        loader.style.display = "none";
      }

      function isTimeSlotBooked(selectedDate, selectedTime, duration, bookedSlots) {
          var selectedDateTime = new Date(selectedDate + ' ' + selectedTime);
          var selectedEndTime = new Date(selectedDateTime.getTime() + duration * 60000); // Convert duration to milliseconds

          for (var i = 0; i < bookedSlots.length; i++) {
              var bookedStartDate = new Date(bookedSlots[i].booked_date + ' ' + bookedSlots[i].booked_stime);
              var bookedEndDate = new Date(bookedSlots[i].booked_date + ' ' + bookedSlots[i].booked_etime);

              // Check if the selected time slot overlaps with a booked time slot
              if (selectedDateTime < bookedEndDate && selectedEndTime > bookedStartDate) {
                  return true;
              }
          }

          return false;
      }


      var defaultConfig = {
        weekDayLength: 1,
        date: new Date(),
        disable: function (date) {
          return date < new Date().setHours(0, 0, 0, 0);
        },
        showTodayButton: false,
        onClickDate: selectDate,
        showYearDropdown: true,
        startOnMonday: false,
        prevButton: "<i class='icon-chev_lt'></i>",
        nextButton: "<i class='icon-chev_rt'></i>",
      };

      const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

      //$('.calendar-container').calendar(defaultConfig);


      //  $('#calender_wrap').calenderPicker(function (eve) {
      // $('#dates').val(eve);
      //  });


      function selectDate(date) {
        var dt = new Date(date);
        $('#choosedDate').text(months[dt.getMonth()] + " " + dt.getDate());
        if (document.getElementById("posT4")) {
          $("#samPleClctn04").text(months[dt.getMonth()] + " " + dt.getDate());
        }
        $('.calendar-container').updateCalendarOptions({
          date: date
        });
      }

      


$(".time_row input:checkbox").on('click', function () {
  var $box = $(this);
  var os_checked = $box.attr("value");
  $('#selected_time').val(os_checked);
  var selected_date = $('#selected_date').val();
  console.log(selected_date);
  console.log(os_checked);

  if ($box.is(":checked")) {
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
    checked = $(".time_row input[type=checkbox]:checked").length;
    if (!checked) {
      return false;
    }
  }



});





      $(".packag_drop").select2({
        templateSelection: iformat,
        templateResult: iformat,
        placeholder: "Choose",
        dropdownCssClass: "dropperDown",
      });

      $('.packag_drop').on('change', function() {
        // Get the selected option's price attribute
        var optionprice = $(this).find(':selected').data('amount');
        var pkgid = $(this).find(':selected').data('pkgid');
        var seloptionid = $(this).find(':selected').data('seloptionid');
        $('#add-to-cart_'+pkgid).data('optionid', seloptionid);

        // Update the price in the DOM
        var option_price = parseInt(optionprice);
        if(isNaN(option_price)) {
          option_price = 0;
        }
        console.log('option_price - '+option_price);

        var addon_price = parseInt($('#addon_price_'+pkgid).val());
        if(isNaN(addon_price)) {
          addon_price = 0;
        }
        console.log('addon_price - '+addon_price);

        var pkg_price = parseInt($('#pkg_price_'+pkgid).val());
        if(isNaN(pkg_price)) {
          pkg_price = 0;
        }
        console.log('pkg_price - '+pkg_price);

        var result = option_price + addon_price + pkg_price;
        console.log('updateaddon - '+result);

        $('#option_price_'+pkgid).val(option_price);
        $('#addon_price_'+pkgid).val(addon_price);
        $('#final_price_'+pkgid).val(result);

        $('#totPrice'+pkgid).text(result);

        $('#add-to-cart_'+pkgid).data('totprice', result);
      });

  

      function iformat(icon) {
        var originalOption = icon.element;
        var originalOptionPlace = $(originalOption).data('place');
        var originalOptionPrice = $(originalOption).data('price');

        // return $('<h5 class=""><span>' + originalOptionPlace + '</span>' + icon.text + '<span class="badge1">' + originalOptionPrice + '</span></h5>');
        return $('<h5 class="d-flex"><span class="ms-0 me-auto txTSml">' + originalOptionPlace + '</span><span class="ms-auto me-0 txTHg">' + originalOptionPrice + '</span></h5>');
      }


      $(".packag_addonz").select2({
        templateSelection: iformat,
        templateResult: iformat,
        dropdownCssClass: "dropperDownAdnz",
      });

      $('.packag_addonz').on('select2:select', function (e) {
        var selectedItem = e.params.data;
        var selectedItemValue = e.params.data.id;
        // var selectedItemTemplate = e.params.data.element.dataset.template;
        var selectedItemTemplatePlace = e.params.data.element.dataset.place;
        var selectedItemTemplatePrice = e.params.data.element.dataset.price;
        var selectedItemAmount = e.params.data.element.dataset.amount;
        var selectedItemPkgId = e.params.data.element.dataset.pkgid;
        console.log("select2:select", e);
        // console.log('Selected Item:', selectedItem);
        //  console.log('Selected Item Template:', selectedItemTemplate);
        // console.log(selectedItemTemplate);
        //$(this).parent().find(".adnSelecTd").attr("pp", "pp");
        $(this).parent().find(".adnSelecTd").append('<div class="d-flex echSlctd_adN"><span class="ms-0 me-auto txTAdn">' +
          selectedItemTemplatePlace + '</span><span class="ms-auto me-0 txTAdnPr">' + selectedItemTemplatePrice + '</span><button type="button" class="delete_it" data-value=' + selectedItemValue + ' data-amount=' + selectedItemAmount + ' data-pkgid=' + selectedItemPkgId + '><i class="icon-minus"></i></button></div>');
    
         // Get the selected option's price attribute
         var price = $(this).find(':selected').data('amount');
        var price = selectedItemAmount;
        console.log('price - '+selectedItemAmount);
        console.log('price - '+price);
        var pkgid = $(this).find(':selected').data('pkgid');
        console.log('pkgid - '+pkgid);
        $('#add-to-cart_'+pkgid).data('addonid', selectedItemValue);
        //$(this).closest('.add-to-cart').data('addonid', selectedItemValue);
        console.log('addonid - '+selectedItemValue);

        //$('#option_price_'+pkgid).val(option_price);
        //console.log('option_price_ - '+option_price);
        // Update the price in the DOM

        var option_price = parseInt($('#option_price_'+pkgid).val());
        if(isNaN(option_price)) {
          option_price = 0;
        }
        console.log('option_price - '+option_price);

        var addon_price = parseInt($('#addon_price_'+pkgid).val())+parseInt(price);
        console.log('addon_price - '+addon_price);
        if(isNaN(addon_price)) {
          addon_price = 0;
          addon_price = parseInt(price);
        }
        console.log('addon_price - '+addon_price);

        var pkg_price = parseInt($('#pkg_price_'+pkgid).val());
        if(isNaN(pkg_price)) {
          pkg_price = 0;
        }
        console.log('pkg_price - '+pkg_price);



        var result = option_price + addon_price + pkg_price;
        console.log('updateaddon - '+result);

        $('#option_price_'+pkgid).val(option_price);
        $('#addon_price_'+pkgid).val(addon_price);
        $('#final_price_'+pkgid).val(result);

        $('#totPrice'+pkgid).text(result);

        $('#add-to-cart_'+pkgid).data('totprice', result);

    
      });

      $(document).on("click", ".delete_it", function (event) {
        var valu_ofThe = $(this).attr("data-value");
        var the_current_stay = $(this).parent();
        console.log("select2:select", valu_ofThe);
        $(this).parent().parent().parent().find(".select2  .selection ul li").each(function () {
          console.log($(this).attr('title').trim());
          if ($(this).attr('title').trim() == valu_ofThe) {
            // $(this).find("button").attr("to", "max")
            $(this).find("button").click();
            the_current_stay.remove();
          }
        });

        var price = $(this).attr('data-amount');
        console.log('dprice - '+price);
        var pkgid = $(this).attr('data-pkgid');
        console.log('dpkgid - '+pkgid);
        //var price = $(this).find(':selected').data('amount');
        //var pkgid = $(this).find(':selected').data('pkgid');

        var option_price = parseInt($('#option_price_'+pkgid).val());
        if(isNaN(option_price)) {
          option_price = 0;
        }
        console.log('option_price - '+option_price);

        var addon_price = parseInt($('#addon_price_'+pkgid).val())-parseInt(price);
        if(isNaN(addon_price)) {
          addon_price = 0;
        }
        console.log('addon_price - '+addon_price);

        var pkg_price = parseInt($('#pkg_price_'+pkgid).val());
        if(isNaN(pkg_price)) {
          pkg_price = 0;
        }
        console.log('pkg_price - '+pkg_price);



        var result = option_price + addon_price + pkg_price;
        console.log('updateaddon - '+result);

        $('#option_price_'+pkgid).val(option_price);
        $('#addon_price_'+pkgid).val(addon_price);
        $('#final_price_'+pkgid).val(result);

        $('#totPrice'+pkgid).text(result);

        $('#add-to-cart_'+pkgid).data('totprice', result);

        // $(this).parent().parent().parent().find(".select2  .selection ul li[title='a2              ']").attr("to", "max");
        // $(this).parent().remove();
      });



      /*       $(".packag_addonz").on("select2:select", function (e) { console.log("select2:select", e); });
            $(".packag_addonz").on("select2:unselect", function (e) { console.log("select2:unselect", e); });
      
       */

      //.pacKgz_list
    });


  </script>

@endsection    