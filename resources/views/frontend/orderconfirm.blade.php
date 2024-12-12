@extends('layouts.frontend')

@section('content')

<section class="py-3 py-md-4 py-lg-5">
        <div class="container cMN_wTh my-auto py-3 py-md-4 py-lg-5">
          <div class="insd_suces_wrp" style="background-image: url(assets/images/success_back.png);">
            <div class="insd_suces_ind">
              <div class="row my-auto mx-0 w-100">
                <div class="col-md-6 d-flex">
                  <div class="insd_suces_ind_Img mx-auto my-auto">
                    <figure>
                      <img src="/frontend/assets/images/strap_studio_logo.png">
                    </figure>
                  </div>
                </div>
                <div class="col-md-6 d-flex">
                  <div class="insd_suces_ind_txt">
                    <div class="insd_suces_ind_txt_HD mb-5">
                      <h4>Congrats!!!</h4>
                    </div>


                    <div class="insd_suces_ind_txt_mId mb-5">
                      <h4>You have successfully made the payment.
                        <!-- <span>booking id#121221</span> check your email for further details. -->
                      </h4>
                    </div>
                    <div class="d-flex">
                      <a href="{{ route('index') }}" class="insd_suces_expLR">Explore more services</a>
                    </div>

                  </div>
                </div>
              </div>
            </div>
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