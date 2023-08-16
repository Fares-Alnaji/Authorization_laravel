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
                                        <th style="width: 55%">Name</th>
                                        <th style="width: 40%">Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subCategories as $subCategory)
                                        <tr id="subCategory_{{ $subCategory->id }}">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $subCategory->name }}</td>
                                            {{-- <td><a href="{{route('subCategory.edit-permissions' , $subCategory->id)}}" type="button" class="btn btn-block btn-outline-primary btn-sm">({{ $subCategory->permissions_count }}) Permission/s</a></td> --}}
                                            <td class="options">
                                                <a href="{{ route('sub-categories.edit', $subCategory->id) }}">Edit</a>
                                                <button class="delete-btn" type="button"
                                                    onclick="deleteRoles('{{ $subCategory->id }}')" style="color: red">
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
            axios.delete(`/cms/admin/sub-categories/${id}`)
                .then(function(response) {
                    document.getElementById(`subCategory_${id}`).remove();
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
