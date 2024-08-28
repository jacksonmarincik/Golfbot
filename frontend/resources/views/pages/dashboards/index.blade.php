<x-default-layout>

    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <span>
            <strong>Hello, {{auth()->user()->name}}</strong>
        </span>
        <!--end::Col-->
    </div>
    <!--begin::Row-->
    @if(\Auth::user()->roles->first()->id == 1)
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" style="    height: 280px;">
                @include('partials/widgets/cards/_widget-20')
            </div>
            <!--end::Col-->
        </div>
    @endif
    <!--end::Row-->
{{--
    <!--begin::Row-->
    <div class="row gx-5 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-6 mb-5 mb-xl-10">
            @include('partials/widgets/charts/_widget-8')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xl-6 mb-5 mb-xl-10">
            @include('partials/widgets/tables/_widget-16')
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-6">
            @include('partials/widgets/cards/_widget-18')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xl-6">
            @include('partials/widgets/charts/_widget-36')
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xl-4">
            @include('partials/widgets/charts/_widget-35')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xl-8">
            @include('partials/widgets/tables/_widget-14')
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

--}}
{{--
    <!--begin::Row-->
    <div class="row gx-5 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-4">
            @include('partials/widgets/charts/_widget-31')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xl-8">
            @include('partials/widgets/charts/_widget-24')
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
--}}
</x-default-layout>
