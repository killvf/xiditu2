<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 17-8-20
 * Time: 下午10:23
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AgentCommodity;


class GoodsController extends Controller
{

    public function index(Request $request, $id) {       
        $mCommodity = new AgentCommodity();
        $goods = $mCommodity->find($id);
        return view('index/goods/detail', ['goods' => $goods]);
    }


}