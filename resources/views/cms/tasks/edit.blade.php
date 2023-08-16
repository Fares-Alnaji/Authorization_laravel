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
                            <h3 class="card-title">Updated subCategory</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <label>Categories</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected($subCategory->category_id == $category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                              <div class="form-group">
                                  <label for="name">Name</label>
                                  <input type="text" class="form-control" id="name"
                                    name="name" value="{{ $subCategory->name }}"placeholder="Enter the Name">
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
        axios.put('/cms/admin/sub-categories/' + {{$subCategory->id}},{
            category_id: document.getElementById('category_id').value,
            name: document.getElementById('name').value,
        })
        .then(function (response){
            toastr.success(response.data.message);
            window.location.href = '/cms/admin/sub-categories';
        })
        .catch(function (error){
            toastr.error(error.response.data.message);
        })
    }
</script>
@endsection
