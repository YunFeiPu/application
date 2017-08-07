<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url()?>css/nav-menu.css" type="text/css" media="all" />
<!--[if lt IE 7]> <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url()?>css/ie6.css" type="text/css" media="all" /> <![endif]-->
<script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>scripts/nav-menu.js"></script>
</head>
<body scroll="auto">
    <form id="form1">
<div id="HEADER">
    <div id="LOGO"></div>
    <div id="NAV">
        <ul>
            <li class="nav selectedNav" rel="index"><a href="<?php echo base_url();?>">首页</a></li>
   <li class="nav" rel="client">财务</li>
    <!--     <li class="nav" rel="business">业务</li>
            <li class="nav" rel="work">工作</li>
            <li class="nav" rel="gift">礼品</li>
            <li class="nav" rel="finance">财务</li>
            <li class="nav" rel="setting">设置</li>
            <li class="nav" rel="system">系统</li>
            <li class="nav" rel="assistant">助理</li>-->
        </ul>
    </div>
    <div id="STATUS">
        <span id="loginStatus">您好 <span class="black"><?php 
        if(isset($username))
        { echo $username;}
        else {echo "noname";}?></span>, 今天是 <span class="black"><script type="text/javascript">                                                                                                getTime();</script></span>
         [<a href="/welcome/logout">注销</a>]</span>
        <span id="statusText"><a href="/">首页</a></span>
    </div>
</div>

<div id="MAIN">
    <div id="LEFT">
        <div style="height:10px;font-size:0;"></div>
        <!-- 首页左侧菜单 -->
        <div id="index" class="showMenu">
            <div class="folder">订单管理</div>
            <div class="list">
                <a href="/order/" class="item" target="main">查看订单</a>                
                <a href="/order/addtest" class="item " target="main">添加订单</a>
                <a href="/order/search" class="item " target="main">订单查询</a>
                <a href="/order/productbuy" class="item" target="main">物品采购单</a>
                <a href="/shiporder/index" class="item" target="main">采购分单</a>
                <a href="/shiporder/showshiporder" class="item " target="main">送货订单</a>
                 <a href="/tableexport/test" class="item" target="main">下载订单</a>
                 <a href="/tableexport/paybill" class="item lastItem" target="main">订单结算生成</a>
            </div>
            
            <div class="folder">订单结算</div>
            <div class="list">
                <a href="/order_confirm/" class="item" target="main">查看未处理订单</a>                
                <a href="/order_confirm/" class="item " target="main">添加订单</a>
                <a href="/order/productbuy" class="item" target="main">物品采购单</a>
                <a href="/order/productbuysp" class="item" target="main">采购分单</a>
                <a href="/order/categorycustom" class="item " target="main">送货订单</a>
                 <a href="/tableexport/test" class="item lastItem" target="main">下载订单</a>
                
            </div>
            
            <div class="folder">客户管理</div>
            <div class="list">
                <a href="/custom/" class="item" target="main">客户列表</a>
                <a href="/custom/add" class="item lastItem" target="main">添加客户</a>
            </div>
            <div class="folder">类别价格管理</div>
            <div class="list">
                <a href="/customgroup/" class="item" target="main">客户组</a>
                <a href="/customgroup/add" class="item" target="main">添加客户组</a>
                <a href="/customgroup/managecustom" class="item" target="main">管理组内客户</a>
                <a href="/product/groupprice" class="item" target="main">修改产品组价格</a>
                <a href="/groupproductprice/add" class="item lastItem" target="main">产品类别价格</a>
            </div>
            <div class="folder">产品管理</div>
            <div class="list">
                <a href="/product/" class="item" target="main">产品管理</a>
                <a href="/product/add" class="item" target="main">添加产品</a>
                <a href="/productcategory/index" class="item lastItem" target="main">产品类别</a>
            </div>
            <div class="folder">测试功能</div>
            <div class="list">
                <a href="/test/" class="item" target="main">快速入单</a>
                <a href="/test/" class="item" target="main">添加产品</a>
                <a href="/test/" class="item lastItem" target="main">产品类别</a>
            </div>
            <div class="folder lastFolder">帮助</div>
            <div class="list lastList">
                <a href="/welcome/update" class="item lastItem" target="main">帮助</a>
            </div>
        </div>

        <!-- 客户管理左侧菜单 -->
        <div id="client" class="hideMenu">
            <div class="folder">财务管理</div>
            <div class="list">
                <a href="/gonghuodan/index" class="item" target="main">供货单管理</a>
            <?php  if(isset($username) && ($username=="admin"||$username=='mastao')):?>

                <a href="/gonghuodan/yuebill" class="item" target = "main">月账单</a>
                <?php endif;?>
                                
                           <a href="/gonghuodan/createghd" class="item" target="main">生成供货单</a>
            <?php  if(isset($username) && $username=="admin"):
        
            ?>
                <a href="/gonghuodan/suodan" class="item" target="main">锁单</a>
 
                <a href="/gonghuodan/pay" class="item" target="main">打款</a>
                 <a href="/gonghuodan/testupload" class="item lastItem" target="main">测试上传</a>
                <?php endif;?>
            </div>
            <?php  if(isset($username) && $username=="admin"):
        
            ?>
            
            <div class="folder">其它</div>
            <div class="list">
           
                <a href="code/fjsdafjasklfjdsaklfjakl" class="item" target="main">清空并且生成供应商数据</a>
                <a href="code/fjsdafjasklfjdsaksflfjakl" class="item" target="main">清空锁单数据</a>
                <a href="code/fjsdafjasklfjdssflfjakl" class="item" target="main">清空供货单数据</a>
                <a href="code/assssdadfdfsda" class="item lastItem" target="main">批量生成锁单和供货单</a>
            </div>
            <?php endif;?>
            <div class="folder">客户类别管理</div>
            <div class="list">
                <a href="frmAdminCustomerTypeNewTop.aspx" class="item" target="main">添加新客户类别</a>
                <a href="frmAdminCustomerTypeMain.htm" class="item" target="main">客户类别管理</a>
                <a href="frmAdminCustomerTypeChoose.aspx" class="item lastItem" target="main">客户类别查看</a>
            </div>
            <div class="folder lastFolder">客户级别管理</div>
            <div class="list lastList">
                <a href="frmAdminCustomerGradeNew.aspx" class="item" target="main">添加新级别</a>
                <a href="frmAdminCustomerGradeInput.aspx" class="item" target="main">级别管理</a>
                <a href="frmAdminCustomerGradeInputCheck.aspx" class="item" target="main">级别审核</a>
                <a href="frmAdminCustomerGradeQuery.aspx" class="item lastItem" target="main">级别查看</a>
            </div>
        </div>
        
        
        
        
        
        
        

        <!-- 业务管理左侧菜单 -->
        <div id="business" class="hideMenu">
            <div class="folder">电话营销</div>
            <div class="list">
                <a href="javascript:;" class="item" target="main">申领客户资源</a>
                <a href="frmAdminTelSalesToaday.htm" class="item lastItem" target="main">每日电话营销</a>
            </div>
            <div class="folder">订单管理</div>
            <div class="list">
                <a href="frmAdminOrderOutputNew.aspx" class="item" target="main">我要签新订单</a>
                <a href="frmAdminOrderOutputQuery_1.aspx" class="item" target="main">我的待签订单</a>
                <a href="frmAdminOrderOutputQuery_3.aspx" class="item" target="main">我的订单查看</a>
                <a href="frmAdminOrderOutputQuery_4.aspx" class="item" target="main">我的未付款续费订单</a>
                <a href="frmAdminOrderOutputQuery_6.aspx" class="item" target="main">我的续费订单查看</a>
                <a href="frmAdminOrderOutputQuery_7.aspx" class="item" target="main">部门员工待签订单</a>
                <a href="frmAdminOrderOutputQuery_9.aspx" class="item" target="main">部门员工订单查看</a>
                <a href="frmAdminOrderOutputQuery_10.aspx" class="item" target="main">部门员工未付款续费订单</a>
                <a href="frmAdminOrderOutputQuery_12.aspx" class="item lastItem" target="main">部门员工续费订单查看</a>
            </div>
            <div class="folder closed">订单审核</div>
            <div class="list hideMenu">
                <a href="frmAdminOrderOutputCheck_1.aspx" class="item" target="main">待审核订单[竞价]</a>
                <a href="frmAdminOrderOutputCheck_2.aspx" class="item" target="main">待审核订单[网站]</a>
                <a href="frmAdminOrderOutputCheck_3.aspx" class="item" target="main">待审核订单[折扣]</a>
                <a href="frmAdminOrderOutputCheck_4.aspx" class="item" target="main">待审核订单[返现]</a>
                <a href="frmAdminOrderOutputCheck_5.aspx" class="item" target="main">待审核订单[赠礼]</a>
                <a href="frmAdminOrderOutputCheck_6.aspx" class="item" target="main">待审核订单[退单]</a>
                <a href="frmAdminOrderOutputMyCheck.aspx" class="item" target="main">我审核的订单</a>
                <a href="frmAdminOrderOutputCheck_7.aspx" class="item lastItem" target="main">待作废的订单</a>
            </div>
            <div class="folder closed">合同管理</div>
            <div class="list hideMenu">
                <a href="frmAdminContractTakeNo.aspx" class="item" target="main">待领取合同</a>
                <a href="frmAdminContractTakeYes.aspx" class="item" target="main">领取未签合同</a>
                <a href="frmAdminContractYes.aspx" class="item" target="main">已签单合同</a>
                <a href="frmAdminContractBackNo.aspx" class="item" target="main">待退还合同</a>
                <a href="frmAdminContractBackYes.aspx" class="item" target="main">已退还合同</a>
                <a href="frmAdminContractTypeNewTop.aspx" class="item" target="main">添加新合同类别</a>
                <a href="frmAdminContractTypeMain.htm" class="item" target="main">合同类别管理</a>
                <a href="frmAdminContractTypeChoose.aspx" class="item lastItem" target="main">合同类别查看</a>
            </div>
            <div class="folder closed">排行榜</div>
            <div class="list hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">商务大区排名</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门排名</a>
                <a href="frmAdminMenu1.aspx#frmAdminWait.aspx" class="item" target="main">百度精英榜</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">销售龙虎榜</a>
            </div>
            <div class="folder closed">客服业务</div>
            <div class="list hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">待[已]处理百度新增订单</a>
                <a href="frmAdminWait.aspx" class="item" target="main">待[已]处理百度续费订单</a>
                <a href="frmAdminWait.aspx" class="item" target="main">待处理其他新增订单</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我维护的客户</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工维护的客户</a>
                <a href="frmAdminWait.aspx" class="item" target="main">点击消费任务分配</a>
                <a href="frmAdminMenu1.aspx#frmAdminWait.aspx" class="item lastItem" target="main">点击消费完成进度</a>
            </div>
            <div class="folder lastFolder lastClosed">业绩/提成/工资</div>
            <div class="list lastList hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">百度新增任务设置</a>
                <a href="frmAdminWait.aspx" class="item" target="main">百度新增任务修改</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我的业绩</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我的提成</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我的薪资</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工的业绩[汇总]</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工的业绩[明细]</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工的平均月单产</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工的提成[汇总]</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工的提成[明细]</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工的薪资</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门团队的业绩[汇总]</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门团队的业绩[明细]</a>
                <a href="frmAdminWait.aspx" class="item" target="main">本机构业绩[汇总]</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">本机构业绩[明细]</a>
            </div>
        </div>

        <!-- 工作管理左侧菜单 -->
        <div id="work" class="hideMenu">
            <div class="folder">EMS邮寄管理</div>
            <div class="list">
                <a href="frmAdminWait.aspx" class="item" target="main">EMS快递公司管理</a>
                <a href="frmAdminWait.aspx" class="item" target="main">EMS打印设置</a>
                <a href="frmAdminWait.aspx" class="item" target="main">EMS基本信息设置</a>
                <a href="frmAdminWait.aspx" class="item" target="main">常用邮寄地址添加</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">常用邮寄地址管理</a>
            </div>
            <div class="folder">IDC业务管理</div>
            <div class="list">
                <a href="frmAdminWait.aspx" class="item" target="main">IDC服务接口配置</a>
                <a href="frmAdminWait.aspx" class="item" target="main">域名默认设置</a>
                <a href="frmAdminWait.aspx" class="item" target="main">待注册的域名</a>
                <a href="frmAdminWait.aspx" class="item" target="main">已经注册的域名</a>
                <a href="frmAdminWait.aspx" class="item" target="main">已经到期的域名</a>
                <a href="frmAdminWait.aspx" class="item" target="main">待续费的域名</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">我客户的域名</a>
            </div>
            <div class="folder">空间管理</div>
            <div class="list">
                <a href="frmAdminWait.aspx" class="item" target="main">待开通[续费]的空间订单</a>
                <a href="frmAdminWait.aspx" class="item" target="main">已开通空间</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">到期空间</a>
            </div>
            <div class="folder closed">邮局管理</div>
            <div class="list hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">待开通[续费]的邮局订单</a>
                <a href="frmAdminWait.aspx" class="item" target="main">已开通邮局</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">到期邮局</a>
            </div>
            <div class="folder closed">定制网站管理</div>
            <div class="list hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">待制作项目订单</a>
                <a href="frmAdminWait.aspx" class="item" target="main">收到的项目</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">部门的全部项目</a>
            </div>
            <div class="folder closed">信息管理</div>
            <div class="list hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">信息分类管理</a>
                <a href="frmAdminWait.aspx" class="item" target="main">信息分类添加</a>
                <a href="frmAdminWait.aspx" class="item" target="main">信息分类移动</a>
                <a href="frmAdminWait.aspx" class="item" target="main">信息分类合并</a>
                <a href="frmAdminWait.aspx" class="item" target="main">发布我的新信息</a>
                <a href="frmAdminWait.aspx" class="item" target="main">已发布信息管理</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">浏览我收到的信息</a>
            </div>
            <div class="folder lastFolder lastClosed">风采展示管理</div>
            <div class="list lastList hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">风采展示分类管理</a>
                <a href="frmAdminWait.aspx" class="item" target="main">风采展示分类添加</a>
                <a href="frmAdminWait.aspx" class="item" target="main">风采站直分类移动</a>
                <a href="frmAdminWait.aspx" class="item" target="main">风采展示分类合并</a>
                <a href="frmAdminWait.aspx" class="item" target="main">发布新风采展示</a>
                <a href="frmAdminWait.aspx" class="item" target="main">已发布风采展示管理</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">浏览风采展示</a>
            </div>
        </div>

        <!-- 礼品管理左侧菜单 -->
        <div id="gift" class="hideMenu">
            <div class="folder">礼品管理</div>
            <div class="list">
                <a href="frmAdminOrderInputNew.aspx" class="item" target="main">采购入库</a>
                <a href="frmAdminOrderInput.aspx" class="item" target="main">采购管理</a>
                <a href="frmAdminOrderInputCheck.aspx" class="item" target="main">采购审核</a>
                <a href="frmAdminOrderInputQuery.aspx" class="item" target="main">采购查看</a>
                <a href="frmAdminGiftQuantity.aspx" class="item" target="main">礼品库存</a>
                <a href="frmAdminGiftTakeNo.aspx" class="item" target="main">待领取礼品</a>
                <a href="frmAdminGiftTakeYes.aspx" class="item" target="main">已领取礼品</a>
                <a href="frmAdminGiftBackNo.aspx" class="item" target="main">待退回礼品</a>
                <a href="frmAdminGiftBackYes.aspx" class="item lastItem" target="main">已退回礼品</a>
            </div>
            <div class="folder">礼品设置</div>
            <div class="list">
                <a href="frmAdminGiftNew.aspx" class="item" target="main">添加新礼品</a>
                <a href="frmAdminGiftInput.aspx" class="item" target="main">礼品管理</a>
                <a href="frmAdminGiftInputCheck.aspx" class="item" target="main">礼品审核</a>
                <a href="frmAdminGiftQuery.aspx" class="item" target="main">礼品查看</a>
                <a href="frmAdminGiftMove.aspx" class="item" target="main">礼品转移</a>
                <a href="frmAdminGiftTypeNewTop.aspx" class="item" target="main">添加新礼品类别</a>
                <a href="frmAdminGiftTypeMain.htm" class="item" target="main">礼品类别管理</a>
                <a href="frmAdminGiftTypeChoose.aspx" class="item lastItem" target="main">礼品类别查看</a>
            </div>
            <div class="folder lastFolder lastClosed">活动管理</div>
            <div class="list lastList hideMenu">
                <a href="frmAdminPromotionalNew.aspx" class="item" target="main">发布活动</a>
                <a href="frmAdminPromotionalInput.aspx" class="item" target="main">活动管理</a>
                <a href="frmAdminPromotionalInputCheck.aspx" class="item" target="main">活动审核</a>
                <a href="frmAdminPromotionalQuery.aspx" class="item" target="main">活动查看</a>
                <a href="frmAdminPromotionalMove.aspx" class="item" target="main">活动转移</a>
                <a href="frmAdminPromotionalTypeNewTop.aspx" class="item" target="main">添加新活动类别</a>
                <a href="frmAdminPromotionalTypeMain.htm" class="item" target="main">活动类别管理</a>
                <a href="frmAdminPromotionalTypeChoose.aspx" class="item lastItem" target="main">活动类别查看</a>
            </div>
        </div>

        <!-- 财务管理左侧菜单 -->
        <div id="finance" class="hideMenu">
            <div class="folder">财务管理</div>
            <div class="list">
                <a href="frmAdminWait.aspx" class="item" target="main">账簿管理</a>
                <a href="frmAdminWait.aspx" class="item" target="main">应收款列表</a>
                <a href="frmAdminWait.aspx" class="item" target="main">应退款列表</a>
                <a href="frmAdminWait.aspx" class="item" target="main">营业外收入记账[正数]</a>
                <a href="frmAdminWait.aspx" class="item" target="main">营业外收入记账[负数]</a>
                <a href="frmAdminWait.aspx" class="item" target="main">支出帐记账</a>
                <a href="frmAdminWait.aspx" class="item" target="main">员工归还借款</a>
                <a href="frmAdminWait.aspx" class="item" target="main">账簿明细查询</a>
                <a href="frmAdminWait.aspx" class="item" target="main">账簿余额查询</a>
                <a href="frmAdminWait.aspx" class="item" target="main">账簿收支汇总查询</a>
                <a href="frmAdminWait.aspx" class="item" target="main">账簿资金内调</a>
                <a href="frmAdminWait.aspx" class="item" target="main">折旧记账</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">折旧查询</a>
            </div>
            <div class="folder closed">薪资管理</div>
            <div class="list hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">发出工资的银行卡</a>
                <a href="frmAdminWait.aspx" class="item" target="main">待录入薪资的员工</a>
                <a href="frmAdminWait.aspx" class="item" target="main">已录[未发]薪资的员工</a>
                <a href="frmAdminWait.aspx" class="item" target="main">按部门批量录入</a>
                <a href="frmAdminWait.aspx" class="item" target="main">按部门批量发放</a>
                <a href="frmAdminWait.aspx" class="item" target="main">当月薪资简表</a>
                <a href="frmAdminWait.aspx" class="item" target="main">生成招行批量文件</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">生成工行批量文件</a>
            </div>
            <div class="folder closed">收据/发票管理</div>
            <div class="list hideMenu">
                <a href="frmAdminCustomerBillTakeNo.aspx" class="item" target="main">待领收据/发票</a>
                <a href="frmAdminCustomerBillTakeYes.aspx" class="item" target="main">已领收据/发票</a>
                <a href="frmAdminCustomerBillBackNo.aspx" class="item" target="main">待退回收据/发票</a>
                <a href="frmAdminCustomerBillBackYes.aspx" class="item lastItem" target="main">已退回收据/发票</a>
            </div>
            <div class="folder lastFolder lastClosed">考勤管理</div>
            <div class="list lastList hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">工作日设置</a>
                <a href="frmAdminWait.aspx" class="item" target="main">工作时间设置</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我要打卡</a>
                <a href="frmAdminWait.aspx" class="item" target="main">不参与考勤人员管理</a>
                <a href="frmAdminWait.aspx" class="item" target="main">缺勤管理</a>
                <a href="frmAdminWait.aspx" class="item" target="main">每日考勤记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工考勤记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我的考勤记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">考勤月报</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我要请假</a>
                <a href="frmAdminWait.aspx" class="item" target="main">代请假</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我的请假记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工请假记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">待审核请假信息</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我审核的请假记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">各职务审核请假天数设置</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我的出访记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工出访记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">机构员工出访记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我要出差</a>
                <a href="frmAdminWait.aspx" class="item" target="main">我的出差申请记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">部门员工出差申请记录</a>
                <a href="frmAdminWait.aspx" class="item" target="main">待审核出差申请记录</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">已审核出差申请记录</a>
            </div>
        </div>

        <!-- 基本设置左侧菜单 -->
        <div id="setting" class="hideMenu">
            <div class="folder">员工管理</div>
            <div class="list">
                <a href="frmAdminMemberNew.aspx" class="item" target="main">添加新员工</a>
                <a href="frmAdminMemberInput.aspx" class="item" target="main">员工管理</a>
                <a href="frmAdminMemberInputCheck.aspx" class="item" target="main">员工审核</a>
                <a href="frmAdminMemberQuery.aspx" class="item" target="main">员工查看</a>
                <a href="frmAdminMemberQueryDepartment.aspx" class="item lastItem" target="main">部门员工查看</a>
            </div>
            <div class="folder">元素管理</div>
            <div class="list">
                <a href="frmAdminElementNew.aspx" class="item" target="main">添加新元素</a>
                <a href="frmAdminElementInput.aspx" class="item" target="main">元素管理</a>
                <a href="frmAdminElementInputCheck.aspx" class="item" target="main">元素审核</a>
                <a href="frmAdminElementQuery.aspx" class="item" target="main">元素查看</a>
                <a href="frmAdminElementMove.aspx" class="item" target="main">元素转移</a>
                <a href="frmAdminElementTypeNewTop.aspx" class="item" target="main">添加新元素类别</a>
                <a href="frmAdminElementTypeMain.htm" class="item" target="main">元素分类管理</a>
                <a href="frmAdminElementTypeChoose.aspx" class="item lastItem" target="main">元素分类查看</a>
            </div>
            <div class="folder closed">产品管理</div>
            <div class="list hideMenu">
                <a href="frmAdminProductNew.aspx" class="item" target="main">添加新产品</a>
                <a href="frmAdminProductInput.aspx" class="item" target="main">产品管理</a>
                <a href="frmAdminProductInputCheck.aspx" class="item" target="main">产品审核</a>
                <a href="frmAdminProductQuery.aspx" class="item" target="main">产品查看</a>
                <a href="frmAdminProductMove.aspx" class="item" target="main">产品转移</a>
                <a href="frmAdminProductTypeNewTop.aspx" class="item" target="main">添加新产品类别</a>
                <a href="frmAdminProductTypeMain.htm" class="item" target="main">产品分类管理</a>
                <a href="frmAdminProductTypeChoose.aspx" class="item lastItem" target="main">产品分类查看</a>
            </div>
            <div class="folder closed">物品管理</div>
            <div class="list hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">添加新物品</a>
                <a href="frmAdminWait.aspx" class="item" target="main">物品类型</a>
                <a href="frmAdminWait.aspx" class="item" target="main">物品入库</a>
                <a href="frmAdminWait.aspx" class="item" target="main">物品管理</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">物品转移机构确认</a>
            </div>
            <div class="folder closed">供应商管理</div>
            <div class="list hideMenu">
                <a href="frmAdminProviderNew.aspx" class="item" target="main">添加新供应商</a>
                <a href="frmAdminProviderInput.aspx" class="item" target="main">供应商管理</a>
                <a href="frmAdminProviderInputCheck.aspx" class="item" target="main">供应商审核</a>
                <a href="frmAdminProviderQuery.aspx" class="item" target="main">供应商查看</a>
                <a href="frmAdminProviderMove.aspx" class="item" target="main">供应商转移</a>
                <a href="frmAdminProviderMoveAreaType.aspx" class="item" target="main">供应商地区转移</a>
                <a href="frmAdminProviderTypeNewTop.aspx" class="item" target="main">添加新供应商类别</a>
                <a href="frmAdminProviderTypeMain.htm" class="item" target="main">供应商类别管理</a>
                <a href="frmAdminProviderTypeChoose.aspx" class="item lastItem" target="main">供应商类别查看</a>
            </div>
            <div class="folder closed">字典管理</div>
            <div class="list hideMenu">
                <a href="frmAdminDictionaryNew.aspx" class="item" target="main">添加新字典</a>
                <a href="frmAdminDictionaryInput.aspx" class="item" target="main">字典管理</a>
                <a href="frmAdminDictionaryInputCheck.aspx" class="item" target="main">字典审核</a>
                <a href="frmAdminDictionaryQuery.aspx" class="item" target="main">字典查看</a>
                <a href="frmAdminDictionaryMove.aspx" class="item" target="main">字典转移</a>
                <a href="frmAdminDictionaryTypeNewTop.aspx" class="item" target="main">添加新字典类别</a>
                <a href="frmAdminDictionaryTypeMain.htm" class="item" target="main">字典类别管理</a>
                <a href="frmAdminDictionaryTypeChoose.aspx" class="item lastItem" target="main">字典类别查看</a>
            </div>
            <div class="folder closed">级别管理</div>
            <div class="list hideMenu">
                <a href="frmAdminGradeNew.aspx" class="item" target="main">添加新级别</a>
                <a href="frmAdminGradeInput.aspx" class="item" target="main">级别管理</a>
                <a href="frmAdminGradeInputCheck.aspx" class="item" target="main">级别审核</a>
                <a href="frmAdminGradeQuery.aspx" class="item lastItem" target="main">级别查看</a>
            </div>
            <div class="folder closed">地区管理</div>
            <div class="list hideMenu">
                <a href="frmAdminAreaTypeNewTop.aspx" class="item" target="main">添加新地区</a>
                <a href="frmAdminAreaTypeMain.htm" class="item" target="main">地区管理</a>
                <a href="frmAdminAreaTypeChoose.aspx" class="item lastItem" target="main">地区查看</a>
            </div>
            <div class="folder lastFolder lastClosed">行业管理</div>
            <div class="list lastList hideMenu">
                <a href="frmAdminIndustryNewTop.aspx" class="item" target="main">添加新行业</a>
                <a href="frmAdminIndustryMain.htm" class="item" target="main">行业管理</a>
                <a href="frmAdminIndustryChoose.aspx" class="item lastItem" target="main">行业查看</a>
            </div>
        </div>

        <!-- 系统设置左侧菜单 -->
        <div id="system" class="hideMenu">
            <div class="folder">选项设置</div>
            <div class="list">
                <a href="frmAdminCompanyModifySet.aspx" class="item" target="main">系统选项修改</a>
                <a href="frmAdminBranchModifySet.aspx" class="item lastItem" target="main">选项资料修改</a>
            </div>
            <div class="folder">角色设置</div>
            <div class="list">
                <a href="frmAdminRoleNew.aspx" class="item" target="main">添加新角色</a>
                <a href="frmAdminRoleInput.aspx" class="item" target="main">角色管理</a>
                <a href="frmAdminRoleQuery.aspx" class="item" target="main">角色查看</a>
                <a href="frmAdminRoleInputPower.aspx" class="item lastItem" target="main">权限设置</a>
            </div>
            <div class="folder">部门管理</div>
            <div class="list">
                <a href="frmAdminDepartmentNewTop.aspx" class="item" target="main">添加新部门</a>
                <a href="frmAdminDepartmentMain.htm" class="item" target="main">部门管理</a>
                <a href="frmAdminDepartmentChoose.aspx" class="item" target="main">部门查看</a>
                <a href="frmAdminMemberMoveDepartment.aspx" class="item lastItem" target="main">部门转移</a>
            </div>
            <div class="folder">部门分配管理</div>
            <div class="list">
                <a href="frmAdminAssemblyNew.aspx" class="item" target="main">添加新部门分配</a>
                <a href="frmAdminAssemblyInput.aspx" class="item" target="main">部门分配管理</a>
                <a href="frmAdminAssemblyInputCheck.aspx" class="item" target="main">部门分配审核</a>
                <a href="frmAdminAssemblyQuery.aspx" class="item lastItem" target="main">部门分配查看</a>
            </div>
            <div class="folder closed">职务管理</div>
            <div class="list hideMenu">
                <a href="frmAdminPositionNewTop.aspx" class="item" target="main">添加新职务</a>
                <a href="frmAdminPositionMain.htm" class="item" target="main">职务管理</a>
                <a href="frmAdminPositionChoose.aspx" class="item lastItem" target="main">职务查看</a>
            </div>
            <div class="folder closed">选项管理</div>
            <div class="list hideMenu">
                <a href="frmAdminBranchNewTop.aspx" class="item" target="main">添加新选项</a>
                <a href="frmAdminBranchMain.htm" class="item" target="main">选项管理</a>
                <a href="frmAdminBranchChoose.aspx" class="item lastItem" target="main">选项查看</a>
            </div>
            <div class="folder closed">分公司管理</div>
            <div class="list hideMenu">
                <a href="frmAdminCorporationNewTop.aspx" class="item" target="main">添加新分公司</a>
                <a href="frmAdminCorporationMain.htm" class="item" target="main">分公司管理</a>
                <a href="frmAdminCorporationChoose.aspx" class="item" target="main">分公司查看</a>
                <a href="frmAdminCorporationChange.aspx" class="item lastItem" target="main">分公司选择</a>
            </div>
            <div class="folder closed">登陆日志</div>
            <div class="list hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">登陆日志查看</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">登陆日志清理</a>
            </div>
            <div class="folder lastFolder lastClosed">操作日志</div>
            <div class="list lastList hideMenu">
                <a href="frmAdminWait.aspx" class="item" target="main">操作日志查看</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">操作日志清理</a>
            </div>
        </div>

        <!-- 个人助理左侧菜单 -->
        <div id="assistant" class="hideMenu">
            <div class="folder">个人助理</div>
            <div class="list">
                <a href="frmAdminMemberPassword.aspx" class="item" target="main">修改登陆密码</a>
                <a href="frmAdminWait.aspx" class="item" target="main">员工通讯录</a>
                <a href="frmAdminWait.aspx" class="item lastItem" target="main">修改个人信息</a>
            </div>
            <div class="folder">留言板</div>
            <div class="list">
                <a href="frmAdminMentionNew.aspx" class="item" target="main">添加新留言</a>
                <a href="frmAdminMentionInput.aspx" class="item" target="main">留言管理</a>
                <a href="frmAdminMentionQuery.aspx" class="item lastItem" target="main">留言查看</a>
            </div>
            <div class="folder lastFolder">帮助</div>
            <div class="list lastList">
                <a href="/welcome/update" class="item lastItem" target="main">帮助</a>
            </div>
        </div>
        <div style="height:10px;font-size:0;"></div>
    </div>

    <div id="RIGHT">
        <iframe name="main" src="<?php echo base_url()?>welcome/hello" frameborder="0" marginheight="0" marginwidth="0" border="0" width="100%"></iframe>
    </div>
</div>
    </form>
</body>
</html>
