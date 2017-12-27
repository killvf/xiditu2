<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 17-8-20
 * Time: 下午10:23
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;

class LoginController extends Controller
{

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login(Request $request) {
        if($request->isMethod('POST')) {
            $hmac = $request->session()->get('staff_hmac');
            $username = $request->input('name');
            $password = $request->input('password');
            $model = new Staff();
            $user = $model->checkLogin($hmac, $username, $password);
            if($user) {
                $request->session()->put('staff', $user);
                return redirect()->route('staff.index');
            } 
            $request->session()->put('staff_login_err', '用户名或密码错误');
            return redirect()->route('staff.login'); 
        }
        return view('admin/login/index');
    }

    /**
     * 得到hmac
     * @return \Illuminate\Http\JsonResponse
     */
    public function hmac(Request $request) {
        $hmac = uniqid('hmac');
        $request->session()->put('staff_hmac', $hmac);
        return response()->json(['hmac'=>$hmac]);
    }

    public function logout(Request $request) {
        $request->session()->forget('staff');
        return redirect()->route('staff.login');
    }
}