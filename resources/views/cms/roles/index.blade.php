@extends('cms.parent')

@section('style')
    <link rel="stylesheet" href="{{ asset('cms/css/style.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('cms/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
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
                            <h3 class="card-title">Responsive Hover Table</h3>

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
                                        <th>Permissions</th>
                                        <th style="width: 20%">Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr id="role_{{ $role->id }}">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td><a href="{{route('role.edit-permissions' , $role->id)}}" type="button" class="btn btn-block btn-outline-primary btn-sm">({{ $role->permissions_count }}) Permission/s</a></td>
                                            <td><span class="badge bg-success">{{ $role->guard_name }}</span></td>
                                            <td class="options">
                                                <a href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                                <button class="delete-btn" type="button"
                                                    onclick="deleteRoles('{{ $role->id }}')" style="color: red">
                                                    Delete</button>
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
<script src="{{ asset('cms/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
    <script>
        function deleteRoles(id) {
            axios.delete(`/cms/admin/roles/${id}`)
                .then(function(response) {
                    document.getElementById(`role_${id}`).remove();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
                .catch(function(error) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title:  error.response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
        }

        function showMessage(icon, message) {
            Swal.fire({
                position: 'center',
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: 1500
            })
        }
    </script>
@endsection
