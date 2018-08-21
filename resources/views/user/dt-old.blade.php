@extends('app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">User</span>
                <div class="widget-menu pull-right mr20">
                    <a href="{{ url('users/create') }}" class="btn btn-xs btn-primary"><span class="fa fa-plus"></span> New User</a>
                </div>
            </div>
            <div class="panel-body pn">
                <table class="table table-striped table-hover" id="datatables">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th style="width:40px">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('contentjs')
<script type="text/javascript">
$(function() {
    // init plugins
    oTable = $('#datatables').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('users/dt') }}',
        columns: [
            { data: 'name' },
            { data: 'username' },
            { data: 'email' },
            { data: 'action', searchable: false, orderable: false }
        ],
        order: [],
        pageLength: 50,
        dom: '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
        drawCallback: function(settings) {
            $('a[data-toggle="tooltip"]', this.api().table().container()).tooltip({ container : 'body' });
        }
    });
    // events
    $('#datatables').on('click', '.row-delete', function() {
        if(confirm('Are you sure want to delete this item?'))
            location.href = '{{ url('users/delete') }}/'+ $(this).data('id');
    });
});
</script>
@endsection