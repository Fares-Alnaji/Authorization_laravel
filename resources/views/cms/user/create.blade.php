@extends('cms.parent')

@section('style')

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
                            <h3 class="card-title">Create User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('users.store') }}">
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                  </div>
                                  @endif
                                  @if (session()->has('message'))
                                  <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                     {{session()->get('message')}}
                                  </div>
                                  @endif
                                  @csrf
                                <div class="form-group">
                                    <label for="name_en">Name User</label>
                                    <input type="text" class="form-control" id="full_name"
                                      name="full_name" value="{{ old('full_name') }}" placeholder="Enter the Name">
                                </div>
                                <div class="form-group">
                                    <label for="name_er">Your Email</label>
                                    <input type="email" class="form-control" id="email"
                                      name="email" value="{{ old('email') }}" placeholder="Enter Your Email">
                                </div>
                                <div class="form-group">
                                    <label for="name_er">Your Password</label>
                                    <input type="password" class="form-control" id="user_password"
                                      name="user_password" value="{{ old('user_password') }}" placeholder="Enter Your Password">
                                </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
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
