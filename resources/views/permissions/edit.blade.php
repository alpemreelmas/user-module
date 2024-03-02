@extends("admin.layouts.master")
@section("content")
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit {{$permission->name}}</h6>
                    <form action="{{route("user-management.permissions.update",["permission"=>$permission->id])}}" method="POST">
                        @csrf
                        @method("PUT")
                        <x-validation-error />
                        <div class="form-group">
                            <label for="exampleInputText1">Name</label>
                            <input type="text" class="form-control" id="exampleInputText1"
                                   value="{{$permission->name}}" placeholder="Enter Name" required name="name">
                        </div>
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
