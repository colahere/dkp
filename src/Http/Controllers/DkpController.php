<?php

namespace Dkp\Seat\SeatDKP\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Seat\Kassie\Calendar\Models\Pap;
use Dkp\Seat\SeatDKP\Models\DkpInfo;
use Dkp\Seat\SeatDKP\Models\DkpConfig;
use Dkp\Seat\SeatDKP\Models\DkpSupplement;
use Dkp\Seat\SeatDKP\Models\DkpQQ;
use Seat\Web\Http\Controllers\Controller;
use Dkp\Seat\SeatDKP\Validation\AddSetting;
use Dkp\Seat\SeatDKP\Validation\AddSupplement;
use Dkp\Seat\SeatDKP\Validation\Commodity;
use Dkp\Seat\SeatDKP\Validation\addpap;
use Dkp\Seat\SeatDKP\Validation\addqq;
use Seat\Web\Models\User;
use Illuminate\Http\Request;
use Seat\Eveapi\Models\RefreshToken;


function sendPostRequest($interface,$getParameter,$data) {
    $url = 'https://seat.chuangshiqingyu.top:443/' . $interface . "?" . $getParameter; // 替换为实际的目标地址

    // 将数据转换为 JSON
    $jsonData = json_encode($data);

    // 设置请求头
    $headers = array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    );

    // 初始化 cURL
    $ch = curl_init();

    // 设置 cURL 选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // 执行请求并获取响应
    $response = curl_exec($ch);

    // 检查是否有错误发生
    if(curl_errno($ch)) {
        $error = curl_error($ch);
        echo "cURL Error: " . $error;
    }

    // 关闭 cURL 资源
    curl_close($ch);

    // 返回响应结果
    return $response;
}

class DkpController extends Controller
{
    /**
     * 获取个人dkp
     */
    public function getMineDkp()
    {
        $dkpList = DkpInfo::join('character_infos', 'character_infos.character_id', '=', 'dkp_info.character_id')
            ->where('dkp_info.user_id', '=', auth()->user()->id)
            ->select('dkp_info.*', 'character_infos.name')
            ->get();

        $sumDkp = 0;
        $lockDkp = 0;
        $isUseDkp = 0;

        foreach ($dkpList as $dkp) {
            $status = $dkp->status;
            $score = $dkp->score;
            //累计获取的dkp总量
            if ($status == 1) {
                $sumDkp += $score;
            }
            //兑换锁定的dkp
            if ($status == 2) {
                $lockDkp += $score;
            }
            //已使用的dkp
            if ($status == 3) {
                $isUseDkp += $score;
            }
        }
        return view('dkp::list')->with('dkpList', $dkpList)->
        with('sumDkp', $sumDkp)->with('lockDkp', $lockDkp)->with('isUseDkp', $isUseDkp);

    }


    /**
     * 分类统计账号dkp
     * @return void
     */
    public function getCommodityInfo()
    {
        $dkpList = DkpInfo::join('users', 'users.id', '=', 'dkp_info.user_id')
            ->get();
        #所有角色的总分
        $allDkpList = array();
        #所有角色花费的分数
        $useDkpList = array();
        #userid对应的name(nickname)
        $userNicknameList = array();
        foreach ($dkpList as $dkp) {
            $userId = $dkp->id;
            $score = $dkp->score;
            $status = $dkp->status;
            $name = $dkp->name;
            $nickname = $dkp->value;
            if ($status == 1) {
                if (array_key_exists($userId, $allDkpList)) {
                    $allDkpList[$userId] += $score;

                } else {
                    $allDkpList[$userId] = $score;
                }
            } else if ($status == 3) {
                if (array_key_exists($userId, $useDkpList)) {
                    $useDkpList[$userId] += $score;

                } else {
                    $useDkpList[$userId] = $score;
                }
            }
            if (!array_key_exists($userId, $userNicknameList)) {
                if (!empty($nickname)) {
                    $userNicknameList[$userId] = $name . "(" . $nickname . ")";
                } else {
                    $userNicknameList[$userId] = $name;
                }
            }
        }
        $resultDkpList = array();
        foreach ($allDkpList as $alldkp => $allscore) {
            $tempDkp = array();
            $tempDkp['user_id'] = $alldkp;
            $tempDkp['name'] = $userNicknameList[$alldkp];
            $tempDkp['all_score'] = $allscore;
            if (array_key_exists($alldkp, $useDkpList)) {
                $tempDkp['use_score'] = $useDkpList[$alldkp];
            } else {
                $tempDkp['use_score'] = 0;
            }
            $resultDkpList[] = $tempDkp;
        }

        return view('dkp::commodityList')->with('allDkpList', json_encode($resultDkpList, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 根据userid获取该用户dkp累加详情
     * @return void
     */
    public function allScoreDetail($userId)
    {
        $userScoreDetail = DkpInfo::join('character_infos', 'character_infos.character_id', '=', 'dkp_info.character_id')	
	    ->where('dkp_info.user_id', '=', $userId)
	    ->where('dkp_info.status', '=', '1')
            ->orderBy('dkp_info.created_at', 'desc')
            ->select('dkp_info.*','character_infos.name')
            ->get();
        return view('dkp::detail.allScoreDetail')->with('userScoreDetail', json_encode($userScoreDetail, JSON_UNESCAPED_UNICODE));
    }


    /**
     * 该用户使用dkp的详情（不包含锁定的）
     * @param $userId
     * @return mixed
     */
    public function useScoreDetail($userId)
    {
        $userScoreDetail = DkpInfo::join('character_infos', 'character_infos.character_id', '=', 'dkp_info.character_id')	
	    ->where('dkp_info.user_id', '=', $userId)
	    ->where('dkp_info.status', '=', '3')
            ->orderBy('dkp_info.created_at', 'desc')
            ->select('dkp_info.*','character_infos.name')
            ->get();
        return view('dkp::detail.allScoreDetail')->with('userScoreDetail', json_encode($userScoreDetail, JSON_UNESCAPED_UNICODE));
    }

    /**
     * DKP设置
     * @return void
     */
    public function settings()
    {
        $dkpConfig = DkpConfig::get();
        $resultDkpConfig = array();
        foreach ($dkpConfig as $config) {
            $tempConfig = array();
            $label = $config->label;
            $score = $config->score;
            $id = $config->id;
            $updated_at = $config->updated_at->format('Y-m-d H:i:s');
            if ($label == "login") {
                $tempConfig['id'] = $id;
                $tempConfig['label'] = "登陆";
                $tempConfig['score'] = $score;
                $tempConfig['name'] = "/";
                $tempConfig['num'] = "/";
                $tempConfig['station'] = "/";
                $tempConfig['update_at'] = $updated_at;
            } else if ($label == "skill") {
                $name = $config->name;
                $level = $config->level;
                $tempConfig['id'] = $id;
                $tempConfig['label'] = "技能";
                $tempConfig['score'] = $score;
                $tempConfig['name'] = $name;
                $tempConfig['num'] = $level;
                $tempConfig['station'] = "/";
                $tempConfig['update_at'] = $updated_at;
            } else if ($label == "asset") {
                $name = $config->name;
                $shipNum = $config->ship_num;
                $station = $config->station;
                $tempConfig['id'] = $id;
                $tempConfig['label'] = "战备";
                $tempConfig['score'] = $score;
                $tempConfig['name'] = $name;
                $tempConfig['num'] = $shipNum;
                $tempConfig['station'] = $station;
                $tempConfig['update_at'] = $updated_at;
            } else if ($label == "bounty") {
                $tempConfig['id'] = $id;
                $tempConfig['label'] = "赏金(单位：百万ISK)";
                $tempConfig['score'] = $score;
                $tempConfig['name'] = "/";
                $tempConfig['num'] = "/";
                $tempConfig['station'] = "/";
                $tempConfig['update_at'] = $updated_at;
            } else if ($label == "mining") {
                $tempConfig['id'] = $id;
                $tempConfig['label'] = "挖矿(单位：千立方)";
                $tempConfig['score'] = $score;
                $tempConfig['name'] = "/";
                $tempConfig['num'] = "/";
                $tempConfig['station'] = "/";
                $tempConfig['update_at'] = $updated_at;
            } else if ($label == "pap") {
                $tempConfig['id'] = $id;
                $tempConfig['label'] = "pap";
                $tempConfig['score'] = $score;
                $tempConfig['name'] = "/";
                $tempConfig['num'] = "/";
                $tempConfig['station'] = "/";
                $tempConfig['update_at'] = $updated_at;
            }
            $resultDkpConfig[] = $tempConfig;
        }
        return view('dkp::setting')->with('dkpConfig', json_encode($resultDkpConfig, JSON_UNESCAPED_UNICODE));
    }

    /**
     * DKP条目分数修改
     * @return void
     */
    public function settingDkpEdit(AddSetting $request)
    {
        $id = $request->input('id');
        $score = $request->input('score');
        $dkpConfig = DkpConfig::find($id);
        $dkpConfig->score = $score;
        $flag = $dkpConfig->save();
        if ($flag) {
            return redirect()->back()
                ->with('success', '修改成功!');
        }
        return redirect()->back()
            ->with('error', '修改失败!');
    }

    /**
     * 删除dkp
     * @return void
     */
    public function settingDkpDelete(AddSetting $request)
    {
        $id = $request->input('id');
        $dkpConfig = DkpConfig::find($id);
        $flag = $dkpConfig->delete($id);
        if ($flag) {
            return redirect()->back()
                ->with('success', '删除成功!');
        }
        return redirect()->back()
            ->with('error', '删除失败!');


    }

    /**
     * 新增dkp
     * @return void
     */
    public function settingDkpAdd(AddSetting $request)
    {
        $setting_label = $request->input('setting_label');
        $score = $request->input('score');
        if ($setting_label == 'asset') {
            $ship_num = $request->input('ship_num');
            $ship_name = $request->input('ship_name');
            $station_name = $request->input('station_name');
            if (!is_numeric($ship_num)) {
                return redirect()->back()
                    ->with('error', '船只数量不正确！');
            }
            if (is_null($ship_name) || is_null($station_name)) {
                return redirect()->back()
                    ->with('error', '船只名或停放空间站为空！');
            }
            DkpConfig::create([
                'label' => $setting_label,
                'ship_num' => $ship_num,
                'name' => $ship_name,
                'station' => $station_name,
                'score' => $score,
            ])->save();
        } else if ($setting_label == 'skill') {
            $skill_name = $request->input('skill_name');
            $skill_level = $request->input('skill_level');
            if (!is_numeric($skill_level)) {
                return redirect()->back()
                    ->with('error', '技能等级不正确！');
            }
            if (is_null($skill_name)) {
                return redirect()->back()
                    ->with('error', '技能名为空！');
            }
            DkpConfig::create([
                'label' => $setting_label,
                'name' => $skill_name,
                'level' => $skill_level,
                'score' => $score,
            ])->save();
        } else {
            DkpConfig::create([
                'label' => $setting_label,
                'score' => $score,
            ])->save();
        }
        return redirect()->back()
            ->with('success', '添加成功');
    }

    /**
     * Dkp兑换物品
     * @return void
     */
    public function supplement()
    {
        $DkpSupplement = DkpSupplement::where('is_use', '=', '1')
            ->get();
        return view('dkp::supplement')->with('DkpSupplement', $DkpSupplement);
    }

    /**
     * 新增Dkp兑换物品
     * @param AddSupplement $request
     * @return void
     *
     */
    public function createSupplement(AddSupplement $request)
    {
        $supplement_name = $request->input('supplement_name');
        $all_dkp = $request->input('all_dkp');
        $use_dkp = $request->input('use_dkp');
        $supplement_num = $request->input('supplement_num');
        $remark = $request->input('remark');
        DkpSupplement::create([
            'supplement_name' => $supplement_name,
            'all_dkp' => $all_dkp,
            'use_dkp' => $use_dkp,
            'supplement_num' => $supplement_num,
            'is_use' => 1,
            'remark' =>$remark,
        ])->save();
        return redirect()->back()
            ->with('success', '添加成功');

    }

    /**
     * Dkp兑换物品删除
     * @return void
     */
    public function supplementDelete(AddSupplement $request)
    {
        $id = $request->input('id');
        $dkpSupplement = DkpSupplement::find($id);
        $dkpSupplement->is_use = 2;
        $flag = $dkpSupplement->save();
        if ($flag) {
            return redirect()->back()
                ->with('success', '删除成功!');
        }
        return redirect()->back()
            ->with('error', '删除失败!');
    }

    /**
     * Dkp兑换物品修改
     * @return void
     */
    public function supplementUpdate(AddSupplement $request)
    {
        $id = $request->input('id');
        $all_dkp = $request->input('all_dkp');
        $use_dkp = $request->input('use_dkp');
        $supplement_num = $request->input('supplement_num');
        $remark = $request->input('remark');
        $dkpSupplement = DkpSupplement::find($id);

        $dkpSupplement->all_dkp = $all_dkp;
        $dkpSupplement->use_dkp = $use_dkp;
        $dkpSupplement->supplement_num = $supplement_num;
        $dkpSupplement->remark = $remark;
        $flag = $dkpSupplement->save();
        if ($flag) {
            return redirect()->back()
                ->with('success', '修改成功!');
        }
        return redirect()->back()
            ->with('error', '修改失败!');
    }

    /**
     * DKP兑换页
     * @return void
     */
    public function commodity()
    {
        $sumDkp = 0;
        $lockDkp = 0;
        $isUseDkp = 0;

        $dkpList = DkpInfo::join('character_infos', 'character_infos.character_id', '=', 'dkp_info.character_id')
            ->where('dkp_info.user_id', '=', auth()->user()->id)
            ->get();
        foreach ($dkpList as $dkp) {
            $status = $dkp->status;
            $score = $dkp->score;
            //累计获取的dkp总量
            if ($status == 1) {
                $sumDkp += $score;
            }
            //兑换锁定的dkp
            if ($status == 2) {
                $lockDkp += $score;
            }
            //已使用的dkp
            if ($status == 3) {
                $isUseDkp += $score;
            }
        }

        $DkpSupplement = DkpSupplement::leftJoin('dkp_info', 'dkp_info.supplement_id', '=', 'dkp_supplement.id')
                ->select('dkp_supplement.id',
                                'dkp_supplement.supplement_name',
                                'dkp_supplement.all_dkp',
                                'dkp_supplement.use_dkp',
                                'dkp_supplement.is_use',
                                'dkp_supplement.supplement_num',
                                'dkp_supplement.remark'
                , DB::raw('COUNT(dkp_info.supplement_id) as already'))
                            ->where('dkp_supplement.is_use', 1)
                            ->groupBy('dkp_supplement.id',
                                'dkp_supplement.supplement_name',
                                'dkp_supplement.all_dkp',
                                'dkp_supplement.use_dkp',
                                'dkp_supplement.is_use',
                                'dkp_supplement.supplement_num',
                                'dkp_supplement.remark')
                            ->get();

        $dkpList = DkpInfo::join('character_infos', 'character_infos.character_id', '=', 'dkp_info.character_id')
            ->where('dkp_info.user_id', '=', auth()->user()->id)
            ->where('dkp_info.approved', '=', 0)
            ->where('dkp_info.status', '=', 2)
            ->select('dkp_info.*', 'character_infos.name')
            ->get();

        return view('dkp::commodity')->with('DkpSupplement', $DkpSupplement)->with('dkpList', $dkpList)
            ->with('sumDkp', $sumDkp)->with('lockDkp', $lockDkp)->with('isUseDkp', $isUseDkp);
    }

    /**
     * 兑换商品
     * @return void
     */
    public function exchangeCommodity($supplementId, $userId)
    {
        $DkpSupplement = DkpSupplement::find($supplementId);

        if ($DkpSupplement->supplement_num < 1) {
            return redirect()->back()
                ->with('error', '兑换失败,库存不足!');
        }
        $DkpSupplement->supplement_num = $DkpSupplement->supplement_num - 1;
        $flag = $DkpSupplement->save();
        if (!$flag) {
            return redirect()->back()
                ->with('success', '兑换失败,修改库存失败!');
        }

        $Users = User::find($userId);
        $dkpInfo = DkpInfo::create([
            'user_id' => $userId,
            'character_id' => $Users->main_character_id,
            'score' => $DkpSupplement->use_dkp,
            'status' => 2,
            'remark' => $DkpSupplement->supplement_name,
            'supplement_id' => $supplementId,
        ]);
		$dkpInfo->save();
		sendPostRequest("api/SendGroupMessage", "module=dkp&event=Create",$dkpInfo);
		


        return redirect()->back()
            ->with('success', '兑换成功!');
    }

    /**
     * 申请兑换撤回
     * @return void
     */
    public function rollbackCommodity(Commodity $request)
    {
        $dkpInfoId = $request->input('id');
        $dkpInfo = DkpInfo::find($dkpInfoId);
        $flag = $dkpInfo->delete($dkpInfoId);
        if ($flag) {
            $dkpSupplement = DkpSupplement::find($dkpInfo->supplement_id);
            $dkpSupplement->supplement_num = $dkpSupplement->supplement_num + 1;
            $flag1 = $dkpSupplement->save();
            if ($flag1) {
                return redirect()->back()
                    ->with('success', '撤回成功!');
            }
        }
        return redirect()->back()
            ->with('error', '撤回失败!');

    }

    /**
     *
     * 兑换审批列表
     * @return void
     */
    public function approve()
    {
        $dkpList = DkpInfo::join('character_infos', 'character_infos.character_id', '=', 'dkp_info.character_id')
            //->where('dkp_info.user_id', '=', auth()->user()->id)
            ->where(function ($query) {
                $query->where('dkp_info.approved', '=', 1)
                    ->orwhere('dkp_info.approved', '=', 0);
            })
            ->where('dkp_info.status', '=', 2)
            ->select('dkp_info.*', 'character_infos.name')
            ->get();

        $dkpList2 = DkpInfo::join('character_infos', 'character_infos.character_id', '=', 'dkp_info.character_id')
            //->where('dkp_info.user_id', '=', auth()->user()->id)
            ->where(function ($query) {
                $query->where('dkp_info.approved', '=', -1)
                    ->orwhere('dkp_info.approved', '=', 2);
            })
            ->where(function ($query) {
                $query->where('dkp_info.status', '=', 3)
                    ->orwhere('dkp_info.status', '=', 0);
            })
            ->select('dkp_info.*', 'character_infos.name')
            ->get();

        return view('dkp::approve')->with('dkpList', $dkpList)->with('dkpList2', $dkpList2);

    }


    public function dkpApprove($kill_id, $action)
    {
        $dkpInfo = DkpInfo::find($kill_id);
		$request_action = str_replace(' ', '_', $action);
		sendPostRequest("api/SendGroupMessage", "module=dkp&event=".$request_action,$dkpInfo);
        switch ($action) {
            case 'Approve':
                //批准
                $dkpInfo->approved = '1';
                break;
            case 'Reject':
                //拒绝
                $dkpInfo->approved = '-1';
                $dkpInfo->status = '0';
                $dkpSupplement = DkpSupplement::find($dkpInfo->supplement_id);
                $dkpSupplement->supplement_num = $dkpSupplement->supplement_num + 1;
                $dkpSupplement->save();
                break;
            case 'Paid Out':
				//支付
                $dkpInfo->approved = '2';
                $dkpInfo->status = '3';
				//echo $dkpInfo;
                break;
            case 'Pending':
                $dkpInfo->approved = '0';
                break;
        }

        $dkpInfo->approver = auth()->user()->name;
        $dkpInfo->save();

        return json_encode(['name' => $action, 'value' => $kill_id, 'approver' => auth()->user()->name]);
    }

    public function paps()
    {   
        $today = carbon();
        $leginpap = Pap::where('month', $today->month)
                          ->where('year', $today->year)
                          ->select('character_id', DB::raw('sum(value) as qty'))
                          ->groupBy('character_id')
                          ->get();
        return view('dkp::paptodkp')->with('leginpap',$leginpap);
    }

    public function leginpap()
    {
        $today = carbon();
        $leginpap = Pap::where('month', $today->month)
                          ->where('year', $today->year)
                          ->select('character_id', DB::raw('sum(value) as score'))
                          ->groupBy('character_id')
                          ->get();
        $i= 0;
        foreach($leginpap as $leginpap)
        {
            $Users = RefreshToken::find($leginpap->character_id);
            $dkpInfo = DkpInfo::create([
                'user_id' => $Users->user_id,
                'character_id' => $leginpap->character_id,
                'score' => $leginpap->score,
                'status' => 1,
                'remark' => "军团pap",
                'supplement_id' => '0',
            ]);
            $dkpInfo->save();
            $i++;
        }
        return redirect()->back()
        ->with('success', "成功导入".$i."条!");

    }

    public function paptodkp(addpap $request)
    {   
        $setlist = DkpConfig::where("dkp_config.label","=","pap")->get();
        $papset = (float)$setlist[0]->score;
	    $mes = $request->input('trdkp');
	    $paptodkp = json_decode($mes);    
        $i= 0;
        foreach($paptodkp as $paptodkp)
        {
            $value = (float)$paptodkp->value;
            $Users = RefreshToken::find($paptodkp->character_id);
            $score = (string)$value*$papset;

        $dkpInfo = DkpInfo::create([
            'user_id' => $Users->user_id,
            'character_id' => $paptodkp->character_id,
            'score' => $score,
            'status' => 1,
            'remark' => "联盟pap",
            'supplement_id' => '0',
        ]);
        $dkpInfo->save();
        $i++;
        }

        return redirect()->back()
        ->with('success', "成功导入".$i."条!");

    }

    public function addqq()
    {
        return view('dkp::addqq');
    }

    public function addqqinfo(addqq $request)
    {
        $mes = $request->input('addqq');
        $dkpqq = DkpQQ::create([
            'user_id' => auth()->user()->id ,
            'QQ' => $mes , 
        ]);
        $dkpqq->save();
        return redirect()->back()
        ->with('success', "成功导入QQ:".$mes);
    }

    public function getqqdkp($QQ = null)
    {   

        $dkpList = DkpInfo::join('character_infos', 'character_infos.character_id', '=', 'dkp_info.character_id')
        ->join('dkp_QQ','dkp_QQ.user_id', '=','dkp_info.user_id')
        ->where('dkp_QQ.QQ', '=', $QQ)
        ->select('dkp_info.*', 'character_infos.name')
        ->get();

    $sumDkp = 0;
    $lockDkp = 0;
    $isUseDkp = 0;

    foreach ($dkpList as $dkp) {
        $status = $dkp->status;
        $score = $dkp->score;
        //累计获取的dkp总量
        if ($status == 1) {
            $sumDkp += $score;
        }
        //兑换锁定的dkp
        if ($status == 2) {
            $lockDkp += $score;
        }
        //已使用的dkp
        if ($status == 3) {
            $isUseDkp += $score;
        }
    }
        return [
            'sumDkp' => $sumDkp,
            'lockDkp' => $lockDkp,
            'isUseDkp' => $isUseDkp,
        ];
    }
}