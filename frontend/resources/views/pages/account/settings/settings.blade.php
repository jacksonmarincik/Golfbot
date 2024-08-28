
<x-default-layout>
    <!-- Get profile info -->
    {{--@include('pages/account/_navbar', array('class' => 'mb-5 mb-xl-10', 'info' => $info))--}}

    @include('pages/account/settings/_profile-details', array('class' => 'mb-5 mb-xl-10', 'info' => $info))
    @include('pages/account/settings/_signin-method', array('class' => 'mb-5 mb-xl-10', 'info' => $info))
</x-default-layout>
