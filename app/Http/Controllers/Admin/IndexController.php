<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 17-8-20
 * Time: 下午10:23
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function index() {
        return view('admin/index/index');
    }
}