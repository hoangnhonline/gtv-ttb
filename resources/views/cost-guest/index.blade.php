@extends('layout-guest')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Chi phí
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'cost-guest' ) }}">Chi phí</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">    
      
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('cost-guest') }}" id="searchForm">
           
            <div class="form-group"> 
              <select class="form-control select2" name="type">
                  <option value="-1" {{ $type == -1 ? "selected" : "" }}>--Phân loại--</option>
                  <option value="1" {{ $type == 1 ? "selected" : "" }}>Vận hành</option>
                  <option value="2" {{ $type == 2 ? "selected" : "" }}>Khác</option>                 
                </select>       
            </div>
            <div class="form-group">              
              <select class="form-control select2" name="cate_id" id="cate_id">
                <option value="">--Loại chi phí--</option>
                @foreach($cateList as $cate)
                <option value="{{ $cate->id }}" {{ $arrSearch['cate_id'] == $cate->id ? "selected" : "" }}>{{ $cate->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group" id="load_doi_tac">
              @if(!empty($partnerList ) || $partnerList->count() > 0)
                      
                <select class="form-control select2" id="partner_id" name="partner_id">     
                  <option value="">--Chọn--</option>      
                  @foreach($partnerList as $cate)
                  <option value="{{ $cate->id }}" {{ $partner_id == $cate->id ? "selected" : "" }}>
                    {{ $cate->name }}
                  </option>
                  @endforeach
                </select>
          
            @endif
            </div>  
           
            <div class="form-group">              
              <select class="form-control select2" name="time_type" id="time_type">                
                <option value="1" {{ $time_type == 1 ? "selected" : "" }}>Theo tháng</option>
                <option value="2" {{ $time_type == 2 ? "selected" : "" }}>Khoảng ngày</option>
                <option value="3" {{ $time_type == 3 ? "selected" : "" }}>Ngày cụ thể </option>
              </select>
            </div> 
            @if($time_type == 1)
            <div class="form-group  chon-thang">                
                <select class="form-control select2" id="month_change" name="month">
                  <option value="">--Tháng--</option>
                  @for($i = 1; $i <=12; $i++)
                  <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}" {{ $month == $i ? "selected" : "" }}>{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group  chon-thang">                
                <select class="form-control select2" id="year_change" name="year">
                  <option value="">--Năm--</option>                  
                  <option value="2022" {{ $year == 2022 ? "selected" : "" }}>2022</option>
                  <option value="2023" {{ $year == 2023 ? "selected" : "" }}>2023</option>
                  <option value="2024" {{ $year == 2024 ? "selected" : "" }}>2024</option>
                </select>
              </div>
            @endif
            @if($time_type == 2 || $time_type == 3)
            
            <div class="form-group chon-ngay">              
              <input type="text" class="form-control datepicker" autocomplete="off" name="use_date_from" placeholder="@if($time_type == 2) Từ ngày @else Ngày @endif" value="{{ $arrSearch['use_date_from'] }}" style="width: 100px">
            </div>
           
            @if($time_type == 2)
            <div class="form-group chon-ngay den-ngay">              
              <input type="text" class="form-control datepicker" autocomplete="off" name="use_date_to" placeholder="Đến ngày" value="{{ $arrSearch['use_date_to'] }}" style="width: 100px">
            </div>
             @endif
            @endif
            
            <button type="submit" class="btn btn-info btn-sm" style="margin-top: -5px">Lọc</button> 
            <button type="reset" class="btn btn-default btn-sm" style="margin-top: -5px">Reset</button>
             <div>
              @foreach($beachList as $beach)
                <div class="form-group">
                  &nbsp;&nbsp;&nbsp;<input type="checkbox" name="beach_ids[]" id="beach_ids" {{ in_array($beach->id, $arrSearch['beach_ids']) || empty($arrSearch['beach_ids']) ? "checked" : "" }} value="{{$beach->id}}">
                  <label for="beach_ids">{{$beach->name}}</label>
                </div>
              @endforeach
            </div>            
          </form>         
        </div>
      </div>
      <div class="panel" style="margin-bottom: 15px;">
        <div class="panel-body" style="padding: 5px;">
          <div class="table-responsive">
          <table class="table table-bordered" id="table_report" style="margin-bottom:0px;font-size: 14px;">
              <tr style="background-color: #f4f4f4">
                <th class="text-left">Tổng số lượng</th>
                <th class="text-right">Tổng chi phí</th>
                @foreach($arrReport as $cate_id => $amountByCate)
                <th class="text-right">{!! isset($cateArr[$cate_id]) ? $cateArr[$cate_id] : "<span style=color:red>Không xác định</span>" !!}</th>
                @endforeach
              </tr>
              <tr>
                <th class="text-left">{{ number_format($total_quantity) }}</th>
                <th class="text-right">{{ number_format($total_actual_amount) }}</th>
                @foreach($arrReport as $cate_id => $amountByCate)
                <th class="text-right">{{ number_format($amountByCate) }}</th>
                @endforeach
              </tr>
          </table>

        </div>
        </div>
      </div>
    
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( <span class="value">{{ $items->total() }} dòng )</span> - Tổng tiền: <span style="color:red">{{ number_format($total_actual_amount) }} </span>- Số lượng: <span style="color:red">{{ $total_quantity }} </span></h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
            {{ $items->appends( $arrSearch )->links() }}
          </div>  
          <table class="table table-bordered table-hover" id="table-list-data">
            <tr>                   
              
              <th style="width: 1%">#</th>
              <th class="text-left">Tạo lúc</th>
              <th class="text-left">Ngày</th>
              <th class="text-center" style="width: 120px">Bãi biển</th>
              <th class="text-left">Nội dung</th>
              <th class="text-center">UNC</th>
              <th class="text-center">Số lượng</th>
              <th class="text-right">Giá</th>
              <th class="text-right">Tổng tiền</th>
              <th width="1%" style="white-space: nowrap;" class="text-center">Người chi</th> 
              
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
              <tr class="cost" id="row-{{ $item->id }}">    
                               
                <td><span class="order">{{ $i }}</span></td>   
                <td class="text-left">  
                  <strong style="color: red">{{ $item->id }}</strong><br>
                    {{ date('H:i d/m', strtotime($item->created_at)) }}                          
                </td>
                <td class="text-left">  
                    {{ date('d/m/y', strtotime($item->date_use)) }} 
                   
                    @if($item->user)
                     <br/> <i class="glyphicon glyphicon-user"></i> {{ $item->user->name }}
                     @endif
                </td>
                <td class="text-center">
                  @if($item->type == 1)
                  <span class="label label-default">Vận hành</span>
                  @else
                  <span class="label label-warning">Khác</span>
                  @endif
                  @if($item->beach_id)                                  
                  <br><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $beachArr[$item->beach_id] }}
                  @endif
                </td>
                <td>
                  @if($item->costType)
                  <?php 
                  $str = $item->partner_id; 
                  ?>
                  <a href="https://plantotravel.vn/cost/{{ Helper::mahoa('mahoa', $str ) }}">{{ $item->costType->name }}</a>
                  @endif
                  @if($item->partner)
                  - {{ $item->partner->name }}
                  @endif
                  @if($item->is_fixed == 1)
                  <label class="label label-success">Cố định</label>
                  @endif
                  <p style="color:red; font-style: italic">{{ $item->notes }}</p>
                  @if($item->image_url && $item->unc_type == 2)
                  <p class="alert-success">
                   SMS: {{ $item->image_url }}
                  </p>
                  @endif
                  @if($item->sms_ung)
                  <p class="alert-warning sms">
                   SMS ỨNG : {{ $item->sms_ung }}
                  </p>
                  @endif
                  @if($item->sms_chi)
                  <p class="alert-success sms">
                   SMS CHI : {{ $item->sms_chi }}
                  </p>
                  @endif
                   
                </td>
                <td class="text-center">
                  @if($item->image_url && $item->unc_type == 1)
                  <span style="color: blue; cursor: pointer;" class="img-unc" data-src="{{ config('plantotravel.upload_url').$item->image_url }}">XEM ẢNH</span>               
                  @endif
                  
                </td>
                <td class="text-center">{{ $item->amount }}</td>
                <td class="text-right">{{ number_format($item->price) }}</td>
                <td class="text-right">
                  {{ number_format($item->total_money) }}                   
                </td>
                <td class="text-center" style="white-space: nowrap;" data-id="{{ $item->nguoi_chi }}">
                 @if($item->nguoi_chi)
                  {{ $collecterNameArr[$item->nguoi_chi] }}
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
          <div style="text-align:center">
           {{ $items->appends( $arrSearch )->links() }}
          </div>  
        </div>  
           
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
<div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="text-align: center;">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>QR CODE</h4>
                </div>
                <div class="modal-body">
                    <img src=""/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ĐÓNG</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    $('.btn-qrcode').click(function (e) {
        e.preventDefault();
        $('#qrCodeModal').find('img').attr('src', $(this).attr('href'));
        $('#qrCodeModal').modal('show');
    });
    $('#searchForm input[type=checkbox]').change(function(){
        $('#searchForm').submit();
      });
    
    $('tr.cost').click(function(){
      $(this).find('.check_one').attr('checked', 'checked');
    });
    $("#check_all").click(function(){
        $('input.check_one').not(this).prop('checked', this.checked);
    });
    
    // $('#partner_id').on('change', function(){
    //   $(this).parents('form').submit();
    // });
    $('#cate_id').change(function(){
        $.ajax({
          url : "{{ route('cost.ajax-doi-tac') }}",
          data: {
            cate_id : $(this).val()
          },
          type : "GET", 
          success : function(data){  
            if(data != 'null'){
              $('#load_doi_tac').html(data);
              if($('#partner_id').length==1){
                $('#partner_id').select2();  
              }              
            }
          }
        });
    });
  });
  $(document).ready(function(){
    $('.img-unc').click(function(){
      $('#unc_img').attr('src', $(this).data('src'));
      $('#uncModal').modal('show');
    }); 
    $('.change-column-value').change(function(){
          var obj = $(this);         
          $.ajax({
            url : "{{ route('cost.change-value-by-column') }}",
            type : 'GET',
            data : {
              id : obj.data('id'),
              col : obj.data('column'),
              value: obj.val(),
            },
            success: function(data){
                console.log(data);
            }
          });
       });
  });
</script>
@stop