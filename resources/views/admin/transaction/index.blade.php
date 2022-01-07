@extends('layouts.admin')
@section('header','Transaction')

@section('css')
    <!-- dataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')

@can('view transactions')
<div id="controller">
    <div class="row">
        <div class="col-lg-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
            @endif
            @if ($message = Session::get('delete'))
            <div class="alert alert-primary alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                        <a href="{{url('transactions/create')}}"
                        class="btn btn-sm btn-primary pull-right">Create New Transaction</a>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="99">Status</option>
                                <option value="1">Selesai</option>
                                <option value="0">Belum Kembali</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class='input-group date' id='datetimepicker'>
                                <input type='date' class="form-control" name="date">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                
                <!-- /.card-header -->
                <div class="card-body">
                    <table  id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Nama</th>
                                <th>Lama Peminjaman</th>
                                <th>Total Buku</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th style="width: 150px" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

</div>
@endcan

@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script type="text/javascript">
    
    var actionUrl = '{{ url('transactions') }}';
    var apiUrl  = '{{url('api/transactions')}}';

    var columns = [
        {data:'DT_RowIndex',class:'text-center',orderable:true},
        {data:'date_start',class:'text-center',orderable:true},
        {data:'date_end',class:'text-center',orderable:true},
        {data:'name',class:'text-center',orderable:true},
        {data:'lama_pinjam',class:'text-center',orderable:true},
        {data:'total_buku',class:'text-center',orderable:true},
        {data:'total_bayar',class:'text-center',orderable:true},
        {data:'status',class:'text-center',orderable:true},
        {render: function(index,row,data,meta) {
            return `<a href="./transactions/${data.id}/edit" class="btn btn-warning btn-sm">
                Edit</a> 
                <a href="./transactions/${data.id}" class="btn btn-info btn-sm">
                Detail</a>
                <form action="./transactions/${data.id}" method="post">
                @csrf
                @method('delete')
                    <button onclick="return confirm('Are you sure?');" type="submit" class="d-sm-inline-block btn btn-sm btn-danger shadow-sm">Delete</button>
                </form>`;
        }, orderable:false, width:'200px', class:'text-center'},
    ];
</script>
<script src="{{asset('js/data.js')}}"></script>
<script type="text/javascript">

$('select[name=status]').on('change', function() {
    status = $('select[name=status]').val()
    if (status == 99) {
        controller.table.ajax.url(apiUrl).load()
    } else {
        controller.table.ajax.url(apiUrl + '?status=' + status).load()
    }
})

$('input[name=date]').on('change', function() {
    date_start = $('input[name=date]').val()
    controller.table.ajax.url(apiUrl + '?date_start=' + date_start).load()
})

</script>

@endsection