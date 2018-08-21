@extends('app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h4>Form: Menu</h4>
            </div>

            <form action="javascript:" id="form-input" class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" id="id" name="id"/>
                <input type="hidden" id="parent_id" name="parent_id"/>

            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm required" id="name" name="name" placeholder="Name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Slug <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm required" id="slug" name="slug" placeholder="Slug">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Icon</label>
                    <div class="col-sm-10">
                        <select class="form-control input-sm" id="icon" name="icon"></select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Order No. <span class="text-danger">*</span></label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm text-right required" id="order_no" name="order_no" placeholder="Order No.">
                    </div>
                    <label class="col-sm-1 control-label">&nbsp;</label>
                    <div class="col-sm-2">
                        <label style="padding-top: 5px">
                            <input type="checkbox" class="form-control input-sm" id="is_active" name="is_active" checked="checked">&nbsp;&nbsp;Active ?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Permissions</label>
                    <div class="col-sm-10">
                        <select class="form-control input-sm" id="permissions" name="permissions[]" multiple="multiple"></select>
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

@section('contentjs')
<script type="text/javascript">
$(function() {
    // init before plugins
    var opt = '<option value=""></option>';
    for(var iLoop=0; iLoop<icons.length; iLoop++) {
        opt += '<option value="'+ icons[iLoop] +'">'+ icons[iLoop] +'</option>'
    }
    $('#icon').html(opt);
    // init plugins
    $('#icon').select2({
        placeholder: 'Pick an Icon',
        allowClear: true,
        templateResult: function(item) {
            if(!item.id)
                return item.text;
            return $('<span><i class="'+ item.element.value +'"></i>&nbsp&nbsp;'+ item.text +'</span>');
        }
    });
    $('#permissions').select2({
        placeholder: 'Pick a Permission',
        tags: true
    });
    $('#order_no').autoNumeric('init', {
        aSep: '',
        mDec: 0
    });
    $('#is_active').iCheck({
        checkboxClass: 'icheckbox_minimal-blue'
    });
    // init data
    @if(isset($parent_id))
    $('#parent_id').val('{{ $parent_id }}');
    $('#order_no').val('{{ $order_no }}');
    @endif
    @if(isset($data))
    $('#id').val('{{ $data->id }}');
    $('#parent_id').val('{{ $data->parent_id }}');
    $('#name').val('{{ $data->name }}');
    $('#slug').val('{{ $data->slug }}');
    $('#icon').val('{{ $data->icon }}').trigger('change');
    $('#order_no').val('{{ $data->order_no }}');
    $('#is_active').iCheck('{{ $data->is_active?'check':'uncheck' }}');
    $('#permissions').html('');
    var perms = '',
        arrPerms = [];
        @foreach ($data->permissions as $val)
    perms += '<option value="{{ $val->name }}">{{ $val->name }}</option>';
    arrPerms.push('{{ $val->name }}');
        @endforeach
    $('#permissions').html(perms);
    $('#permissions').val(arrPerms).trigger('change');
    @endif
    @if(old('name'))
    $('#id').val('{{ old('id') }}');
    $('#parent_id').val('{{ old('parent_id') }}');
    $('#name').val('{{ old('name') }}');
    $('#slug').val('{{ old('slug') }}');
    $('#icon').val('{{ old('icon') }}').trigger('change');
    $('#order_no').val('{{ old('order_no') }}');
    $('#is_active').iCheck('{{ old('is_active')?'check':'uncheck' }}');
    @endif
    // event
    $('#btn-submit').click(function() {
        var isValid = true,
            form = $('#form-input');
        $.each($('.required'), function() {
            isValid &= $(this).val()!=='';
        });
        if(isValid) {
            form.attr('method', 'post');
            form.attr('action', '{{ url('menus/store') }}');
            form.submit();
        } else {
            alert('Please check your input!');
        }
    });
});
</script>
@endsection
