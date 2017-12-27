<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 17-8-20
 * Time: 下午10:23
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    protected $row = 24;

    public function index(Request $request) {

        return response()->json(['url'=>'http://hq2005001.byethost7.com/public/']);
    }

}