<div class="modal fade" id="kt_modal_edit_role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Role</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body py-lg-10 px-lg-10">
                <form action="" method="" id="store_role_data1">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 pt-5">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <span class="required"></span>
                                <input type="text" name="name" id="name1" value="" class="form-control" placeholder="Name"/>
                                <p class="error text-danger"></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pt-5">
                            <div class="form-group">
                                <strong>Permission:</strong>
                                <span class="required"></span>
                                <br/>
                                <div id="permission1"></div>
                                <p class="error text-danger"></p>
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

<!-- roles.edit function call -->
<script>

    var id="";
    var permissions=[];
    $(".edit_model_open").on('click', function(e) {
        e.preventDefault();

        $("#permission1").html("");

        id=$(this).data("role_id");
		var url = '{{ route("roles.edit", ":id") }}';
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

                    $("#name1").val(response.roles.name);

                    permissions=response.rolePermissions;

                    $.each(response.permission, function(key,val){

                        if(checkValue(val.id, permissions) == 1) {
                            $("#permission1").append('<label class="pt-5 h5">'+
                                                    '<input type="checkbox" name="permission[]" value="'+val.id+'" class="name" style="margin-right: 10px;" checked>'+
                                                    val.name+'</label><br>');
                        } else {
                            $("#permission1").append('<label class="pt-5 h5">'+
                                                    '<input type="checkbox" name="permission[]" value="'+val.id+'" class="name" style="margin-right: 10px;">'+
                                                    val.name+'</label><br>');
                        }

                    });

                    $('#kt_modal_edit_role').modal('show');
                }

            }
        });
    });

    function checkValue(value, permissions) {
        var status = 0;
        for (var i = 0; i < permissions.length; i++) {
            var name = permissions[i];
            if (name == value) {
                status = 1;
                break;
            }
        }
        return status;
    }


    //  roles.update function call 

    $(document).ready(function() {
        $('#store_role_data1').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $(".error").html("");

            var url = '{{ route("roles.update", ":id") }}';
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
                        $('#kt_modal_edit_role').modal('hide');
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
