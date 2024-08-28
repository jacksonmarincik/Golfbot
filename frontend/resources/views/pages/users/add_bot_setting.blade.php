
<x-default-layout>    
    <style>
        .ml-8-px {
            margin-left: 15px !important;
        }
        .ml-7-px {
            margin-left: 7px !important;
        }
    </style>       
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __('Add Booking Profile') }}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->

        <!--begin::Content-->
        <div id="" class="collapse show">
            <!--begin::Form-->
            <form id="userSettingFrm" class="form" enctype="multipart/form-data">
                @csrf
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div id="basic_info">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Profile Name') }}</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="full_name" id="full_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                             placeholder="Full name" value=""/>
                                        <p class="error text-danger"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span class="required">{{ __('No of Bookings to STOP BOT') }}</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('No of Bookings to STOP BOT') }}"></i>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input type="number" name="stop_booking" id="stop_booking" class="form-control form-control-lg form-control-solid"
                                onkeypress="validatePhone(event)" placeholder="No of Bookings to STOP BOT" value="{{ !empty($userSettingData) ? $userSettingData->stop_booking : -1 }}"/>
                                <p class="error text-danger"></p>
                            </div>
                        </div>
                    </div>
                    <div id="day_slot">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Day Slot') }}</label>
                                <div class="col-lg-8 fv-row">
                                    <div class="d-flex align-items-center mt-3">
                                        <label class="form-check-inline form-check-solid me-5">
                                            <select name="slot[0][day]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" id="">
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                            </select>
                                        </label>
                                        <label class="form-check-inline form-check-solid">
                                            <input type="time" name="slot[0][from]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value=""/>
                                        </label>
                                        <label class="form-check-inline form-check-solid">
                                            <input type="time" name="slot[0][to]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value=""/>
                                        </label>
                                        <label class="form-check-inline form-check-solid">
                                            <a class="btn btn-success" onclick="add_dateTime_slot();">
                                                <i class="fa-solid fa-plus fa-2xl"></i>
                                            </a>
                                        </label>
                                    </div>
                                </div>
                            <div class="row" id="more_date_time_slot">
                            </div>
                            <div class="row">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('') }}</label>
                                <div class="col-lg-7 fv-row ml-8-px">
                                    <div class="d-flex align-items-center mt-3 ml-4">
                                        <input type="hidden" id="dateTimeErr">
                                        <p class="error text-danger"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="site_criteria">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Site Location') }}</label>
                            <div class="col-lg-8 fv-row">
                                <div class="block_1 row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <select name="site_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" id="">
                                                <option value="">Select Location</option>
                                                <option value="0">Rockwood Park Golf Coursek</option>
                                                <option value="1">Keet on Park</option>
                                            </select>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div id="booking_criteria">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Booking Criteria') }}</label>
                            <div class="col-lg-8 fv-row">
                                <div class="block_1 row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Location ZipCode') }}</label>
                                            <textarea name="location" id="location" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Location">{{ !empty($userSettingData) ? $userSettingData->location :'' }}</textarea>
                                            <p class="error text-danger"></p>
                                        </div>    
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Location Name') }}</label>
                                            <textarea name="category" id="category" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Category">{{ !empty($userSettingData) ? $userSettingData->category :'' }}</textarea>
                                            <p class="error text-danger"></p>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                
                    <div id="site_availibility">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Profile Status') }}</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" name="status" type="checkbox" value="1" id="flexCheckChecked"/>
                                            <label class="form-check-label" for="flexCheckChecked">{{"Active"}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->

                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary" id="profile_details_submit">
                        @include('partials.general._button-indicator', ['label' => __('Save Changes')])
                    </button>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
    
</x-default-layout> 

<script>
    // ONLY NUMBER ALLOWS
    function validatePhone(e) {
        e = e || window.event;
        var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
        var charStr = String.fromCharCode(charCode);
        if (!charStr.match(/^[0-9]+$/))
            e.preventDefault();
    }
    
</script>

<script>
    // ADD MORE DATE TIME SLOT
    var dateSlot = 0;
    function add_dateTime_slot(){
        var slot_count = $("#slot_count").val();
        slot_count = parseInt(slot_count)+1;
        console.log("slot_count >>>>", slot_count);
        dateSlot++;
        var field = '<div class="row date_append_'+dateSlot+'">'+
                        '<label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('') }}</label>'+
                        '<div class="col-lg-7 fv-row ml-8-px">'+
                            '<div class="d-flex align-items-center mt-3">'+
                                '<label class="form-check-inline form-check-solid me-5">'+
                                    '<select name="slot['+slot_count+'][day]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" id="day_'+dateSlot+'">'+
                                        '<option value="Monday">Monday</option>'+
                                        '<option value="Tuesday">Tuesday</option>'+
                                        '<option value="Wednesday">Wednesday</option>'+
                                        '<option value="Thursday">Thursday</option>'+
                                        '<option value="Friday">Friday</option>'+
                                        '<option value="Saturday">Saturday</option>'+
                                        '<option value="Sunday">Sunday</option>'+
                                    '</select>'+
                                '</label>'+
                                '<label class="form-check-inline form-check-solid me-5">'+
                                    '<input type="time" name="slot['+slot_count+'][from]" id="from'+dateSlot+'" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value=""/>'+
                                '</label>'+
                                '<label class="form-check-inline form-check-solid">'+
                                    '<input type="time" name="slot['+slot_count+'][to]" id="to'+dateSlot+'" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value=""/>'+
                                '</label>'+
                                '<label class="form-check-inline form-check-solid">'+
                                '<a class="btn btn-danger remove_date_slot" data-append_id="date_append_'+dateSlot+'">'+
                                    '<i class="fa-solid fa-minus fa-2xl" ></i>'+
                                '</a>'+
                                '</label>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
            $("#more_date_time_slot").append(field);
            $("#slot_count").val(slot_count);
    }

    $(document).on('click','.remove_date_slot',function(e){
		e.preventDefault();
        var slot_count = $("#slot_count").val();
        console.log("slot_count >> ", slot_count);
        slot_count = parseInt(slot_count)-1;
        console.log("slot_count >> ", slot_count);
		var ids=$(this).data("append_id");
        console.log("ids >> ", ids);
		$("."+ids).html('');
        $("#slot_count").val(slot_count);
	});


    $(document).on('click','.remove_booking_criteria',function(e){
        e.preventDefault();
        var ids=$(this).data("append_id");
        $("#"+ids).html('');
    });

</script>

<!-- STORE USER SETTINGS -->
<script>
    $(document).ready(function() {
        $('#userSettingFrm').on('submit', function(e) {
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
                url: "{{ route('user_setting_store') }}",
                data: formData,
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
                        $.each(response.msg, function(key, value) {
                            $(`#${key}`).siblings('p').html(value);
                        });
                    }
                    if(response.status == "arrayError"){
                        $.each(response.msg, function(key, value) {
                            $(`#${key}`).html(value);
                        });
                    }

                }
            });
        });

        $(".delete_criterea").on("click", function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {   
                    var c_id = $(this).data("criterea_id");
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'POST',
                        url: "{{ route('delete_criterea') }}",
                        data: {
                            "c_id":c_id
                        },
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
            });
        });

        $(".remove_slot").on("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {                    
                    var slot_id = $(this).data("slot_id");
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'POST',
                        url: "{{ route('delete_day_slot') }}",
                        data: {
                            "slot_id":slot_id
                        },
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
            });
        });
    });
</script>
