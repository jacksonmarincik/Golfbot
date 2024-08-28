<x-default-layout>

    <div class="container">
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <a id="create_model_open" class="btn btn-primary align-self-center">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        Create New Role
                    </a>
                </div>
            </div>
        <div class="card-body p-9">
            <table class="table table-bordered h5">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th width="210px">Action</th>
                </tr>
                @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
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
                                    <a class="menu-link px-3 show_model_open" data-role_id="{{$role->id}}">Show</a>
                                </div>  
                                <div class="menu-item px-2">
                                    <a class="menu-link px-3 edit_model_open" data-role_id="{{$role->id}}">Edit</a>
                                </div>
                                <div class="menu-item px-2">
                                    <a id="{{$role->id}}" onclick="delete_role(this.id)" class="menu-link px-3">Delete</a>
                                </div>                   
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table> 
            <div class="pagination-area d-flex justify-content-center">
                <div class="pagination">
                {!! $roles->links() !!}
                </div>
            </div>
        </div>   
    </div>

    @include('pages.roles.create')
    @include('pages.roles.edit')
    @include('pages.roles.show')

    <!-- Delete Role -->
    <script>
        function delete_role(id){

            var url = '{{ route("roles.destroy", ":id") }}';
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

                    if(response.status == "success"){

                    toastr.success(response.msg);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);

                    }

                    if(response.status == "error"){

                        toastr.error(response.msg);
                        
                    }

                }
            });
        }
    </script>

</x-default-layout>