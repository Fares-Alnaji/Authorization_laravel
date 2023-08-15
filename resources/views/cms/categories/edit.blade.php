@extends('cms.parent')

@section('style')
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
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Updated Role</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                  <label>User Type</label>
                                  <select class="form-control" id="guard" name="guard">
                                          <option value="admin" @selected($role->guard_name == 'admin')>Admin</option>
                                          <option value="user" @selected($role->guard_name == 'user')>User</option>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <label for="name">Name</label>
                                  <input type="text" class="form-control" id="name"
                                    name="user_name" value="{{ old('name_ar') ?? $role->name }}"placeholder="Enter the Name">
                              </div>
                              <div class="card-footer">
                                  <button type="button" onclick="performSave()" class="btn btn-primary">Save</button>
                              </div>
                          </div>
                            <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
<script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
<script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
<script>
    function performSave(){
        axios.put('/cms/admin/roles/' + {{$role->id}},{
            guard: document.getElementById('guard').value,
            name: document.getElementById('name').value,
        })
        .then(function (response){
            toastr.success(response.data.message);
            window.location.href = '/cms/admin/roles';
        })
        .catch(function (error){
            toastr.error(error.response.data.message);
        })
    }
</script>
@endsection
