<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TvQq extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tv:qq';

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
        //
        $data = [];
        for($i=1; $i <= 100; $i++) {
            $j = 21 * $i;
            $rUrl = "http://list.video.qq.com/fcgi-bin/list_common_cgi?novalue=1&otype=json&platform=5&version=10000&tid=573&uappkey=d2a6457eb8ae927a&uappid=20001172&intfname=hollywood_tv&sourcetype=1&type=2&pagesize=21&offset={$j}&sort=17&iyear=-1&itype=-1";
            //这里处理数据并放到数据库中
            $client = new Client();
            $html = $client->get($rUrl)->getBody()->getContents();
            try {
                $html = str_replace('QZOutputJson=', '', $html);
                $html = substr($html, 0, strlen($html)-1);

                $data1 = json_decode($html, true);

                if(!empty($data1['jsonvalue']['results'])) {
                    $data1 = $data1['jsonvalue']['results'];

                    foreach($data1 as $d) {
                        $data[] = [
                            'name' => $d['fields']['title'],
                            'link' => $d['fields']['url'],
                            'picture' => $d['fields']['vertical_pic_url'],
                            'desc' => empty($d['fields']['second_title']) ? '':$d['fields']['second_title'] ,
                            'from'=> 'qq',
                        ];
                    }
                }

            } catch (\Exception $e) {

            }
        }

        $rs = DB::table('tvs')->insert($data);
        dd($rs);
    }
}
