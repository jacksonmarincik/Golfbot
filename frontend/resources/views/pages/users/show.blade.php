<div class="modal fade" id="kt_modal_show_user" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>User Details</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body py-lg-10 px-lg-10">
                <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                    <div class="form-group">
                        <strong class="h3 text-primary">User Name:</strong>
                        <label id="user_name" class="h5"></label>
                    </div>    
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                    <div class="form-group">
                        <strong class="h3 text-primary">User Email:</strong>
                        <label id="user_email" class="h5"></label>
                    </div>    
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                    <div class="form-group">
                        <strong class="h3 text-primary">User Role:</strong>
                        <label id="user_role" class="h5"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- users.show function call -->
<script>
    $(".show_model_open").on('click', function(e) {
        e.preventDefault();

        var id=$(this).data("user_id");
		var url = '{{ route("users.show", ":id") }}';
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

                    $("#user_name").text(response.user.name);
                    $("#user_email").text(response.user.email);
                    $("#user_role").text(response.role[0]);
                    $('#kt_modal_show_user').modal('show');
                    
                }
            }
        });
    });
</script>
