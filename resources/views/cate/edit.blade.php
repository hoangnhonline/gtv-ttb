@extends('layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dịch vụ    
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('cate.index') }}">Dịch vụ</a></li>
      <li class="active">Cập nhật</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('cate.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('cate.update') }}" id="dataForm">
      <input type="hidden" name="id" value="{{ $detail->id }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Tạo mới</h3>
          </div>
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
              <div class="row">
                <div class="form-group col-xs-4">
                      <label style="font-weight: bold">
                        <input type="checkbox" id="is_load" name="is_load" value="1" {{ old('da_thu', $detail->is_load) == 1 ? "checked" : "" }}>
                        Hiện app
                      </label>
                  </div>
              </div>
                 <!-- text input -->
                <div class="form-group">
                  <label>Tên dịch vụ (thêm giá tiền vào phía sau tên cho dễ phân biệt. Vd: Dù bay 2 người 900 ) <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $detail->name) }}">
                </div>  
                <div class="form-group">
                  <label>Tên ngắn (để hiển thị ngắn gọn trên APP ) <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="short_name" id="short_name" value="{{ old('short_name', $detail->short_name) }}">
                </div> 
                <div class="form-group">
                  <label>Giá tiền<span class="red-star">*</span></label>
                  <input type="text" class="form-control number" name="price" id="price" value="{{ old('price', $detail->price) }}">
                </div>
                <div class="form-group">
                  <label>Thời gian (phút) - có thể để trống</label>
                  <input type="text" class="form-control" name="duration" id="duration" value="{{ old('duration', $detail->duration) }}">
                </div>
                <div class="form-group">
                  <label>Loại dịch vụ<span class="red-star">*</span></label>
                  <select name="type" id="type" class="form-control">
                    @foreach($cateType as $cate)
                    <option value="{{ $cate->id }}" {{ old('type', $detail->type) == $cate->id ? "selected" : "" }}>{{ $cate->name }}</option>
                    @endforeach
                  </select>
                </div>                      
            </div>                        
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('cate.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      </div>
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

@stop