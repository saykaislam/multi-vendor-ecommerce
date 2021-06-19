<form class="form-horizontal" action="{{route('admin.seller.commissions.pay_to_seller')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Pay to seller</h5>
        {{--<h4 class="modal-title" id="myModalLabel">Pay to seller</h4>--}}
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>

    <div class="modal-body">
        <div>
            <table class="table ">
                <tbody>
                    <tr>
                        @if($seller->admin_to_pay >= 0)
                            <td>Due to seller</td>
                            <td>{{ $seller->admin_to_pay }}</td>
                        @endif
                    </tr>
                    @if ($seller->bank_payment_status == 1)
                        <tr>
                            <td>Bank Name</td>
                            <td>{{$seller->bank_name}}</td>
                        </tr>
                        <tr>
                            <td>Bank Account Name</td>
                            <td>{{ $seller->bank_acc_name }}</td>
                        </tr>
                        <tr>
                            <td>Bank Account Number</td>
                            <td>{{ $seller->bank_acc_no }}</td>
                        </tr>
                        <tr>
                            <td>Bank Routing Number</td>
                            <td>{{ $seller->bank_routing_no }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($seller->admin_to_pay > 0)
            <input type="hidden" name="seller_id" value="{{ $seller->id }}">
            <input type="hidden" name="type" value="payment">
            <div class="form-group row">
                <label class="col-sm-4 control-label" for="amount">Amount</label>
                <div class="col-sm-8">
                    <input type="number" min="0" step="0.01" name="amount" id="amount" value="{{ $seller->admin_to_pay }}" class="form-control" max="{{$seller->admin_to_pay}}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 control-label" for="payment_option">Payment Method</label>
                <div class="col-sm-8">
                    <select name="payment_option" id="payment_option" class="form-control demo-select2-placeholder" required>
                        <option value="">Select Payment Method</option>
                        @if($seller->cash_on_delivery_status == 1)
                            <option value="cash">Cash</option>
                        @endif
                        @if($seller->bank_payment_status == 1)
                            <option value="bank_payment">Bank Payment</option>
                        @endif
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
            @if ($seller->admin_to_pay > 0)
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
