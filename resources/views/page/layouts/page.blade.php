<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'VietScapeJourneys - Lựa chọn hàng đầu cho TOUR DU LỊCH trực tuyến tại Việt Nam')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('page.common.head')
    
</head>

<body>
    @include('page.common.navbar')
    @yield('content')
    @include('page.common.footer')
    @include('page.common.script')
</body>
<!-- Messenger Plugin chat Code -->
<div id="fb-root"></div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>
 <!-- <script lang="javascript">var __vnp = {code : 19328,key:'', secret : 'b7ecffda3ca095656c1f1e08110c7ac3'};(function() {var ga = document.createElement('script');ga.type = 'text/javascript';ga.async=true; ga.defer=true;ga.src = '//core.vchat.vn/code/tracking.js?v=37834'; var s = document.getElementsByTagName('script');s[0].parentNode.insertBefore(ga, s[0]);})();</script>
 -->
 <!--Start of Tawk.to Script-->
<!--Start of Fchat.vn-->{{--<script type="text/javascript" src="https://cdn.fchat.vn/assets/embed/webchat.js?id=651e57a3b03746667d236bb8" async="async"></script><!--End of Fchat.vn--> --}}
<!--End of Tawk.to Script-->
 <!--Start of Fchat.vn--><!--End of Fchat.vn-->
{{--<script src="https://tudongchat.com/js/chatbox.js"></script> --}}
<!--Start of Fchat.vn-->{{--<script type="text/javascript" src="https://cdn.fchat.vn/assets/embed/webchat.js?id=651e57a3b03746667d236bb8" async="async"></script><!--End of Fchat.vn--> --}}
<link href="https://chatcompose.azureedge.net/static/all/global/export/css/main.5b1bd1fd.css" rel="stylesheet">    
<script async type="text/javascript" src="https://chatcompose.azureedge.net/static/all/global/export/js/main.a7059cb5.js?user=in_trâm&lang=VI" user="in_trâm" lang="VI"></script>  
<script>
  const tudong_chatbox = new TuDongChat('FKst-zvLIfUtNuJ688SDB')
  tudong_chatbox.initial()
</script>
  <script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "114604888407890");
  chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v17.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

</html>