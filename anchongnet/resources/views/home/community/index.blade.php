<html>
<head>
    <meta charset="utf-8">
    <title>社区</title>
    <link rel="stylesheet" type="text/css" href="home/css/chat.css"/>
    <script src="home/js/jquery-3.1.0.js"></script>
    <script src="home/layer/layer.js"></script>
</head>
<body>
@include('inc.home.site-top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="home/images/chat/logo_01.jpg"/>
                <i>安虫社区</i>
            </a>
        </div>
        <div class="search">
            <form class="search-form" method="post">
                <input type="text" name="search" class="search-text" placeholder="找工程&nbsp;找人才&nbsp;聊生活" />
                <input type="submit" value="搜索" class="search-btn"/>
            </form>
        </div>
        <div class="cl"></div>
        <div class="site-nav">
            <ul class="navigation">
                <li class="nav-item"><a class="nav-name" href="{{url('/community')}}">所有</a></li>
                <li class="nav-item"><a class="nav-name" href="{{url('/talk')}}">闲聊</a></li>
                <li class="nav-item"><a class="nav-name" href="{{url('/question')}}">问问</a></li>
                <li class="nav-item"><a class="nav-name" href="{{url('/activity')}}">活动</a></li>
                <li class="new-chat" ><a href="{{url('/chat')}}"><img src="home/images/chat/chat.png"></a></li>
                <div class="cl"></div>
            </ul>
        </div>
    </div>
</div>
<div class="site-middle">
    <div class="middle-container">
        <ul class="chat-info">
            @foreach($chat as $value)
            <li class="chat-item">
                <ul class="chat-show">
                    <li>
                        <img class="portrait" src="{{$value ->  headpic}}">
                        <p class="name">{{$value -> name}}</p>
                        <p class="date">
                            <i class="day">{{date("d",strtotime($value -> created_at))}}/</i>
                            <i class="month">{{date("m",strtotime($value -> created_at))}}</i>
                        </p>
                    </li>
                    <li class="chat-content">
                        <a href="{{url('/community/'.$value -> chat_id)}}">
                            <h3 class="chat-title">{{$value -> title}}</h3>
                            <p class="content">{{$value -> content}}</p>
                        </a>
                        <div class="share bdsharebuttonbox" data-tag="share_1"><a class="bds_more" data-cmd="more"></a></div>
                        <p class="comments-share">
                            <a class="comments" href="{{url('/community/'.$value -> chat_id).'/#comments'}}"><img src="home/images/chat/talk.png">{{$num[$value-> chat_id]}}</a>
                        </p>
                        <div style="clear: both"></div>
                    </li>
                </ul>
            </li>
            @endforeach
        </ul>
        <div class="pages">
            <ul class="page-select">
               {!! $chat -> links() !!}
            </ul>
            <ul class="page-skip">
                <i>共有{{$chat -> lastpage()}}页，</i>
                <i class="blank">
                    去第
                    <input name="page" class="page-num" onchange="changePage(this)" type="text" value="{{$chat->currentPage()}}">
                    页
                </i>
                <a class="page-btn" href="{{$chat->url($chat->currentPage())}}">确定</a>
            </ul>
            <div class="cl"></div>
        </div>
    </div>
</div>
@include('inc.home.site-foot')
</body>
<script>
    {{--获取用户输入的页数，然后更改a标签的链接--}}
    function changePage(obj) {
        var num = $(obj).val();
        if(!isNaN(num)&&num>0&&num<={{$chat->lastpage()}}){
            $('.page-btn').attr('href','http://www.anchong.net/community?page='+num);
        }else{
            layer.alert('请输入数字并小于等于"{{$chat->lastpage()}}"');
        }
    }
    window._bd_share_config = {
        common : {
            bdText : '',
            bdDesc : '',
            bdUrl : '',
        },
        share : [{
            "bdSize" : 16
        }],
    }
    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
    $(".bds_more").css({
        "height":"18px",
        "line-height":"18px",
        "margin":"0",
        "backgroundImage":"url(http://www.anchong.net/home/images/chat/share.png)"
    });
</script>
</html>