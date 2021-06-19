<form class="form-horizontal" action="{{route('admin.withdraw-request.store',$seller->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Pay to Admin</h5>
        {{--<h4 class="modal-title" id="myModalLabel">Pay to seller</h4>--}}
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>

    <div class="modal-body">
        <div>
            <table class="table ">
                <tbody>
                <tr>
                    @if($seller->seller_will_pay_admin >= 0)
                        <td>Due to seller</td>
                        <td>{{ $seller->seller_will_pay_admin }}</td>
                    @endif
                </tr>
                </tbody>
            </table>
        </div>

        @if ($seller->seller_will_pay_admin > 0)
            <input type="hidden" name="seller_id" value="{{ $seller->id }}">
            <input type="hidden" name="type" value="payment">
            <div class="form-group row">
                <label class="col-sm-4 control-label" for="amount">Amount</label>
                <div class="col-sm-8">
                    <input type="number" min="0" step="0.01" name="amount" id="amount" value="{{ $seller->seller_will_pay_admin }}" class="form-control" max="{{$seller->seller_will_pay_admin}}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 control-label" for="payment_option">Payment Method</label>
                <div class="col-sm-8">
                    <select name="payment_option" id="payment_option" class="form-control demo-select2-placeholder" required>
                        <option value="">Select Payment Method</option>
                            <option value="cash">Cash</option>
                    </select>
                </div>
            </div>

            <div class="form-group row" id="txn_div">
                <label class="col-sm-4 control-label" for="txn_code">Txn Code</label>
                <div class="col-sm-8">
                    <input type="text" name="txn_code" id="txn_code" class="form-control">
                </div>
            </div>
        @endif

    </div>
    <div class="modal-footer">
        <div class="panel-footer text-right">
            @if ($seller->seller_will_pay_admin > 0)
                <button class="btn btn-success" type="submit">Pay</button>
            @endif
            <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        $('#payment_option').on('change', function() {
            if ( this.value == 'bank_payment')
            {
                $("#txn_div").show();
            }
            else
            {
                $("#txn_div").hide();
            }
        });
        $("#txn_div").hide();
    });
</script>
