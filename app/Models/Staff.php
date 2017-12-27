<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends BaseModel
{

    protected $guarded = [];

    /**
     * 检查是否可以登录成功
     * @param $hmac
     * @param $username
     * @param $password
     * @return bool|\Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function checkLogin($hmac, $username, $password) {
        $user = $this->where('name', $username)->first();
        if(empty($user)) {
            return false;
        }
        if(md5($hmac.$user->password) == $password) {
            return $user;
        }
        return false;
    }

    /**
     * 修改密码
     * @param $id
     * @param $password
     * @return bool
     */
    public function changePassword($id, $password) {
        $user = $this->find($id);
        if(empty($user)) {
            return false;
        }
        $udata = ['password' => md5($user->username.$password)];
        $rs = $this->where('id', $id)->update($udata);
        return $rs;
    }
}
