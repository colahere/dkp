@extends('web::layouts.grids.8-4')

@section('title', 'DKP')
@section('page_header', 'Pap导入——————每月1号执行一次')

@push('head')
    <link rel="stylesheet"
          type="text/css"
          href="https://snoopy.crypta.tech/snoopy/seat-srp-approval.css"/>

    <link rel="stylesheet" type="text/css" href="https://snoopy.crypta.tech/snoopy/seat-srp-request.css"/>
@endpush

@section('left')
<div class = "card card-success">
        <div class = "card-header">
			<h3 class="card-title">工具人dkp发放</h3>
		</div>
		<div class="card-body">
		<form role="form" action="{{ route('dkp.tooldkps') }}" method="post">
   		 	@csrf
        	<div class="form-group">
			<br>
                                名称：<select name="user_id" id="user_id" style="width: 50%">
                                <option value=""></option>
                                @foreach(json_decode($user,false) as $user)
                                <option value="{{$user->id}}">用户名称:{{$user->name}}</option>
                                @endforeach
                                </select>
										<br>
                                        <br>
                                数量：<input type="text" id="score" name="score" style="width: 50%"/>
                                        <br>
										<br>
                                原因：<input type="text" id="remark" name="remark" style="width: 50%"/>
                                        <br>
										<br>
                                <input type="submit" id="submittooldkp" name="submittooldkp" value="提交" />
            </br>

        	</div>
       	</form>
		</div>
</div>


<div class = "card card-success">
        <div class = "card-header">
			<h3 class="card-title">联盟PAP导入</h3>
        </div>
        <div class="card-body">
       	  	<form role="form" action="{{ route('dkp.paptodkp') }}" method="post">
   		 	@csrf
        	<div class="form-group">
        		<textarea type="form-control" class="form-control" name="papform" id="papform" cols="70" rows="10" placeholder="请复制整个excel并在此处粘贴"></textarea>
        		<br>
        			<input type="hidden"  id="trdkp" name="trdkp">
        			<input type="button" id="readform" name="readform" value="解析" />
        			<input type="submit" id="submitdkp" name="submitdkp" value="提交" />
				</br>
        	</div>
       	 	</form>
		</div>
</div>
	<div class = "card card-default">
		<div class = "card-header">
			<h3 class="card-title">军团PAP导入</h3>
		</div>
        <div class="card-body">
			<form role="form" action="{{ route('dkp.leginpap') }}" method="post">
				@csrf
        		<div class="form-group">
					<input type="submit" id="leginpap" name="leginpap" value="军团pap导入" />
				</div>
			</form>
		</div>
	</div>

@stop
@section('right')
<div class = "card card-primary">
	<div class = "card-header">
		<h3 class="card-title">联盟PAP导入预览</h3>
	</div>
	<div class="card-body">
    	<table id="showpaptodkp" class="table table-condensed">
        	<thead>
       		<tr>
                <th><label class="label pull-right" style="font-size: 100%">角色ID</label></th>
                <th><label class="label pull-right" style="font-size: 100%">paps数量</label></th>
        	</tr>
        	</thead>
        	<tbody>
        	</tbody>
    	</table>

	</div>
</div>
<div class = "card card-default">
	<div class = "card-header">
			<h3 class="card-title">军团PAP预览</h3>
		</div>
		<div class="card-body">
		<table id="showleginpap" class="table table-condensed">
		<thead>
       		<tr>
                <th><label class="label pull-right" style="font-size: 100%">角色ID</label></th>
                <th><label class="label pull-right" style="font-size: 100%">paps数量</label></th>
        	</tr>
        </thead>
        <tbody>
		@foreach(json_decode($leginpap,false) as $leginpap)
			<tr>
				<td>{{$leginpap->character_id}}</td>
				<td>{{$leginpap->qty}}</td>
			</tr>
		@endforeach

        </tbody>
		</table>
		</div>
	</div>
</div>


@stop


@push('javascript')
<script>

$paptodkp = [];
    $('#readform').on('click', function(){


	    mesFormGroup = $('#papform').parent('div.form-group');
	    mesFormGroup.find('span.help-block').hide();
            mesFormGroup.removeClass('has-error');
        $('#highSlots, #midSlots, #lowSlots, #rigs, #cargo, #drones')
            .find('tbody')
            .empty();
	$mes = $('#papform').val();
	    $mestest = "101";
	console.log($('#papform'));
	console.log($mes);
	console.log($mestest);
	$mes = $mes.replace("\r", "");
	$mes = $mes.split("\n");
	$len = $mes.length;
	console.log($mes);
	$paptodkp = [];

	for($i=0;$i<$len;$i++){
	if($mes[$i].split("\t").length ==2){
		$info=$mes[$i].split("\t");
		console.log($info);
		$table = document.getElementById("showpaptodkp");
		$result = {"character_id" : $info[0],
			"value" : $info[1],};
		$paptodkp.push($result);
		$table.innerHTML += "<tr>\n"+
                "<td>"+$info[0]+"</td>\n"+
                "<td>"+$info[1]+"</td>\n"+
                "</tr>";

	}	
	}
	console.log($paptodkp);
	document.getElementById("trdkp").value = JSON.stringify($paptodkp);
	console.log($('#trdkp'));
        $mesi = $('#trdkp').val();
	console.log($mesi);

    });
</script>
@endpush
