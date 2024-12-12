<div class="alert alert-danger alert-dismissible" style="padding: 5px;padding-right: 35px;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
  <i class="icon fa fa-ban"></i> Hệ thống đang có <span style="font-size: 20">{{ $count }}</span> yêu cầu thanh toán GẤP. &nbsp;&nbsp;&nbsp;<a class="" href="{{ route('payment-request.index', ['status' => 1, 'urgent' => 1])}}" style="font-style: italic;text-decoration: underline;">Chi tiết</a>
</div>