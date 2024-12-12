@extends('layout')
@section('content')
<div class="content-wrapper">
  
  <!-- Content Header (Page header) -->
  <section class="content-header">
  <h1 style="text-transform: uppercase;">  
      Đặt tour Đà Nẵng<span style="color:#f39c12">
        {{-- @if($tour_id == 4) CÂU MỰC @elseif($tour_id == 1) ĐẢO @elseif($tour_id == 3) RẠCH VẸM @endif --}}
    </span></h1>    
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('booking-tour-dn.index', ['type' => $type]) }}" style="margin-bottom:5px">Quay lại</a>
    <a class="btn btn-success btn-sm" href="{{ route('booking-tour-dn.index', ['type' => $type]) }}" style="margin-bottom:5px">Xem danh sách booking</a>     
    <form role="form" method="POST" action="{{ route('booking-tour-dn.store') }}" id="dataForm">
    <div class="row">
      <!-- left column -->

      <div class="col-md-12">
        <div id="content_alert"></div>
        <!-- general form elements -->
        <div class="box box-primary">
          
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif                
              <input type="hidden" name="type" value="1">
              <div class="row">
                <div class="form-group @if($tour_id != 4) col-xs-6 @else col-xs-12 @endif " style="padding-right: 0px">                    
                  <label>Tour<span class="red-star">*</span></label>
                  <select class="form-control" id="tour_id" name="tour_id">                     
                      {{-- <option value="1" {{ old('tour_id', $tour_id) == 1 ? "selected" : "" }}>Tour đảo</option>
                      <option value="3" {{ old('tour_id', $tour_id) == 3 ? "selected" : "" }}>Tour Rạch Vẹm</option>
                      <option value="4" {{ old('tour_id', $tour_id) == 4 ? "selected" : "" }}>Tour Câu Mực</option> --}}
                      <option value="0">--Chọn--</option> 
                      @foreach($listTourDn as $tour)        
                        <option value="{{ $tour->id }}" {{ old('tour_id',$tour_id) == $tour->id ? "selected" : "" }}>{{ $tour->name }}</option>
                      @endforeach
                  </select>
                </div> 
                {{-- @if($tour_id != 4) 
                <div class="form-group col-xs-4">                    
                  <label>Loại tour<span class="red-star">*</span></label>
                  <select class="form-control" id="tour_cate" name="tour_cate" >                     
                      <option value="1" {{ old('tour_cate') == 1 ? "selected" : "" }}>4 đảo</option>
                      <option value="2" {{ old('tour_cate') == 2 ? "selected" : "" }}>2 đảo</option>
                  </select>
                </div> 
                <div class="form-group col-xs-4" style="padding-left: 0px;">                  
                  <label>Hình thức <span class="red-star">*</span></label>
                  <select class="form-control" id="tour_type" name="tour_type">                      
                      <option value="1" {{ old('tour_type') == 1 ? "selected" : "" }}>Tour ghép</option>
                      <option value="2" {{ old('tour_type') == 2 ? "selected" : "" }}>Tour VIP</option>
                      <option value="3" {{ old('tour_type') == 3 ? "selected" : "" }}>Thuê cano</option>
                  </select>
                </div>
                @endif --}}
                @if(Auth::user()->role == 1)
                  <div class="form-group col-xs-6">
                     <label>Sales <span class="red-star">*</span></label>
                      <select class="form-control select2" name="user_id" id="user_id">
                        <option value="0">--Chọn--</option>
                        @foreach($listUser as $user)        
                        <option data-level="{{ $user->level }}" value="{{ $user->id }}" {{ old('user_id') == $user->id ? "selected" : "" }}>{{ $user->name }} - {{ Helper::getLevel($user->level) }}</option>
                        @endforeach
                      </select>
                  </div>
                  @endif
                  <input type="hidden" name="book_date" value="">
                </div>
                <div class="row">
                  <div class="form-group col-xs-6" style="padding-right: 0px">
                    <label>Đối tác</label>
                    <select class="form-control" name="partner_id" id="partner_id">  
                      <option value="0">--Chọn--</option>
                    </select>
                  </div>
                  @if(Auth::user()->id == 1)
                    <div class="form-group col-xs-6">
                        <label>Hoa hồng</label>
                        <input type="text" name="hoa_hong_cty" id="hoa_hong_cty" class="form-control number" value="{{ old('hoa_hong_cty') }}">
                    </div>
                  </div>
                  @else
                  <div class="form-group col-xs-6" style="display: none;">
                        <label>Hoa hồng</label>
                        <input type="text" name="hoa_hong_cty" id="hoa_hong_cty" class="form-control number" value="{{ old('hoa_hong_cty') }}">
                    </div>
                
                  @endif

             
                <div class="row">
                  <div class="form-group col-md-3">                    
                    <label>Tên khách hàng <span class="red-star">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                  </div>  
                  <div class="form-group col-md-3 col-xs-6">                  
                    <label>Điện thoại <span class="red-star">*</span></label>
                    <input type="text" maxlength="20" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
                  </div> 
                  <div class="form-group col-md-3 col-xs-6">                  
                    <label>Điện thoại 2 <span class="red-star">*</span></label>
                    <input type="text" maxlength="20" class="form-control" name="phone_1" id="phone_1" value="{{ old('phone_1') }}">
                  </div> 
                  <div class="form-group col-md-3 col-xs-6">                  
                    <label>Điện thoại sales</label>
                    <input type="text" maxlength="20" class="form-control" name="phone_sales" id="phone_sales" value="{{ old('phone_sales') }}">
                  </div> 
                </div>
                <div class="row">
                   @if($tour_id != 4) 
                <div class="form-group col-md-4">                  
                  <label>Facebook</label>
                  <input type="text" class="form-control" name="facebook" id="facebook" value="{{ old('facebook') }}">
                </div>                    
                @endif
                  <div class="form-group col-md-4">                    
                    <label>Ngày đi <span class="red-star">*</span></label>
                    <input type="text" class="form-control datepicker" name="use_date" id="use_date" value="{{ old('use_date') }}" autocomplete="off">
                  </div>   
                  <div class="col-md-4 input-group" style="padding-left: 20px;padding-right: 20px"> 
                              
                  <label>Nơi đón <span class="red-star">*</span></label>

                  <select class="form-control select2" name="location_id" id="location_id">
                    <option value="">--Chọn--</option>
                    @foreach($listTag as $location)        
                    <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? "selected" : "" }}>{{ $location->name }}</option>
                    @endforeach
                  </select>
                  <span class="input-group-btn">
                    <button style="margin-top:24px" class="btn btn-primary btn-sm" id="btnAddTag" type="button" data-value="3">
                      Thêm  
                    </button>
                  </span>
                </div>  
                </div>
                @if($tour_id != 4) 
                {{-- <div class="row">
                  <div class="form-group col-md-12">
                      <label style="font-weight: bold; color: red">
                        <input type="checkbox" id="ko_cap_treo" name="ko_cap_treo" value="1" {{ old('ko_cap_treo') == 1 ? "checked" : "" }}>
                        KHÔNG ĐI CÁP TREO
                      </label>
                  </div>
                </div> --}}
                @endif
                <div class="row">
                  <div class="form-group col-xs-4">
                      <label>NL <span class="red-star">*</span></label>
                      <select class="form-control" name="adults" id="adults">
                        @for($i = 1; $i <= 150; $i++)            
                        <option value="{{ $i }}" {{ old('adults') == $i ? "selected" : "" }}>{{ $i }}</option>
                        @endfor
                      </select>
                  </div>
                  <div class="form-group col-xs-4">
                      <label>TE(1m-1m4) <span class="red-star">*</span></label>
                      <select class="form-control" name="childs" id="childs">
                        @for($i = 0; $i <= 20; $i++)            
                        <option value="{{ $i }}" {{ old('childs') == $i ? "selected" : "" }}>{{ $i }}</option>
                        @endfor
                      </select>
                  </div>
                  <div class="form-group col-xs-4">
                      <label>EB(dưới 1m)</label>
                      <select class="form-control" name="infants" id="infants">
                        @for($i = 0; $i <= 20; $i++)            
                        <option value="{{ $i }}" {{ old('infants') == $i ? "selected" : "" }}>{{ $i }}</option>
                        @endfor
                      </select>
                  </div>
                  
                </div>
                <div class="row">
                  <div class="form-group col-xs-4">
                    <label>Giá gốc vé NL <span class="red-star">*</span></label>
                    <input type="text" name="price_adult_original" id="price_adult_original" class="form-control number" value="{{ old('price_adult_original') }}">
                  </div>

                  <div class="form-group col-xs-4">
                    <label>Giá gốc vé TE <span class="red-star">*</span></label>
                    <input type="text" name="price_child_original" id="price_child_original" class="form-control number" value="{{ old('price_child_original') }}">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-xs-4">
                    <label>Giá bán vé NL <span class="red-star">*</span></label>
                    <input type="text" name="price_adult" id="price_adult"  class="form-control number" value="{{ old('price_adult') }}">
                  </div>

                  <div class="form-group col-xs-4">
                    <label>Giá bán vé TE <span class="red-star">*</span></label>
                    <input type="text" name="price_child" id="price_child" class="form-control number" value="{{ old('price_child') }}">
                  </div>
                </div>
                 {{-- @if($tour_id != 4) 
                <div class="row">
                  <div class="form-group col-xs-3">
                      <label>Ăn NL <span class="red-star">*</span></label>
                      <select class="form-control" name="meals" id="meals">
                        @for($i = 0; $i <= 150; $i++)            
                        <option value="{{ $i }}" {{ old('meals') == $i ? "selected" : "" }}>{{ $i }}</option>
                        @endfor
                      </select>
                  </div>
                  <div class="form-group col-xs-3">
                      <label>Ăn TE <span class="red-star">*</span></label>
                      <select class="form-control" name="meals_te" id="meals_te">
                        @for($i = 0; $i <= 20; $i++)            
                        <option value="{{ $i }}" {{ old('meals_te') == $i ? "selected" : "" }}>{{ $i }}</option>
                        @endfor
                      </select>
                  </div>
                  <div class="form-group col-xs-3">
                      <label>Cáp NL <span class="red-star">*</span></label>
                      <select class="form-control" name="cap_nl" id="cap_nl">
                        @for($i = 0; $i <= 150; $i++)            
                        <option value="{{ $i }}" {{ old('cap_nl') == $i ? "selected" : "" }}>{{ $i }}</option>
                        @endfor
                      </select>
                  </div>
                  <div class="form-group col-xs-3">
                      <label>Cáp TE <span class="red-star">*</span></label>
                      <select class="form-control" name="cap_te" id="cap_te">
                        @for($i = 0; $i <= 20; $i++)            
                        <option value="{{ $i }}" {{ old('cap_nl') == $i ? "selected" : "" }}>{{ $i }}</option>
                        @endfor
                      </select>
                  </div>
                  @endif --}}
                  <div class="form-group col-xs-7" style="display: none;">
                      <label>Thành tiền <span class="red-star">*</span></label>
                      <input type="text" name="total_price_adult" id="total_price_adult" class="form-control number" value="{{ old('total_price_adult') }}">
                  </div>
                </div>
                
                <div class="row">
                  <input type="hidden" name="ngay_coc">
                  <div class="form-group col-md-7" style="display: none;">
                      <label>Thành tiền <span class="red-star">*</span></label>
                      <input type="text" name="total_price_child" id="total_price_child" class="form-control number" value="{{ old('total_price_child') }}">
                  </div>
                </div>
                
                <div class="row">
                  <div class="form-group col-xs-6">
                      <label>Phụ thu</label>
                      <input type="text" name="extra_fee" id="extra_fee" class="form-control number" value="{{ old('extra_fee') }}">
                  </div>
                  <div class="form-group col-xs-6" >
                      <label>Giảm giá</label>
                      <input type="text" name="discount" id="discount" class="form-control number" value="{{ old('discount') }}">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-xs-6" >
                      <label>TỔNG TIỀN <span class="red-star">*</span></label>
                    <input type="text" class="form-control number" name="total_price" id="total_price" value="{{ old('total_price') }}">
                  </div>
                  <div class="form-group col-xs-6">
                      <label>Người thu tiền <span class="red-star">*</span></label>
                      <select class="form-control" name="nguoi_thu_tien" id="nguoi_thu_tien">
                        <option value="">--Chọn--</option>
                        <option value="1" {{ old('nguoi_thu_tien') == 1 ? "selected" : "" }}>Sales</option>
                        {{-- <option value="2" {{ old('nguoi_thu_tien') == 2 ? "selected" : "" }}>CTY</option>
                        <option value="3" {{ old('nguoi_thu_tien') == 3 ? "selected" : "" }}>HDV</option>
                        <option value="5" {{ old('nguoi_thu_tien') == 5 ? "selected" : "" }}>Thao thu</option> --}}
                        <option value="2" {{ old('nguoi_thu_tien') == 2 ? "selected" : "" }}>Công nợ</option>
                      </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-3 col-xs-6">
                      <label>Tiền cọc</label>
                    <input type="text" class="form-control number" name="tien_coc" id="tien_coc" value="{{ old('tien_coc') }}">
                  </div>
                  <div class="form-group col-md-3 col-xs-6">
                      <label>Người thu cọc <span class="red-star">*</span></label>
                      <select class="form-control" name="nguoi_thu_coc" id="nguoi_thu_coc">
                        <option value="">--Chọn--</option>
                        <option value="1" {{ old('nguoi_thu_coc') == 1 ? "selected" : "" }}>Sales</option>
                        {{-- <option value="2" {{ old('nguoi_thu_coc') == 2 ? "selected" : "" }}>CTY</option> --}}
                        <option value="2" {{ old('nguoi_thu_coc') == 2 ? "selected" : "" }}>HDV</option>
                      </select>
                  </div>
                  <div class="form-group col-md-3 col-xs-6" >
                      <label>CÒN LẠI <span class="red-star">*</span></label>
                      <input type="text" class="form-control number" name="con_lai" id="con_lai" value="{{ old('con_lai') }}">
                  </div>
                   <div class="form-group col-md-3 col-xs-6" >
                      <label>THỰC THU <span class="red-star">*</span></label>
                      <input type="text" class="form-control number" name="tien_thuc_thu" id="tien_thuc_thu" value="{{ old('tien_thuc_thu') }}" style="border: 1px solid red">
                  </div>
                </div>
               
                <div class="form-group" style="display: none;">
                     <label>Trạng thái <span class="red-star">*</span></label>
                      <select class="form-control" name="status" id="status">                        
                        <option value="1" {{ old('status') == 1 ? "selected" : "" }}>Mới</option>
                        <option value="2" {{ old('status') == 2 ? "selected" : "" }}>Hoàn tất</option>
                        <option value="3" {{ old('status') == 3 ? "selected" : "" }}>Hủy</option>
                      </select>
                  </div>
                <div class="form-group">
                  <label>Danh sách khách</label>
                  <textarea class="form-control" rows="6" name="danh_sach" id="danh_sach">{{ old('danh_sach') }}</textarea>
                </div>
                <div class="form-group">
                  <label>Ghi chú</label>
                  <textarea class="form-control" rows="6" name="notes" id="notes">{{ old('notes') }}</textarea>
                </div>                  
            </div>          
                              
            <div class="box-footer">
              <button type="button" class="btn btn-default btn-sm" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i> Đang xử lý...</button>              
              <button type="submit" id="btnSave" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('booking-tour-dn.index', ['type' => $type])}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<div id="tagTag" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="POST" action="{{ route('location.ajax-save')}}" id="formAjaxTag">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tạo mới điểm đón</h4>
      </div>
      <div class="modal-body" id="contentTag">
          <input type="hidden" name="type" value="1">
           <!-- text input -->
          <div class="col-md-12">
            <div class="form-group">
              <label>Tên địa điểm<span class="red-star">*</span></label>
              <input type="text" class="form-control" id="add_address" value="{{ old('address') }}" name="str_tag"></textarea>
            </div>
            
          </div>
          <div classs="clearfix"></div>
      </div>
      <div style="clear:both"></div>
      <div class="modal-footer" style="text-align:center">
        <button type="button" class="btn btn-primary btn-sm" id="btnSaveTagAjax"> Save</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="btnCloseModalTag">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
@stop
@section('js')
<script type="text/javascript">
  var levelLogin = {{ Auth::user()->level }};
  console.log(levelLogin);
  $(document).on('click','#btnSave', function(){
    
    if(parseInt($('#tien_coc').val()) > 0 && $('#nguoi_thu_coc').val() == ''){
      alert('Bạn chưa chọn người thu cọc');
      return false;
    }
  });
$(document).on('click', '#btnSaveTagAjax', function(){
  $(this).attr('disabled', 'disabled');
    $.ajax({
      url : $('#formAjaxTag').attr('action'),
      data: $('#formAjaxTag').serialize(),
      type : "post", 
      success : function(str_id){          
        $('#btnCloseModalTag').click();
        $.ajax({
          url : "{{ route('location.ajax-list') }}",
          data: {
            str_id : str_id
          },
          type : "get", 
          success : function(data){
              $('#location_id').html(data);
              $('#location_id').select2('refresh');
              
          }
        });
      }
    });
 });
  $(document).ready(function(){
    $('#dataForm').submit(function(){      
      $('#btnSave').hide();
      $('#btnLoading').show();
    });
    $('#tour_id').change(function(){
      // location.href="{{ route('booking-tour-dn.create')}}?type=1&tour_id=" + $(this).val();
    });
    $('#tour_id').change(function(){
      $.ajax({
        url : '{{ route('booking-tour-dn.related-partner')}}',
        type : 'GET',
        data: {
          tour_id : $('#tour_id').val()
        },
        success: function(data){
          $('#partner_id').html(data);
        }
      });
    });
    $('#btnAddTag').click(function(){
          $('#tagTag').modal('show');
      });  
    
  });

</script>
@stop