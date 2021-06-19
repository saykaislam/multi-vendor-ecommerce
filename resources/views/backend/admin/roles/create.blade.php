@extends('backend.layouts.master')
@section("title","Roles")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h1>Roles</h1>
                </div>
                <div class="col-sm-4">
                    <div class="float-left">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Add Permission
                        </button>
                    </div>
                </div>
                <div class="col-sm-3">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-8 offset-2">
            <!-- general form elements -->
                <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title float-left">Add Roles</h3>

                    <div class="float-right">
                        <a href="{{route('admin.roles.index')}}">
                            <button class="btn btn-success">
                                <i class="fa fa-backward"> </i>
                                Back
                            </button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{route('admin.roles.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Role Name" required>
                        </div>
                        <div class="form-group">
                            <h3>Permissions</h3>
                            <p class="bg-info pl-3">
                                <input type="checkbox" id="checkAll"> By a click you can select all
                            </p>
                            <ul style="height: 415px; overflow-y: scroll;">
                                @foreach($permission as $per)
                                <li>
                                    <label for="permission">
                                        <input type="checkbox" class="checkbox" name="permission[]" id="permission" value="{{$per->id}}"> {{$per->name}}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </section>

    <!-- Modal permission add-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Permission List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{URL('admin/roles/permission')}}" method="post">
                        @csrf
                        {{--<div class="form-group">
                            <label for="due">Enter Controller <span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="controller_permission" aria-describedby="emailHelp" name="controller_name" placeholder="ProductController">
                        </div>--}}
                        <div class="form-group">
                            <label for="due">Enter Controller Action <span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="permission" aria-describedby="emailHelp" name="name" placeholder="product-list">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

@endpush
