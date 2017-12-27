<header role="heading" class="current">
    <div class="head-box">
        <div class="logo-box">
            <a href="#">
                <img src="{{asset('resource/img/index-logo1.png')}}" title="" alt="">
            </a>
        </div>
        <div class="head-top">

            <div class="jodo-box">
                <p><img src="{{asset('resource/img/index-titlefall.jpg')}}" alt="扫一扫微信二维码"/></p>
                <p>扫一扫微信二维码 <em class="fa fa-mobile-phone"></em></p>
            </div>

        </div>
        <div class="nav-cut">
            <ul>
                @foreach($sideNavs as $index => $sNav)
                <li class="nav1 @if($index==0)
                                    background
                                @endif">
                    <a href="{{$sNav->link}}"  title="{{$sNav->title}}" data-alert="全部">{{$sNav->title}}</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="head-bottom">
            <div class="foto-box">

                <div class="social-box">

                    <a href="#" rel="nofollow" target="_blank">
                        <i class="fa fa-qq"></i>
                    </a>


                    <a href="" rel="nofollow" target="_blank"><i class="fa fa-weibo"></i></a>

                    <a id="met-weixin"><i class="fa fa-weixin"></i></a>
                </div>
            </div>
        </div>
    </div>
</header>