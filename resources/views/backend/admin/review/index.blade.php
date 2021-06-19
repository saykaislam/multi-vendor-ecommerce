@extends('backend.layouts.master')
@section("title","Review List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
    <style>
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 0px 6px!important;
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Review List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Review List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="callout callout-info">
                        <div class="card card-info" style="padding: 20px 40px 40px 40px;">
                            <form role="form" action="{{route('admin.review.details')}}" method="POST" style="padding-left: 250px;">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <label>Ratings</label>
                                        <select name="rating" id="" class="form-control select2">
                                                <option value="5" {{$value == 5 ? 'selected' : ''}}>5</option>
                                                <option value="4" {{$value == 4 ? 'selected' : ''}}>4</option>
                                                <option value="3" {{$value == 3 ? 'selected' : ''}}>3</option>
                                                <option value="2" {{$value == 2 ? 'selected' : ''}}>2</option>
                                                <option value="1" {{$value == 1 ? 'selected' : ''}}>1</option>
                                        </select>
                                    </div>
                                    <div class="col-4" style="margin-top: 30px;">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        @if($reviews != null)
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#Id</th>
                                    <th>Customer name</th>
                                    <th>Shop name</th>
                                    <th>Product name</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reviews as $key => $review)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>
                                            {{$review->user->name}}
                                            @if($review->viewed == 0)
                                                <span class="right badge badge-danger">New</span>
                                            @endif</td>
                                        <td>
                                            @if($review->shop != null)
                                                {{$review->shop->name}}
                                            @endif
                                        </td>
                                        <td>{{$review->product->name}}</td>
                                        <td>{{$review->rating}}</td>
                                        <td>
                                            <div class="form-group col-md-2">
                                                <label class="switch" style="margin-top:40px;">
                                                    <input onchange="update_review_status(this)" value="{{ $review->id }}" {{$review->status == 1? 'checked':''}} type="checkbox" >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="btn btn-info waves-effect" href="{{route('admin.review.view',$review->id)}}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#Id</th>
                                    <th>User name</th>
                                    <th>Shop name</th>
                                    <th>Product name</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        @else
                            <div class="text-center ">
                                <h2><i class="fa fa-info-circle text-info"></i> Please Select Rating!!!</h2>
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
{{--    <section class="content">--}}
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                <div class="card card-info card-outline">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="card-title float-left">Review Lists</h3>--}}
{{--                        <div class="float-right">--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- /.card-header -->--}}
{{--                    <div class="card-body table-responsive">--}}
{{--                        <table id="example1" class="table table-bordered table-striped">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#Id</th>--}}
{{--                                <th>User name</th>--}}
{{--                                <th>Shop name</th>--}}
{{--                                <th>Product name</th>--}}
{{--                                <th>Rating</th>--}}
{{--                                <th>Status</th>--}}
{{--                                <th>Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($reviews as $key => $review)--}}
{{--                                <tr>--}}
{{--                                    <td>{{$key + 1}}--}}
{{--                                        @if($review->viewed == 0)--}}
{{--                                            <span class="right badge badge-danger">New</span>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                    <td>{{$review->user->name}}</td>--}}
{{--                                    <td>--}}
{{--                                        @if($review->shop != null)--}}
{{--                                        {{$review->shop->name}}--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                    <td>{{$review->product->name}}</td>--}}
{{--                                    <td>{{$review->rating}}</td>--}}
{{--                                    <td>--}}
{{--                                        <div class="form-group col-md-2">--}}
{{--                                            <label class="switch" style="margin-top:40px;">--}}
{{--                                                <input onchange="update_review_status(this)" value="{{ $review->id }}" {{$review->status == 1? 'checked':''}} type="checkbox" >--}}
{{--                                                <span class="slider round"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <a class="btn btn-info waves-effect" href="{{route('admin.review.view',$review->id)}}">--}}
{{--                                            <i class="fa fa-eye"></i>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                            <tfoot>--}}
{{--                            <tr>--}}
{{--                                <th>#Id</th>--}}
{{--                                <th>User name</th>--}}
{{--                                <th>Shop name</th>--}}
{{--                                <th>Product name</th>--}}
{{--                                <th>Rating</th>--}}
{{--                                <th>Status</th>--}}
{{--                                <th>Action</th>--}}
{{--                            </tr>--}}
{{--                            </tfoot>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                    <!-- /.card-body -->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}





@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        //sweet alert
        function deleteCategory(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your Data is save :)',
                        'error'
                    )
                }
            })
        }
            //Initialize Select2 Elements
            $('.select2').select2();
            /*$('.textarea').wysihtml5({
            toolbar: { fa: true }
        })*/
        //today's deals
        function update_review_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('admin.review.status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    toastr.success('success', 'Status updated successfully');
                }
                else{
                    toastr.danger('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endpush
