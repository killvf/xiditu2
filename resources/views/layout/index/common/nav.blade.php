 <!-- 链接  start -->
 <div>
    <div class="hearder">
        <div class="wrap-1200 clearfix rel">
            <div class="logo fl">
                <a href="/">
                    <img src="{{asset('resource/img/logo.png')}}" alt="喜地控股" title="喜地控股" />
                </a>
            </div>
            <ul class="nav fr navFall">
                @foreach($navs as $nav)
                <li  onclick="window.location.href='{{$nav->link}}'" 
                    @if($nav->position == $curPos)
                    class='cur'
                    @endif>{{$nav->title}}</li>
                @endforeach
            </ul>
        </div>
        <div  class="leftNav">
            <p class="leftFist">
                <span>{{$language->name}}</span>
            </p>
            <ul class="leftUl clear language">
                @foreach($languages as $language)
                <li data-language="{{$language->english}}">{{$language->name}}</li>
                @endforeach
            </ul>
            <img class="leftImg" id="leftClick" src="{{asset('/resource/img/index-tit03.png')}}" alt="">
        </div>
    </div>
</div>
