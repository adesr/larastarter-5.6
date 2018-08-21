@extends('app')

@section('plugins_css')
@endsection

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
                    <label class="col-sm-2 control-label">Username <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm required" id="username" name="username" placeholder="Username">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm required" id="name" name="name" placeholder="Name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm required" id="email" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Role <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control input-sm required" id="role_id" name="role_id">
                            <option value=""></option>
                        @foreach ($roles as $r)
                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                        @endforeach
                        </select>
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

    // init plugins
    $('#role_id').select2({
        placeholder: 'Pick a Role',
        allowClear: true
    });
    // init data
    @if(isset($data))
    $('#id').val('{{ $data->id }}');
    $('#username').val('{{ $data->username }}');
    $('#name').val('{{ $data->name }}');
    $('#email').val('{{ $data->email }}');
    $('#role_id').val('{{ $data->roles->first()->id }}').trigger('change');
    @endif
    @if(old('name'))
    $('#id').val('{{ old('id') }}');
    $('#username').val('{{ old('username') }}');
    $('#name').val('{{ old('name') }}');
    $('#email').val('{{ old('email') }}');
    $('#role_id').val('{{ old('role_id') }}').trigger('change');
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
            form.attr('action', '{{ url('users/store') }}');
            form.submit();
        } else {
            alert('Please check your input!');
        }
    });
});
</script>
@endsection
