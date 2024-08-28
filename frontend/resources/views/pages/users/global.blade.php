<x-default-layout>
    <div class="row">
        <form action="{{route('store-global-setting') }}" method="{{'POST'}}" class="form" id="frmPlaces">
            <div class="card shadow mb-5">
                <div class="card-header">
                    <div class="card-title">
                        {{$pageTitle}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">                            
                            @csrf
                            <div class="d-flex flex-column mb-8">
                                <div class="form-check">
                                    <input class="form-check-input" name="global-setting" type="checkbox" value="1" id="flexCheckChecked" {{$check ? "checked" : ""}} />
                                    <label class="form-check-label" for="flexCheckChecked">{{$check ? "Active" : "Inactive"}}</label>
                                </div>
                                {!! $check ? '<label class="text-muted mt-2">Uncheck if you want to disable setting</label>' : '<label class="text-muted mt-2">Check if you want to active setting</label>' !!}
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary" id="btnContact">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-default-layout>