@extends("admin.layouts.master")
@push("css")
    <link rel="stylesheet" href="{{asset("adminAEE")}}/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endpush
@section("content")
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">User Management</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permissions</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card d-flex flex-column">
            <div class="d-flex justify-content-between">
                {{--@can(auth()->user()->can("user_create"))
                    <a class="btn btn-primary my-3 w-auto d-flex justify-content-center align-items-center"
                       style="max-width: 200px" title="Add user" href="{{route("user-management.permissions.create")}}">
                        <span>Add user</span>
                    </a>
                @endcan
                @if(!request()->query("only_trashed") || request()->query("only_trashed") === "false")
                    <a class="btn btn-danger my-3 w-auto d-flex justify-content-center align-items-center"
                       style="max-width: 150px" title="Only Trashed" href="{{url("/admin/users?only_trashed=true")}}">
                        <span>Only Trashed</span>
                    </a>
                @endif
                @if(request()->query("only_trashed") && request()->query("only_trashed") === "true")
                    <a class="btn btn-secondary btn-icon-text my-3 w-auto d-flex justify-content-center align-items-center"
                       style="max-width: 200px" title="Go Back" href="{{url("/admin/users")}}">
                        <i data-feather="arrow-left" class="feather-12"></i>
                        Go Back
                    </a>
                @endif--}}
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Permissions</h6>
                    <x-validation-error />
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table datatableAEE">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Created At</th>
                                <th>Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{$permission->id}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td>{{$permission->created_at}}</td>
                                    <td class="flex-nowrap d-flex">
                                        @if(auth()->user()->can("user_update") && !$permission->deleted_at)
                                            <a
                                                class="btn btn-primary btn-icon d-flex justify-content-center align-items-center mr-2"
                                                title="Edit User"
                                                href="{{route("user-management.permissions.edit",["permission" => $permission->id])}}">
                                                <i data-feather="edit"></i>
                                            </a>
                                        @endif
                                        {{--@if(auth()->user()->can("user_delete") && !$user->deleted_at)
                                            <form method="POST"
                                                  action="{{route("user-management.users.delete",["user" => $user->id])}}">
                                                @method("DELETE")
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-danger btn-icon d-flex justify-content-center align-items-center"
                                                        title="Remove User">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if(auth()->user()->can("user_restore") && $user->deleted_at)
                                            <form method="POST"
                                                  action="{{route("user-management.users.restore",["id"=>$user->id])}}"
                                                  class="mr-2">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-info btn-icon d-flex justify-content-center align-items-center"
                                                        title="Restore User">
                                                    <i data-feather="upload-cloud"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if(auth()->user()->can("user_force_delete") && $user->deleted_at)
                                            <form method="POST"
                                                  action="{{route("user-management.users.forceDelete",["id"=>$user->id])}}">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-danger btn-icon d-flex justify-content-center align-items-center"
                                                        title="Force Delete User">
                                                    <i data-feather="trash"></i>
                                                </button>
                                            </form>
                                        @endif--}}
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push("js")
    <!-- plugin js for this page -->
    <script src="{{asset("adminAEE")}}/assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="{{asset("adminAEE")}}/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="{{asset("adminAEE")}}/assets/js/data-table.js"></script>
@endpush
