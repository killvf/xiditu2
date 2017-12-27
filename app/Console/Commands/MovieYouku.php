<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class MovieYouku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:youku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->parseYouku();
        echo 'finish parse Youku....';
//        $this->parseQq();
        echo 'finish parse qq....';
//        $this->parseIqiyi();
        echo 'finish parse iqiyi....';
    }

    public function parseYouku ( ) {
        //得到优酷电影 的分类ID
        $categoryID = 2;
        $url = 'http://vip.youku.com/ajax/filter/filter_data?tag=10005&pl=30&pt=1&ar=0&mg=0&y=0&cl=1&o=0&pn=';
        $data = [];
        for($i=1; $i <= 59; $i++) {
            $rUrl = $url . $i;
            //这里处理数据并放到数据库中
            $client = new Client();
            $html = $client->get($rUrl)->getBody()->getContents();
            $response = json_decode($html, true);
            $response = $response['result']['result'];
//            dd($response);
            foreach($response as $d) {
                $data[] = [
                    'name' => $d['showname'],
                    'picture'=> $d['show_vthumburl'],
                    'desc' => $d['display_status'],
                    'link' => $d['firstepisode_videourl'],
                    'category_id' => $categoryID,
                ];
            }
            echo 1;
        }
        $rs = DB::table('videos')->insert($data);
    }

    public function parseQq() {
        $categoryID = 6;
        $url = 'http://v.qq.com/x/list/movie?pay=-1&sort=18&offset=';
        $data = [];
        for($i=0; $i <= 30* 164; $i+=30) {
            $rUrl = $url . $i;

            //这里处理数据并放到数据库中
            $client = new Client();
            $html = $client->get($rUrl)->getBody()->getContents();

            $crawl = new Crawler($html);
            try{
                $link = $crawl->filterXPath('//li[@class="list_item"]/a')->each(function (Crawler $node, $i) {
                    return $node->attr('href');
                });

                $name = $crawl->filterXPath('//li[@class="list_item"]/a/img[1]')->each(function (Crawler $node, $i) {
                    return $node->attr('alt');
                });
                $desc = $crawl->filterXPath('//li[@class="list_item"]/a/div/span')->each(function (Crawler $node, $i) {
                    return $node->text();
                });
                //r-lazyload

                $picture = $crawl->filterXPath('//li[@class="list_item"]/a/img[1]')->each(function (Crawler $node, $i) {
                    return 'https:'.$node->attr('r-lazyload');
                });
                foreach($link as $index => $l) {
                    $data[] = [
                        'name' => $name[$index],
                        'link' => $link[$index],
                        'picture' => $picture[$index],
                        'desc' => $desc[$index],
                        'category_id'=> $categoryID,
                    ];
                }
                $rs = DB::table('videos')->insert($data);
            }catch (\Exception $e) {
                dd($e->getMessage());
                return response()->json(['html'=>'']);
            }
        }
    }

    public function parseIqiyi() {
        $categoryID = 10;
        $data = [];
        for($i=1; $i <= 20; $i++) {
            $rUrl = "http://search.video.iqiyi.com/o?pageNum={$i}&mode=11&ctgName=%E7%94%B5%E5%BD%B1&threeCategory=&content_type=&pageSize=21&type=list&if=html5&pos=1&site=iqiyi&qyid=f41faz4e2sjg9qiydniriaal&access_play_control_platform=15&pu=&u=f41faz4e2sjg9qiydniriaal&ispurchase=2";

            //这里处理数据并放到数据库中
            $client = new Client();
            $html = $client->get($rUrl)->getBody()->getContents();
            try {
                $data1 = json_decode($html, true);
                if(!empty($data1['data']['docinfos'])) {
                    $data1 = $data1['data']['docinfos'];
                    foreach($data1 as $d) {
                        $data[] = [
                            'name' => $d['albumDocInfo']['albumTitle'],
                            'link' => $d['albumDocInfo']['videoinfos'][0]['itemLink'],
                            'picture' => $d['albumDocInfo']['albumImg'],
                            'desc' => '',
                            'category_id'=> $categoryID,
                        ];
                    }
                }
            } catch (\Exception $e) {

            }
        }
        $rs = DB::table('videos')->insert($data);
    }
}
