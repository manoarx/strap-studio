<script>
	var baseUrl = '{{url('/')}}';
</script>
<script src="/backend/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="/backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/backend/assets/vendor/chart.js/chart.umd.js"></script>
<script src="/backend/assets/vendor/echarts/echarts.min.js"></script>
<script src="/backend/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="/backend/assets/vendor/php-email-form/validate.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

 $(function(){
    $(document).on('click','#delete',function(e){

        e.preventDefault();
        var link = $(this).attr("href");


         Swal.fire({
           title: 'Are you sure?',
           text: "Delete This Data?",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = link
             Swal.fire(
               'Deleted!',
               'Your file has been deleted.',
               'success'
             )
           }
         }) 


    });

    $(document).on('click','#deleteproduct',function(e){

        e.preventDefault();
        var link = $(this).attr("href");


         Swal.fire({
           title: 'Are you sure?',
           text: "Delete This Data?",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = link
             Swal.fire(
               'Deleted!',
               'Your file has been deleted.',
               'success'
             )
           }
         }) 


    });

  });
</script>
<script>
  $(window).on('load', function() {
    $('#loader').fadeOut('slow');
  });
</script>
<!-- Template Main JS File -->
<script src="/backend/assets/js/main.js"></script>
<script src="/backend/assets/js/validate.min.js"></script>