@extends('web::layouts.grids.12')

@section('title', 'DKP')
@section('page_header', 'QQ绑定')

@push('head')
    <link rel="stylesheet"
          type="text/css"
          href="https://snoopy.crypta.tech/snoopy/seat-srp-approval.css"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/denngarr-srp-hook.css') }}"/>
@endpush

@section('full')



<div class="card" style="width: 30rem;">
<div class="card-body">
<form role="form" action="{{ route('dkp.addqqinfo') }}" method="post">
    @csrf
    <div class="form-group">
    <input type="form-control" class="form-control" name="addqq" id="addqq" placeholder="请输入qq号"></input>
    <br>
    <input type="submit" id="submitqq" name="submitqq" value="提交" class="btn btn-primary float-right"/>		
    </div>
</form>
</div>
</div>

<div class="card" style="width: 30rem;">
<div class="card-body">
<form role="form" action="{{ route('dkp.editname') }}" method="post">
    @csrf
    <div class="form-group">
    <input type="form-control" class="form-control" name="editname" id="editname" placeholder="请输入昵称"></input>
    <br>
    <input type="submit" id="submitname" name="submitname" value="提交" class="btn btn-primary float-right"/>		
    </div>
</form>
</div>
</div>

    @stop