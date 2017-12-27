@extends('layout.index.index')

@section('content')
    <div class="am-container container-fix">
    @foreach($languages as $language)
                    <div class="am-u-sm-6 am-u-md-2">
                        <p><a href="javascript:;" class="language" data-language="{{$language->english}}">
                                {{$language->name}}
                            </a>
                        </p>

                    </div>
                @endforeach


    </div>
    <div class="am-container container-fix">
               @foreach($navs as $nav)
                    <div class="am-u-sm-6 am-u-md-2">
                        <p><a href="javascript:;">
                                {{$nav->title}}
                            </a>
                        </p>

                    </div>
                @endforeach
    </div>
@endsection

@section('script')
    <script src="{{asset('theme/js/js.cookie.js')}}"></script>
    <script>
        $(function() {
            $('a.language').on('click', function() {
                var language = $(this).data('language');
                Cookies.set('language', language);
                location.reload();
            })
        })
    </script>
    @endsection