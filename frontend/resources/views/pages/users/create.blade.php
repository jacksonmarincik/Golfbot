<div class="modal fade" id="kt_modal_create_user" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New User</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body py-lg-10 px-lg-10">
                <form action="" method="" enctype="multipart/form-data" id="store_user_data">
                    @csrf
                    <div class="row">
                        <div class="block_1">
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>User Name:</strong>
                                    <span class="required"></span>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="User Name"/>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    <span class="required"></span>
                                    <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Email"/>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>User Role:</strong>
                                    <span class="required"></span>
                                    <select name="roles" id="roles" class="form-control"></select>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>User Department:</strong>
                                    {{--<span class="required"></span>--}}
                                    <select name="department_id" id="department" class="form-control"></select>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>Position:</strong>
                                    {{--<span class="required"></span>--}}
                                    <input type="text" name="position" id="email" value="{{ old('position') }}" class="form-control" placeholder="Position"/>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>Password:</strong>
                                    <span class="required"></span>
                                    <input type="password" name="password" id="password" value="" class="form-control" placeholder="Password"/>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>Confirm Password:</strong>
                                    <span class="required"></span>
                                    <input type="password" name="confirm-password" id="confirm-password" value="" class="form-control" placeholder="confirm-password"/>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- users.create function call -->
<script>
    $("#create_model_open").on('click', function(e) {
        e.preventDefault();

        $("#roles").html("");
        $("#department").html("");

        jQuery.ajax({
            type: 'GET',
            url: "{{ route('users.create') }}",
            dataType: 'JSON',
            success: function(response) {
                if(response.status == "success"){

                    $("#roles").append('<option value="">-- Select --</option>');

                    $.each(response.data, function(key,val){
                        $("#roles").append('<option value="'+val.id+'">'+val.name+'</option>');
                    });
                    $("#department").append('<option value="">-- Select --</option>');
                    $.each(response.department, function(key,val){
                        $("#department").append('<option value="'+val.id+'">'+val.name+'</option>');
                    });

                    $('#kt_modal_create_user').modal('show');

                }
            }
        });
    });
</script>

<!-- users.store function call -->
<script>
    $(document).ready(function() {
        $('#store_user_data').on('submit', function(e) {
            e.preventDefault();

            $(".error").html("");

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'POST',
                url: "{{ route('users.store') }}",
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {

                    if(response.status == "success"){

                        toastr.success(response.msg);
                        $('#kt_modal_create_user').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                        
                    }
                    if(response.status == "error"){

                        $.each(response.msg, function(key, value) {
                            $(`#${key}`).siblings('p').html(value);
                        });

                    }

                }
            });
        });
    });
</script>
