@extends('layouts.user')
<!-- 
  <link   href="/frontend/assets/xZoom-master/xzoom.css" rel="stylesheet" /> -->
@section('content')
<section class="py-0 py-lg-3 py-xl-4 py-xxl-5">
        <div class="container cMN_wTh">
          <div class="d-flex dash_wrpR">
            <div class="dash_wrpRMenu">
            <button class="dash_wrpRMenu_icon">
              <i class="icon-menu"></i>
            </button>
            </div>
            <div class="dash_baKgrey"></div>
          
          <div class="dash_wrpRLFt">

              <div class="dash_wrpRLFt_A">
                <div class="dash_wrpRLFt_B">
                  <h4 class="dash_wrpRHead">Student</h4>
                </div>

                <div class="dash_wrpRLFt_C  py-3 py-xl-4 py-xxl-5 pe-0 pe-lg-3 pe-xl-4 pe-xxl-5">

                  <div class="dash_wrpRLFt_C_tab">
                    <nav>
                      <div class="nav nav-tabs" id="student-tab" role="tablist">
                        @foreach($userData->student as $students)
                        <button class="nav-link @if($loop->first) active @endif" id="nav-{{ $students->id ?? '' }}-tab" data-bs-toggle="tab"
                          data-bs-target="#nav-{{ $students->id ?? '' }}" type="button" role="tab" aria-controls="nav-{{ $students->id ?? '' }}"
                          aria-selected="true">
                          <h4>{{ $students->student_name ?? '' }} {{ $students->student_last_name ?? '' }}</h4>
                          <span>{{ $students->classe ?? '' }}</span>
                          <i class="icon-arrow_right"></i>
                        </button>
                        @endforeach
                        <!-- <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                          type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                          <h4>Shifa Muhammad </h4>
                          <span>Std VC</span>
                          <i class="icon-arrow_right"></i>
                        </button> -->

                      </div>
                    </nav>
                  </div>

                  <div class="dash_wrpRLFt_C_offer">
                    
                    @foreach($offerbanners as $key => $offerbanner)
                    <div class="dash_wrpRLFt_C_offer_each">
                      <figure>
                        <img src="{{ (!empty($offerbanner->image)) ? asset($offerbanner->image) : url('upload/no_image.jpg') }}">
                      </figure>
                      
                    </div>
                    <h4>{{$offerbanner->name ?? ''}}</h4>
                    <div>&nbsp;</div>
                    @endforeach
                    <!-- <div class="dash_wrpRLFt_C_offer_each">

                      <figure>
                        <img src="/frontend/assets/images/summer sale.png">
                      </figure>

                      <div class="ofr_txt_a">
                        <h4>SUMMER FAMILY PHOTO PACKAGES</h4>
                      </div>
                      <div class="ofr_txt_b">
                        <p>off Up to</p>
                        <h4>20%</h4>
                      </div>
                      <div class="ofr_txt_c">
                        <h4>Use Coupon code <br>GHTREGW</h4>
                      </div>
                    </div> -->

                    <!-- <div class="dash_wrpRLFt_C_offer_each">

                      <figure>
                        <img src="/frontend/assets/images/summer sale.png">
                      </figure>


                      <div class="ofr_txt_a">
                        <h4>SUMMER FAMILY PHOTO PACKAGES</h4>
                      </div>
                      <div class="ofr_txt_b">
                        <p>off Up to</p>
                        <h4>20%</h4>
                      </div>
                      <div class="ofr_txt_c">
                        <h4>Use Coupon code GHTREGW</h4>
                      </div>
                    </div> -->

                  </div>



                </div>

              </div>

            </div>

            <div class="dash_wrpRRIt">
              <div class="dash_wrpRRIt_z_A">
                <div class="dash_wrpRRIt_z_B">
                  <h4 class="dash_wrpRHead">Events</h4>
                </div>

                <div class="dash_wrpRRIt_01 py-3 py-md-4 py-lg-5">

                  <div class="tab-content" id="student-tabContent">
                    @foreach($userData->student as $students)
                    @if(count($students->products) > 0)
                    <div class="tab-pane fade @if($loop->first) show active @endif" id="nav-{{ $students->id ?? '' }}" role="tabpanel" aria-labelledby="nav-{{ $students->id ?? '' }}-tab"
                      tabindex="0">

                      <div class="accordion" id="accordionEventz">
                        @foreach($students->products as $product)
                        <div class="accordion-item">

                          <div id="collapse_{{ $product->id ?? '' }}" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="head_{{ $product->id ?? '' }}"
                            data-bs-parent="#accordionEventz">
                            <div class="accordion-body">

                              <div class="d-flex flex-column">
                                <div class="d-flex w-100">
                                  <div class="acdn_Txt">
                                    <h4>{{ $product->title ?? '' }}</h4>
                                    <p>Added on {{ date("d-m-Y", strtotime($product->created_at)) ?? '' }}</p>
                                  </div>
                                  <!-- <div class="dropdown">
                                    <button class="more_button dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                      aria-expanded="false">
                                      <i class="icon-more"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#">Action</a></li>
                                      <li><a class="dropdown-item" href="#">Another action</a></li>
                                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                  </div> -->
                                </div>


                                <div class="mx-auto the_schlZ_hLdR">

                                  <div class="the_schlZ owl-carousel owl-theme">

                                    @foreach($product->photos as $key => $media)
                                    <div class="the_schlZ_eacH">
                                      <figure>
                                        <img src="{{ $media->getUrl() }}" class="xzoom" data_img="{{ $media->getUrl() }}">
                                      </figure>
                                    </div>
                                    @endforeach

                                    <!-- <div class="the_schlZ_eacH">
                                      <figure>
                                        <img src="/frontend/assets/images/big_img_001.png">
                                      </figure>
                                    </div> -->



                                  </div>
                                </div>

                                <div class="the_schl_Dtl">
                                  {!! $product->desc ?? '' !!}
                                </div>

                              </div>

                              <div class="abr_t">
                                <h4 class="abr_t_taiL">Hard Copy</h4>
                                <h4 class="abr_t_heD my-auto">{{ $product->hard_copy_amount ?? '' }} AED</h4>
                                @if($product->digital_amount > 0)
                                <div><input type="checkbox" id="digitalCheckbox" value="{{ $product->digital_amount ?? '' }}"> {{ $product->digital_title ?? '' }} ( + {{ $product->digital_amount ?? '' }} AED )</div>
                                @endif
                                <div>&nbsp;</div>
                                <div class="d-flex">
                                  
                                  <a href="#1" class="add_tocart my-auto school-add-to-cart" data-id="{{$product->id ?? ''}}" data-totprice="{{ $product->hard_copy_amount ?? '' }}" data-digitalprice="0" data-type="school">Add to Cart</a>
                                </div>
                              </div>


                            </div>


                          </div>

                          <h2 class="accordion-header" id="head_{{ $product->id ?? '' }}">
                            @if($loop->first)
                            <div class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#collapse_{{ $product->id ?? '' }}" aria-expanded="true" aria-controls="collapse_{{ $product->id ?? '' }}">

                              <div class="acdn_Txt">
                                <h4>{{ $product->title ?? '' }}</h4>
                                <p>Added on {{ date("d-m-Y", strtotime($product->created_at)) ?? '' }}</p>
                              </div>


                              <div class="acdn_Img">
                                @foreach($product->photos as $key => $media)
                                <figure>
                                  <img src="{{ $media->getUrl('thumb') }}">
                                </figure>
                                @endforeach
                                <!-- <figure>
                                  <img src="/frontend/assets/images/picz_002.png">
                                </figure> -->
                              </div>

                              <div class="abr_hDe">
                                <h4>Hide Details</h4>
                              </div>

                            </div>
                            @else

                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                              data-bs-target="#collapse_{{ $product->id ?? '' }}" aria-expanded="false" aria-controls="collapse_{{ $product->id ?? '' }}">

                              <div class="acdn_Txt">
                                <h4>{{ $product->title ?? '' }}</h4>
                                <p>Added on {{ date("d-m-Y", strtotime($product->created_at)) ?? '' }}</p>
                              </div>


                              <div class="acdn_Img">
                                @foreach($product->photos as $key => $media)
                                <figure>
                                  <img src="{{ $media->getUrl('thumb') }}">
                                </figure>
                                @endforeach
                                <!-- <figure>
                                  <img src="/frontend/assets/images/picz_002.png">
                                </figure> -->
                              </div>

                              <div class="abr_hDe">
                                <h4>Hide Details</h4>
                              </div>

                            </button>
                            @endif
                          </h2>

                        </div>
                        @endforeach

                      </div>



                    </div>
                    @endif
                    @endforeach
      

                  </div>






                </div>


              </div>
            </div>

          </div>
        </div>
      </section>
@endsection

@section('scripts')
<!-- 
  <script src="/frontend/assets/xZoom-master/xzoom.min.js"></script>
 -->

  <!-- Modal -->
  <div class="modal fade" id="imgModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mdl_img_wrp">
            <img id="mdl_img">
          </div>
        </div>
      </div>
    </div>
  </div>

<script>

  $.ajaxSetup({
      headers:{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
  })

  /// Start Add To Cart Prodcut 
  $(document).on('click', '.school-add-to-cart', function(e) {
    e.preventDefault();
    var pkgId = $(this).data('id');
    var pkgType = $(this).data('type');
    var totprice = parseInt($(this).data('totprice'));
    var addonid = 0;
    var optionid = 0;
    var digitalPrice = 0;
    // var checkBox = document.getElementById("digitalCheckbox");
    // if (checkBox.checked == true){
    //   digitalPrice =checkBox.value;
    // }
    
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      //console.log(`Checked checkbox: ${checkbox.id}`);
      //console.log(`Checked checkbox value: ${checkbox.value}`);
      digitalPrice =checkbox.value;
    }
  });

    // console.log('pkgId - '+pkgId);
    // console.log('pkgType - '+pkgType);
    // console.log('totprice - '+totprice);
    // console.log('digitalPrice - '+digitalPrice);

    $.ajax({
        type: "POST",
        dataType : 'json',
        data:{
            pkg_type:pkgType, option_id:optionid, addon_id:addonid, totprice:totprice, digitalPrice:digitalPrice
        },
        url: "/cart/school/store/"+pkgId,
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




  });
  /// End Add To Cart Prodcut 
  </script>

@endsection    