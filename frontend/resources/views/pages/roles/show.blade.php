<div class="modal fade" id="kt_modal_show_role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Role Details</h2>
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
                        <strong class="h3 text-primary">Name:</strong>
                        <label id="role_name" class="h6"></label>
                    </div>    
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                    <div class="form-group">
                        <strong class="h3 text-primary">Permissions:</strong>
                        <ul id="show_data"></ul>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- roles.show function call -->
<script>
    $(".show_model_open").on('click', function(e) {
        e.preventDefault();

        $("#show_data").html("");

        var id=$(this).data("role_id");
		var url = '{{ route("roles.show", ":id") }}';
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

                    $("#role_name").text(response.role.name);
                    $.each(response.rolePermissions, function(key,val){
                        $("#show_data").append('<li class="label label-success h5">'+val.name+'</li>');
                    });
                    $('#kt_modal_show_role').modal('show');

                }
                
            }
        });
    });
</script>
