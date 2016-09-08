<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>商机</title>
		<link rel="stylesheet" type="text/css" href="home/css/project.css"/>
		<script src="{{asset('home/js/jquery-3.1.0.js')}}"></script>
		<script src="{{asset('home/js/talent.js')}}" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="site-top">
			<div class="top-container">
				<ul class="info">
					<li class="tel">垂询电话：010-88888888</li>
					<li>
						<img class="little-tx" src="home/images/business/tx.jpg"/>
						<span class="userinfo">
							{{session('name')}}
							<span class="info-triangle"></span>
							<div class="cart">
								<p><a href="">购物车</a></p>
								<p><a href="">收藏夹</a></p>
							</div>	
						</span>
					</li>
				</ul>
			</div>
		</div>
		<div class="header">
			<div class="header-container">
				<div class="logo">
					<img src="home/images/business/logo.jpg"/>
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
						<li class="home"><a href="">首页</a></li>
						<li class="business">
							<a href="">商机</a>
							<span class="business-triangle"></span>
							<div class="business-list">
								<p><a href="">工程</a></p>
								<p><a href="">人才</a></p>
								<p><a href="">找货</a></p>
							</div>
						</li>
						<li class="community"><a href="">社区</a></li>
						<li class="equipment"><a href="">设备选购</a></li>
						<li class="news"><a href="">资讯</a></li>
						<div class="cl"></div>
					</ul>
				</div>	
			</div>	
		</div>
		<div class="banner">
			<img src="home/images/business/banner.jpg"/>
		</div>
		<div class="site-middle">
			<div class="middle-container">
				<div class="work">
					<a class="contract-work" href=""><img src="home/images/business/push_accept.png"/></a>
					<a class="package" href=""><img src="home/images/business/accept.png"/></a>
					<a class="release" href=""><img src="home/images/business/push.png"/></a>
				</div>
				<div class="nav">
					<div class="server">
						<ul class="server-type">
							<li class="type-title" style="width:180px">服务类别</li>
							<li class="type-list">探测监控</li>
							<li class="type-list">防护保障</li>
							<li class="type-list">探测报警</li>
							<li class="type-list">弱电工程</li>
							<li class="type-list">呼救器</li>
							<li class="type-list">楼宇对讲</li>
							<li class="type-list">快速通道</li>
							<li class="show-list">展开</li>
                            <div class="cl"></div>
						</ul>
						<ul class="server-area">
							<li class="area-title" style="width:180px">区&nbsp;&nbsp;域</li>
							<li class="area-list">北京市</li>
							<li class="area-list">上海市</li>
							<li class="area-list">武汉市</li>
							<li class="area-list">保定市</li>
							<li class="area-list">石家庄</li>
							<li class="area-list">衡水市</li>
							<li class="area-list">邢台市</li>
							<li class="show-list">展开</li>
                            <div class="cl"></div>
						</ul>
					</div>
				</div>
				<div class="project-list">
					<div class="sort">
						<span class="rank">排序</span>
						<span class="hot-rank">热门排序</span>
						<ul class="pages-turn">
                            <a href="" class="pageup">
                                <img src="home/images/pageup.png">
                            </a>
                            <a href="" class="pagedown">
                                <img src="home/images/pagedown.png">
                            </a>
                    </div>
					<div class="project-info">
						<ul>
                            <li class="project-preview">
                                <p class="title"><a href="">湖南常德万达广场建设安防系统招标</a></p>
                                <p class="digest">项目概况 项目所属行业房地产</p>
                            </li>
                            <li class="image"><img src="home/images/business/image1.jpg"></li>
                            <li class="cl"></li>
                        </ul>
                        <ul>
                            <li class="project-preview">
                                <p class="title"><a href="">四川省凉山彝族自治州不拖汽车客运站安防招标</a></p>
                                <p class="digest">长56m，宽1m，办公室3间餐厅一间，停车场16*8m 看现场上午8点到下午5点</p>
                            </li>
                            <li class="image"><img src="home/images/business/image1.jpg"></li>
                            <li class="cl"></li>
                        </ul>
                        <ul>
                            <li class="project-preview">
                                <p class="title"><a href="">聚朋友垂钓园监控系统招标</a></p>
                                <p class="digest">长56m，宽1m，办公室3间餐厅一间，停车场26*8m&nbsp;&nbsp;&nbsp;&nbsp;看现场上午8点到下午5点</p>
                            </li>
                            <li class="image"><img src="home/images/business/image1.jpg"></li>
                            <li class="cl"></li>
                        </ul>
                        <ul>
                            <li class="project-preview">
                                <p class="title"><a href="">聚朋友垂钓园监控系统招标</a></p>
                                <p class="digest">长56m，宽1m，办公室3间餐厅一间，停车场26*8m&nbsp;&nbsp;&nbsp;&nbsp;看现场上午8点到下午5点</p>
                            </li>
                            <li class="image"><img src="home/images/business/image1.jpg"></li>
                            <li class="cl"></li>
                        </ul>
                        <ul>
                            <li class="project-preview">
                                <p class="title"><a href="">聚朋友垂钓园监控系统招标</a></p>
                                <p class="digest">长56m，宽1m，办公室3间餐厅一间，停车场26*8m&nbsp;&nbsp;&nbsp;&nbsp;看现场上午8点到下午5点</p>
                            </li>
                            <li class="image"><img src="home/images/business/image1.jpg"></li>
                            <li class="cl"></li>
                        </ul>
                        <ul>
                            <li class="project-preview">
                                <p class="title"><a href="">聚朋友垂钓园监控系统招标</a></p>
                                <p class="digest">长56m，宽1m，办公室3间餐厅一间，停车场26*8m&nbsp;&nbsp;&nbsp;&nbsp;看现场上午8点到下午5点</p>
                            </li>
                            <li class="image"><img src="home/images/business/image1.jpg"></li>
                            <li class="cl"></li>
                        </ul>
                        <ul>
                            <li class="project-preview">
                                <p class="title"><a href="">聚朋友垂钓园监控系统招标</a></p>
                                <p class="digest">长56m，宽1m，办公室3间餐厅一间，停车场26*8m&nbsp;&nbsp;&nbsp;&nbsp;看现场上午8点到下午5点</p>
                            </li>
                            <li class="image"><img src="home/images/business/image1.jpg"></li>
                            <li class="cl"></li>
                        </ul>
                        <ul>
                            <li class="project-preview">
                                <p class="title"><a href="">聚朋友垂钓园监控系统招标</a></p>
                                <p class="digest">长56m，宽1m，办公室3间餐厅一间，停车场26*8m&nbsp;&nbsp;&nbsp;&nbsp;看现场上午8点到下午5点</p>
                            </li>
                            <li class="image"><img src="home/images/business/image1.jpg"></li>
                            <li class="cl"></li>
                        </ul>
                        <ul>
                            <li class="project-preview">
                                <p class="title"><a href="">聚朋友垂钓园监控系统招标</a></p>
                                <p class="digest">长56m，宽1m，办公室3间餐厅一间，停车场26*8m&nbsp;&nbsp;&nbsp;&nbsp;看现场上午8点到下午5点</p>
                            </li>
                            <li class="image"><img src="home/images/business/image1.jpg"></li>
                            <li class="cl"></li>
                        </ul>
                        <ul>
                            <li class="project-preview">
                                <p class="title"><a href="">聚朋友垂钓园监控系统招标</a></p>
                                <p class="digest">长56m，宽1m，办公室3间餐厅一间，停车场26*8m&nbsp;&nbsp;&nbsp;&nbsp;看现场上午8点到下午5点</p>
                            </li>
                            <li class="image"><img src="home/images/business/image1.jpg"></li>
                            <li class="cl"></li>
                        </ul>
					</div>
					<div class="pages">
						<ul class="page-select">
                            <li class="pagesup"><a href="">&lt;&nbsp;上一页</a></li>
                            <li class="pages-num"><a href="">4</a></li>
                            <li class="pages-num"><a href="">5</a></li>
                            <li class="pages-num"><a href="">6</a></li>
                            <li class="pages-num"><a href="">7</a></li>
                            <li class="pages-num"><a href="">8</a></li>
                            <li class="pagesdown"><a href="">下一页&nbsp;&gt;</a></li>
                        </ul>
                        <ul class="page-skip">
                            <i>共有10页，</i>
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
		</div>
		<div class="site-footer">
			<div class="footer-top">
				<div class="footer-top-container">
					<div class="link">
						<h4>友情链接</h4>
						<hr class="line" />
						<div class="link-list">
							<p><a href="">中国安防行业网</a></p>
							<p><a href="">华强安防网</a></p>
							<p><a href="">中国安防展览网</a></p>
							<p><a href="">安防英才网</a></p>
						</div>
						<div class="link-list1">
							<p><a href="">智能交通网</a></p>
							<p><a href="">中国智能化</a></p>
							<p><a href="">中关村在线</a></p>
							<p><a href="">教育装备采购网</a></p>
						</div>
						<div class="link-list1">
							<p><a href="">中国贸易网</a></p>
							<p><a href="">华强电子网</a></p>
							<p><a href="">研究报告中国测控网</a></p>
							<p><a href="">五金机电网</a></p>
						</div>
						<div class="link-list1">
							<p><a href="">中国安防展览网</a></p>
							<p><a href="">民营企业网</a></p>
							<p><a href="">中国航空新闻网</a></p>
							<p><a href="">北极星电力</a></p>
						</div>
					</div>
					<div class="qr-code">
						<ul>
							<li>
								<h4>下载安虫APP客户端</h4>
								<img src="home/images/1.jpg"/>
							</li>
							<li>
								<h4>安虫微信订阅号</h4>
								<img src="home/images/2.jpg"/>
							</li>
							<div class="cl"></div>
						</ul>
					</div>
					<div style="clear: both"></div>
				</div>	
			</div>
			<div class="site-bottom">
				<div class="btottom">
					<div class="bottom-container">
						<p class="p1">
							<a href="">关于安虫</a>
							<span class="">|</span>
							<a href="">联系我们</a>
							<span class="">|</span>
							<a href="">帮助中心</a>
							<span class="">|</span>
							<a href="">服务网点</a>
							<span class="">|</span>
							<a href="">法律声明</a>
							<span class="">|</span>
							客服热像400-888-888
						</p>
						<p class="p2">Copyright©北京安虫版权所有 anchong.net</p>
						<p class="p3">
							<a href="">京ICP备111111号</a>
							<span class="">|</span>
							<a href="">出版物经营许可证</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>