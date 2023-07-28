@extends('web::layouts.grids.12')

@section('title', 'DKP')
@section('page_header', '联盟Pap导入')

@push('head')
    <link rel="stylesheet"
          type="text/css"
          href="https://snoopy.crypta.tech/snoopy/seat-srp-approval.css"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/denngarr-srp-hook.css') }}"/>
@endpush

@section('full')
    <div class="form-group" method=post>
    <textarea name="content" id="form" cols="70" rows="30" placeholder="请复制整个excel并在此处粘贴"></textarea>
    <br>
    <input type="submit" id="readform" name="submit" value="提交" />
    </div>


@stop

@push('javascript')
<script>
    $('#readform').on('click', function(){


        mes = $('#form').parent('div.form-group');
        








    });



</script>
@endpush

