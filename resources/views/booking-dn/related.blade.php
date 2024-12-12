<option value="0">-- Chọn --</option>
@if(!empty($detailRelated))
@foreach($detailRelated as $r)
<option value="{{ $r->id }}">{{ $r->name }}</option>
@endforeach
@endif