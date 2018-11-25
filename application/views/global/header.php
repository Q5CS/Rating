<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <base href='<?php echo base_url();?>' />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食堂窗口评价系统</title>
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
    <link rel="stylesheet" href="assets/css/amazeui.css"/>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/global.css?v=2">
    <?php
    for ($i=1; $i<=count($add_css); $i++) {
        echo '<link href="assets/css/'. $add_css[$i-1] . '" rel="stylesheet">' . PHP_EOL;
    }
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-78734040-7"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-78734040-7');
    </script>
</head>
<body>

<!--[if lte IE 8]>
<div class="ie-must-go-die">
  <div class="ie-container">
    <h1>
      您正在使用IE
    </h1>
    <p>
      少女H也曾依赖过IE，借此来窥探这个世界。
      <br>
      但IE毕竟已然老去，早已无法适应这个绚丽的时代。
      <br>
      他的职责既已完成，不如就任其安然睡去吧——
      <br>
      毕竟，这个时代是属于现代浏览器的。
    </p>
    <a href="https://api.i-meto.com/chrome" target="_blank">
      您可以点击此处，下载Chrome后再次打开本页面。
    </a>
  </div>
</div>
<![endif]-->

 <header class="am-topbar am-topbar-inverse">
    <h1 class="am-topbar-brand">
        <a href="" class="am-text-ir"></a>
    </h1>

<?php
if ($logged) {
    echo '
    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only" data-am-collapse="{target: \'#doc-topbar-collapse-2\'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
    <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse-2">
    <ul class="am-nav am-nav-pills am-topbar-nav">
      <li><a href="/">首页</a></li>';

    echo'
    </ul>

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
        <li><a id="a-logout" href="javascript:;"><span class="am-icon-close"></span> 退出</a></li>
    </ul>
    </ul>
    </div>
    <script>var login = true;</script>
        ';
} else {
    echo '<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only" data-am-collapse="{target: \'#doc-topbar-collapse-2\'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
    <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse-2">
    <ul class="am-nav am-nav-pills am-topbar-nav">
    <li><a href="/main/login">登录</a></li>
    </ul>
    </div>
    <script>var login = false;</script>
    ';
}
?>
</header>

<div class="am-cf admin-main">
<div class="am-container">
