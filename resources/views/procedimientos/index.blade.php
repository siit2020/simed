@extends('theme.lte.layout')
@section('contenido')
   {{--  <div class="col-md-4 pull-right">
      <div class="input-group input-daterange">
  
        <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">
  
        <div class="input-group-addon">to</div>
  
        <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">
  
      </div>
    </div>
  </div> --}}
  <table id="procedimientos"></table>
  
@endsection
@section('scripts')
    <script>
/*       
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[2] || 0; 

    if (
      (min == "" || max == "") ||
      (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
    ) {
      return true;
    }
    return false;
  }
);

var table = $('#my-table').DataTable();
$('.date-range-filter').change(function() {
  table.draw();
}); */

    </script>
@endsection