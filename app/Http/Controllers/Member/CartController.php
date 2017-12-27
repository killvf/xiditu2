<?php


namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgentCommodity;


class CartController extends Controller
{
    protected $controller = 'cart';
    /**
     * 显示购物车列表
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {

        $mCommodity = new AgentCommodity();
        //得到Cookie中的商品ID
  
        $ids = empty($_COOKIE['shopcart']) ? '' : $_COOKIE['shopcart'];
        $idsArr = json_decode($ids, true);
        $idsArr = empty($idsArr) ? [] : $idsArr;
        $ids = array_keys($idsArr);
        $goods = $mCommodity->whereIn('id', $ids)
            ->where('status', AgentCommodity::STATUS_DEFAULT)->get();
        $sum = 0;
        foreach($goods as &$g) {
            $g->amount = $idsArr[$g->id];
            $sum += $g->amount * $g->unit_price /100;
        }
        return view('member.cart.index', ['goods'=>$goods, 'sum'=> $sum]);
    }

}