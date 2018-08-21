@extends('app')

@section('content')
<style>
tr.fancytree-active, tr.fancytree-selected {
    background-color: #eeeeee !important;
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Role | Entry</span>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="javascript:" method="post" id="form-input">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id"/>
                    <div class="form-group">
                        <label class="col-md-2 control-label pt5">Name <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input class="form-control input-sm required" type="text" placeholder="Name" name="name" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label pt5">&nbsp;</label>
                        <div class="col-md-10">
                            <table class="table" id="tree">
                                <colgroup>
                                    <col width="320px"></col>
                                    <col width="*"></col>
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Permission</th>
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
                </form>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-2 col-lg-offset-10">
                        <button class="btn btn-sm btn-primary dark btn-block" type="button" id="btn-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('contentjs')
<script type="text/javascript">
$(function() {
    // init plugins
    var menus = [];
    var perms = [];
    @isset($menus)
    menus = [{!! $menus->implode('id', ',') !!}];
    @endisset
    @isset($perms)
    perms = [{!! $perms->implode('id', ',') !!}];
    @endisset
    $('#tree').fancytree({
        clickForMode: 2,
        selectMode: 3,
        checkbox: true,
        source: {
            url: '{{ url('roles/tree') }}'
        },
        extensions: [ 'table' ],
        table: {
            indentation: 20,
            nodeColumnIdx: 0
        },
        renderColumns: function(ev, data) {
            var node = data.node,
                $tds = $(node.tr).find('>td'),
                html = '';
            if($.inArray(parseInt(node.key), menus)>=0)
                node.setSelected(true);
            if(node.data.perms) {
                $.each(node.data.perms, function(key,val) {
                    html += '<input type="checkbox" value="'+ val.id +'" name="perms[]"'+ ($.inArray(val.id,perms)>=0?' checked="checked"':'') +'>&nbsp;&nbsp;'+ val.name +'&nbsp;&nbsp;&nbsp;&nbsp;';
                });
                $tds.eq(1).html(html);
            }
        }
    });
    // init data
    @isset($data)
    $('#id').val('{{ $data->id }}');
    $('#name').val('{{ $data->name }}');
    @endisset
    // events
    $('#btn-submit').click(function() {
        var isValid = true,
            form = $('#form-input');
        $.each($('.required'), function() {
            if($(this).val()==='') {
                $(this).closest('div').addClass('has-error');
                isValid &= false;
            }
        });
        if(isValid) {
            var treeData = $.map($('#tree').fancytree('getTree').getSelectedNodes(), function(node) {
                return node.key;
            });
            for(var iLoop=0; iLoop<treeData.length; iLoop++) {
                form.append(
                    '<input type="hidden" name="menus[]" value="'+ treeData[iLoop] +'"/>'
                );
            }
            form.attr('action', '{{ url('roles/store') }}');
            form.submit();
        }
        form.attr('action', 'javascript:');
    });
});
</script>
@endsection