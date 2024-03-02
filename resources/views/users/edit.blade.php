@extends("admin.layouts.master")
@section("content")
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit {{$user->name}}</h6>
                    <form action="{{route("user-management.users.update",["user"=>$user->id])}}" method="POST">
                        @csrf
                        @method("PUT")
                        <x-validation-error />
                        <div class="form-group">
                            <label for="exampleInputText1">Name</label>
                            <input type="text" class="form-control" id="exampleInputText1"
                                   value="{{$user->name}}" placeholder="Enter Name" required name="name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail3"
                                   value="{{$user->email}}" placeholder="Enter Email" required name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="w-100 position-relative">
                                <input type="password" class="form-control" id="password" value="" name="password">
                                <button type="button" id="icon-of-password" onclick="changeVisibilityOfPassword()" class="password-eye" style="border:none;background: white; right:10px; top:5px" >
                                    <i data-feather="eye"></i>
                                </button>
                            </div>
                            <button class="btn btn-warning mt-2" type="button" onclick="generatePassword()">Generate Password</button>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect2" class="d-flex">Roles <span class="text-danger mx-1">*</span>
                                <button type="button" class="mx-1 btn btn-sm btn-info" onclick="selectAllRoles()">Select All</button>
                                <button type="button" class="mx-1 btn btn-sm btn-info" onclick="deselectAllRoles()">Deselect All</button>
                            </label>
                            <select multiple class="form-control select2multiple" required id="exampleFormControlSelect2" name="roles[]">
                                @foreach($roles as $role)
                                    <option value="{{$role->name}}" @if(in_array($role->name,$user->roles->pluck("name")->toArray())) selected @endif >{{$role->name}}</option>
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
        function generatePassword(){
            var length = 10,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }
            $("#password").val(retVal)
        }

        function changeVisibilityOfPassword(){
            const current = $("#password").attr("type")
            changeIconOfPasswordField(current)
            current === "text" ? $("#password").attr("type","password") : $("#password").attr("type","text")
        }


        function changeIconOfPasswordField(type){
            const eye = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" width=\"18\" height=\"18\" class=\"main-grid-item-icon\" fill=\"none\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\">\n" +
                "                                            <path d=\"M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z\" />\n" +
                "                                            <circle cx=\"12\" cy=\"12\" r=\"3\" />\n" +
                "                                        </svg>"
            const eyeOff = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" width=\"18\" height=\"18\" class=\"main-grid-item-icon\" fill=\"none\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\">\n" +
                "  <path d=\"M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24\" />\n" +
                "  <line x1=\"1\" x2=\"23\" y1=\"1\" y2=\"23\" />\n" +
                "</svg>"

            const iconOfPassword = $("#icon-of-password")

            type === "password" ? iconOfPassword.html(eyeOff) : iconOfPassword.html(eye)
        }

        function selectAllRoles(){
            // Get the Select2 instance
            var select2Instance = $(".select2multiple");

            // Get all options within the Select2 dropdown
            var allOptions = select2Instance.find('option');

            // Set all options as selected
            allOptions.prop('selected', true);

            // Trigger the change event to update the Select2 UI
            select2Instance.trigger('change');
        }

        function deselectAllRoles(){
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
