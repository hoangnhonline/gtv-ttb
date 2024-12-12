@extends('layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      HDV    
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('hdv.index') }}">HDV</a></li>
      <li class="active">Cập nhật</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('hdv.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('hdv.update') }}" id="dataForm">
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
                <div class="form-group col-md-12">
                  <label>Đối tác<span class="red-star">*</span></label>
                  <select name="user_id" id="user_id" class="form-control select2">
                     <option value="">--Đối tác--</option>
                    @foreach($partners as $partner)
                    <option value="{{ $partner->id }}" {{ old('user_id', $detail->user_id) == $partner->id ? "selected" : "" }}>{{ $partner->name }}</option>
                    @endforeach
                  </select>
                </div>                 
                 <!-- text input -->
                <div class="form-group col-md-12">
                  <label>Tên HDV</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $detail->name) }}" autocomplete="off">
                </div>                  
                                   
            </div>                        
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('hdv.index')}}">Hủy</a>
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