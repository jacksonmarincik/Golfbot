<x-default-layout>

    <div class="container">
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
          <div class="card-header cursor-pointer">
            
            <div class="col-sm-12 col-md-9 align-self-center m-auto">
                <form action="{{ route('orders') }}" id="filterdata">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <select name="username" id="username" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" >
                                <option value="">Select Profile name</option>
                                @foreach ($user_setting_data as $key => $value)
                                    <option value="{{ $key }}" {{ (Request::get('username') == $key) ? 'selected' : ''  }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <input type="date" name="date" id="userdate" class="form-control" value="{{ (Request::get('date')) ? Request::get('date') : '' }}">
                        </div>
                        <div class="col">
                            <a href="{{ route('orders') }}" class="btn btn-primary">Reset</a>
                        </div>
                    </div>
                </form>    
            </div>
        </div>

        <div class="card-body p-9">
  
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead>
                    <tr class="border-0">
                        <th>No</th>
                        <th>Profile Name</th>
                        <th>Book Time</th>
                        <th>Book Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                @php
                    $i = 1;
                @endphp
                <tbody>
                    @if (count($orders) > 0)
                        @foreach ($orders as $key => $data)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $data->user_name }}</td>
                                <td>{{ date('h:i a', strtotime($data->book_time)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($data->book_date)) }}</td>
                                <td>{!! $data->status == 1 ? '<span class="badge badge-success">Booked</span>' : '<span class="badge badge-danger">Not Booked</span>' !!}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="5">There are no record found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="pagination-area d-flex justify-content-center">
                <div class="pagination">
                {!! $orders->links() !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#username').on('change', function(){
            $('#filterdata').submit();
        });

        $('#userdate').on('change', function(){
            $('#filterdata').submit();
        });

        $('#status').on('change', function(){
            $('#filterdata').submit();
        });
    </script>

</x-default-layout>