<x-default-layout>
  <div class="container">
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
      <div class="card-header cursor-pointer">

        <div class="col-sm-12 col-md-6 align-self-center">
          <form id="frmCampaignSearch" method="GET" action="{{route('users.index')}}">
            <div class="d-flex align-items-center position-relative my-1">
              <input type="text" name="s" class="form-control form-control-solid w-250px me-2 ps-14" placeholder="Search " value="{{request()->get('s')}}" />
              <div class="d-flex align-items-center">
                <button type="submit" class="btn btn-info me-2">Search</button>
                <a href="{{route('users.index')}}" class="btn btn-secondary me-2">Clear</a>
              </div>
            </div>
          </form> 
        </div>
        <div class="col-sm-12 col-md-6 align-self-center"></div>
    </div>
    <div class="card-body p-9">
      <table class="table table-bordered">
        <tr class="h4">
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th width="100px">Action</th>
        </tr>
        @foreach ($data as $key => $user)
        <tr class="h6">
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td class="text-end">
            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
              <span class="svg-icon svg-icon-5 m-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
                </svg>
              </span>
            </a>
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
              <div class="menu-item px-2">
                <a class="menu-link px-3 show_model_open" data-user_id="{{$user->id}}">Show</a>
              </div>
              <div class="menu-item px-2">
                <a class="menu-link px-3 edit_model_open" data-user_id="{{$user->id}}">Edit</a>
              </div>
              <div class="menu-item px-2">
                <a href="#" id="{{$user->id}}" onclick="delete_user(this.id)" class="menu-link px-3">Delete</a>
              </div>
              <div class="menu-item px-2">
                <a href="{{route('user_setting',$user->id)}}" class="menu-link px-3">Setting</a>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </table>
      <div class="pagination-area d-flex justify-content-center">
        <div class="pagination">
          {!! $data->links() !!}
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