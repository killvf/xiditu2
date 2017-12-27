<?php


namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\AgentUser;
use App\Models\AgentOrderForm;
use Illuminate\Http\Request;


class MemberController extends Controller
{

    protected $controller = 'member';

    /**
     * 显示购物车列表
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {

        $member = $request->session()->get('member');

        $member = (new AgentUser())->find($member->id);

        //得到用户的当月已完成的订单数
        $mOrder = new AgentOrderForm();
        $orderCount = $mOrder->where('status', AgentOrderForm::STATUS_FINISHED)->where('created_at', '>=', strtotime(date('Y-m-01')))->count();

        return view('member.index.index', ['member' => $member, 'orderCount'=> $orderCount]);
    }


    public function password(Request $request)
    {
        if ($request->isMethod('POST')) {
            $member = $request->session()->get('member');
            $username = $member->username;
            $mAgent = new AgentUser();
            $member = $mAgent->find($member->id);
            $oPassword = $request->input('old_password');
            $nPassword = $request->input('password');
            $cPassword = $request->input('confirm_password');
            if ($nPassword != $cPassword || md5($username . $oPassword) != $member->password) {
                return redirect()->back();
            } else {
                $member->password = md5($member->username . $nPassword);
                $member->save();
                $request->session()->forget('member');
                return redirect()->route('member.login');
            }
        }
        return view('member.password.modify');

    }
}