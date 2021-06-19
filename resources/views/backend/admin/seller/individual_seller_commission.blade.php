<form class="form-horizontal" action="{{route('admin.seller.individual.commission.set',$seller->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Set Commission For <strong>{{$seller->user->name}}</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="commission">Commission <small class="text-info" >(Commission will be {{$seller->commission}} percent (%) for all seller.)</small></label>
            <input type="number" class="form-control" name="commission" value="{{$seller->commission}}" id="commission" placeholder="Set Commission for this seller" required>
        </div>
    </div>
    <div class="modal-footer">
        <div class="panel-footer text-right">
            <button class="btn btn-success" type="submit">Save</button>
            <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</form>
