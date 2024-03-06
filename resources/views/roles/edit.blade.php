@extends("admin.layouts.master")
@section("content")
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit {{$role->name}}</h6>
                    <form action="{{route("user-management.roles.update",["role"=>$role->id])}}" method="POST">
                        @csrf
                        @method("PUT")
                        <x-validation-error />
                        <div class="form-group">
                            <label for="exampleInputText1">Name</label>
                            <input type="text" class="form-control" id="exampleInputText1"
                                   value="{{$role->name}}" placeholder="Enter Name" required name="name">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect2" class="d-flex">Roles <span class="text-danger mx-1">*</span>
                                <button type="button" class="mx-1 btn btn-sm btn-info" onclick="selectAllPermissions()">Select All</button>
                                <button type="button" class="mx-1 btn btn-sm btn-info" onclick="deselectAllPermissions()">Deselect All</button>
                            </label>
                            <select multiple class="form-control select2multiple" required id="exampleFormControlSelect2" name="permissions[]">
                                @foreach($permissions as $permission)
                                    <option value="{{$permission->name}}" @if(in_array($permission->name,$role->permissions->pluck("name")->toArray())) selected @endif >{{$permission->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("js")
    <script>

        function selectAllPermissions(){
            // Get the Select2 instance
            var select2Instance = $(".select2multiple");

            // Get all options within the Select2 dropdown
            var allOptions = select2Instance.find('option');

            // Set all options as selected
            allOptions.prop('selected', true);

            // Trigger the change event to update the Select2 UI
            select2Instance.trigger('change');
        }

        function deselectAllPermissions(){
            var select2Instance = $(".select2multiple");
            var allOptions = select2Instance.find('option');
            allOptions.prop('selected', false);
            select2Instance.trigger('change');
        }
    </script>
    <script src="{{asset("adminAEE")}}/assets/vendors/select2/select2.min.js"></script>
    <script src="{{asset("adminAEE")}}/assets/js/select2.js"></script>
@endpush
@push("css")
    <link rel="stylesheet" href="{{asset("adminAEE")}}/assets/vendors/select2/select2.min.css">
@endpush
