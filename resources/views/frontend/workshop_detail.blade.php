@extends('layouts.frontend')

@section('styles')
<link href="/frontend/assets/css/flexslider.css" rel="stylesheet" />

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
              <li><a href="{{ route('workshops') }}">Workshops</a></li>
              <li>{{ $workshop->title ?? "" }}</li>
            </ul>
          </div>
        </div>
      </section>

      <section class="py-3 py-md-4 py-lg-5 wrkShp_sngl_Wrp">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 ">

          <div class="row">
            <div class="col-lg-6 d-flex mb-3 mb-lg-0">

              <div class="slider_of_wrokSp w-100">
                <div id="slider" class="flexslider sliderFull">
                  <ul class="slides gallery" id="lightgallery">
                    @foreach($workshop->photos as $key => $media)
                    <li data-src="/frontend/assets/images/slider_01.png">
                      <a href="" data-lightbox="img-set-light"> <img src="{{ $media->getUrl() }}" /></a>
                    </li>
                    @endforeach
                    <!-- <li data-src="/frontend/assets/images/slider_02.png">
                      <a href="" data-lightbox="img-set-light"> <img src="/frontend/assets/images/slider_02.png" /></a>
                    </li>
                    <li data-src="/frontend/assets/images/slider_03.png">
                      <a href="" data-lightbox="img-set-light"> <img src="/frontend/assets/images/slider_03.png" /></a>
                    </li>
                    <li data-src="/frontend/assets/images/slider_04.png">
                      <a href="" data-lightbox="img-set-light"> <img src="/frontend/assets/images/slider_04.png" /></a>
                    </li>

                    <li data-src="/frontend/assets/images/slider_01.png">
                      <a href="" data-lightbox="img-set-light"> <img src="/frontend/assets/images/slider_01.png" /></a>
                    </li>
                    <li data-src="/frontend/assets/images/slider_02.png">
                      <a href="" data-lightbox="img-set-light"> <img src="/frontend/assets/images/slider_02.png" /></a>
                    </li>
                    <li data-src="/frontend/assets/images/slider_03.png">
                      <a href="" data-lightbox="img-set-light"> <img src="/frontend/assets/images/slider_03.png" /></a>
                    </li>
                    <li data-src="/frontend/assets/images/slider_04.png">
                      <a href="" data-lightbox="img-set-light"> <img src="/frontend/assets/images/slider_04.png" /></a>
                    </li> -->
                  </ul>
                </div>

                <div class="the_minor_carosl">
                  <div id="carousel" class="flexslider slideMinorHolder">
                    <ul class="slides slideMinor">
                      @foreach($workshop->photos as $key => $media)
                      <li>
                        <img src="{{ $media->getUrl('thumb') }}" />
                      </li>
                      @endforeach
                      <!-- <li>
                        <img src="/frontend/assets/images/slider_02_thumb.png" />
                      </li>
                      <li>
                        <img src="/frontend/assets/images/slider_03_thumb.png" />
                      </li>
                      <li>
                        <img src="/frontend/assets/images/slider_04_thumb.png" />
                      </li>
                      <li>
                        <img src="/frontend/assets/images/slider_01_thumb.png" />
                      </li>
                      <li>
                        <img src="/frontend/assets/images/slider_02_thumb.png" />
                      </li>
                      <li>
                        <img src="/frontend/assets/images/slider_03_thumb.png" />
                      </li>
                      <li>
                        <img src="/frontend/assets/images/slider_04_thumb.png" />
                      </li> -->
                    </ul>
                  </div>

                </div>




              </div>
            </div>
            @php
            $discount_perc=0;
            if($workshop->discount_price > 0) {
            $discount_perc=round(($workshop->selling_price - $workshop->discount_price)/$workshop->selling_price*100);
            }
            $number = preg_replace('/\D/', '', $workshop->short_title);
            $duration = 60*$number;
            @endphp
            <div class="col-lg-6 d-flex">
              <div class="wrKshp_insdR">
                <div class="mb-4">
                  <h4 class="home_service_header ">{{ $workshop->title ?? "" }}</h4>
                </div>
                <div class="wrKshp_insdR_02">
                  <p>{{ $workshop->short_title ?? "" }}</p>
                </div>
                <div class="d-block workactual ">
                  <h5 class="workactual_tax">Total(excl. vat)</h5>
                  @if($discount_perc > 0)
                  @php
                  $price = $workshop->discount_price;
                  @endphp
                  <h4 class="workactual_price">{{$workshop->discount_price ?? ''}} AED<small>AED {{$workshop->selling_price ?? ''}}</small></h4>
                  @else
                  @php
                  $price = $workshop->selling_price;
                  @endphp
                  <h4 class="workactual_price">{{$workshop->selling_price ?? ''}} AED</h4>
                  @endif
                </div>
                <div class="d-flex mt-3 mt-md-4 mt-lg-5">
                  <a href="#" class="pacKgz_add_ToCart wsp-add-to-cart openTSmodal" data-id="{{$workshop->id ?? ''}}" data-title="Workshop - {{ $workshop->title ?? '' }}" data-totprice="{{ $price ?? '' }}" data-type="workshop" data-duration="{{ $duration ?? '' }}">Add to Cart</a>
                  <a id="{{ $workshop->id }}" onclick="addToWishList(this.id,'workshop')" class="add_Towish "> <!-- use active class for fav -->
                    <i class="icon-fav"></i>
                    <i class="icon-fav_outline"></i>
                    <span>Add to Wishlist</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section>

      <section class="py-3 py-md-4 py-lg-5">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 ">
          <div class="row">
            @if($workshop->about_course)
            <div class="col-md-6 d-flex">
              <div class="wrksngle_dtlz">
                <div class="d-block mb-3 mb-md-4">
                  <h4 class="wrksngle_dtlz_small">About Course</h4>
                </div>
                <p>{!! $workshop->about_course ?? "" !!}</p>
              </div>
            </div>
            @endif
            <div class="col-md-1 d-flex"></div>
            @if($workshop->cover)
            <div class="col-md-5 d-flex">
              <div class="wrksngle_dtlz">
                <div class="d-block mb-3 mb-md-4">
                  <h4 class="wrksngle_dtlz_small">This workshop will cover:</h4>
                </div>
                {!! $workshop->cover ?? "" !!}
                <!-- <ul>
                  <li>How cameras work</li>
                  <li>Camera controls and functions Lenses</li>
                  <li>Filters & Accessories</li>
                  <li>The importance of lightUsing shutter speed to control motion</li>
                  <li>Using aperture to control depth of field</li>
                  <li>White balance</li>
                  <li>Basic composition techniques</li>
                </ul> -->
              </div>
            </div>
            @endif
          </div>
        </div>
      </section>
      

      @if($workshop->notes)
      <section class="pb-3 pb-md-4 pb-lg-5">
        <div class="container cMN_wTh pb-3 pb-md-4 pb-lg-5 ">
          <div class="wrksngle_dtlzNotz">
            <div class="row">
              <div class="col-md-12 d-flex">
                <div class="d-block mb-3 mb-md-4">
                  <h4 class="wrksngle_dtlz_small">Note</h4>
                </div>

              </div>
              <div class="col-md-3 d-flex mb-3 mb-md-0">
                <div class="my-auto wrksngle_dtlzNotz_Icn">
                  <i class="icon-note"></i>
                </div>
              </div>
              <div class="col-md-9 d-flex">
                <div class="d-block my-auto wrksngle_dtlzNotz_Dtl">
                  <p>{!! $workshop->notes ?? "" !!}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      @endif

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
                <h4 class="popupTitle">Title </h4>
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
                <div id="timeslot-container"></div>

              </div>

              <div class="w-100 mt-auto mb-0 d-flex">
                <div class="my-auto date_result_aed">
                  <h4>AED <span class="popupTotalPrice">0</span></h4>
                </div>
                <div class="d-flex my-auto me-0 ms-auto">
                  <input type="hidden" id="selected_date" value="{{ date('Y-m-d')}}">
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
<script src="/frontend/assets/js/jquery.flexslider-min.js"></script>
<script>

  $.ajaxSetup({
      headers:{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
  })

  $(document).on('click', '.openTSmodal', function(e) {

    e.preventDefault();
    var pkgId = $(this).data('id');
    var title = $(this).data('title');
    var pkgType = $(this).data('type');
    var duration = $(this).data('duration');
    var totprice = parseInt($(this).data('totprice'));

    console.log('pkgType - '+pkgType);
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
    var duration = $(this).data('mduration');
    var totprice = parseInt($(this).data('mtotprice'));

    var selected_date = $('#selected_date').val();
    var selected_time = $('#selected_time').val();

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
              pkg_type:pkgType, totprice:totprice, selected_time:selected_time, selected_date:selected_date, duration:duration
          },
          url: "/cart/workshop/store/"+pkgId,
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

  /// Start Add To Cart Prodcut 
  /*$(document).on('click', '.wsp-add-to-cart', function(e) {
    e.preventDefault();
    var pkgId = $(this).data('id');
    var pkgType = $(this).data('type');
    var totprice = $(this).data('totprice');
    var addonid = 0;
    var optionid = 0;
      
    $.ajax({
        type: "POST",
        dataType : 'json',
        data:{
            pkg_type:pkgType, option_id:optionid, addon_id:addonid, totprice:totprice
        },
        url: "/cart/servicepackage/store/"+pkgId,
        success:function(data){
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
     });
  });*/
  /// End Add To Cart Prodcut 

      

  function addToWishList(product_id,pkgType){
    @auth
    @if(Auth::user()->type == 'customer')
      $.ajax({
          type: "POST",
          dataType: 'json',
          data:{
              pkg_type:pkgType
          },
          url: "/add-to-wishlist/"+product_id,
          success:function(data){
               // Start Message 
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
        // End Message  
          }
      })
    @endif
    @else
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Please Login!',
      footer: '<a href="/login">Click Here To Login</a>'
    })
          
    @endif
  }

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
        disable: [
          function(date) {
            // Disable all days except Saturdays
            return date.getDay() !== 6;
          }
        ],
        enable: [
          function(date) {
            // Enable only Saturdays
            return date.getDay() === 6;
          }
        ],
        onChange: function (selectedDates, dateStr, instance) {
          $('#tsdiv').data('mselDate',dateStr);
          console.log(dateStr);
          $('#selected_date').val(dateStr);
          //endpicker.set("minDate", dateStr);
          const dateParts = dateStr.split("-");

          $("#clnDr_day").text(dateParts[2]);
          $("#clnDr_month").text(dateParts[1]);
          $("#clnDr_year").text(dateParts[0]);

          var selectedDate = dateStr;
          getBookedSlots(selectedDate);
          //generateTimeSlots();
        },
        onReady: function(selectedDates, dateStr) {
          console.log('onready'+selectedDates);
            var selectedDate = dateStr;
            getBookedSlots(selectedDate);
        },
        disable: [
            function(date) {
                // Disable Sundays (Sunday is represented by 0 in JavaScript's getDay())
                return date.getDay() === 0;
            }
        ]
      });

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
          var timeslotContainer = document.getElementById("timeslot-container");
          timeslotContainer.innerHTML = "";
          @php
          $shop_open = isset($settings['shop_open']) ? $settings['shop_open'] : '09:00';
          $shop_close = isset($settings['shop_close']) ? $settings['shop_close'] : '17:30';
          @endphp
          var startTime = new Date();
          startTime.setHours(10, 0, 0); // Set start time to 10:00 AM
          var endTime = new Date();
          endTime.setHours(17, 0, 0); // Set end time to 5:00 PM
          var timeSlotDuration = 30; // Time slot duration in minutes
          var duration = $('#tsdiv').data('mduration');
          console.log('Duration : '+duration);
          
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

              if (isBooked) {
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

      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemMargin: 10,
        asNavFor: '#slider',
      });

      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel",
        start: function (slider) {
          $('body').removeClass('loading');
        }
      });


    });


  </script>

@endsection    