<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Home - Strap Studios</title>
  @include('partials.user.styles')
  @yield('styles')
</head>

<body>
  <div class="pG_wrp">
    @include('partials.user.header')
      <div id="pG_Body" class="stnt_body">
    @yield('content')

    @include('partials.user.footer')

    </div>

  </div>

<!-- Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="update-password-form"> 
            @csrf
            @method('PUT')
            <div class="to_profile">
              @if (session('status'))
             <div class="alert alert-success" role="alert">
                    {{session('status')}}
             </div>
             @elseif(session('error'))
             <div class="alert alert-danger" role="alert">
                {{session('error')}}
             </div>
             @endif
              <div class="inside_page_Rf_paswrd_head mb-4">
                <h4>Reset Password</h4>
              </div>
              <div class="mb-4">
                <input class="form-control" placeholder="Old password" @error('old_password') is-invalid @enderror"  name="old_password" type="password" id="current_password">
              </div>


              <div class="mb-4">
                <input class="form-control" placeholder="New Password" @error('new_password') is-invalid @enderror"  name="new_password" type="password" id="new_password">
              </div>

              <div class="mb-4">
                <input class="form-control" placeholder="Confirm password" name="new_password_confirmation" type="password" id="new_password_confirmation">
              </div>
              <div class="mb-3">
                <button type="submit" class="up_lD_bTn">
                  <i class="icon-check-mark"></i>
                  <span>Save</span></button>
              </div>

            </div>

          </form>

        </div>

      </div>
    </div>
</div>
@include('partials.user.scripts')
@yield('scripts')
<script type="text/javascript">
$(document).ready(function () {
    $('#update-password-form').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: '{{ route('school.update.password') }}',
            method: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                $('#update-password-form')[0].reset();
                Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: response.success,
                  showConfirmButton: false,
                  timer: 1500 // Time in milliseconds
                });
                $('#passwordModal').modal('hide');
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';

                $.each(errors, function (key, value) {
                    errorMessage += value[0] + '\n';
                });

                Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: errorMessage,
                  showConfirmButton: false,
                  timer: 1500 // Time in milliseconds
                });
            }
        });
    });
});
</script>
</body>

</html>