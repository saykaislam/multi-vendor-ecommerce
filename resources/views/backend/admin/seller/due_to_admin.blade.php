@extends('backend.layouts.master')
@section("title","Due To Admin")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Due To Admin</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Due To Admin</li>
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
                            <form role="form" action="{{route('admin.due-to-admin-details')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <label>Seller List</label>
                                        <select name="seller_id" id="" class="form-control select2">
                                            @foreach($sellers as $seller)
                                                <option value="{{$seller->id}}" {{$sellerId == $seller->id ? 'selected' : ''}}>{{$seller->name}} ({{$seller->shop->name}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4" style="margin-top: 30px">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        @if($sellerInfo != null)
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#Id</th>
                                    <th>Shop Name</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{$sellerInfo->shop->name}}</td>
                                    <td>{{$sellerInfo->seller_will_pay_admin}}</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#Id</th>
                                    <th>Shop Name</th>
                                    <th>Amount</th>
                                </tr>
                                </tfoot>
                            </table>
                        @else
                            <div class="text-center ">
                                <h2><i class="fa fa-info-circle text-info"></i> Please Select Seller!!!</h2>
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
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
    </script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2();
        /*$('.textarea').wysihtml5({
            toolbar: { fa: true }
        })*/
    </script>
@endpush
