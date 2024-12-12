@extends('layout')
@section('content')
<div class="content-wrapper">
  
<!-- Content Header (Page header) -->
<section class="content-header" style="padding-top: 10px;">
  <h1 style="text-transform: uppercase;">    
    TOUR ĐN NGÀY {{$arrSearch['use_date_from']}}
  </h1>
  
</section>

<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-md-12">
      <div id="content_alert"></div>
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('booking-tour-dn.create', ['type' => $type]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">        
        <div class="panel-body">
          
          <form class="form-inline" role="form" method="GET" action="{{ route('booking-tour-dn.index') }}" id="searchForm">
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="row">
              
              <div class="form-group col-xs-6" style="padding-right: 0px;">
                <input type="text" class="form-control" autocomplete="off" name="id_search" value="{{ $arrSearch['id_search'] }}" placeholder="PTT ID" >
              </div>
              <div class="form-group col-xs-6">
                <select class="form-control select2" name="tour_id" id="tour_id">
                  <option value="">-Tour-</option>
                  @foreach($listTourDn as $tour)
                    <option value="{{ $tour->id }}" {{ $arrSearch['tour_id'] == $tour->id ? "selected" : "" }}>{{ $tour->name }}</option>
                  @endforeach>
                </select>
              </div>

            </div>
            <div class="row">
              <div class="form-group @if($time_type == 3) col-xs-6 @else col-xs-4 @endif" style="padding-right: 0px">              
                <select class="form-control select2" name="time_type" id="time_type">                  
                  <option value="">--Thời gian--</option>
                  <option value="1" {{ $time_type == 1 ? "selected" : "" }}>Theo tháng</option>
                  <option value="2" {{ $time_type == 2 ? "selected" : "" }}>Khoảng ngày</option>
                  <option value="3" {{ $time_type == 3 ? "selected" : "" }}>Ngày cụ thể </option>
                </select>
              </div>
              @if($time_type == 1)
            <div class="form-group col-xs-4 chon-thang" style="padding-right: 5px">                
                <select class="form-control select2 " id="month_change" name="month">
                  <option value="">--THÁNG--</option>
                  @for($i = 1; $i <=12; $i++)
                  <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}" {{ $month == $i ? "selected" : "" }}>{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group col-xs-4 chon-thang" style="padding-left: 5px">                
                <select class="form-control select2" id="year_change" name="year">
                  <option value="">--Năm--</option>
                  <option value="2020" {{ $year == 2020 ? "selected" : "" }}>2020</option>
                  <option value="2021" {{ $year == 2021 ? "selected" : "" }}>2021</option>
                  <option value="2022" {{ $year == 2022 ? "selected" : "" }}>2022</option>
                </select>
              </div>
            @endif
            @if($time_type == 2 || $time_type == 3)            
              <div class="form-group @if($time_type == 3) col-xs-6 @else col-xs-4 @endif"  style="@if($time_type!=3)padding-right: 5px; @endif padding-left: 5px">
                <input type="text" class="form-control datepicker" autocomplete="off" name="use_date_from" placeholder="@if($time_type == 2) Từ ngày @else Ngày @endif " value="{{ $arrSearch['use_date_from'] }}">
              </div>
              
              @if($time_type == 2)
              <div class="form-group col-xs-4" style="padding-left: 0px">
                <input type="text" class="form-control datepicker" autocomplete="off" name="use_date_to" placeholder="Đến ngày" value="{{ $arrSearch['use_date_to'] }}" >
              </div>
              @endif
            @endif
            </div>            
            @if(Auth::user()->role == 1)
            <div class="form-group">
              <select class="form-control select2" name="user_id" id="user_id">
                <option value="">-Sales-</option>
                @foreach($listUser as $user)
                <option value="{{ $user->id }}" {{ $arrSearch['user_id'] == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                @endforeach
              </select>
            </div>                     
            @endif 
           
            <div class="row">
              <div class="form-group col-xs-6" style="padding-right: 0px;">
                <input type="text" class="form-control" name="phone" value="{{ $arrSearch['phone'] }}" placeholder="Số ĐT">
              </div>   
               <div class="form-group col-xs-6">
                <input type="text" class="form-control" name="name" value="{{ $arrSearch['name'] }}" placeholder="Tên">
              </div>   
            </div>
            {{-- @if($arrSearch['tour_id'] != 4)       
            <div class="row" style="font-size: 12px;">
               <div class="form-group col-xs-3">
              <input type="checkbox" name="tour_type[]" id="tour_type_1" {{ in_array(1, $arrSearch['tour_type']) ? "checked" : "" }} value="1">
              <label for="tour_type_1">GHÉP</label>
            </div>   
            <div class="form-group col-xs-4">
              &nbsp;&nbsp;&nbsp;<input type="checkbox" name="tour_type[]" id="tour_type_2" {{ in_array(2, $arrSearch['tour_type']) ? "checked" : "" }} value="2">
              <label for="tour_type_2">VIP&nbsp;&nbsp;&nbsp;&nbsp;</label>
            </div>   
            <div class="form-group col-xs-5" style="border-right: 1px solid #9ba39d">
              &nbsp;&nbsp;&nbsp;<input type="checkbox" name="tour_type[]" id="tour_type_3" {{ in_array(3, $arrSearch['tour_type']) ? "checked" : "" }} value="3">
              <label for="tour_type_3">THUÊ CANO&nbsp;&nbsp;&nbsp;&nbsp;</label>
            </div>  
            </div>
            @endif --}}
            <div class="row" style="font-size: 12px;">
              <div class="form-group col-xs-6">
                <input type="checkbox" name="status[]" id="status_1" {{ in_array(1, $arrSearch['status']) ? "checked" : "" }} value="1">
                <label for="status_1">MỚI</label>
              </div>   
              <div class="form-group col-xs-6">
                <input type="checkbox" name="status[]" id="status_2" {{ in_array(2, $arrSearch['status']) ? "checked" : "" }} value="2">
                <label for="status_2">Hoàn tất</label>
              </div> 
              <div class="form-group col-xs-6">
                <input type="checkbox" name="status[]" id="status_4" {{ in_array(4, $arrSearch['status']) ? "checked" : "" }} value="4">
                <label for="status_4">DỜI NGÀY</label>
              </div>   
              <div class="form-group col-xs-6">
                <input type="checkbox" name="status[]" id="status_3" {{ in_array(3, $arrSearch['status']) ? "checked" : "" }} value="3">
                <label for="status_3">HỦY</label>
              </div>  
              {{-- @if($arrSearch['tour_id'] != 4)   
              <div class="form-group col-xs-4">
                <input type="checkbox" name="no_cab" id="no_cab" {{ $arrSearch['no_cab'] == 1 ? "checked" : "" }} value="1">
                <label for="no_cab">Không cáp</label>
              </div> 
              <div class="form-group col-xs-4">
                <input type="checkbox" name="no_meals" id="no_meals" {{ $arrSearch['no_meals'] == 1 ? "checked" : "" }} value="1">
                <label for="no_meals">Không ăn</label>
              </div>
              @endif --}}
              <div class="form-group col-xs-4">
                <input type="checkbox"name="hh0" id="hh0" {{ $arrSearch['hh0'] == 1 ? "checked" : "" }} value="1">
                <label for="hh0">Chưa HH</label>
              </div>   
            </div>
            <button type="submit" class="btn btn-info btn-sm">Lọc</button>
            <button type="button" id="btnReset" class="btn btn-danger btn-sm">Reset</button>
          </form>         
        </div>
      </div>
      <div style="background-color: #dbdbd5;" class="table-responsive">
          <table class="table table-bordered" id="table_report">
              <tr>
                <th class="text-center">Tổng BK</th>
                <th class="text-center">Tổng NL</th>
                <th class="text-center">Tổng TE</th>
                {{-- <th class="text-center">Ăn NL</th>
                <th class="text-center">Ăn TE</th>
                <th class="text-center">Cáp NL</th>
                <th class="text-center">Cáp TE</th> --}}
                <th class="text-right">Thực thu</th>
                <th class="text-right">HDV thu</th>
                <th class="text-right">Tổng cọc</th>
                {{-- <th class="text-right">HH sales</th>--}}
                <th class="text-right">Doanh số</th> 
              </tr>
              <tr>
                <td class="text-center">{{ number_format($items->count()) }}</td> 
                <td class="text-center">{{ number_format($tong_so_nguoi ) }}</td> 
                <td class="text-center">{{ number_format($tong_te ) }}</td>
                {{-- <td class="text-center">{{ number_format($tong_phan_an ) }}</td> 
                <td class="text-center">{{ number_format($tong_phan_an_te ) }}</td>
                <td class="text-center">{{ number_format($cap_nl ) }}</td> 
                <td class="text-center">{{ number_format($cap_te ) }}</td>   --}}
                <td class="text-right">{{ number_format($tong_thuc_thu ) }}</td>
                <td class="text-right">{{ number_format($tong_hdv_thu ) }}</td>                
                <td class="text-right">{{ number_format($tong_coc ) }}</td> 
                {{-- <td class="text-right">{{ number_format($tong_hoa_hong_sales ) }}</td>--}}
                <td class="text-right">{{ number_format($tong_doanh_so ) }}</td>
              </tr>
          </table>          
        </div>
        
      
        <div style="text-align:center; margin-top: 10px;">
            {{ $items->appends( $arrSearch )->links() }}
          </div>  
          <div class="table-responsive" style="font-size: 12px;border: none;">            
            <ul style="padding: 0px; ">
             @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
                <li style="padding: 10px;background-color: #fff; font-size:15px;margin-bottom: 10px; border-radius: 5px; color: #2c323f">        
                <!-- <div class="dropdown" style="position: absolute;right: 10px;top:10px">
                  <button class="dropdown-toggle" type="button" data-toggle="dropdown">

                  
                                            <i class="  glyphicon glyphicon-menu-hamburger"></i>
                                        </button>
                  <ul class="dropdown-menu">
                    <li><a href="#">HTML</a></li>
                    <li><a href="#">CSS</a></li>
                    <li><a href="#">JavaScript</a></li>
                  </ul>
                </div>       -->    
                    @php $arrEdit = array_merge(['id' => $item->id], $arrSearch) @endphp
                    
                    <span style="color: red">
                        PTT{{ $item->id }}</span> 
                        @if($item->status == 1)
                    <span class="label label-info">MỚI</span>
                    @elseif($item->status == 2)
                    <span class="label label-default">HOÀN TẤT</span>
                    @elseif($item->status == 4)
                    <span class="label label-warning">DỜI NGÀY</span>
                    @elseif($item->status == 3)
                    <span class="label label-danger">HỦY</span>
                    @endif  
                      @if($item->user)
                  - <span style="font-style: italic;">{{ $item->user->name }}</span>
                  @else
                    {{ $item->user_id }}
                  @endif</span>
                    <br>
                        <a style="text-transform: uppercase;font-weight:bold;" href="{{ route( 'booking-tour-dn.edit', $arrEdit ) }}">
                       {{ $item->name }}</a>
                    
                  @php $arrEdit = array_merge(['id' => $item->id], $arrSearch) @endphp            
                                   
                  
                     
                  <br> 
                   
                    <i class="glyphicon glyphicon-phone"></i> <a href="tel:{{ $item->phone }}" target="_blank">{{ $item->phone }}</a> 
                    <br>
                    <i class="glyphicon glyphicon-map-marker"></i>
                    @if($item->location)
                    {{ $item->location->name }}
                    @else
                    {{ $item->address }}
                    @endif
                    
                    <br>
                    <i class="glyphicon glyphicon-user"></i> NL: <b>{{ $item->adults }}</b> / TE: {{ $item->childs }} / EB: {{ $item->infants }} - 
                    <?php 
                    $meals = $item->meals;
                    if($meals > 0){
                      $meals+= $item->childs/2;  
                    }
                                
                    ?>
                    <i class="glyphicon glyphicon-briefcase"></i> {{ $meals }}
                    <br>

                    <i class="glyphicon glyphicon-usd"></i> {{ number_format($item->total_price) }} @if($item->tien_coc > 0)- Cọc: {{ number_format($item->tien_coc) }} @endif @if($item->discount > 0)- Giảm: <span style="color: red;font-weight: bold;">{{ number_format($item->discount) }}
                  </span>
                    @endif
                    @if($item->extra_fee > 0)                    
                    <br>
                    Phụ thu: {{ number_format($item->extra_fee) }}
                    @endif
                    
                    @if(!$item->hoa_hong_sales && $item->status != 3)
                      
                      @else
                       HH: {{ number_format($item->hoa_hong_sales) }}
                      @endif
                  
                    <br>
                    Thu: {{ number_format($item->con_lai) }}
                    @if($item->ko_cap_treo)
                    <br><span style="color: red">KHÔNG CÁP</span>
                    @endif
                    @if($item->notes)
                    <br>
                    @if(!$item->hoa_hong_sales && $item->status != 3 && Auth::user()->role == 1)
                    
                    @else
                     {{ number_format($item->hoa_hong_sales) }}
                    @endif  
                    <span style="color:red">{!! nl2br($item->notes) !!}</span>
                    @endif    
                    <!-- @if($item->export == 1)
                    <span class="label label-default">Đã gửi</span>
                    @else
                    <span class="label label-danger">Chưa gửi</span> 
                    @endif   
                    <br><br>        
                    @if(Auth::user()->role == 1 && $item->export == 2)
                    <input type="checkbox" name="" class="change_status" value="1" data-id="{{ $item->id }}">
                    <br>
                    @endif  -->
                    @if($item->tour_id == 4)
                    <div class="clearfix"></div>
                      @if($item->mail_hotel == 0)
                      <a href="{{ route('mail-preview', ['id' => $item->id, 'tour_id' => 4]) }}" class="btn btn-sm btn-success" >
                        <i class="  glyphicon glyphicon-envelope"></i> Book Tour
                      </a>
                      @else
                      <p class="label label-info" style="margin-bottom: 5px; clear:both">Đã mail John</p>
                      @endif
                      <div class="clearfix"></div>
                    @endif
                    <div class="clearfix"></div>
                    @if(Auth::user()->role == 1 && $item->status == 1)
                  <a style="float:right; margin-left: 2px" onclick="return callDelete('{{ $item->title }}','{{ route( 'booking-tour-dn.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                  @endif
                  
                   <a style="float:right; margin-left: 2px" href="{{ route( 'booking-tour-dn.edit', $arrEdit ) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>   
                    <a style="float:right; margin-left: 2px" href="{{ route( 'booking-payment.index', ['booking_id' => $item->id] ) }}" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-usd"></span></a>    
                      <a style="float: left;" target="_blank" href="{{ route('history.booking', ['id' => $item->id]) }}">Xem lịch sử</a> - <a href="{{ route('view-pdf', ['id' => $item->id])}}" target="_blank">PDF</a> 
                      <div style="clear: both;"></div>
                </li>              
              @endforeach
            @else
            <li>
              <p>Không có dữ liệu.</p>
            </li>
            @endif
            </ul>
          
          </div>
          <div style="text-align:center">
            {{ $items->appends( $arrSearch )->links() }}
          </div>       
      </div>
     
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
<input type="hidden" id="table_name" value="articles">
<!-- Modal -->
<div id="capnhatModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" id="modal_content">
      
    </div>

  </div>
</div>
<style type="text/css">
  .form-group{
    margin-bottom: 10px !important;
  }
</style>
@stop
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    $('#searchForm input[type=checkbox]').change(function(){
        $('#searchForm').submit();
      });
    // setTimeout(function(){
    //   window.location.reload();
    // }, 30000);
    $('.hoa_hong_sales').blur(function(){
        var obj = $(this);
        $.ajax({
          url:'{{ route('save-hoa-hong')}}',
          type:'GET',
          data: {
            id : obj.data('id'),
            hoa_hong_sales : obj.val()
          },
          success : function(doc){
            
          }
        });
      });
  });
  $('.change_status').click(function(){
          var obj = $(this);      
          $.ajax({
            url : "{{ route('change-export-status') }}",
            type : 'GET',
            data : {
              id : obj.data('id')
            },
            success: function(){
              window.location.reload();
            }
          });
        });
  $(document).ready(function(){
      $(document).on('click', '.btn-edit-bk', function(){
        var id = $(this).data('id');        
        $.ajax({
          url: '{{ route('booking.info') }}',
          type: "GET",
          data: {          
              id : id
          },
          success: function(data){
              $('#modal_content').html(data);    
              $('#capnhatModal').modal('show');              
          }
      });
      });
      $(document).on('click', '#btnSaveInfo', function(){
        var hdv_id = $('#hdv_id').val();    
        var hdv_notes = $('#hdv_notes').val();  
        var booking_id = $('#booking_id').val();
        var call_status = $('#call_status').val();      
        $.ajax({
          url: '{{ route('booking.save-info') }}',
          type: "GET",
          data: {          
              hdv_id : hdv_id,
              hdv_notes : hdv_notes,
              booking_id : booking_id,
              call_status : call_status
          },
          success: function(data){              
              $('#capnhatModal').modal('hide'); 
              window.location.reload();             
          }
      });
      });
      $('#btnReset').click(function(){
        $('#searchForm select').val('');
        $('#searchForm').submit();
      });
  });
</script>
@stop