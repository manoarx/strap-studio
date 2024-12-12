<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script src="https://vjs.zencdn.net/7.18.1/video.min.js"></script>

  <script src="https://code.createjs.com/1.0.0/createjs.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- 
  <script src="/frontend/assets/js/butter.js"></script> -->
  <script src="/frontend/assets/js/owl.carousel.min.js"></script>
  <script src="/frontend/assets/js/slick.min.js"></script>
  <script src="/frontend/assets/js/sal.js"></script>
  <script src="/frontend/assets/js/viewportAnime.js"></script>
  <script src="/frontend/assets/js/com.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="/frontend/assets/js/disableRightClick.js"></script>
<script>
 @if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;
    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;
    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;
    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break; 
 }
 @endif 
</script>
<script type="text/javascript">
  function miniCart(){
    $.ajax({
        type: 'GET',
        url: '/product/mini/cart',
        dataType: 'json',
        success:function(response){
            $('#cartQty').text(response.cartQty);
        }
    })
  }

  miniCart();
</script>


  <script>
    $(document).ready(function () {
      // sal();
      sal({
        threshold: 0.05,
      });

      $(document).on("click", ".the_schlZ_eacH figure img", function () {
        var aImg = $(this).attr("data_img");
        $("#mdl_img").attr("src", aImg)
        $("#imgModal").modal("show");
      });



      $('.the_schlZ').owlCarousel({
        transitionStyle: "fade",
        autoplayTimeout: 2000,
        autoplaySpeed: 2000,
        items: 1,
        loop: false,
        margin: 16,
        autoWidth: false,
        autoplay: false,
        dots: false,
        nav: true,
        navText: ['<i class="icon-chev_left"></i>', '<i class="icon-chev_right"></i>'],
        responsive: {
          0: {
            margin: 8,
            items: 1,
          },
          600: {
            margin: 15,
            items: 1,
          },
          900: {
            margin: 20,
            items: 1,
          },
          1000: {
            margin: 25,
            items: 1,
          },
          1200: {
            margin: 30,
            items: 1,
          }
        }
      });

      //$('.xzoom').each(function () {
        // $('.xzoom, .xzoom-gallery').xzoom({ zoomWidth: 500, title: true, tint: '#333', position: "left", Xoffset: -100 });
        //  $(this).xzoom({ zoomWidth: 200, title: true, tint: '#333', position: "left", Xoffset: -100 });
      //});

    });


  </script>