@extends('app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h4>Form: Role</h4>
            </div>

            <form action="javascript:" id="form-input" class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" id="id" name="id"/>

            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm required" id="name" name="name" placeholder="Name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Access &amp; Permissions</label>
                    <div class="col-sm-10">
                        <div id="tree"></div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" id="btn-submit">Submit</button>
            </div>

            </form>

        </div>
    </div>
</div>
@endsection

@section('plugins_js')
@endsection

@section('contentjs')
<script type="text/javascript">
$(function() {
    // init before plugins
    var menus = [];
    @if(isset($menus))
        @foreach($menus as $m)
    menus.push('{{ $m->id }}');
        @endforeach
    @endif
    var perms = [];
    @if(isset($perms))
        @foreach($perms as $p)
    perms.push({{ $p->id }});
        @endforeach
    @endif
    // init plugins
    $('#tree').fancytree({
        clickFolderMode : 2,
        selectMode      : 3,
        checkbox        : true,
        source: {
            url: '{{ url('roles/tree') }}',
            cache: false
        },
        renderNode: function(event, data) {
            var node = data.node;
            var nodeSpan = $(node.span);
            if(!nodeSpan.data('rendered')) {
                if(node.data.perms!==undefined) {
                    // render inputs
                    var inputs = '';
                    $.each(node.data.perms, function(index, item) {
                        inputs += '<input type="checkbox" name="perms[]" value="'+ item.id +'" '+ ($.inArray(item.id,perms)>=0?'checked="checked"':'') +'/>&nbsp;'+
                            item.name +'&nbsp;&nbsp;&nbsp;&nbsp;';
                        console.log($.inArray(item.id,perms));
                    });
                    // render Span
                    var spanBtn = $('<span class="fancytree-buttons fs11" style="margin-left:20px"></span>');
                    spanBtn.append(inputs);
                    // append elements
                    nodeSpan.append(spanBtn);
                }
                if($.inArray(node.key, menus)>=0) {
                    node.setSelected(true);
                }
                nodeSpan.data('rendered', true);
            }
        }
    });
    // init data
    @if(isset($data))
    $('#id').val('{{ $data->id }}');
    $('#name').val('{{ $data->name }}');
    $('#description').val('{{ $data->description }}');
    @endif
    @if(old('name'))
    $('#id').val('{{ old('id') }}');
    $('#name').val('{{ old('name') }}');
    $('#description').val('{{ old('description') }}');
    @endif
    // event
    $('#btn-submit').click(function() {
        var isValid = true,
            form = $('#form-input');
        $.each($('.required'), function() {
            isValid &= $(this).val()!=='';
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
            form.attr('method', 'post');
            form.attr('action', '{{ url('roles/store') }}');
            form.submit();
        } else {
            alert('Please check your input!');
        }
    });
});
</script>
@endsection
