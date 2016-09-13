<html>
<head>
    <meta charset="utf-8">
    <title>聊聊</title>
    <link rel="stylesheet" type="text/css" href="home/css/chat.css"/>
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
                <li class="nav-item"><a class="nav-name" href="">所有</a></li>
                <li class="nav-item"><a class="nav-name" href="">闲聊</a></li>
                <li class="nav-item"><a class="nav-name" href="">问问</a></li>
                <li class="nav-item"><a class="nav-name" href="">活动</a></li>
                <li class="new-chat" ><a href=""><img src="home/images/chat/chat.png"></a></li>
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
                        <a href="{{url('/chat/'.$value -> chat_id)}}">
                            <h3 class="chat-title">{{$value -> title}}</h3>
                            <p class="content">{{$value -> content}}</p>
                        </a>
                        <p class="comments-share">
                            <a class="comments" href=""><img src="home/images/chat/talk.png">28</a>
                            <a class="share" href=""><img src="home/images/chat/share.png"></a>
                        </p>
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
                    <input class="page-num" type="text">
                    页
                </i>
                <input class="page-btn" type="button" value="确定">
            </ul>
            <div class="cl"></div>
        </div>
    </div>
</div>
@include('inc.home.site-foot')
</body>
</html>