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
                            <h3 class="card-title">Create Tasks</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                @csrf
                                @auth('admin')
                                    <div class="form-group">
                                        <label>Users</label>
                                        <select class="form-control" id="user_id" name="user_id">
                                            <option value="-1">Select User</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endauth
                                <div class="form-group">
                                    <label>Categories</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="-1">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>sub-Categories</label>
                                    <select class="form-control" id="sub_category_id" name="sub_category_id">
                                        {{-- <option value="{{ $sub->id }}">{{ $category->name }}</option> --}}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Enter the Name">
                                </div>
                                <div class="form-group">
                                    <label for="name">Info</label>
                                    <input type="text" class="form-control" id="info" name="info"
                                        placeholder="Enter the Info">
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
        controlFormInputs(true);
        $('#category_id').on('change', function() {
            controlFormInputs(this.value == -1);
            $('#sub_category_id').empty();
            if (this.value != -1) {
                getSubCategories(this.value);
            } else {
                $('#title').val('');
                $('#info').val('');
            }
        });

        function controlFormInputs(disabled) {
            $('#title').attr('disabled', disabled);
            $('#sub_category_id').attr('disabled', disabled);
            $('#info').attr('disabled', disabled);
        }

        function getSubCategories(categoryId) {
            axios.get('/cms/admin/categories/' + categoryId)
                .then(function(response) {
                    console.log(response);
                    if (response.data.subCategories.length != 0) {
                        $.each(response.data.subCategories, function(i, item) {
                            $('#sub_category_id').append(new Option(item['name'], item['id']));
                        })
                    } else {
                        $('#sub_category_id').attr('disabled', true);
                    }
                })
                .catch(function(error) {
                    toastr.error(error.response.data.message);
                })
        }
    </script>
    <script>
        function performSave() {

            let dataObject =  {
                    sub_category_id: document.getElementById('sub_category_id').value,
                    title: document.getElementById('title').value,
                    info: document.getElementById('info').value,
                }

                if('{{auth("admin")->check()}}') {
                    dataObject['user_id'] = document.getElementById('user_id').value;
                }
            axios.post('/cms/admin/tasks', dataObject)
                .then(function(response) {
                    toastr.success(response.data.message);
                })
                .catch(function(error) {
                    toastr.error(error.response.data.message);
                })
        }
    </script>
@endsection
