@extends('app')

@section('content')

<style>
tr.fancytree-active {
    background-color: #eeeeee !important;
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Menu</span>
                <div class="widget-menu pull-right mr20">
                    <a href="{{ url('menus/create/0') }}" class="btn btn-xs btn-primary"><span class="fa fa-plus"></span> Add Root</a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table" id="tree">
                    <colgroup>
                        <col width="*"></col>
                        <col width="220px"></col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Application Menu</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
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
    $('#tree').fancytree({
        source: {
            url: '{{ url('menus/tree') }}'
        },
        extensions: [ 'table' ],
        table: {
            indentation: 20,
            nodeColumnIdx: 0
        },
        renderColumns: function(ev, data) {
            var node = data.node,
                $tds = $(node.tr).find('>td'),
                html = '<a href="{{ url('menus/create') }}/'+ node.key +'" class="btn btn-xs btn-primary fs10"><span class="fa fa-plus"></span>&nbsp;&nbsp;Add child</a>'+
                    '&nbsp;&nbsp;<a href="{{ url('menus/update') }}/'+ node.key +'" class="btn btn-xs btn-success fs10"><span class="fa fa-pencil"></span>&nbsp;&nbsp;Edit</a>'+
                    '&nbsp;&nbsp;<a href="javascript:" class="btn btn-xs btn-danger fs10 btn-delete" data-id="'+ node.key +'"><span class="fa fa-trash"></span>&nbsp;&nbsp;Delete</a>';
            $tds.eq(1).html(html);
        }
    });
    // events
    $('#tree').on('click', '.btn-delete', function() {
        if(confirm('Are you sure want to delete this item?'))
            location.href = '{{ url('menus/delete') }}/'+ $(this).data('id');
    });
});
</script>
@endsection