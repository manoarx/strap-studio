@extends('layouts.backend')
  
@section('content')
<div class="pagetitle">
<h1>Contact Form</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
  <li class="breadcrumb-item active">Contact Form</li>
</ol>
</nav>
</div><!-- End Page Title -->
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Contact Form List</h5>

          <!-- Table with hoverable rows -->
          <table class="table table-hover table-bordered table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Contact No.</th>
                <th scope="col">Message</th>
                <th scope="col">Date</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($contactforms as $key => $contactform)
              <tr data-entry-id="{{ $contactform->id }}">
                <th scope="row">{{ ($key+1) ?? '' }}</th>
                <td>{{ $contactform->name ?? '' }}</td>
                <td>{{ $contactform->email ?? '' }}</td>
                <td>{{ $contactform->contact_number ?? '' }}</td>
                <td>{{ $contactform->message ?? '' }}</td>
                <td>{{ $contactform->created_at ?? '' }}</td>
                <td>
                  <a class="btn btn-xs btn-primary" href="{{ route('admin.contactforms.show', $contactform->id) }}">
                      View
                  </a>

                  <form action="{{ route('admin.contactforms.destroy', $contactform->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- End Table with hoverable rows -->

        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
  var dataTable;
  var basePath ="{{url('/')}}";
  $(document).ready(function() {
    dataTable = $('#table').DataTable({
      pageLength: 10,
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    let deleteButtonTrans = 'Delete'
    let deleteButton = {
      text: deleteButtonTrans,
      url: "{{ route('admin.contactforms.massDestroy') }}",
      className: 'btn-danger',
      action: function (e, dt, node, config) {
        var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
            return $(entry).data('entry-id')
        });

        if (ids.length === 0) {
          alert('No rows selected')

          return
        }

        if (confirm('Are you sure')) {
          $.ajax({
            headers: {'x-csrf-token': _token},
            method: 'POST',
            url: config.url,
            data: { ids: ids, _method: 'DELETE' }})
            .done(function () { location.reload() })
        }
      }
    }
    dtButtons.push(deleteButton)
  });

  $(document).on('click', '.common_id_post', function(e) {
    var id = $(this).data("id");
    var message = $(this).data("message");
    var method = $(this).data("method");
    var url = $(this).data("url");
    swal({
        title: message,
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then(successTrue => {
        if (successTrue) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                type: method,
                url: basePath + "/" + url,
                data: {
                    id: id
                },
                beforeSend: function() {
                    $(".se-pre-con").show();
                },
                success: function(response) {
                    $(".se-pre-con").hide();
                    if (response) {
                        if (response.statuscode == 200) {
                            swal({
                                title: response.section,
                                text: response.message,
                                icon: "success",
                                closeOnClickOutside: false,
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            sweetAlert({
                                title: response.message,
                                icon: "warning",
                                dangerMode: true,
                            });
                        }

                    } else {
                        $(".se-pre-con").hide();
                        swal("Error!");
                    }
                }
            });
        }
    });
});
</script>

@endsection