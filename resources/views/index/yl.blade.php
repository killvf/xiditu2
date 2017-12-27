@extends('layout.index.inner')


@section('content')

<div id="fullpage">
    <div class="section" id="club-section1" style="background:url('{{asset('resource/img/index_agriculture.jpg')}}');">
        <div class="full-wrap">
            <div class="club-text club-text2 fl">
                <h3 hStyle="fadeInLeft1"><span>守护财富，专业规划</span></h3>
                <span class="tit" titStyle="fadeInLeft1">正如米兰•昆德拉所说“在时间的乱山碎石中流过，两岸的景致并不重要，重要的是溪流将流向沃野还是沙漠”。我们的使命是所有投资者的财富最终都能流向沃野！</span>

            </div>
        </div>
    </div>
    <div class="section" id="club-section2" style="background:url('{{asset('resource/img/index_agriculture.jpg')}}');">
        <div class="full-wrap">
            <div class="club-text club-text3 fr">
                <h3 hStyle="fadeInLeft1"><span>守护财富，专业规划</span></h3>
                <span class="tit" titStyle="fadeInRight1">分享、交流、碰撞、启示，求变创新，持态律己，时刻保持学习充电，迎接每一个新挑战！</span>

            </div>
        </div>
    </div>
    <div class="section" id="club-section3" style="background:url('{{asset('resource/img/index_agriculture.jpg')}}');">
        <div>
            <div class="footer-wrap active">
                <div class="wrap-1200">
                    <div class="footer clearfix">
                        <div class="wx fl"><img src="{{asset('resource/img/index-titlefall.jpg')}}" width="127" height="127" alt="" title=""/></div>
                        <div class="about fr">
                            <p>香港喜地国际控股有限公司&nbsp;&nbsp;<a href="http://www.miitbeian.gov.cn/" target="_blank"> 粤ICP备XXXXXXXX号</a><br />TEL:0755-555555555<br />ADD:深圳市南山区梦海大道卓越.前海壹号B栋2707室</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="full-wrap">
            <div class="club-text club-text6 fl">
                <h3 hStyle="fadeInLeft1"><span>守护财富，专业规划</span></h3>
                <span class="tit" titStyle="fadeInLeft1">人生各种际遇，生活热点每天在变，不变的是致远金控“金融为善”的初心，投身公益，萤火虽微，世界因你更美丽。</span>
            </div>
        </div>
    </div>
</div>

@endsection