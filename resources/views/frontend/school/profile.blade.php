@extends('layouts.frontend')
@section('content')
<section class="py-3 py-md-4 py-lg-5">
<div class="container cMN_wTh my-auto pb-3 pb-md-4 pb-lg-5">
  <div class="d-flex flex-wrap pt-3 pt-md-0">
    <div class="inside_page_Head">
      <h4>Profile</h4>
    </div>

    <div class="inside_page_Rft">

      <div class="inside_page_Rf_profile">
        @if(Auth::user()->phone == '' || Auth::user()->address == '')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Please update profile</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(!isset($userData->cn_code))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Please update country code</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <form method="post" action="{{ route('school.profile.store') }}" enctype="multipart/form-data" >
            @csrf
          <div class="row">
            <input type="hidden" name="currentPath" value="{{ $currentPath ?? '' }}">
            <div class="col-md-4 d-flex order-md-2">
              <div class="to_profile_pic mx-auto me-md-0">
                <figure>
                  <img id="showImage" src="{{ (!empty($userData->photo)) ? url('upload/user_images/'.$userData->photo):url('upload/no_image.jpg') }}">
                </figure>

                <div class="d-flex mx-0 mt-3 pt-3">
                  <input type="file" id="myFileUpld" name="photo">
                  <button class="up_lD_bTn up_lD_bTnClk w-100" type="button">
                    <i class="icon-download"></i>
                    <span>Update Profile Pic</span>
                  </button>
                </div>
              </div>
            </div>


            <div class="col-md-8 d-flex order-md-1">
              <div class="to_profile">

                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $userData->name }}" required>
                </div>


                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $userData->email }}" required disabled>
                </div>

                <div class="d-flex mb-3">
                  <select name="cn_code" id="cn_code"  class="form-control" required>
                            <!-- <option value="971" @if(empty($userData->cn_code) || $userData->cn_code == '971') selected @endif>United Arab Emirates (+971)</option> -->
                            <option value = "">Select Country Code</option>

                            @foreach($countries as $country)
                            <option value="{{$country->phonecode}}" @if(isset($userData->cn_code) && $country->phonecode == $userData->cn_code) selected @endif >{{$country->nicename}} (+{{$country->phonecode}})</option>
                            @endforeach
                         </select><input type="tel" class="form-control" placeholder="Phone" name="phone" value="{{ $userData->phone }}" >
                </div>


                <div class="mb-3">
                  <textarea type="text" class="form-control" placeholder="Address" name="address" rows="6">{{ $userData->address }}</textarea>
                </div>

                <div class="mb-3">
                  <button type="submit" class="up_lD_bTn">
                    <i class="icon-check-mark"></i>
                    <span>Save</span></button>
                </div>

              </div>
            </div>



          </div>
        </form>

        <div class="inside_page_Rf_paswrd mt-5">
          <div class="inside_page_Rf_paswrd_head">
            <h4>Reset Password</h4>
          </div>
          <div class="d-flex mt-4">
            <button type="button" class="up_lD_bTn" data-bs-toggle="modal" data-bs-target="#passwordModal">
              <i class="icon-password"></i>
              <span>Update Password</span>
            </button>
          </div>
        </div>

      </div>

    </div>

  </div>
</div>
</section>


@endsection

@section('modal')
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
@endsection

@section('scripts')
<script>
$(document).ready(function () {
  // sal();
  sal({
    threshold: 0.05,
  });


  $('#myFileUpld').change(function(e){
      var reader = new FileReader();
      reader.onload = function(e){
          $('#showImage').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.target.files['0']);
  });



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
@endsection   