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
    <li><a href="{{ route( 'hdv.index' ) }}">Danh mục</a></li>
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
      <a href="{{ route('hdv.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>   
      <div class="box">
        <div class="panel-body">    
            <form class="form-inline" id="dataForm" role="form" method="GET" action="{{ route('hdv.index') }}">
               
              <div class="form-group">
                <select class="form-control select2" name="user_id" id="user_id">
                    <option value="">--Đối tác--</option>
                    @foreach($partners as $partner)
                    <option value="{{ $partner->id }}" {{ $user_id == $partner->id ? "selected" : "" }}>{{ $partner->name }}</option>
                    @endforeach
                  </select>
              </div>
              <button class="btn btn-info" type="submit">Lọc</button>     
            </form>
          </div>
      </div>   
        <div class="box-header with-border">
          <h3 class="box-title">Danh sách</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>
              <th class="text-left">Đối tác</th>          
              <th>Tên HDV</th>           
              <th width="1%" style="white-space: nowrap;">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>
                <td class="text-left">
                  @if($item->user_id)
                  {{ $item->partner->name }}
                  @endif
                </td> 
                <td>                  
                  <a href="{{ route( 'hdv.edit', [ 'id' => $item->id ]) }}">{{ $item->name }}</a>               

                </td>                  
                                     
                <td style="white-space:nowrap">                 
                  <a href="{{ route( 'hdv.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>
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
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
@stop
@section('js')
<script type="text/javascript">
function callDelete(name, url){  
  swal({
    title: 'Bạn muốn xóa "' + name +'"?',
    text: "Dữ liệu sẽ không thể phục hồi.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then(function() {
    location.href= url;
  })
  return flag;
}

$(document).ready(function(){
  $('#user_id').change(function(){
        $('#dataForm').submit();
  });


});

</script>
@stop