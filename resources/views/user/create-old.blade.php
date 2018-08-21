@extends('app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">User | Entry</span>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="javascript:" method="post" id="form-input">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id"/>
                    <div class="form-group">
                        <label class="col-md-2 control-label pt5">Role</label>
                        <div class="col-md-10">
                            <select class="form-control input-sm input-select2" name="role_id" id="role_id">
                                <option value=""></option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label pt5">Name <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input class="form-control input-sm required" type="text" placeholder="Name" name="name" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label pt5">Username <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input class="form-control input-sm required" type="text" placeholder="Username" name="username" id="username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label pt5">Email <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input class="form-control input-sm required" type="text" placeholder="Email" name="email" id="email">
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

    // init data
    @isset($data)
    $('#id').val('{{ $data->id }}');
    $('#name').val('{{ $data->name }}');
    $('#username').val('{{ $data->username }}');
    $('#email').val('{{ $data->email }}');
    $('#role_id').val('{{ $data->roles->first()->id }}').trigger('change');
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
            form.attr('action', '{{ url('users/store') }}');
            form.submit();
        }
        form.attr('action', 'javascript:');
    });
});
</script>
@endsection