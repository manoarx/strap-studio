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
</style>
@endsection 

@section('content')
@php
$banners = App\Models\Banners::where('page','studiorentals')->orderBy('id','ASC')->get();
@endphp
<section class="py-3 py-md-4 py-lg-5 rental_pag_head" style="background-image: url({{ asset($banners[0]->image ?? '/frontend/assets/images/studio_rental_default.png') }});">
  <div class="container cMN_wTh mb-auto py-3 py-md-4 py-lg-5 mt-0">
    <div class="row">
      <div class="col-md-12 d-flex flex-column">
        <h1 class="home_service_header rental_pag_head_txt mx-auto">Studio Rentals</h1>
        <div class="d-flex mx-auto mt-4">
          <a href="#" class="button_c">Book Now</a>
        </div>
      </div>
    </div>
  </div>

  <div class="container cMN_wTh mt-auto py-3 py-md-4 py-lg-5 mb-0">
    <div class="row">
      <div class="rental_pag_OwlBlk mx-auto">

        <div class="owl-carousel owl-theme owlRentlZ">

          @foreach($banners as $banner)
          <div class="rentLZ_each" data-img="{{ asset($banner->image ) }}">
            <figure>
              <img src="{{ asset($banner->thumb_image ) }}">
            </figure>
          </div>
          @endforeach

          <!-- <div class="rentLZ_each" data-img="/frontend/assets/images/rental_full_02.png">
            <figure>
              <img src="/frontend/assets/images/rental_thumb_02.png">
            </figure>
          </div>



          <div class="rentLZ_each" data-img="/frontend/assets/images/rental_full_03.png">
            <figure>
              <img src="/frontend/assets/images/rental_thumb_03.png">
            </figure>
          </div>



          <div class="rentLZ_each" data-img="/frontend/assets/images/rental_full_04.png">
            <figure>
              <img src="/frontend/assets/images/rental_thumb_04.png">
            </figure>
          </div>



          <div class="rentLZ_each" data-img="/frontend/assets/images/rental_full_01.png">
            <figure>
              <img src="/frontend/assets/images/rental_thumb_01.png">
            </figure>
          </div> -->

        </div>

      </div>
    </div>
  </div>

</section>

<section class="py-3 py-md-4 py-lg-5 ">

  <div class="container cMN_wTh  py-3 py-md-4 py-lg-5 ">
    <div class="wrkShop_wrp mx-auto">
      <div class="row">
        <div class="col-md-12 pb-3 pb-md-4 pb-lg-5">
          <h4 class="home_service_header text-center">Studio Rentals</h4>
        </div>
        <div class="col-md-12 wrkShop_wrp_p pb-2  pb-sm-3">
          <div id="collapseService">
                    <div class="bdy_ofclPz">
          <p>{{ $settings['about_studio_rental'] ?? '' }}</p>
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



        <div class="col-12 d-none">
          <div class="d-flex mx-auto">
            <button class="more_btn collapsed">
              <span class="toHide">Readmore</span>
              <i class="icon-arrow_down"></i>
            </button>
          </div>
        </div>


      </div>
    </div>
  </div>

</section>

<section class="py-0 rental_pag_tL_hlDr">
  <div class="container cMN_wTh  py-3 py-md-4 py-lg-5">
    <div class="row">
      <div class="col-md-12">
        <div class="d-flex pb-3 pb-md-4 pb-lg-5">
          <h4 class="home_service_header">Packages</h4>
        </div>
      </div>

      @foreach($studiorentals as $studiorental)
      @php
      $number = preg_replace('/\D/', '', $studiorental->title);
      $duration = 60*$number;
      @endphp
      <div class="col-6 col-sm-6 col-md-4 col-lg-3 d-flex">
        <div class="rental_pag_tL_hlDr_ECh mb-3 mb-md-4 mb-lg-5 px-3 py-3 px-md-4 py-md-4 px-lg-5 py-lg-5 ">
          <div class="mb-3 mb-md-4 mb-lg-5">
            <h4 class="home_service_header">{{ $studiorental->title ?? ''}}</h4>
          </div>
          <div class="mb-3 mb-md-4 rental_pag_tL_hlDr_ECh_Pric">
            <h5>Total(excl. vat)</h5>
            <h4>{{ $studiorental->price ?? ''}} AED</h4>
          </div>
          <div class="d-flex">
            <a href="#" class="button_c openTSmodal" data-id="{{$studiorental->id ?? ''}}" data-title="Studio Rental - {{ $studiorental->title ?? '' }}" data-totprice="{{ $studiorental->price ?? '' }}" data-type="studiorental" data-duration="{{ $duration ?? '' }}">Book Now</a>
          </div>
          @if($studiorental->most_liked)
          <h5 class="_msT_lkD">Most liked</h5>
          @endif
        </div>
      </div>
      @endforeach




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
          url: "/cart/studiorental/store/"+pkgId,
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
 /* $(document).on('click', '.sr-add-to-cart', function(e) {
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





      jQuery(".rentLZ_each").on("click", function (e) {
        var imageUrl = $(this).attr("data-img");
        console.log(imageUrl);
        $(".rental_pag_head").css("background-image", "url('" + imageUrl + "')");
      });





      $('.owlRentlZ').owlCarousel({
        slideTransition: 'linear',
        autoplayTimeout: 2000,
        autoplaySpeed: 2000,
        items: 4,
        loop: true,
        margin: 10,
        autoWidth: false,
        autoplay: false,
        dots: false,
        nav: true,
        navText: ['<i class="icon-chev_left"></i>', '<i class="icon-chev_right"></i>'],
        responsive: {
          0: {
            margin: 5,
            items: 2,
          },
          500: {
            margin: 10,
            items: 3,
          },
          900: {
            margin: 10,
            items: 3,
          },
          1000: {
            margin: 10,
            items: 4,
          },
          1200: {
            margin: 10,
            items: 4,
          },
          1300: {
            margin: 10,
            items: 4,
          }
        }
      });

    });


  </script>

@endsection    

