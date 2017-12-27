@extends('layout.index.news')


@section('content')
<div class="main">
    <div class="news">
        <div class="wrap-1200">
            <div class="navigation">
                <a href="/">首页</a>
                <i>&gt;</i>
                <span>新闻速递</span>
            </div>
            <div class="news-list">
                @foreach($news as $new)
                <dl class="clearfix">
                    <dt>
                        <a href="{{url('/news', ['id'=>$new->id])}}"><img src="{{asset($new->picture)}}" alt="{{$new->title}}"></a>
                    </dt>
                    <dd>
                        <h3><a href="{{url('/news', ['id'=>$new->id])}}">{{$new->title}}</a></h3>
                        <p>{{$new->descr}}</p>
                    </dd>
                </dl>
                @endforeach
            </div>
            {{$news->links()}}
            <!-- <div class="page active">
                <a href="">首页</a>
                <a href="">上一页</a>
                <a href="" class="cur">1</a>
                <a href="">2</a>
                <a href="">3</a>
                <a href="">4</a>
                <a href="">下一页</a>
                <a href="">尾页</a>
            </div>
            <form class="query-form" role="form" action="/front/news-list" method="post">
                <div class="page"></div>
                <input type="hidden" value="2" name="newsType" />
            </form> -->
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