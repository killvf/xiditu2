<?php

use Illuminate\Database\Seeder;

class NavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //首页
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '首页',
            'link' => '/',
            'position' => '1',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'index',
            'link' => '/',
            'position' => '1',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '首页',
            'link' => '/',
            'position' => '1',
        ]);
        //农业
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '农业',
            'link' => '/nongye',
            'position' => '2',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'agriculture',
            'link' => '/nongye',
            'position' => '2',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '农业',
            'link' => '/nongye',
            'position' => '2',
        ]);
        //基金
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '基金',
            'link' => '/jijin',
            'position' => '3',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'fund',
            'link' => '/jijin',
            'position' => '3',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '基金',
            'link' => '/jijin',
            'position' => '3',
        ]);
        //教育
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '教育',
            'link' => '/jiaoyu',
            'position' => '4',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'education',
            'link' => '/jiaoyu',
            'position' => '4',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '教育',
            'link' => '/jiaoyu',
            'position' => '4',
        ]);
        //地产
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '地产',
            'link' => '/dichan',
            'position' => '5',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'estate',
            'link' => '/dichan',
            'position' => '5',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '地产',
            'link' => '/dichan',
            'position' => '5',
        ]);
        //医疗
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '医疗',
            'link' => '/yiliao',
            'position' => '6',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'medical',
            'link' => '/yiliao',
            'position' => '6',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '医疗',
            'link' => '/yiliao',
            'position' => '6',
        ]);
        //关于我们
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '关于我们',
            'link' => '/about',
            'position' => '7',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'about',
            'link' => '/about',
            'position' => '7',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '关于我们',
            'link' => '/about',
            'position' => '7',
        ]);

        //侧边导航

        //精彩首页
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '精彩首页',
            'link' => '/',
            'position' => '21',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'index',
            'link' => '/',
            'position' => '21',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '精彩首页',
            'link' => '/',
            'position' => '21',
        ]);


        //新闻资讯
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '新闻资讯',
            'link' => '/news',
            'position' => '22',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'news',
            'link' => '/news',
            'position' => '22',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '新闻资讯',
            'link' => '/news',
            'position' => '22',
        ]);


        //关于我们
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '关于我们',
            'link' => '/about',
            'position' => '23',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'about',
            'link' => '/about',
            'position' => '23',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '关于我们',
            'link' => '/about',
            'position' => '23',
        ]);

        //子导航
        
        //投资理财
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '投资理财',
            'link' => '/touzilicai',
            'position' => '41',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'touzilicai',
            'link' => '/touzilicai',
            'position' => '41',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '投资理财',
            'link' => '/touzilicai',
            'position' => '41',
        ]);

         
        //讲座沙龙
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '讲座沙龙',
            'link' => '/jiangzuoshalong',
            'position' => '42',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'jiangzuoshalong',
            'link' => '/jiangzuoshalong',
            'position' => '42',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '讲座沙龙',
            'link' => '/jiangzuoshalong',
            'position' => '42',
        ]);


        //健康运动
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '健康运动',
            'link' => '/jiankangyundong',
            'position' => '43',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'jiankangyundong',
            'link' => '/jiankangyundong',
            'position' => '43',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '健康运动',
            'link' => '/jiankangyundong',
            'position' => '43',
        ]);


        //生活休闲
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '生活休闲',
            'link' => '/shenghuoxiuxian',
            'position' => '44',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'shenghuoxiuxian',
            'link' => '/shenghuoxiuxian',
            'position' => '44',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '生活休闲',
            'link' => '/shenghuoxiuxian',
            'position' => '44',
        ]);


        //爱心公益
        \App\Models\Navs::create([
            'language' => 'chinese_simple',
            'title' => '爱心公益',
            'link' => '/aixingongyi',
            'position' => '45',
        ]);
        \App\Models\Navs::create([
            'language' => 'english',
            'title' => 'aixingongyi',
            'link' => '/aixingongyi',
            'position' => '45',
        ]);
        \App\Models\Navs::create([
            'language' => 'chinese_traditional',
            'title' => '爱心公益',
            'link' => '/aixingongyi',
            'position' => '45',
        ]);
    }
}
