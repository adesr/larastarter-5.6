@extends('app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Menu | Entry</span>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="javascript:" method="post" id="form-input">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id"/>
                    <input type="hidden" name="parent_id" id="parent_id"/>
                    <div class="form-group">
                        <label class="col-md-2 control-label pt5">Name <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input class="form-control input-sm required" type="text" placeholder="Name" name="name" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label pt5">Slug <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input class="form-control input-sm required" type="text" placeholder="Slug" name="slug" id="slug">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label pt5">Icon</label>
                        <div class="col-md-10">
                            <select class="form-control input-sm input-select2" name="icon" id="icon"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label pt5">Order No.</label>
                        <div class="col-lg-2">
                            <input id="order_no" name="order_no" class="form-control input-sm input-int required" type="text" placeholder="Order No.">
                        </div>
                        <div class="col-lg-2">
                            <div class="checkbox-custom pt5">
                                <input type="checkbox" id="is_active" name="is_active" checked="checked" value="1">
                                <label for="is_active">Active ?</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label pt5">Available Permissions</label>
                        <div class="col-md-10">
                            <select class="form-control input-sm input-select2-multiple" multiple="multiple" name="permissions[]" id="permissions"></select>
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
    $('select.input-select2').select2({
        placeholder: 'Pick an Icon',
        allowClear      : true,
        templateResult  : function(item) {
            if(!item.id)
                return item.text;
            var $item = $('<span><i class="'+ item.element.value +'"></i>&nbsp&nbsp;'+ item.text +'</span>');
            return $item;
        },
        templateSelection: function(item) {
            if(!item.id)
                return item.text;
            var $item = $('<span><i class="'+ item.element.value +'"></i>&nbsp&nbsp;'+ item.text +'</span>');
            return $item;
        }
    });
    // init data
    var buildIcons = function(data) {
        var html = '',
            len = data.length;
        for(var iLoop=0;iLoop<len;iLoop++) {
            html += '<option value="'+ data[iLoop] +'">'+ data[iLoop] +'</option>';
        }
        return html;
    };
    if(!localStorage.getItem('icons')) {
        localStorage.setItem('icons', buildIcons(icons));
    }
    $('#icon').append(localStorage.getItem('icons')).trigger('change');
    @isset($parent_id)
    $('#parent_id').val('{{ $parent_id }}');
    @endisset
    @isset($data)
    $('#id').val('{{ $data->id }}');
    $('#parent_id').val('{{ $data->parent_id }}');
    $('#name').val('{{ $data->name }}');
    $('#slug').val('{{ $data->slug }}');
    $('#icon').val('{{ $data->icon }}').trigger('change');
    $('#order_no').val('{{ $data->order_no }}');
    $('#is_active').prop('checked', {{ $data->is_active?'true':'false' }});
    $('#permissions').html('{!! $perms->map(function($item,$index) {
        return '<option value="'. $item->name .'">'. $item->name .'</option>';
    })->implode('') !!}');
    $('#permissions').val(["{!! $perms->implode('name', '","') !!}"]).trigger('change');
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
            form.attr('action', '{{ url('menus/store') }}');
            form.submit();
        }
        form.attr('action', 'javascript:');
    });
});
</script>
@endsection