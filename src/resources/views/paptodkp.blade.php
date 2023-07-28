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
<form role="form" action="{{ route('dkp.paptodkp') }}" method="post">
    @csrf
    <div class="form-group">
    <textarea type="form-control" class="form-control" name="papform" id="papform" cols="70" rows="30" placeholder="请复制整个excel并在此处粘贴"></textarea>
    <br>
    <input type="hidden"  id="trdkp" name="trdkp">
    <input type="button" id="readform" name="readform" value="解析" />
    <input type="submit" id="submitdkp" name="submitdkp" value="提交" />
		
    </div>
</form>


<table id="showpaptodkp" class="table table-bordered">
	<thead>
	<tr>
		<th>角色ID</th>
		<th>paps数量</th>
	</tr>
	</thead>
	<tbody>
	</tbody>
	</table>



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
