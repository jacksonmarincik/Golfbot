<div class="modal fade" id="kt_modal_create_role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New Role</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body py-lg-10 px-lg-10">
                <form action="" method="" id="store_role_data">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 pt-5">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <span class="required"></span>
                                <input type="text" name="name" id="name" value="" class="form-control" placeholder="Name"/>
                                <p class="error text-danger"></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pt-5">
                            <div class="form-group">
                                <strong>Permission:</strong>
                                <span class="required"></span>
                                <br/>
                                <div id="permission"></div>
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

<!-- roles.create function call -->
<script>
    $("#create_model_open").on('click', function(e) {
        e.preventDefault();

        $("#permission").html("");

        jQuery.ajax({
            type: 'GET',
            url: "{{ route('roles.create') }}",
            dataType: 'JSON',
            success: function(response) {

                if(response.status == "success"){

                    $.each(response.data, function(key,val){

                        $("#permission").append('<label class="pt-5 h5">'+
                                                    '<input type="checkbox" name="permission[]" value="'+val.id+'" class="name" style="margin-right: 10px;">'+
                                                    val.name+'</label><br>');
                                                    
                    });

                    $('#kt_modal_create_role').modal('show');

                }

            }
        });
    });
</script>

<!-- roles.store function call -->
<script>
    $(document).ready(function() {
        $('#store_role_data').on('submit', function(e) {
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
                url: "{{ route('roles.store') }}",
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $(".error").html("");
                    if(response.status == "success"){
                        toastr.success(response.msg);
                        $('#kt_modal_create_role').modal('hide');
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
