$(document).on('click', '.download_invoice', function (event) {
  var id = $(this).data('id'),
    enid = $(this).data('enid')
  button = $(this);
  $('#loader').show();
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: baseUrl + '/admin/invoice/download/' + id,
    type: 'post',
    success: function (data) {
      $('#loader').hide();
      if (data.invoice_exists) {
        button.text("Download");
        var newWin = window.open(
          baseUrl + "/admin/invoice/print/" + enid,
          "_blank"
        );
        if (!newWin || newWin.closed || typeof newWin.closed == 'undefined') {
          Swal.fire("Your browser pop is not enabled");
        }
      } else {
        if (!data.token) {
          var newWin = window.open(baseUrl + "/admin/quickbooks/login", "QuickBook", "height=500,width=500");
          if (!newWin || newWin.closed || typeof newWin.closed == 'undefined') {
            Swal.fire("Your browser pop is not enabled");
          }
        } else if (!data.customer) {
          Swal.fire("Customer not found on QuickBooks!");
        } else if (data.error) {
          Swal.fire("Server not responding!");
        }
                     /*else if(!data.product){
                        Swal.fire("Product(s) not found on QuickBooks!");
                    }*/ else if (!data.invoice_create) {
          if (data.message && data.message != '') {
            var textMessage,
              missingMype = 'product',
              missingHtml = '<div>';
            if (data.sync_product == 1) {
              if (data.missing_services.length) {
                textMessage = "Do you want to sync products to QuickBooks";
                $.each(data.missing_services, function (key, value) {
                  missingHtml += '<p> ' + value.title + ' (' + value.slug + ')</p>';
                });
                missingHtml += '<br/><p><b>Do you want to sync services to QuickBooks?</b></p></div>';
                textMessage = "Do you want to sync services to QuickBooks";
                missingMype = 'service';
              } else {
                $.each(data.missing_products, function (key, value) {
                  missingHtml += '<p>' + value.title + ' (' + value.slug + ')</p>';
                });
                missingHtml += '<br/><p><b>Do you want to sync products to QuickBooks?</b></p></div>';

              }
              Swal.fire({
                title: data.message,
                text: textMessage,
                icon: "warning",
                html: missingHtml,
                buttons: true,
                showCancelButton: true,
                dangerMode: true,
              }).then((result) => {
                if (result.isConfirmed) {
                  try {
                    syncProduct(data, id);
                  } catch (e) {
                    Swal.fire("Server Not Responding!");
                    $('#loader').hide();
                  }
                }
              });
            } else {
              Swal.fire(data.message);
              $('#loader').hide();
            }
          } else {
            Swal.fire("Server Not Responding!");
            $('#loader').hide();
          }
        }
      }

    },
    error: function (xhr, ajaxOptions, thrownError) {
      $('#loader').hide()
      alert("Server not responding");
    }
  });
});
function syncProduct(data, id) {
  $('#loader').show();
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: baseUrl + '/admin/invoice/sync-products-to-quickbooks',
    type: 'post',
    data: {
      orderId: id,
      products: data.missing_products
    },
    success: function (data) {
      $('#loader').hide();
      if (data.error) {
        $('#loader').hide();
        Swal.fire({
          title: 'Error',
          icon: "warning",
          html: data.message,
          buttons: true,
          dangerMode: true,
        });

      } else {
        $('#loader').hide();
        Swal.fire({
          title: 'Success',
          icon: "success",
          html: data.message,
          buttons: true,
          dangerMode: true,
        }).then((result) => {
          $('#loader').hide();
        });
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      $('#loader').hide()
      alert("Server not responding");
    }
  });
}