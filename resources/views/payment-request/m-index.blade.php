@extends('layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Yêu cầu thanh toán
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'payment-request.index' ) }}">Yêu cầu thanh toán</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('payment-request.create',['bank_info_id' => $bank_info_id]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">       
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('payment-request.index') }}" id="searchForm">
            <div class="form-group">              
              <select class="form-control" name="status" id="status">
                <option value="">--Trạng thái--</option>
                <option value="1" {{ $status == 1 ? "selected" : "" }}>Chưa thanh toán</option>
                <option value="2" {{ $status == 2 ? "selected" : "" }}>Đã thanh toán</option>                
              </select>
            </div>
            @if(Auth::user()->role == 1)
            <div class="form-group">              
              <select class="form-control select2" name="city_id" id="city_id">
                <option value="">--Tỉnh/Thành--</option>
                <option value="1"  {{ $city_id == 1 ? "selected" : "" }}>Phú Quốc</option>
                <option value="2"  {{ $city_id == 2 ? "selected" : "" }}>Đà Nẵng</option>
              </select>
            </div> 
            @endif
            <div class="form-group">              
              <select class="form-control select2" name="bank_info_id" id="bank_info_id">
                <option value="">--Tài khoản đối tác--</option>
                @foreach($bankInfoList as $cate)
                <option value="{{ $cate->id }}" {{ $arrSearch['bank_info_id'] == $cate->id ? "selected" : "" }}>{{ $cate->name }}</option>
                @endforeach
              </select>
            </div>
            @if(Auth::user()->role == 1)         
            <div class="form-group">              
              <select class="form-control" name="payer" id="payer">
                <option value="">--Người chi--</option>
                <option value="1" {{ $payer == 1 ? "selected" : "" }}>Nguyễn Hoàng</option>
                <option value="2" {{ $payer == 2 ? "selected" : "" }}>Thương Trần</option>
                <option value="3" {{ $payer == 3 ? "selected" : "" }}>Như Ngọc</option>  
                <option value="4" {{ $payer == 4 ? "selected" : "" }}>Mộng Tuyền</option>                
              </select>
            </div>
            @endif 
            <div class="form-group">              
              <select class="form-control" name="time_type" id="time_type">
                <option value="">--Thời gian--</option>                
                <option value="1" {{ $time_type == 1 ? "selected" : "" }}>Theo tháng</option>
                <option value="2" {{ $time_type == 2 ? "selected" : "" }}>Khoảng ngày</option>
                <option value="3" {{ $time_type == 3 ? "selected" : "" }}>Ngày cụ thể </option>
              </select>
            </div> 
            @if($time_type == 1)
            <div class="form-group  chon-thang">                
                <select class="form-control" id="month_change" name="month">
                  <option value="">--THÁNG--</option>
                  @for($i = 1; $i <=12; $i++)
                  <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}" {{ $month == $i ? "selected" : "" }}>{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group  chon-thang">                
                <select class="form-control" id="year_change" name="year">
                  <option value="">--Năm--</option>
                  <option value="2020" {{ $year == 2020 ? "selected" : "" }}>2020</option>
                  <option value="2021" {{ $year == 2021 ? "selected" : "" }}>2021</option>
                  <option value="2022" {{ $year == 2022 ? "selected" : "" }}>2022</option>
                </select>
              </div>
            @endif
            @if($time_type == 2 || $time_type == 3)
            
            <div class="form-group chon-ngay">              
              <input type="text" class="form-control datepicker" autocomplete="off" name="use_date_from" placeholder="Từ ngày" value="{{ $arrSearch['use_date_from'] }}" style="width: 100px">
            </div>
           
            @if($time_type == 2)
            <div class="form-group chon-ngay den-ngay">              
              <input type="text" class="form-control datepicker" autocomplete="off" name="use_date_to" placeholder="Đến ngày" value="{{ $arrSearch['use_date_to'] }}" style="width: 100px">
            </div>
             @endif
            @endif
            <button type="submit" class="btn btn-info btn-sm" style="margin-top: -5px">Lọc</button>            
          </form>         
        </div>
      </div>
      <p style="text-align: right;"><a href="javascript:;" class="btn btn-primary btn-sm" id="btnExport">Export Excel</a>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( <span class="value">{{ $items->total() }} mục )</span> - Tổng tiền: <span style="color:red">{{ number_format($total_actual_amount) }}</span></h3>
        </div>
        @if(Auth::user()->role == 1)
        <div class="form-inline" style="padding: 5px">
          <div class="form-group">            
            <select class="form-control select2 multi-change-column-value" data-column="nguoi_chi">
                <option value="">--SET NGƯỜI CHI--</option>
                <option value="1">Nguyễn Hoàng</option>
                <option value="2">Thương Trần</option>
                <option value="3">Như Ngọc</option>                 
              </select>                         
          </div>
          <div class="form-group">            
            <select class="form-control select2 multi-change-column-value" data-column="city_id">
                <option value="">--SET TỈNH/THÀNH--</option>
                <option value="1">Phú Quốc</option>
                <option value="2">Đà Nẵng</option>                
              </select>                         
          </div>
        </div>
        @endif
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
            {{ $items->links() }}
          </div>  
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table-list-data">
            <tr>                   
              <th style="width: 1%"><input type="checkbox" id="check_all" value="1"></th>
              <th style="width: 1%">#</th>
              <th class="text-left">Ngày</th>
              <th class="text-left">User</th>
              <th class="text-left">Số TK</th>
              <th class="text-left">Nội dung</th>
              <th class="text-center">Hình ảnh</th>
              <th class="text-center">UNC</th>
              <th class="text-right">Số tiền</th>
              <th width="1%" style="white-space: nowrap;" class="text-center">Người chi</th>
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
              <tr class="cost" id="row-{{ $item->id }}">                
                <td>
                  <input type="checkbox" id="checked{{ $item->id }}" class="check_one" value="{{ $item->id }}">
                </td>                
                <td><span class="order">{{ $i }}</span></td>   
                <td class="text-left">  
                    {{ date('d/m/Y', strtotime($item->date_pay)) }}  <br>
                    @if($item->status == 1)
                    <label class="label label-danger label-sm">Chưa thanh toán</label>
                    @else
                    <label class="label label-success label-sm">Đã thanh toán</label>
                    @endif 
                    @if($item->urgent == 1)
                    <label class="label label-warning label-sm">GẤP</label>
                    @endif                       
                </td>
                <td class="text-left">{{ $item->user->name }}</td>
                <td class="text-left">
                  @if($item->bank)
                  {{ $item->bank->name }}<br>
                  {{ $item->bank->bank_name }}-{{ $item->bank->account_name }}-{{ $item->bank->bank_no }}
                  @endif
                </td>
                <td>
                  @if($item->costType)
                  <a href="{{ route( 'payment-request.edit', [ 'id' => $item->id ]) }}">{{ $item->costType->name }}</a>
                  @endif
                  @if($item->partner)
                  - {{ $item->partner->name }}
                  @endif
                  <p style="color:red; font-style: italic">{{ $item->notes }}</p>
                </td>
               <td class="text-center">
                  @if($item->image_url)
                  <span style="color: blue; cursor: pointer;" class="img-unc" data-src="{{ config('plantotravel.upload_url').str_replace('uploads/', '', $item->image_url) }}">XEM ẢNH</span>               
                  @endif
                </td>  
                <td class="text-center">
                  @if($item->unc_url)
                  <span style="color: blue; cursor: pointer;" class="img-unc" data-src="{{ config('plantotravel.upload_url').str_replace('uploads/', '', $item->unc_url) }}">XEM ẢNH</span>               
                  @endif
                </td>        
                <td class="text-right">
                  {{ number_format($item->total_money) }}                   
                </td>
                <td class="text-center" style="white-space: nowrap;">
                  @if($item->payer == 1)
                  Nguyễn Hoàng
                  @elseif($item->payer == 2)
                  Thương Trần
                  @elseif($item->payer == 3)
                  Như Ngọc
                  @endif
                </td>                
                <td style="white-space:nowrap">                                              
                  <a href="{{ route( 'payment-request.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>
                  @if($item->costType)
                  <a onclick="return callDelete('{{ $item->costType->name . " - ".number_format($item->total_money) }}','{{ route( 'payment-request.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                  @else
                  <a onclick="return callDelete('{{ number_format($item->total_money) }}','{{ route( 'payment-request.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                  @endif
                  
                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="4">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>
          </div>
          
          <div style="text-align:center">
            {{ $items->links() }}
          </div>  
        </div>  
        @if(Auth::user()->role == 1)
        <div class="form-inline" style="padding: 5px">
          <div class="form-group">            
            <select class="form-control select2 multi-change-column-value" data-column="nguoi_chi">
                <option value="">--SET NGƯỜI CHI--</option>
                <option value="1">Nguyễn Hoàng</option>
                <option value="2">Thương Trần</option>
                <option value="3">Như Ngọc</option>                 
              </select>                         
          </div>
          <div class="form-group">            
            <select class="form-control select2 multi-change-column-value" data-column="city_id">
                <option value="">--SET TỈNH/THÀNH--</option>
                <option value="1">Phú Quốc</option>
                <option value="2">Đà Nẵng</option>                
              </select>                         
          </div>   
        </div>
        @endif      
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
<div class="modal fade" id="uncModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="text-align: center;">
       <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" id="unc_img" style="width: 100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="table_name" value="articles">
@stop
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    $('#urgent').change(function(){
      $('#searchForm').submit();
    });
    $('.multi-change-column-value').change(function(){
          var obj = $(this);      
          $('.check_one:checked').each(function(){
              $.ajax({
                url : "{{ route('payment-request.change-value-by-column') }}",
                type : 'GET',
                data : {
                  id : $(this).val(),
                  col : obj.data('column'),
                  value: obj.val()
                },
                success: function(data){

                }
              });
          });
          
       });
    $('tr.cost').click(function(){
      $(this).find('.check_one').attr('checked', 'checked');
    });
    $("#check_all").click(function(){
        $('input.check_one').not(this).prop('checked', this.checked);
    });
    $('#btnExport').click(function(){
        var oldAction = $('#searchForm').attr('action');
        $('#searchForm').attr('action', "{{ route('payment-request.export') }}").submit().attr('action', oldAction);
      }); 
  });
  $(document).ready(function(){
    $('.img-unc').click(function(){
      $('#unc_img').attr('src', $(this).data('src'));
      $('#uncModal').modal('show');
    }); 
  });
</script>
@stop