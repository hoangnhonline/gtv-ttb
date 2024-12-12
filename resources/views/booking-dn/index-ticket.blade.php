@extends('layout')
@section('content')
<div class="content-wrapper">
  
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1 style="text-transform: uppercase;">  
    @if($type == 1)
    Đặt tour
    @elseif($type == 2)
    Đặt khách sạn
    @elseif($type == 3)
    Đặt vé tham quan Đà Nẵng
    @endif
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'booking-ticket-dn.index') }}">
      @if($type == 1)
    Đặt tour
    @elseif($type == 2)
    Đặt khách sạn
    @elseif($type == 3)
    Đặt vé tham quan Đà Nẵng
    @endif</a></li>
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
      <a href="{{ route('booking-ticket-dn.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('booking-ticket-dn.index') }}" id="searchForm">
            <input type="hidden" name="type" value="{{ $type }}"> 
            <div class="form-group">
              <input type="text" class="form-control" autocomplete="off" name="id_search" value="{{ $arrSearch['id_search'] }}" style="width: 70px"  placeholder="PTT ID">
            </div>
            <div class="form-group">                            
              <input type="text" class="form-control datepicker" autocomplete="off" name="book_date" value="{{ $arrSearch['book_date'] }}" style="width: 100px" placeholder="Ngày đặt từ">
            </div>
            <div class="form-group">                            
              <input type="text" class="form-control datepicker" autocomplete="off" name="book_date_to" value="{{ $arrSearch['book_date_to'] }}" style="width: 100px" placeholder="Đến ngày">
            </div>
            
            {{-- <div class="form-group">
              <select class="form-control" name="status" id="status">
                <option value="">--Trạng thái--</option>
                <option value="1" {{ $arrSearch['status'] == 1 ? "selected" : "" }}>Mới</option>
                <option value="2" {{ $arrSearch['status'] == 2 ? "selected" : "" }}>Hoàn tất</option>
                <option value="3" {{ $arrSearch['status'] == 3 ? "selected" : "" }}>Hủy</option>
              </select>
            </div>  --}} 
            @if(Auth::user()->role == 1)
            <div class="form-group">
              <select class="form-control select2" name="user_id" id="user_id">
                <option value="">--Sales--</option>
                @foreach($listUser as $user)
                <option value="{{ $user->id }}" {{ $arrSearch['user_id'] == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                @endforeach
              </select>
            </div> 
                            
            @endif 
            <div class="form-group">
              <input type="text" class="form-control" name="phone" value="{{ $arrSearch['phone'] }}" style="width: 120px" maxlength="11" placeholder="Điện thoại">
            </div>
            <input type="hidden" name="sort_by" id="sort_by" value="{{ $arrSearch['sort_by'] }}">
            <button type="submit" class="btn btn-info btn-sm" style="margin-top: -5px">Lọc</button>
            <div class="row" style="font-size: 12px;">
              <div class="form-group col-xs-4 col-md-2 col-lg-1">
                <input type="checkbox" name="status[]" id="status_1" {{ in_array(1, $arrSearch['status']) ? "checked" : "" }} value="1">
                <label for="status_1">MỚI</label>
              </div>   
              <div class="form-group col-xs-4 col-md-2 col-lg-1">
                <input type="checkbox" name="status[]" id="status_2" {{ in_array(2, $arrSearch['status']) ? "checked" : "" }} value="2">
                <label for="status_2">Hoàn tất</label>
              </div> 
              <div class="form-group col-xs-4 col-md-2 col-lg-1">
                <input type="checkbox" name="status[]" id="status_4" {{ in_array(4, $arrSearch['status']) ? "checked" : "" }} value="4">
                <label for="status_4">Dời ngày</label>
              </div>  
              <div class="form-group col-xs-4 col-md-2 col-lg-1">
                <input type="checkbox" name="status[]" id="status_3" {{ in_array(3, $arrSearch['status']) ? "checked" : "" }} value="3">
                <label for="status_3">HỦY</label>
              </div>    
            </div>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title col-md-8">Danh sách ( <span class="value">{{ $items->total() }} booking )</span>
            Số khách : {{ number_format($tong_so_nguoi )}} - Hoa hồng cty : {{ number_format($tong_hoa_hong_cty) }} - Hoa hồng sales : {{ number_format($tong_hoa_hong_sales) }} - Tổng cọc : {{ number_format($tong_coc) }}  
          </h3>
          
          
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
            {{ $items->appends( $arrSearch )->links() }}
          </div>  
          <div class="table-responsive">
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%; white-space: nowrap;">PTT CODE<br>Ngày book</th>
              <th width="200" style="overflow: hidden;width: 200px">Tên KH / Điện thoại</th>
              <th width="">UNC</th>
              <th width="" style="white-space: nowrap;">Ngày giao</th>
              <th style="width: 150px">Nơi giao</th>
              <th>Loại vé
                <table class="table table-bordered">
                  <tr>
                    <th width="35%">Loại vé</th>
                    <th width="5%" class="text-center">SL</th>
                    <th width="20%" class="text-right">Giá vốn</th>
                    <th width="20%" class="text-right">Giá bán</th>
                    <th width="20%" class="text-right">Lãi</th>
                  </tr>
                </table>
              </th>              
              <th class="text-right" width="100">Hoa hồng</th>    
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; 
              $hoa_hong_cty = 0;
              ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order"><strong style="color: red;font-size: 16px">PTV{{ $item->id }}</strong></span><br>
                {{ date('d/m/y', strtotime($item->book_date)) }}
              </td>                 
                <td style="overflow: hidden;width: 200px">     
                  <br>  
                  @php $arrEdit = array_merge(['id' => $item->id], $arrSearch) @endphp
                  <a style="font-size:17px" href="{{ route( 'booking-ticket-dn.edit', $arrEdit) }}">{{ $item->name }}</a>
                  <a class="btn btn-sm btn-success" href="{{ route('ticket.view-pdf', ['id' => $item->id])}}" target="_blank">Xem PDF</a>
                  <br>
                   @if($item->user)
                  <span style="font-weight: bold;font-size:16px">{{ $item->user->name }}</span>
                  @endif
                  &nbsp; &nbsp; &nbsp;
                  @if($item->status == 1)
                  <span class="label label-info">MỚI</span>
                  @elseif($item->status == 2)
                  <span class="label label-success">HOÀN TẤT</span>
                  @elseif($item->status == 3)
                  <span class="label label-danger">HỦY</span>
                  @endif 
                </td> 
                <td>
                  @foreach($item->payment as $p)
                  @if($p->type == 1)
                  <img src="{{ Helper::showImageNew($p->image_url)}}" width="80" style="border: 1px solid red" class="img-unc" >
                  @else
                  <br>+ {{number_format($p->amount) }} lúc {{ date('d/m/Y', strtotime($p->created_at)) }}
                  @endif
                  @endforeach
                </td>  
                <td class="text-center">
                  {{ date('d/m/y', strtotime($item->use_date)) }}
                </td>
                <td>
                  {{ $item->address}}
                  
                  <br>
                  <span style="color:red">{{ $item->notes }}</span>

                </td>
                <td>
                  <h4 style="color: red; font-style: italic;">
                    @if($item->nguoi_thu_tien == 1)
                    @if($item->user)
                    {{ $item->user->name }} thu tiền
                    @else
                    Sales thu tiền
                    @endif
                    @elseif($item->nguoi_thu_tien == 2)
                    CTY thu tiền
                    @else
                    Đại lý thu tiền
                    @endif
                  </h4>
                  <table class="table table-bordered">
                   
                  @php 
                  $tong_hoa_hong = 0;
                  @endphp
                  @foreach($item->tickets as $r)
                  
                  @php 
                 
                  $hh = $r->amount*$r->price_sell - $r->amount*$r->price;
                  if($item->status != 3) $tong_hoa_hong+= $hh;
                  @endphp
                  <tr>
                    <td width="35%">
                      @if(isset($ticketTypeArr[$r->ticket_type_id]))
                      {{ $ticketTypeArr[$r->ticket_type_id] }}                   
                      @else
                      {{ $r->ticket_type_id }} 
                      @endif
                    </td>

                    <td class="text-center" width="5%">
                      {{ $r->amount }}
                    </td>
                    <td class="text-right" width="20%">
                      
                      @if($item->status != 3) 
                      {{ number_format($r->price) }}
                      <br>
                      {{ number_format($r->amount*$r->price) }}
                      @endif

                    </td>
                    <td class="text-right" width="20%">
                      {{ number_format($r->price_sell) }}
                      <hr>
                      @if($item->status != 3) 
                      {{ number_format($r->price_sell) }}
                      <br>
                      {{ number_format($r->amount*$r->price_sell) }}
                      @endif
                    </td>
                    <td class="text-right" width="20%">
                      @if($item->status != 3) 
                     {{ number_format($hh) }}
                     @endif
                    </td>
                
                  </tr>

                  @endforeach
                  </table>
                </td> 
                <td class="text-right">
                  {{ number_format($tong_hoa_hong) }}
                </td>             
           
                  <td style="white-space:nowrap">
                <a href="{{ route( 'booking-payment.index', ['booking_id' => $item->id] ) }}" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-usd"></span></a>         
                  @php $arrEdit = array_merge(['id' => $item->id], $arrSearch) @endphp            
                  <a href="{{ route( 'booking-ticket-dn.edit', $arrEdit ) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>                     
                  @if(Auth::user()->role == 1 && $item->status == 1)
                  <a onclick="return callDelete('{{ $item->title }}','{{ route( 'booking-ticket-dn.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                  @endif
                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="9">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>
          </div>
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
<!-- Modal -->
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
@stop
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    $('#searchForm input[type=checkbox]').change(function(){
        $('#searchForm').submit();
      });
  $('img.img-unc').click(function(){
    $('#unc_img').attr('src', $(this).attr('src'));
    $('#uncModal').modal('show');
  });  
    $('#sort_by_change').change(function(){
      $('#sort_by').val($(this).val());
      $('#searchForm').submit();
    });
  });
</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.bk_code').blur(function(){
        var obj = $(this);
        $.ajax({
          url:'{{ route('saveBookingCode')}}',
          type:'GET',
          data: {
            id : obj.data('id'),
            booking_code : obj.val()
          },
          success : function(doc){
            
          }
        });
      });
    });
  </script>
@stop