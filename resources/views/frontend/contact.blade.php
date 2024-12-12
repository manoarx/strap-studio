@extends('layouts.frontend')

@section('content')
@php
$banner = App\Models\Banners::where('page','contact')->first();
@endphp
<section class="py-3 py-md-4 py-lg-5 contact_back"
        style="background-image: url({{ isset($banner->image) ? asset($banner->image) : '/frontend/assets/images/contact_background.png'}});">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 ">

        </div>
      </section>

      <section class="pt-3 pt-md-4 pt-lg-5 contact_dtlz">
        <div class="container cMN_wTh pt-3 pt-md-4 pt-lg-5 ">

          <div class="cntct_wht_t">
            <div class="row">
              <div class="col-lg-6 d-flex" data-sal="fade" style="--sal-duration: 3s; --sal-delay: 0s">
                <div class="contact_dtlz_Adr my-auto pt-3 pb-lg-3 pb-4">
                  <div class="d-block mb-3 mb-md-4 mb-lg-5">
                    <h4 class="home_service_header">Let’s keep in touch</h4>
                  </div>
                  <div class="contact_dtlz_liNkz">
                    <ul>
                      <li><a href="tel:{{ $settings['contact_phone'] ?? '' }}"><i class="icon-phone"></i><span>{{ $settings['contact_phone'] ?? '' }}</span></a></li>
                      <li><a href="mailto:{{ $settings['contact_mail'] ?? '' }}"><i
                            class="icon-mail"></i><span>{{ $settings['contact_mail'] ?? '' }}</span></a></li>
                      <li><a href="https://www.google.com/maps?ll=24.490776,54.371816&z=16&t=m&hl=en&gl=IN&mapclient=embed&cid=6091323262778567005" target="_blank"><i class="icon-location"></i><span>{{ $settings['contact_address'] ?? '' }}</span></a></li>
                    </ul>
                  </div>
                  <div class="contact_dtlz_sociaL">
                    <ul>
                      <li><a href="{{ $settings['instagram'] ?? '' }}">
                          <i class="icon-instagram"></i>
                          <span>Instagram</span>
                        </a></li>

                      <li><a href="{{ $settings['linkedin'] ?? '' }}">
                          <i class="icon-linkedin"></i>
                          <span>Linkedin</span>
                        </a></li>
                    </ul>
                  </div>

                </div>
              </div>
              <div class="col-lg-6 d-flex">
                <div class="frm_contact">
                  @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                  @endif
                  @if(Session::has('warning'))
                      <div class="alert alert-warning">
                          {{Session::get('warning')}}
                      </div>
                  @endif
                  <form method="post" action="{{ route('store-contact') }}">
                  @csrf
                    <div class="row">

                      <div class="mb-3 mb-md-4 col-md-12 col-sm-6 d-flex ">
                        <div class="form-group">
                          <label class="form-label">Full name</label>
                          <input type="text" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="mb-3 mb-md-4 col-md-12 col-sm-6 d-flex">
                        <div class="form-group">
                          <label class="form-label">Email</label>
                          <input type="text" class="form-control" name="email">
                        </div>
                      </div>
                      <div class="mb-3 mb-md-4 col-md-12 col-sm-6 d-flex">
                        <div class="form-group">
                          <label class="form-label">Phone</label>
                          <input type="text" class="form-control" name="contact_number">
                        </div>
                      </div>

                      <div class="mb-3 mb-md-4 col-md-12 col-sm-12 d-flex">
                        <div class="form-group">
                          <label class="form-label">Message</label>
                          <textarea type="text" class="form-control" rows="5" name="message"></textarea>
                        </div>
                      </div>
                      <div class="mb-3 col-md-12 col-sm-6 d-flex mx-auto">
                        <div class="form-group">
                          <button type="submit" class="cntCtBtnZ">Submit</button>
                        </div>
                      </div>

                    </div>
                  </form>


                </div>
              </div>
            </div>
          </div>

        </div>
      </section>

      <section class="contact_dtlzMap py-3">
        <div class="container cMN_wTh py-3 pb-md-4 pb-lg-5 ">
          <div class="cntCtMap">
            <iframe
              src="{{ $settings['contact_map'] ?? '' }}"
              style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </section>

@endsection     


@section('scripts')

<script>
    $(document).ready(function () {
      // sal();
      sal({
        threshold: 0.05,
      });

      $(".packag_drop").select2({
        templateSelection: iformat,
        templateResult: iformat,
        placeholder: "Choose",
        dropdownCssClass: "dropperDown",
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
        console.log("select2:select", e);
        // console.log('Selected Item:', selectedItem);
        //  console.log('Selected Item Template:', selectedItemTemplate);
        // console.log(selectedItemTemplate);
        //$(this).parent().find(".adnSelecTd").attr("pp", "pp");
        $(this).parent().find(".adnSelecTd").append('<div class="d-flex echSlctd_adN"><span class="ms-0 me-auto txTAdn">' +
          selectedItemTemplatePlace + '</span><span class="ms-auto me-0 txTAdnPr">' + selectedItemTemplatePrice + '</span><button class="delete_it" data-value=' + selectedItemValue + '><i class="icon-minus"></i></button></div>');
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