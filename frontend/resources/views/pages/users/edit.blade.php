<div class="modal fade" id="kt_modal_edit_user" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit User</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body py-lg-10 px-lg-10">
                <form action="" method="" enctype="multipart/form-data" id="store_user_data1">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="block_1">
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>User Name:</strong>
                                    <span class="required"></span>
                                    <input type="text" name="name" id="name1" value="{{ old('name') }}" class="form-control" placeholder="User Name"/>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    <span class="required"></span>
                                    <input type="text" name="email" id="email1" value="{{ old('email') }}" class="form-control" placeholder="Email"/>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>User Role:</strong>
                                    <span class="required"></span>
                                    <select name="roles" id="roles1" class="form-control">
                                        <option value="">-- Select --</option>
                                    </select>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>User Department:</strong>
                                    {{--<span class="required"></span>--}}
                                    <select name="department_id" id="department1" class="form-control">
                                        <option value="">-- Select --</option>
                                    </select>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>Position:</strong>
                                    {{--<span class="required"></span>--}}
                                    <input type="text" name="position" id="position" value="{{ old('position') }}" class="form-control" placeholder="Position"/>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>Password:</strong>
                                    <input type="password" name="password" id="password1" value="" class="form-control" placeholder="Password"/>
                                    <p class="error text-danger"></p>
                                </div>    
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <strong>Confirm Password:</strong>
                                    <input type="password" name="confirm-password" id="confirm-password1" value="" class="form-control" placeholder="confirm-password"/>
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

<!-- users.edit function call -->
<script>

    var id="";

    $(".edit_model_open").on('click', function(e) {
        e.preventDefault();
        $("#roles").html("");

        id=$(this).data("user_id");
		var url = '{{ route("users.edit", ":id") }}';
    	url = url.replace(':id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            type: 'get',
            url: url,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,

            success: function(response) {
                if(response.status == "success"){
                    
                    $("#name1").val(response.user.name);
                    $("#email1").val(response.user.email);
                    $("#position").val(response.user.position);
                    $("#roles").append('<option value="">-- Select --</option>');
                    // $("#department").append('<option value="">-- Select --</option>');
                    $("#roles1").html("");
                    $.each(response.roles, function(key,val){
                        if(val.id == response.role){
                            $("#roles1").append('<option value="'+val.id+'" selected>'+val.name+'</option>');
                        }else{
                            $("#roles1").append('<option value="'+val.id+'">'+val.name+'</option>');
                        }
                    });
                    $("#department1").html("");
                    $.each(response.departments, function(key,val){
                        if(val.id == response.department){
                            $("#department1").append('<option value="'+val.id+'" selected>'+val.name+'</option>');
                        }else{
                            $("#department1").append('<option value="'+val.id+'">'+val.name+'</option>');
                        }
                    });
                    $('#kt_modal_edit_user').modal('show');
                }
            }
        });
    });

    //  users.update function call 

    $(document).ready(function() {

        $('#store_user_data1').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $(".error").html("");
            
            var url = '{{ route("users.update", ":id") }}';
            url = url.replace(':id', id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                type: 'POST',
                url: url,
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,

                success: function(response) {
                    if(response.status == "success"){
                        
                        toastr.success(response.msg);
                        $('#kt_modal_edit_user').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);

                    }
                    if(response.status == "error"){

                        $.each(response.msg, function(key, value) {
                            $(`#${key}`+1).siblings('p').html(value);
                        });

                    }
                }
            });
        });
    });
</script>
