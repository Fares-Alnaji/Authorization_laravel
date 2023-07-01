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
                            <h3 class="card-title">Create Roles</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('admins.store') }}">
                            <div class="card-body">
                                  @csrf
                                  <div class="form-group">
                                    <label>User Type</label>
                                    <select class="form-control" id="guard" name="city_id">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name"
                                      name="user_name"  placeholder="Enter the Name">
                                </div>
                                </div>

                                <div class="card-footer">
                                    <button type="button" onclick="performSave()" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
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
        axios.post('/cms/admin/roles',{
            guard: document.getElementById('guard').value,
            name: document.getElementById('name').value,
        })
        .then(function (response){
            toastr.success(response.data.message);
        })
        .catch(function (error){
            toastr.error(error.response.data.message);
        })
    }
</script>
@endsection
