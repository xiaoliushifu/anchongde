<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>第三方商城</title>
    <link rel="stylesheet" href="/home/css/thirdparty.css">

</head>
<body>
@include('inc.home.top',['page'=>' <li><div class="shop-ioc">
            <a href="">购物车</a>
            <a href=""><img src="../../home/images/shebei/10.jpg" alt=""  style="width: 16px;height: 40px;margin-top: 0px;margin-left: 2px;"></a>
        </div></li>'])
<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <a href="{{url('/')}}"><img src="{{asset('../home/images/shebei/12.jpg')}}" alt=""></a>
        </div>
        <div class="search">
            <div class="searchbar">
                <input type="text" class="biaodan">
                <button type="button" class="btn">搜索</button>
                <li><a href="">搜本店</a></li>
            </div>

        </div>
    </div>
</div>
<div class="ad">
    <img src="{{asset('../home/images/shebei/41.jpg')}}" alt="">
    <li><a href="">收藏</a></li>
</div>
<div class="nav">
    <div class="navc">
        <div class="navcontent">
            <ul>
                <li><a href="{{url('/equipment')}}">首页</a></li>
                @foreach($nav as $a)
                    <li><a href="{{url('equipment/list/'.$a->cat_id)}}">{{$a->cat_name}}</a></li>
                @endforeach
            </ul>
        </div>

    </div>

</div>
<div style="clear: both"></div>
<hr class="nav-underline">

<div class="centermain">
    <div class="submain">
         <div class="adress"><p>您的位置：首页>设备选购><span>门禁监控</span></p></div>

        <script>
            $(document).ready(function(){
                $("#flip").click(function(){
                    $("#yy").slideToggle("slow");
                });
            });
        </script>
        <div class="server">
            <hr>
            <ul class="server-type">
                <li class="type-title" style="width:180px;;"><span style="font-size: 18px;">品&nbsp;&nbsp;牌</span></li>
                <li><a href="#">探测监视</a></li>
                <li><a href="#">防护保障</a></li>
                <li><a href="#">探测报警</a></li>
                <li><a href="#">弱电工程</a></li>
                <li><a href="#">呼救器</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li><a href="#">快速通道</a></li>
                <li class="downmenue" style="width: 80px;height: 40px;float: right;font-size: 14px;color:#606060;"><span  id="flip" >展开 <b class="caret"></b></span> </li>
            </ul>
            <ul class="server-type" id="yy" style="display: none;">
                <li><a href="#">按时打算</a></li>
                <li><a href="#">探测监视</a></li>
                <li><a href="#">防护保障</a></li>
                <li><a href="#">探测报警</a></li>
                <li><a href="#">弱电工程</a></li>
                <li><a href="#">呼救器</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li ><a href="#">快速通道</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li ><a href="#">快速通道</a></li>
            </ul>

            <ul class="server-type">
                <li class="type-title-1" style="width: 180px;"><span  style="font-size: 18px;">种&nbsp;&nbsp;类</span></li>
                <li><a href="#">北京市</a></li>
                <li><a href="#">上海市</a></li>
                <li><a href="#">武汉市</a></li>
                <li><a href="#">保定市</a></li>
                <li><a href="#">石家庄市</a></li>
                <li><a href="#">衡水市</a></li>
                <li><a href="#">邢台市</a></li>
                <li class="downmenue" style="width: 80px;height: 40px;float: right;font-size: 14px;color:#606060;"><span  id="show" >展开 <b class="caret"></b></span></li>
            </ul>
            <script>
                $(document).ready(function(){
                    $("#show").click(function(){
                        $("#adress").slideToggle("slow");
                    });
                });
            </script>

            <ul class="server-type" id="adress" style="display: none">
                <li><a href="#">北京市</a></li>
                <li><a href="#">上海市</a></li>
                <li><a href="#">武汉市</a></li>
                <li><a href="#">保定市</a></li>
                <li><a href="#">石家庄市</a></li>
                <li><a href="#">衡水市</a></li>
                <li><a href="#">邢台市</a></li>
                <li><a href="#">北京市</a></li>
                <li><a href="#">上海市</a></li>
                <li><a href="#">武汉市</a></li>
            </ul>
            <ul class="server-type">
                <li class="type-title" style="width:180px;;"><span style="font-size: 18px;">筛&nbsp;&nbsp;选</span></li>
                <li><a href="#">探测监视</a></li>
                <li><a href="#">防护保障</a></li>
                <li><a href="#">探测报警</a></li>
                <li><a href="#">弱电工程</a></li>
                <li><a href="#">呼救器</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li><a href="#">快速通道</a></li>
                <li class="downmenue" style="width: 80px;height: 40px;float: right;font-size: 14px;color:#606060;"><span  id="" >展开 <b class="caret"></b></span> </li>
            </ul>
        </div>

            <ul class="rank">
                <li class="ranking" style="width: 180px;">排&nbsp;&nbsp;序</li>
                <li><a href="">全部</a></li>
                <li><a href="">销量</a></li>
                <li class="price"><a href="">价格</a><img src="{{asset('../home/images/shebei/upp.png')}}" alt=""><img src="{{asset('../home/images/shebei/don.png')}}" alt=""></li>

                <li style="width: 400px; float: right ;text-align: right;" class="pagmm">
                    <a href="{{$data->nextPageUrl()}}"><img src="{{asset('../home/images/shebei/下一页.png')}}" alt=""></a>
                    <a href="{{$data->previousPageUrl()}}"><img src="{{asset('../home/images/shebei/上一页.png')}}" alt=""></a>
                </li>
            </ul>

    </div>
</div>

<div class="maindetail">
    <div class="submaindetail">
        <div class="goodsdetail">
            <ul>
                @foreach($data as $d)
                <li>
                    <a href="{{url('equipment/show/'.$d->goods_id.'/'.$d->gid)}}"><img src="{{$d->pic}}" alt=""></a>
                    <a href="{{url('equipment/show/'.$d->goods_id.'/'.$d->gid)}}"><nobr><p>{{$d->title}}</p></nobr></a>
                    <span class="vip">会员价：￥{{$d->vip_price}}</span><span class="common">价格：￥{{$d->price}}</span>
                </li>
                @endforeach

            </ul>
        </div>



        <div class="paging" >
            <div class="">
                {{$data->links()}}

            </div>
            <div class="paging-right">
                <span>共有{{$data->lastpage()}}页，去第 <input type="text"></span> <button type="submit">确定</button>
            </div>
        </div>
    </div>
</div>
















<div class="foottop">
    <div class="foottop-1">
        <div class="foottoplf">
            <div class="link"><h4>友情链接</h4>
                <hr>
            </div>
            <ul>
                <li>
                    <p><a href="#">中国安防行业网</a></p>
                    <p><a href="#">华强安防网</a></p>
                    <p><a href="#">中国安防展览网</a></p>
                    <p><a href="#">安防英才网</a></p>
                </li>
                <li>
                    <p><a href="#">智能交通网</a></p>
                    <p><a href="#">中国智能化</a></p>
                    <p><a href="#">中关村在线</a></p>
                    <p><a href="#">教育装备采购网</a></p>
                </li>
                <li>
                    <p><a href="#">中国贸易网</a></p>
                    <p><a href="#">华强电子网</a></p>
                    <p><a href="#">研究报告中国测控网</a></p>
                    <p><a href="#">五金机电网</a></p>
                </li>
                <li>
                    <p><a href="#">中国安防展览网</a></p>
                    <p><a href="#">民营企业网</a></p>
                    <p><a href="#">中国航空新闻网</a></p>
                    <p><a href="#">北极星电力网</a></p>
                </li>
            </ul>

        </div>
        <div class="foottoprg">
            <div class="rqcode-app" >
                <h4>下载安虫app客户端</h4>
                <img src="{{asset('../home/images/shebei/1.jpg')}}">
            </div>
            <div class="rqcode-wx">
                <h4>安虫微信订阅号</h4>
                <img src="{{asset('../home/images/shebei/2.jpg')}}">
            </div>

        </div>
    </div>
</div>
<hr class="downline">

<div class="footdown">
    <div class="footdown-1">


        <div class="about">
            <p><a href="#">关于安虫</a><span>|</span>
                <a href="#">联系我们</a><span>|</span>
                <a href="#">帮助中心</a><span>|</span>
                <a href="#">服务网点</a><span>|</span>
                <a href="#">法律声明</a><span>|</span>
                客服热线：400-888-888

            </p>
            <p>Copyright©&nbsp;北京安虫版权所有&nbsp;anchong.net</p>
            <p>京ICP备111111号&nbsp;<span>|</span>&nbsp;出版物经营许可证</p>

        </div>

    </div>
</div>


</body>
</html>