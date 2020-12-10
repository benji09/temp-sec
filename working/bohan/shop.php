<?php $active_uri = 'service';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,  viewport-fit=cover">
    <meta name="keywords" content="idemitsu,出光,出光润滑油,汽车用润滑油,工业用润滑油" /> 
    <meta name="description" content="出光润滑油(中国)有限公司【IDEMITSU LUBE CHINA Co.，Ltd.】是一家在中国主要从事润滑油生产、销售和研究的公司，也是出光集团中的主要公司之一。" /> 
    <title>IDEMITSU LUBE CHINA 出光润滑油（中国）有限公司</title> 
    <link rel="stylesheet" href="/lube/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/lube/assets/font/iconfont.css">
    <link rel="stylesheet" href="/lube/assets/css/common.min.css">
    <link rel="stylesheet" href="/lube/assets/css/shop.min.css">
</head>
<body>
	<?php include('header.php');?>
    <div class="container">
        <div class="row custom-breadcrumb d-none d-lg-block">
            <a href="/lube/">首页</a> &gt;
            <span>代理店</span>
        </div>
        <h2 class="page-title">代理店</h2>
        <div class="row main-shadow">
            <div class="sales-search text-center col-12">
                <form class="form-inline flex-column">
                    <div class="form-group">
                        请选择代理店所属区域&nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="select-group">
                            <select name="province" class="form-control">
							<option value="">全部</option>
							<?php foreach($data['province_list'] as $v) { ?>
							<option value="<?php echo $v['id'];?>" <?php if ($v['id']==$data['search']['province']) { ?>selected<?php } ?>><?php echo $v['name'];?></option>
							<?php } ?>                                
                            </select>
                            <select name="city" class="form-control">
							<option value="">全部</option>
							<?php foreach($data['city_list'] as $v) { ?>
							<option value="<?php echo $v['id'];?>" <?php if ($v['id']==$data['search']['city']) { ?>selected<?php } ?>><?php echo $v['name'];?></option>
							<?php } ?>                                
                            </select>
                            <input type="submit" value="搜索" class="btn btn-default link-shadow">
                        </div>
                    </div>
					<p class="tip">* 仅显示有代理店的区域</p>
                </form>
            </div>
            <div class="sales-result col-12">
                <h3><?php echo $data['search_title'];?>代理店搜索结果</h3>
                <ul class="row">
					<?php $i=0;foreach($data['item'] as $v) { ?>
                    <li class="col-12 col-lg-4">
                        <p class="company"><?php echo $v['name'];?><span><?php echo $v['type'];?></span></p>
                        <p class="address">地址：<span><?php echo $data['citys'][$v['province']]['name'];?> <?php echo $data['citys'][$v['city']]['name'];?> <?php echo $v['address'];?></span></p>
                        <p class="phone">电话：<span><?php echo $v['contact_number'];?></span></p>
                        <p class="name">联系人：<span><?php echo $v['contact'];?></span></p>
                        <?php if (in_array($v['type'], array('授权贩卖店', '高级形象店')) && $_GET['action']=='preview'){ ?><p class="name"><a href="/lube/shop/<?php echo $v['id'];?>.html">&gt;&gt;查看店铺详情</a></p><?php } ?>
                    </li>
					<?php
					$i++;
					if ($i%3==0) { echo '<li class="clearfix visible-md-block visible-lg-block"></li>';}
					}
					?>
                </ul>
            </div>
			<div class="col-12 text-center mb-3">
			    <nav style="display: inline-block;">
    				<?php echo $data['pagination'];?>
    			</nav>
			</div>
        </div>
    </div>
	<!-- <?php include('footer.php');?> -->
    <script src="/lube/assets/js/jquery-3.5.1.min.js" id="jquery"></script>
    <script src="/lube/assets/js/bootstrap.min.js"></script>
    <script src="/lube/assets/js/index.js"></script>
    <script>
	$(function(){
		$('select[name=province]').change(function(){
			getCityVal();
		})
	})
	function getCityVal()
	{
		var province = $('select[name=province]').val();
		$.getJSON("/lube/getcity", {province:province}, function(json){
			var city = $('select[name=city]');
			$('option', city).remove();
			$(city).prepend("<option value='' select>全部</option>");
			$.each(json,function(index, arr){
				var option = "<option value='"+arr['id']+"'>"+arr['name']+"</option>";
				city.append(option);
			});
		});
	}
	</script>
</body>
</html>