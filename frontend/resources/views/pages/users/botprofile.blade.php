<x-default-layout>
    <div class="container">
      <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-header cursor-pointer">
  
          <div class="col-sm-12 col-md-6 align-self-center"></div>
          <div class="col-sm-12 col-md-6 d-flex align-self-center justify-content-end">
            <div class="d-flex align-items-center">
                <a disabled href="{{route('add-bot-settings')}}" class="btn btn-info me-2">Add Profile</a>
            </div>
          </div>
      </div>
      <div class="card-body p-9">


        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
            <!--begin::Table head-->
            <thead>
                <tr class="border-0">
                    <th>No</th>
                    <th>Profile Name</th>
                    <th>Bot Location</th>
                    <th>Booking Limit</th>
                    <th>Status</th>
                    <th width="200px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userSettingData as $key => $user)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->category }}</td>
                    <td>{{ $user->stop_booking }}</td>
                    <td>{!! $user->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                    <td><a class="btn btn-primary" href="{{route('user_setting',$user->id)}}">Profile Settings</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-area d-flex justify-content-center">
          <div class="pagination">
            {!! $userSettingData->links() !!}
          </div>
        </div>
      </div>
    </div>
  
    @include('pages.users.create')
    @include('pages.users.edit')
    @include('pages.users.show')
  
    <!-- Delete User -->
    <script>
      $("#search_filter").change(function() {
        $('#search_filter').submit();
      });
    </script>
    <script>
      function delete_user(id) {
  
        var url = '{{ route("users.destroy", ":id") }}';
        url = url.replace(':id', id);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
  
        jQuery.ajax({
          type: 'delete',
          url: url,
          dataType: 'JSON',
          contentType: false,
          cache: false,
          processData: false,
          success: function(response) {
            if (response.status == "success") {
              toastr.success(response.msg);
              setTimeout(function() {
                location.reload();
              }, 1000);
            }
            if (response.status == "error") {
              toastr.error(response.msg);
            }
          }
        });
      }
    </script>
  
  </x-default-layout>