@extends('layout.index.news')


@section('content')
<div class="main">
    <div class="news">
        <div class="wrap-1200">
            <div class="navigation">
                <a href="{{url('/')}}">首页</a>
                <i>&gt;</i>

                <span>新闻速递</span>
            </div>
            <div class="news-detail">
                    <div class="news-detail-tit">{{$news->title}}</div>
                     
                    <div>
                        {!! $news->content !!}   
                    </div>
                </div>
        </div>  
    </div>
</div>

<div class="footer-wrap">
    <div class="wrap-1200">
        <div class="footer clearfix">
            <div class="wx fl"><img src="{{asset('resource/img/index-titlefall.jpg')}}" width="127" height="127" alt="致远金控" title="致远金控"/></div>
            <div class="about fr">
                <p>香港喜地国际控股有限公司&nbsp;&nbsp;<a href="http://www.miitbeian.gov.cn/" target="_blank"> 粤ICP备XXXXXXXX号</a><br />TEL:0755-555555555<br />ADD:深圳市南山区梦海大道卓越.前海壹号B栋2707室</p>
            </div>
        </div>
    </div>
</div>
@endsection