<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MovieIqiyi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:iqiyi';

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
        $data = [];
        for($i=1; $i <= 1; $i++) {
            $rUrl = "http://search.video.iqiyi.com/o?pageNum={$i}&mode=11&ctgName=电影&pageSize=800&type=list&if=html5&site=iqiyi&qyid=esht75r3q2l5ad1drkwxtqy8&access_play_control_platform=15&u=esht75r3q2l5ad1drkwxtqy8";

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
                            'from'=> 'iqiyi',
                        ];
                    }
                }
            } catch (\Exception $e) {

            }
        }
        $rs = DB::table('movies')->insert($data);
        dd($rs);
    }
}
