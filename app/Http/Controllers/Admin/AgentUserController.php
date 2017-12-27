<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 17-8-22
 * Time: 下午9:42
 */
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ControllerREST;
use Illuminate\Http\Request;
use App\Models\AgentBalanceRecord;
use App\Models\AgentProductDetail;
use App\Models\AgentUser;
use Illuminate\Support\Facades\DB;


class AgentUserController extends ControllerREST
{
    protected $model = 'App\Models\AgentUser';

    protected $controller = 'admin.agent';

    protected $fieldValidation = [
        'username' => 'required',
        'agent_code' => 'required',
    ];

    protected $redirectUrlAlias = 'staff.agent.lists';

    public function parseQuery(Request $request) {
            $this->conditions['is_partner'] = 0;
    }

    public function doAdd(Request $request) {
        $this->validate($request, $this->fieldValidation);

        $data = $request->all();
        $data['password'] = md5($data['username'].'123456');
        foreach($data as $k => $d) {
            if(is_null($d)) {
                unset($data[$k]);
            }
        }
        $this->iModel->create($data);
        // return true;
        return redirect()->route($this->redirectUrlAlias);
    }

    /**
     * 充值
     *
     * @param Request $request
     * @return void
     */
    public function charge(Request $request) {
        $id = $request->input('id');
        $price = $request->input('price');
        //判断这个用户是否存在
        $mAgent = new AgentUser();
        $agent = $mAgent->find($id);
        if(!empty($agent)){
            //得到用户的余额
            return DB::transaction(function() use ($agent, $id, $price) {
                $mMoney = new AgentBalanceRecord();
                $money = $mMoney->where('agent_user_id', $agent->id)->orderBy('created_at','desc')->first();
                if(!empty($money)) {
                    $amount = $money->amount;
                } else {
                    $amount = 0;
                }
                $chargeMoney = intval(abs($price)) * 100;
                $sum = $amount + $chargeMoney;
                $nData = [
                    'agent_user_id' => $agent->id,
                    'amount_pay' => $chargeMoney,
                    'amount' => $sum,
                    'remark' => '充值'+$chargeMoney,
                ];
                $mMoney->create($nData);

                //修改用户的余额
                $agent->money = $sum;

                $agent->save();

                return $this->apiData([
                    'amount' => $sum,
                ]);
            });

        }
        return $this->apiErr('充值失败');
    }

     /**
     * 充值订单数
     *
     * @param Request $request
     * @return void
     */
    public function chargeOrder(Request $request) {
        $id = $request->input('id');
        $price = $request->input('price');
        //判断这个用户是否存在
        $mAgent = new AgentUser();
        $agent = $mAgent->find($id);
        if(!empty($agent)){
            //得到用户的余额
            

            $mProduct = new AgentProductDetail();
            
            $info = $mProduct->where('id', $agent->id)->first();

            if(!empty($info)) {
                $price += $info->order_amount;
            }

            $ndata = [
                    'id' => $agent->id,
                    'order_amount' => $price,
                ];
            $mProduct->create($ndata);

            return $this->apiData([
                'amount' => $price,
            ]);
            
        }
        return $this->apiErr('充值失败');
    }
}