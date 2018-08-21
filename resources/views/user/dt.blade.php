@extends('app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h4 class="box-title">List: User</h4>
                @can('create user')
                <div class="box-tools pull-right">
                    <a class="btn btn-sm btn-primary mr20" href="{{ url('users/create') }}"><i class="fa fa-plus"></i> New</a>
                </div>
                @endif
            </div>
            <div class="box-body">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width:60px">&nbsp;</th>
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
    // init before plugins
    // init plugins
    var oTable = $('#datatable').DataTable({
        processing      : true,
        serverSide      : true,
        ajax            : '{{ url('users/dt') }}',
        columns         : [
            { data: 'username', name: 'username' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        pageLength      : 50,
        order           : [],
        searchDelay     : 1500,
        drawCallback    : function(settings) {
            $('a[data-toggle="tooltip"]', this.api().table().container()).tooltip({ container : 'body' });
        }
    });
    // init data
    // event
    $('body').on('click', '.row-delete', function() {
        if(confirm('Attempting to delete data, are you sure?')) {
            location.href = $(this).attr('data-url');
        }
    });
});
</script>
@endsection
