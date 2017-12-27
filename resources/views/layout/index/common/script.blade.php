<script type="text/javascript">
    require(['jquery', 'frontCommon', 'js/js.cookie'], function($, fc, Cookies) {
       
        fc.fullpage({
            id: '#index'
        });
        fc.touchSilde({
            slideCell: "#tabBox",
            delayTime: 1000
        });
        var times = setInterval(function () {
            $.fn.fullpage.moveSlideRight();
        },6000);
           

        $("#leftClick").click(function () {
            $('.current').toggleClass('active')
        })

        $('li', 'ul.language').on('click', function() {
            var language = $(this).data('language');
            Cookies.set('language', language);
            location.reload();
        })
   
    });
</script>