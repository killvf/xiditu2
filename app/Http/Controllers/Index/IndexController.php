<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 17-8-20
 * Time: 下午10:23
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Invites;
use App\Models\Sliders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AgentCommodity;
use Illuminate\Support\Facades\View;

class IndexController extends Controller
{

    /**
     * 首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {       

        $sliders =  Sliders::query()->where('language', $this->language)
            ->orderBy('position')->get();

        return view('index/index', ['sliders' => $sliders]);
    }

    /**
     * 新闻页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function news(Request $request)
    {
        $news = Articles::query()->where('language', $this->language)
            ->orderBy('created_at', 'desc')->paginate($this->row);

        return view('index/news', ['news' => $news]);
    }

    /**
     * 新闻页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newsDetail(Request $request, $id)
    {
        $news = Articles::query()->find($id);
        return view('index/news_detail', ['news' => $news]);
    }


    /**
     * 招聘页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invites(Request $request) {
        $invites = Invites::query()->where('language', $this->language)
            ->orderBy('created_at', 'desc')->get();
        return view('index/index/invites', ['invites' => $invites]);
    }

    public function ny(Request $request) {
        View::share('curPos', 2);
        return view('index.ny');
    }


    public function jj(Request $request) {
        View::share('curPos', 3);
        return view('index.jj');
    }

    public function jy(Request $request) {
        View::share('curPos', 4);
        return view('index.jy');
    }

    public function dc(Request $request) {
        View::share('curPos', 5);
        return view('index.dc');
    }

    public function yl(Request $request) {
        View::share('curPos', 6);
        return view('index.yl');
    }

    public function about(Request $request) {
        View::share('curPos', 7);
        return view('index.about');
    }
}