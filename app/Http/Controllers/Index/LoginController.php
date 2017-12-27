<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 17-8-20
 * Time: 下午10:23
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Models\AgentUser;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login(Request $request) {
        if($request->isMethod('POST')) {
            $hmac = $request->session()->get('member_hmac');
            $username = $request->input('name');
            $password = $request->input('password');
            $model = new AgentUser();
            $user = $model->checkLogin($hmac, $username, $password);
            if($user) {
                if($user->status != AgentUser::STATUS_DEFAULT) {
                    $request->session()->put('member_login_err', '该账号已被限制登录');
                    return redirect()->route('member.login');
                }
                $request->session()->put('member', $user);
                return redirect('/');
            } 
            $request->session()->put('member_login_err', '用户名或密码错误');
            return redirect()->route('member.login'); 
        }
        return view('index/login/index');
    }

    /**
     * 得到hmac
     * @return \Illuminate\Http\JsonResponse
     */
    public function hmac(Request $request) {
        $hmac = uniqid('hmac');
        $request->session()->put('member_hmac', $hmac);
        return response()->json(['hmac'=>$hmac]);
    }

    public function logout(Request $request) {
        $request->session()->forget('member');
        return redirect()->route('member.login');
    }
}