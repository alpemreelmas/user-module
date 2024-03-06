@extends("admin.layouts.master")
@push("css")
    <link rel="stylesheet" href="{{asset("adminAEE")}}/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endpush
@section("content")
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">User Management</a></li>
            <li class="breadcrumb-item active" aria-current="page">Roles</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card d-flex flex-column">
            <div class="d-flex justify-content-between">
                @can("user_create")
                    <a class="btn btn-primary my-3 w-auto d-flex justify-content-center align-items-center"
                       style="max-width: 200px" title="Add role" href="{{route("user-management.roles.create")}}">
                        <span>Add role</span>
                    </a>
                @endcan
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Roles</h6>
                    <x-validation-error />
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table datatableAEE">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Created At</th>
                                <th>Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    {{-- TODO : check if this query is n+1 --}}
                                    <td class="flex-wrap">
                                        @foreach($role->permissions->pluck("name") as $permission)
                                            <span class="badge badge-primary ">{{$permission}}</span>&nbsp;
                                        @endforeach
                                    </td>
                                    <td>{{$role->created_at}}</td>
                                    <td class="flex-nowrap d-flex">
                                        @if(auth()->user()->can("user_update") && !$role->deleted_at)
                                            <a
                                                class="btn btn-primary btn-icon d-flex justify-content-center align-items-center mr-2"
                                                title="Edit User"
                                                href="{{route("user-management.roles.edit",["role" => $role->id])}}">
                                                <i data-feather="edit"></i>
                                            </a>
                                        @endif
                                        @if(auth()->user()->can("user_delete"))
                                            <form method="POST"
                                                  action="{{route("user-management.roles.delete",["role" => $role->id])}}">
                                                @method("DELETE")
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-danger btn-icon d-flex justify-content-center align-items-center"
                                                        title="Remove Role">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        @endif
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
