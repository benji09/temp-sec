<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,  viewport-fit=cover">
    <meta name="keywords" content="idemitsu,出光,出光润滑油,汽车用润滑油,工业用润滑油" /> 
    <meta name="description" content="出光润滑油(中国)有限公司【IDEMITSU LUBE CHINA Co.，Ltd.】是一家在中国主要从事润滑油生产、销售和研究的公司，也是出光集团中的主要公司之一。" /> 
    <!-- <title>IDEMITSU LUBE CHINA 出光润滑油（中国）有限公司</title>  -->
    <title>bohan</title>
    <link rel="stylesheet" href="lube/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="lube/assets/font/iconfont.css">
    <link rel="stylesheet" href="lube/assets/css/common.min.css">
    <link rel="stylesheet" href="lube/assets/css/shop.min.css">
    <style>
        #map {
            overflow: hidden;
            width: 100%;
            height: 800px;
            margin: 0;
            font-family: "微软雅黑";

        }
        .clearfix:after{
            content: "020"; 
            display: block; 
            height: 0; 
            clear: both; 
            visibility: hidden;  
        }
        .company {
            color: rgb(216, 117, 78);
            font-weight: 700;
        }
        .type {
            background-color: #d8052e;
            color: #fff;
            font-size: 13px;
            padding: 2px 5px;
            display: inline-block;   
            margin-top: 15px;
        }
        .info {
            margin: 20px 0;
        }
        .info-left {
            width: 70%;
            float: left;
        }
        .info-left .phone {
            margin: 4px 0;
        }
        .info-right {
            width:20%;
            float: right;
            text-align: center;
            cursor: pointer;
        }
        .info-right span {
            display: block;
        }
        .tip-mask {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 99;
        }
       
        .tip-mask>div {width:50vw;margin:30vw auto;}
        .tip-mask p{color: #fff; text-align: center;}
        .tip-mask ul{color: #000; position: relative;}
        .tip-mask li{width: 50vw; height: 10vw; line-height: 10vw;text-align:center; margin-top: 20px;background: #fff url('lube/assets/images/nav48.png') no-repeat 5vw center;cursor: pointer;border: 1px solid #ccc;border-radius: 2px;}
        .wechat-mask img {display: block;width: 100%;height: auto;}

    </style>
    <script src="//api.map.baidu.com/api?v=2.0&ak=OGpW3qTzoRHh4fSN8ROg9Rkn9dzUZAGF"></script>
</head>
<body>
    <div class="container">
        <div class="row custom-breadcrumb d-none d-lg-block">
            <a href="lube/">首页</a> &gt;
            <span>代理店</span>
        </div>
        <h2 class="page-title">代理店网点查询</h2>
        <button style="background-color: red;" onclick="search()">search</button>
        <div class="row main-shadow">
            <div class="sales-search text-center col-12">
                <form class="form-inline flex-column">
                    <div class="form-group">
                        请选择代理店所属区域&nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="select-group">
                            <select name="province" class="form-control">
							<option value="">全部</option>
							<option value="上海市">上海市</option>
                            </select>
                            <select name="city" class="form-control">
							<option value="">全部</option>
							<option value=""></option>
                            </select>
                            <!-- test -->
                            <input type="submit" value="搜索" class="btn btn-default link-shadow">
                        </div>
                    </div>
					<p class="tip">* 仅显示有代理店的区域</p>
                </form>
            </div>
            <!-- 地图显示区域 -->
            <div class="sales-map col-12">
                <div id="map"></div>

            </div>
            <!-- 显示结果 -->

            <div class="sales-result col-12">
                <h3>代理店搜索结果</h3>
                <ul class="row">
                    <li class="col-12 col-lg-4">
                        <p class="company"><span></span></p>
                        <p class="address">地址：<span></span></p>
                        <p class="phone">电话：<span></span></p>
                        <p class="name">联系人：<span></span></p>
                        <p class="name"><a href="">&gt;&gt;查看店铺详情</a></p>
                    </li>
					<li class="clearfix visible-md-block visible-lg-block"></li>';
                </ul>
            </div>
			<div class="col-12 text-center mb-3">
			    <nav style="display: inline-block;">
    			</nav>
            </div>
            
            <!-- 移动端导航提示遮罩 -->
            <div class="tip-mask" style="display:none;position:fixed;top:0;bottom:0;left:0;right:0;background-color: rgba(0, 0, 0, 0.8);z-index: 99;">
                <div class="" style="color:#fff;">
                    <p>请选择导航APP</p>
                    <ul>
                        <li id="toBaiduMap">百度地图</li>
                        <li id="toGaodeMap">高德地图</li>
                        <li id="toTencentMap">腾讯地图</li>
                    </ul>
                </div>
            </div>
            <!-- 微信环境遮罩 -->
            <div class="wechat-mask" style="display:none;position:fixed;top:0;bottom:0;left:0;right:0;z-index: 100;">
                <img src="wechat-mask.png" alt="">
            </div>


        </div>
    </div>
    <script src="lube/assets/js/jquery-3.5.1.min.js" id="jquery"></script>
    <script src="lube/assets/js/bootstrap.min.js"></script>
    <script src="lube/assets/js/index.js"></script>
    <script>
	$(function(){
		$('select[name=province]').change(function(){
			getCityVal();
		})
	})
	function getCityVal()
	{
		var province = $('select[name=province]').val();
		$.getJSON("lube/getcity", {province:province}, function(json){
			var city = $('select[name=city]');
			$('option', city).remove();
			$(city).prepend("<option value='' select>全部</option>");
			$.each(json,function(index, arr){
				var option = "<option value='"+arr['id']+"'>"+arr['name']+"</option>";
				city.append(option);
			});
		});
	}

   
   

    // 地图相关
    var longitude, latitude, accuracy   //经纬度
    function getCurrentPosition() {
        if(window.navigator.geolocation){
            window.navigator.geolocation.getCurrentPosition(function(pos){
                console.log(pos);
                latitude = pos.coords.latitude; 
                longitude = pos.coords.longitude;
                accuracy = pos.coords.accuracy	 
            }, function(error) {
                console.log(error);
                

            })
        }else {
            console.log('您的浏览器不支持地理定位');
        }
    }
    
    getCurrentPosition();
    var map = new BMap.Map('map'); // 创建Map实例
    map.centerAndZoom(new BMap.Point(121.48789949,31.24916171), 4); // 初始化地图,设置中心点坐标和地图级别
    map.enableScrollWheelZoom(true); // 开启鼠标滚轮缩放
    
    var index = 0;
    var myGeo = new BMap.Geocoder();
   
    var names=[], types, addresses, contact_numbers;
    function search() {
        var province = $('select[name=province]').val();
        var city = $('select[name=city]').val();
        $.getJSON('lube/getPoint.json', {province, city},function(json) {
            // 保存当前 name, type, address, contact_number
            names = json.map(function(item) {return item.name});
            types = json.map(function(item) {return item.type});
            addresses = json.map(function(item) {return item.address});
            contact_numbers = json.map(function(item) {return item.contact_number});

             //批量地址解析显示在地图上，根据搜索结果返回调用
            for(var i = 0; i< addresses.length;i++) {
                var curAddr = addresses[i];
                getCurrentAddr(curAddr);
            }
        })
    }

    function getCurrentAddr(curAddr) {
        myGeo.getPoint(curAddr, function(point){
            if (point) {
                var location = new BMap.Point(point.lng, point.lat);
                addMarker(curAddr, location);
            }else {
                console.log(`${address}':该地址没有解析到结果！'`);
            }
        });
    }
  
    // 添加自定义地理位置图标
	function addMarker(curAddr, location){
        var myIcon = new BMap.Icon("lube/assets/images/point-icon.png", new BMap.Size(42, 42));
        var marker = new BMap.Marker(location, {icon:myIcon});
       
        map.addOverlay(marker);
        addClickHandler(curAddr,marker);
    
    }
    function addClickHandler(curAddr, marker){ 
        marker.addEventListener("click",function(e){
            console.log(curAddr);
            document.cookie = 'curAddr=' + curAddr;
            openInfo(curAddr,e)
        });
    }

    function openInfo(curAddr,e){
         //创建图标及信息窗口
         var opts = {
            width : 340,     // 信息窗口宽度
            height: 150,     // 信息窗口高度
            title : "" , // 信息窗口标题
            enableMessage:true//设置允许信息窗发送短息
        }
        //信息窗口样式
        //href: 用模板添加当前地址（自定义属性data-）, name, type, address, contact_number
        var contentDOM = 
        '<div class="wrap"> ' +
            '<div class="company"><span>路安汽车维修中心&nbsp;&nbsp;</span><a href="">&gt;&gt;店铺详情</a></div>' +
            '<div class="type"><span>一般贩卖店</span></div>' +
            '<div class="info clearfix">' +
                '<div class="info-left">' +
                    '<div class="address"><span><strong>地址：</strong>上海市襄阳公园襄阳公园襄阳公园襄阳公园</span></div>' +
                    '<div class="phone"><span><strong>电话：</strong>15265455422</span></div>' +
                '</div>' +
                '<div class="info-right"><img src="lube/assets/images/navigator.png" alt="" width="40" height="40"><span>到这去</span></div>' +
            '</div>' +
        '</div>';
        var p = e.target;
        var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
        var infoWindow = new BMap.InfoWindow(contentDOM,opts);  // 创建信息窗口对象 
        map.openInfoWindow(infoWindow,point); //开启信息窗口
        var currentAddress = infoWindow.getContent();   //这个整个content

        //到这去
        infoWindow.addEventListener('open', function() {
        })
        toMap(e);
        
       
    }

    var u = navigator.userAgent;
    var isMobile = u.match(/(iPhone|iPod|Android|ios)/i);
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; 
    var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
    var isWechat = u.match(/MicroMessenger/i) == 'MicroMessenger'; //微信浏览器 
    var isPC = !isAndroid && !isIOS;
    var curAddr = '';

    function toMap(e) {
        var p = e.target;
        var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
        $('.wrap').on('click', '.info-right', function(e) {
        alert('到这去')
        var target = e.currentTarget;
        // Web页在pc & mobile & wechat
        
        curAddr = getCurAddrCookie();
        alert(curAddr)
        if(isPC) { //是PC导航到百度地图
            alert('ispc');
            window.location.href = "http://api.map.baidu.com/geocoder?address=" +curAddr+"&output=html&src=webapp.baidu.openAPIdemo";  
        }

        if(isMobile) {
            alert('ismobile')
            $('.tip-mask').css('display', 'block');
        }
         // 现微信不支持直接调起app或到应用商店打开安卓百度地图app和苹果百度地图app,普通用户不支持，去浏览器下载
        if (isWechat && isMobile) {
            alert(isWechat);
            $('.wechat-mask').css('display', 'block');
            window.location.href = '/goMap.html';


            //此方法是微信内置地图，
            wx.openLocation({
                latitude: 22.545538, // 纬度，浮点数，范围为90 ~ -90
                longitude: 114.054565, // 经度，浮点数，范围为180 ~ -180。
                name: '上海', // 位置名
                address: '位置名的详情说明', // 地址详情说明
                scale: 10, // 地图缩放级别,整形值,范围从1~28。默认为最大
            });
        }
    })

     //调起百度地图
    $('.container').on('click', '#toBaiduMap', function() {
        var curAddr = getCurAddrCookie();
        if (isAndroid) {
            window.location.href = 'baidumap://map/place/search?query=' + curAddr;
            setTimeout(function(){
                let hidden = window.document.hidden || window.document.mozHidden || window.document.msHidden ||window.document.webkitHidden 
                if(typeof hidden =="undefined" || hidden ==false){
                    window.location.href ="https://a.app.qq.com/o/simple.jsp?pkgname=com.baidu.BaiduMap";
                }
            }, 2000);
        }
        if (isIOS) {
                window.location.href = 'baidumap://map/place/search?query=' + curAddr;
                setTimeout(function(){
                let hidden = window.document.hidden || window.document.mozHidden || window.document.msHidden ||window.document.webkitHidden 
                if(typeof hidden =="undefined" || hidden ==false){
                    //App store下载地址
                    window.location.href = "https://itunes.apple.com";
                }
            }, 2000);
            return false;
        }
    })
    

    //调起高德地图
    $('.container').on('click', '#toGaodeMap', function() {
        window.location.href = ' https://uri.amap.com/marker?position=116.473195,39.993253&name='+ curAddr +'&src=mypage&coordinate=gaode&callnative=0';
       
    })

     //调起腾讯地图, 当用户手机中未安装腾讯地图APP时，可通过浏览器调起腾讯地图下载页，为用户提供下载(来自官方), 'key: 4KGBZ-6PPHS-DXYOU-6JZDH-CMCU5-4QFAN'
    $('.container').on('click', '#toTencentMap', function() {
        window.location.href = ' https://apis.map.qq.com/uri/v1/search?keyword='+curAddr+'&referer=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77';

    });
   

    //从cookie里获取当时要前往的地址值
    function getCurAddrCookie() {
        var cookies = document.cookie.split(';');
        for(var i = 0;i < cookies.length;i ++) {
            var temp = cookies[i].split("=");
            if(temp[0] == 'curAddr') return unescape(temp[1]);
        }
    }
       
    
  
    //经纬度转换成省名显示在选择框默认值
    // map.addEventListener('click', function(e) {console.log(e.latlng);})
    myGeo.getLocation(new BMap.Point( 121.48789949, 31.24916171), function(rs){
        var addComp = rs.addressComponents;
        // 无option添加option,作下接口返回判断
        var province = addComp.province;
        $('select[name=province] option[value=' + province +']').attr('selected', true);
    })
    
  
    }

	</script>
</body>
</html>