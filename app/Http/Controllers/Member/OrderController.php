<?php


namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\AgentBalanceRecord;
use App\Models\AgentProductDetail;
use App\Models\AgentUser;
use Illuminate\Http\Request;
use App\Models\AgentOrderForm;
use App\Models\AgentCommodity;
use App\Models\AgentDeliveryAddress;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{

    protected $row = 3;
    /**
     * 显示用户订单页面
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {

        $member = $request->session()->get('member');
        $status = $request->input('status');
        //得到用户的所有订单
        $mOrder = new AgentOrderForm();
        $query = $mOrder->where('submiter_id', $member->id);
        if(!is_null($status)) {
            $query = $query->where('status', $status);
        }
        $orders = $query->orderBy('updated_at', 'desc')->paginate($this->row);
        if($request->ajax()) {
            return $this->apiData(['html'=>view('member.order.list', ['member'=> $member, 'orders'=>$orders])->render()]);

        } else {
            return view('member.order.index', ['member'=> $member, 'orders'=>$orders]);
        }
        
    }

    /**
     * 支付订单
     *
     * @param Request $request
     * @return void
     */
    public function pay(Request $request) {
        if($request->isMethod('POST')) {
            //确认支付
            $result = DB::transaction(function() use ($request){
                $payid = $request->input('pid');
                $member = $request->session()->get('member');
                $member_id = $member->id;
                
                //判断支付类型是线下支付还是余额支付
                $type = $request->input('type');

                if($type == AgentOrderForm::TYPE_LOCAL) {
                    //修改订单的状态
                    $mOrder = new AgentOrderForm();
                    $order = $mOrder->find($payid);
                    $order->status = AgentOrderForm::STATUS_NOT_PAY;
                    $order->pay_type = $type;
                    $order->save();
                } else {
                    //扣除用户的余额
                    $mBalance = new AgentBalanceRecord();
                    $mBalance->payout($member_id, $payid);
                    //修改订单的状态
                    $mOrder = new AgentOrderForm();
                    $order = $mOrder->find($payid);
                    $order->status = AgentOrderForm::STATUS_WAIT_POST;
                    $order->pay_type = $type;
                    $order->save();
                }
                
                
                //扣掉用户的订单数量
                $mProduct = new AgentProductDetail();
                //找到合伙人
                $mAgent = new AgentUser();
                $agent = $mAgent->where('is_partner', AgentUser::PARTNER_TRUE)->first();
                $productInfo = $mProduct->find($agent->id);
                $productInfo->order_amount--;
                $productInfo->save();
                return true;
            });
            $request->session()->forget('payid');
            if($result) {
                return $this->apiData([]);
            } else {
                return $this->apiErr('支付失败');
            }
        } 
        $id = $request->input('pid');
        $member = $request->session()->get('member');
        $mAgent = new AgentUser();
        $member = $mAgent->find($member->id);
        //得到agentid
        $partner = (new AgentUser())->where('is_partner', AgentUser::PARTNER_TRUE)->first();
        $product = (new AgentProductDetail())->where('id', $partner->id)->first();
        if(empty($product)) {
            $product = 0;
        } else {
            $product = $product->order_amount;
        }

        $memberAmount = $member->money;

        if(!empty($id)) { //继续支付
            $mOrder = new AgentOrderForm();
            $order = $mOrder->find($id);
            if($order->status != AgentOrderForm::STATUS_NOT_PAY) {
                return redirect()->back();
            }
        } else {

            //判断是否有payid如果有表示已经请求过了
            $pid = $request->session()->get('payid');
            if(!empty($pid)) {
                return redirect()->route('member.order.pay', ['pid'=>$pid]);
            }
            //得到用户的备注
            $remark = $request->input('remark');
            //显示支付页面
         
            $goods = $request->session()->get('order_info');
            list($usec, $sec) = explode(" ", microtime());
             //得到用户的收货地址信息
            $addressID = $request->session()->get('address_id');
            if(empty($addressID)) {
                return redirect()->back();
            }
            $mAddress = new AgentDeliveryAddress();
            $address = $mAddress->find($addressID);
            //得到当前的时间cuo
            $data = [
                'submiter_id' => $member->id,
                'order_code' => date('YmdHis', $sec).intval($usec*1000).substr(uniqid(), -3),
                'order_sum' => 0,
                'goods_sum' => 0,
                'goods_amount' => 0,
                'pay_amount' => 0,
                'receiver_name' => $address->name,
                'receiver_mobile' => $address->mobile,
                'receiver_addr' => $address->province.$address->city.$address->district.$address->detail,
                'order_remark' => empty($remark) ? '' : $remark,
            ];
            //商品总数
            $amount = 0;
            //商品价值
            $sum = 0;
            foreach($goods as $g) {
                $amount += $g->amount;
                $sum += $g->unit_price * $g->amount;
            }
            $data['order_sum'] = $sum;
            $data['goods_sum'] = $sum;
            $data['pay_amount'] = $sum;
            $data['goods_amount'] = $amount;
            $order = DB::transaction(function() use ($data, $goods) {
                //创建订单
                $mOrder = new AgentOrderForm();
                $order = $mOrder->create($data);
                //关联商品信息到订单详情表中
                $detailData = [];
                foreach($goods as $g) {
                    $detailData[] = [
                        'agent_order_form_id' => $order->id,
                        'agent_commodity_id' => $g->id,
                        'goods_name' => $g->name,
                        'goods_amount' => $g->amount,
                        'price' => $g->unit_price * $g->amount,
                        'unit_price' => $g->unit_price,
                        'picture' => $g->pictures[0]->url,
                    ];
                }
                DB::table('agent_order_details')->insert($detailData);
                return $order;
            });
            //如果生成了pid就把它存到session中
            $request->session()->put('payid', $order->id);
        }

        return view('member.order.pay', ['order'=>$order, 'amount'=>$memberAmount, 'member'=>$member, 'product'=>$product]);
    }

    /**
     * 确认订单
     *
     * @param Request $request
     * @return void
     */
    public function sure(Request $request) {
        //得到从哪里过来的
        $type = $request->input('type');
        $mCommodity = new AgentCommodity();
        $goods = [];
        $sum = 0;
        if($type == 'shopcart') {
            $shopcart = empty($_COOKIE['buyItems']) ? '' : $_COOKIE['buyItems'];
            if(!empty($shopcart)) {
                $shopcart = json_decode($shopcart, true);
                $ids = array_keys($shopcart);
                $goods = $mCommodity->whereIn('id', $ids)->get();
                foreach($goods as &$g) {
                    $g->amount = $shopcart[$g->id];
                    $sum += $g->amount * $g->unit_price;
                }
            }
        } else if($type == 'back') {
            //选择地址后回调
            //1.得到下单物品信息
            $goods = $request->session()->get('order_info');
            $sum = $request->session()->get('order_sum') * 100;
        } else {
            //直接购买会带id过来
            $id = $request->input('id');
            $num = $request->input('num');
            if(intval($num) <= 0) {
                return redirect()->back();
            }
            //得到物品的信息
            $goods = $mCommodity->where('id',$id)->get();
            foreach($goods as &$g) {
                $g->amount = $num;
                $sum += $g->amount * $g->unit_price;
            }
        }
        //得到用户ID
        $member = $request->session()->get('member');
        $member = (new AgentUser())->find($member->id);
        //判断用户是否选择了地址了
        $addressID = $request->session()->get('address_id');
        //得到当前用户的地址列表
        $mAddress = new AgentDeliveryAddress();

        if(!empty($addressID)) {
            $address = $mAddress->find($addressID);
            if(empty($address)) {
                $address = $mAddress->where('agent_user_id', $member->id)->where('default', AgentDeliveryAddress::DEFAULT_TRUE)->first();
                if(!empty($address)) {
                    $request->session()->put('address_id', $address->id);
                }
            }
        } else {
            $address = $mAddress->where('agent_user_id', $member->id)->where('default', AgentDeliveryAddress::DEFAULT_TRUE)->first();
            if(!empty($address)) {
                $request->session()->put('address_id', $address->id);
            }
        }



        //这里把订单物品的信息存入到session中
        $request->session()->put('order_info', $goods);
        $sum = round($sum /100, 2);
        $request->session()->put('order_sum', $sum);
        return view('member.order.sure', ['goods'=>$goods, 'sum' => $sum, 'amount'=>$member->money, 'address'=>$address]);
    }

    /**
     * 订单详情
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function detail(Request $request , $id) {
        $mOrder = new AgentOrderForm();
        $member = $request->session()->get('member');
        $order = $mOrder->where('id', $id)->where('submiter_id', $member->id)->first();
        return view('member.order.detail', ['order'=>$order]);
    }

    /**
     * 取消订单
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request, $id) {
        $mOrder  = new AgentOrderForm();
        $order = $mOrder->find($id);
        if($order->status == AgentOrderForm::STATUS_NOT_PAY) {
            $order->status = AgentOrderForm::STATUS_CANCEL;
            $order->save();
        }
        return redirect()->back();
    }

    /**
     * 确认收货
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function receive(Request $request, $id) {
        $mOrder  = new AgentOrderForm();
        $order = $mOrder->find($id);
        if($order->status == AgentOrderForm::STATUS_WAIT_RECEIVE) {
            $order->status = AgentOrderForm::STATUS_FINISHED;
            $order->save();
        }
        return redirect()->back();
    }

    /**
     * 已支付
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function payed(Request $request, $id) {
        $mOrder = new AgentOrderForm();
        $order = $mOrder->find($id);
        if($order->status == AgentOrderForm::STATUS_NOT_PAY) {
            $order->status = AgentOrderForm::STATUS_WATI_CHECK;
            $order->save();
        }
        return redirect()->back();
    }
}