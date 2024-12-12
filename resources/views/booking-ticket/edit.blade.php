@extends('layout')
@section('content')
<div class="content-wrapper">
  <!-- Main content -->
   
  <!-- Content Header (Page header) -->
  <section class="content-header">
  <h1 style="text-transform: uppercase;">  
      Cập nhật đặt vé
    </h1>    
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('booking-ticket.index') }}" style="margin-bottom:5px">Quay lại</a>
    <a class="btn btn-success btn-sm" href="{{ route('booking-ticket.index') }}" style="margin-bottom:5px">Danh sách booking</a>
    <form role="form" method="POST" action="{{ route('booking-ticket.update') }}" id="dataForm">
      <input type="hidden" name="id" value="{{ $detail->id }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-12">
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
              <div>
                @foreach($detail->payment as $p)
                  @if($p->type == 1)
                  <img src="{{ Helper::showImageNew(str_replace('uploads/', '', $p->image_url))}}" width="80" style="border: 1px solid red" class="img-unc" >
                  @else
                  <br>+ {{$p->notes}}
                  @endif
                  @endforeach

                   
              </div>               
              <input type="hidden" name="type" value="3">

                <div class="form-group">
                  <label>Trạng thái <span class="red-star">*</span></label>
                   <select class="form-control" name="status" id="status">                        
                     <option value="1" {{ old('status', $detail->status) == 1 ? "selected" : "" }}>Mới</option>
                     <option value="2" {{ old('status', $detail->status) == 2 ? "selected" : "" }}>Hoàn tất</option>
                     <option value="4" {{ old('status', $detail->status) == 4 ? "selected" : "" }}>Dời ngày</option>
                     <option value="3" {{ old('status', $detail->status) == 3 ? "selected" : "" }}>Hủy</option>
                   </select>
                </div>


                <div class="row">
                    <div class="form-group col-xs-6">
                      <label>Tên khách hàng <span class="red-star">*</span></label>
                      <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $detail->name) }}">
                    </div> 
                   <div class="form-group col-xs-6"  >                  
                      <label>Điện thoại <span class="red-star">*</span></label>
                      <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $detail->phone) }}">
                    </div>
                    
                </div>
                @php
                    if($detail->use_date){
                        $use_date = old('use_date', date('d/m/Y', strtotime($detail->use_date)));
                    }else{
                        $use_date = old('use_date');
                    }
                  @endphp      
                <div class="row">
                  <div class="form-group col-xs-6" >                    
                    <label>Ngày giao <span class="red-star">*</span></label>
                    <input type="text" class="form-control datepicker" name="use_date" id="use_date" value="{{ $use_date }}" autocomplete="off">
                  </div> 
                  <div class="form-group col-xs-6">                  
                    <label>Nơi giao</label>
                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $detail->address) }}">
                  </div>  
                </div>
                
                <p style="color: blue;font-weight: bold;text-decoration: underline;text-transform: uppercase;margin-top: 15px;">Danh sách vé:</p>
                <hr>
                @for($k = 0; $k < 4; $k++)
                @php
                $ticket_type_id = $amount = $price = $price_sell = $total = $commission = null;
                if(isset($ticketArr[$k])){
                  $ticket_type_id = $ticketArr[$k]->ticket_type_id;
                  $amount = $ticketArr[$k]->amount;
                  $price = $ticketArr[$k]->price;
                  $price_sell = $ticketArr[$k]->price_sell;
                  $total = $ticketArr[$k]->total;
                  $commission = $ticketArr[$k]->commission;
                }
                @endphp
                <div class="rooms-row">
                <div class="row">
                  <div class="form-group col-xs-4 col-md-4">
                      <label>Loại vé</label>
                      <select class="form-control select2 ticket_type" name="ticket_type_id[]" id="ticket_type_id{{ $k }}">  
                        <option value="">--Chọn--</option>  
                        @foreach($ticketType as $hotel)
                        <option data-price="{{ number_format($hotel->price) }}" value="{{ $hotel->id }}" {{ old('ticket_type_id.'.$k, $ticket_type_id) == $hotel->id  ? "selected" : "" }}>{{ $hotel->name }}</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="form-group col-xs-2 col-md-2" >
                      <label>Số lượng</label>
                      <select class="form-control room_amount select2" name="amount[]" id="amount{{ $k }}">
                        <option value="0">0</option>
                        @for($i = 1; $i <= 50; $i++)            
                        <option value="{{ $i }}" {{ old('amount.'.$k, $amount) == $i ? "selected" : "" }}>{{ $i }}</option>
                        @endfor
                      </select>
                  </div>                  
                  <div class="form-group col-xs-3 col-md-3" >
                        <label>Giá gốc 1 vé</label>
                      <input type="text" name="price[]" id="price{{ $k }}" class="form-control number price" value="{{ old('price.'.$k, $price) }}">
                    </div>
                  <div class="form-group col-xs-3 col-md-3" >
                      <label>Giá bán</label>
                      <input type="text" name="price_sell[]" id="price_sell{{ $k }}" class="form-control number room_price" value="{{ old('price_sell.'.$k, $price_sell) }}">
                  </div>
                  
                </div>
                <div class="row">
                    <div class="form-group col-xs-6 col-md-6" >
                        <label>Tổng tiền</label>
                        <input type="text" name="total[]" id="total{{ $k }}" class="form-control number room_price_total" value="{{ old('total.'.$k, $total) }}">
                    </div>
                    <div class="form-group col-xs-6 col-md-6" >
                        <label>Tiền lãi</label>
                        <input type="text" name="commission[]" id="commission{{ $k }}" class="form-control number commission" value="{{ old('commission.'.$k, $commission) }}" placeholder="">
                    </div>
                </div>
              </div>
                <hr>
                @endfor
                
                <div class="row">
                  <div class="form-group col-xs-4" >
                      <label>Tiền cọc</label>
                    <input type="text" class="form-control number" name="tien_coc" id="tien_coc" value="{{ old('tien_coc', $detail->tien_coc) }}">
                  </div>
                  @php
                    if($detail->ngay_coc){
                        $ngay_coc = old('ngay_coc', date('d/m/Y', strtotime($detail->ngay_coc)));
                    }else{
                        $ngay_coc = old('ngay_coc');
                    }
                  @endphp 
                  <div class="form-group col-xs-4" >
                      <label>Ngày cọc</label>
                      <input type="text" class="form-control datepicker" name="ngay_coc" id="ngay_coc" value="{{ $ngay_coc }}" autocomplete="off">
                  </div>
                  <div class="form-group col-xs-4" style="padding-right: 0px">
                      <label>Người thu cọc <span class="red-star">*</span></label>
                      <select class="form-control" name="nguoi_thu_coc" id="nguoi_thu_coc">
                        <option value="">--Chọn--</option>
                        <option value="1" {{ old('nguoi_thu_coc', $detail->nguoi_thu_coc) == 1 ? "selected" : "" }}>Sales</option>
                        <option value="2" {{ old('nguoi_thu_coc', $detail->nguoi_thu_coc) == 2 ? "selected" : "" }}>CTY</option>
                      </select>
                  </div>
                </div>  
                <div class="row">
                  <div class="form-group col-xs-4" >
                      <label>TỔNG TIỀN <span class="red-star">*</span></label>
                    <input type="text" class="form-control number" name="total_price" id="total_price" value="{{ old('total_price', $detail->total_price) }}">
                  </div>
                  <div class="form-group col-xs-4">
                      <label>Người thu tiền {{ $detail->nguoi_thu_tien }}<span class="red-star">*</span></label>
                      <select class="form-control" name="nguoi_thu_tien" id="nguoi_thu_tien">
                        <option value="">--Chọn--</option>
                        <option value="1" {{ old('nguoi_thu_tien', $detail->nguoi_thu_tien) == 1 ? "selected" : "" }}>Sales</option>
                        <option value="2" {{ old('nguoi_thu_tien', $detail->nguoi_thu_tien) == 2 ? "selected" : "" }}>CTY</option>
                        <option value="3" {{ old('nguoi_thu_tien', $detail->nguoi_thu_tien) == 3 ? "selected" : "" }}>Đại lý</option>
                      </select>
                  </div>
                  <div class="form-group col-xs-4" >
                      <label>CÒN LẠI <span class="red-star">*</span></label>
                      <input type="text" class="form-control number" name="con_lai" id="con_lai" value="{{ old('con_lai', $detail->con_lai) }}">
                  </div>
                </div> 
                <div class="row">
                  @if(Auth::user()->role == 1)
                  <div class="form-group col-xs-4" >
                     <label>Sales <span class="red-star">*</span></label>
                      <select class="form-control select2" name="user_id" id="user_id">
                        <option value="0">--Chọn--</option>
                        @foreach($listUser as $user)        
                        <option value="{{ $user->id }}" {{ old('user_id', $detail->user_id) == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                        @endforeach
                      </select>
                  </div>
                  
                  @endif 
                  <div class="form-group col-xs-4">
                     <label>Người book </label>
                      <select class="form-control select2" name="ctv_id" id="ctv_id">
                        <option value="">--Chọn--</option>
                        @foreach($ctvList as $ctv)
                        <option value="{{ $ctv->id }}" {{ old('ctv_id', $detail->ctv_id) == $ctv->id ? "selected" : "" }}>{{ $ctv->name }}</option>
                        @endforeach
                      </select>
                  </div>
                  @php
                    if($detail->book_date){
                        $book_date = old('book_date', date('d/m/Y', strtotime($detail->book_date)));
                    }else{
                        $book_date = old('book_date');
                    }
                  @endphp 
                    <div class="form-group @if(Auth::user()->role == 1) col-xs-4 @else col-xs-12  @endif" >
                  <label>Ngày đặt</label>
                  <input type="text" class="form-control datepicker" name="book_date" id="book_date" value="{{ $book_date }}" autocomplete="off">
              </div>                     
                </div>
                
               
                
                <div class="form-group">
                  <label>Ghi chú</label>
                  <textarea class="form-control" rows="4" name="notes" id="notes" >{{ old('notes', $detail->notes) }}</textarea>
                </div>    
                  
                </div>                
            </div>          
                              
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-defaulD btn-sm" class="btn btn-primary btn-sm" href="{{ route('booking-ticket.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@stop
@section('js')
<script type="text/javascript">
  $(document).on('click','#btnSave', function(){    
    if(parseInt($('#tien_coc').val()) > 0 && $('#nguoi_thu_coc').val() == ''){
      alert('Bạn chưa chọn người thu cọc');
      return false;
    }
  });
  $(document).ready(function(){
    $('.room_price, .room_amount, #tien_coc').change(function(){     
      setPrice();
    });
    $('.ticket_type').change(function(){
      var price = $(this).parents('.rooms-row').find('.ticket_type option:selected').data('price');
      $(this).parents('.rooms-row').find('.price').val(price);
      setPrice();
    });
  });
  function setPrice(){
    var total_price = 0;
    $('.rooms-row').each(function(){
      var row = $(this);
      var room_amount = parseInt(row.find('.room_amount').val()); 
      var room_price = parseInt(row.find('.room_price').val());
      var price = parseInt(row.find('.price').val());
      console.log(room_amount, room_price);
      if(room_amount > 0 && room_price > 0){
        var room_price_total = room_amount*room_price;  
        row.find('.room_price_total').val(room_price_total);
        total_price += room_price_total;
        var room_price_old = room_amount*price;  
        row.find('.commission').val(room_price_total-room_price_old);
      }     
      
    });
    console.log(total_price);
   
    //tien_coc
    var tien_coc = 0;
    if($('#tien_coc').val() != ''){
     tien_coc = parseInt($('#tien_coc').val());
    }
    total_price = total_price;    
    console.log('total_price: ', total_price);
    $('#total_price').val(total_price);

    $('#con_lai').val(total_price - tien_coc);
  }
</script>
@stop