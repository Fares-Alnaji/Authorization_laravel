@extends('cms.parent')

@section('style')
    <link rel="stylesheet" href="{{ asset('cms/css/style.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
@endsection

@section('lg-title', '')
@section('main-title', '')
@section('sm-title', '')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User ({{ $user->full_name }}) - Permissions</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th style="width: 20%">Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr id="role_{{ $permission->id }}">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td><span class="badge bg-success">{{ $permission->guard_name }}</span></td>
                                            <td>
                                                <div class="form-group clearfix">
                                                    <div class="icheck-primary d-inline">
                                                        <input onclick="performUpdate('{{$permission->id}}')"
                                                            type="checkbox" id="permission_{{ $permission->id }}_ched_box" @checked($permission->assigned)>
                                                        <label for="permission_{{ $permission->id }}_ched_box">
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>

    <script>
        function performUpdate(permissionId) {
            axios.put('/cms/admin/users/{{$user->id}}/permissions' ,{
                    permission_id: permissionId,
                })
                .then(function(response) {
                    toastr.success(response.data.message);
                })
                .catch(function(error) {
                    toastr.error(error.response.data.message);
                })
        }
    </script>
@endsection
