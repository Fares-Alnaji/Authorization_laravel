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
                            <h3 class="card-title">Create Admin</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" class="form-control" id="current_password"
                                        placeholder="Current Password" value="">
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" class="form-control" id="new_password"
                                        placeholder="Current Password" value="">
                                </div>
                                <div class="form-group">
                                    <label for="new_password_confirmation">New Password Confirmation</label>
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        placeholder="Current Password Confirmation" value="">
                                </div>
                            </div>

                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="button" onclick="edit()" class="btn btn-primary">Submit</button>
                    </div>
                    </form>
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
    function edit() {
        axios.put('/cms/admin/edit-password', {
            current_password: document.getElementById('current_password').value,
            new_password: document.getElementById('new_password').value,
            new_password_confirmation: document.getElementById('new_password_confirmation').value,
            }).then(function(response) {
                toastr.success(response.data.message);
                window.location.href = '/cms/admin';
            })
            .catch(function(error) {
                console.log('ffff');
                toastr.error(error.response.data.message);
            });
    }
</script>
@endsection
