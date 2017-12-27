<?php

namespace App\Http\Controllers;

use App\Models\AgentUser;
use App\Models\Languages;
use App\Models\Navs;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;


class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 显示语言
     * @var array|string
     */
    protected $language='chinese_simple';
    protected $controller = 'index';


    protected $row = 20;
    protected $field = ['*'];

    protected $sort = [['created_at', 'desc']];

    protected $options = [];

    public function __construct(Request $request) {
        $this->row = empty($request->get('row')) ? $this->row : intval($request->get('row'));
        $this->field = empty($request->get('field')) ? $this->field : explode(',', $request->get('field'));

        $sort = $request->get('sort');
        if (!empty($sort)) {
            $sort = explode(',', $sort);
            foreach ($sort as &$s) {
                if (strpos($s, '-') !== false) {
                    $s = [substr($s, 1), 'desc'];
                } else {
                    $s = [$s, 'asc'];
                }
            }
        }
        $this->sort = empty($request->get('sort')) ? $this->sort : $sort;

        $this->options = ['sort' => $this->sort, 'row' => $this->row, 'field' => $this->field];

        View::share('controller', $this->controller);

        //统一得到一个导航的信息
        $language = $request->cookie('language');
        $this->language = empty($language) ? $this->language : $language;
        $navs = Navs::query()->where('language', $this->language)
            ->where('position','<', 20)
            ->orderBy('position')->get();
        View::share('navs', $navs);
        $sideNavs = Navs::query()->where('language', $this->language)
            ->whereBetween('position', [20, 40])
            ->orderBy('position')->get();
            View::share('sideNavs', $sideNavs);
            
            $subNavs = Navs::query()->where('language', $this->language)
            ->whereBetween('position', [40,60])
            ->orderBy('position')->get();
            View::share('subNavs', $subNavs);

        //得到所有的语言信息
        $languages = Languages::all();
        View::share('languages', $languages);
        //当前的语言
        $language = Languages::query()->where('english', $this->language)->first();
        View::share('language', $language);
        View::share('curPos', 1);
    }

    /**
     * 返回api数据
     *
     * @param [type] $data
     * @param [type] $msg
     * @param integer $status
     * @return void
     */
    public function  apiData($data, $msg='', $status=1) {
        return response()->json([
            'status'=>$status,
            'msg' => $msg,
            'data' => $data,
        ]);
    }

    /**
     * 错误返回
     *
     * @param [type] $msg
     * @param [type] $status
     * @return void
     */
    public function apiErr($msg, $status=0) {
        return $this->apiData([], $msg, $status);
    }
}
