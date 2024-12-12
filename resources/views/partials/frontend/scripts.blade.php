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
 <script src="/frontend/assets/js/butter.js"></script> 

<script src="/frontend/assets/js/owl.carousel.min.js"></script>
<script src="/frontend/assets/js/slick.min.js"></script>
<script src="/frontend/assets/js/sal.js"></script>
<script src="/frontend/assets/js/viewportAnime.js"></script>
<script src="/frontend/assets/js/fadeSlider.js"></script>
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
  @auth
  @if(Auth::user()->type == 'customer')
  function wishlist(){
    $.ajax({
        type: 'GET',
        url: '/customer/wishlistcnt',
        dataType: 'json',
        success:function(response){
            $('#wishQty').text(response.wishQty);
        }
    })
  }
  wishlist();
  @endif
  @endif
</script>

