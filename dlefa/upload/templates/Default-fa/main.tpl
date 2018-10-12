<!DOCTYPE html>
<html[available=lostpassword|register] class="page_form_style"[/available]>
<head>
	{headers}
	<meta name="HandheldFriendly" content="true">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width"> 
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">

	<link rel="shortcut icon" href="{THEME}/images/favicon.ico">
	<link rel="apple-touch-icon" href="{THEME}/images/touch-icon-iphone.png">
	<link rel="apple-touch-icon" sizes="76x76" href="{THEME}/images/touch-icon-ipad.png">
	<link rel="apple-touch-icon" sizes="120x120" href="{THEME}/images/touch-icon-iphone-retina.png">
	<link rel="apple-touch-icon" sizes="152x152" href="{THEME}/images/touch-icon-ipad-retina.png">

	<link href="{THEME}/css/engine.css" type="text/css" rel="stylesheet">
	<link href="{THEME}/css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
	[not-available=lostpassword|register]
	<div class="page[available=showfull] showfull[/available]">
		<div class="wrp">
			<!-- Header -->
			<header id="header">
				<!-- Search -->
				<form id="q_search" class="rightside" method="post">
					<div class="q_search">
						<input id="story" name="story" placeholder="جستجو در سایت..." type="search">
						<button class="btn q_search_btn" type="submit" title="جستجو"><svg class="icon icon-search"><use xlink:href="#icon-search"></use></svg><span class="title_hide">جستجو</span></button>
						<a class="q_search_adv" href="/index.php?do=search&amp;mode=advanced" title="جستجوی پیشرفته"><svg class="icon icon-set"><use xlink:href="#icon-set"></use></svg><span class="title_hide">جستجوی پیشرفته</span></a>
					</div>
					<input type="hidden" name="do" value="search">
					<input type="hidden" name="subaction" value="search">
				</form>
				<!-- / Search -->
				<div class="header">
					<div class="wrp">
						<div class="midside">
							<div id="header_menu">
								<!-- Logo -->
								<a class="logotype" href="/">
									<span class="logo_icon"><svg class="icon icon-logo"><use xlink:href="#icon-logo"></use></svg></span>
									<span class="logo_title">همیار دیتالایف انجین</span>
								</a>
								<!-- / Logo -->
								<!-- main menu -->
								<nav id="top_menu">
									{include file="modules/topmenu.tpl"}
								</nav>
								<!-- / main menu -->
								<!-- menu button -->
								<button id="mobile_menu_btn">
									<span class="menu_toggle">
										<i class="mt_1"></i><i class="mt_2"></i><i class="mt_3"></i>
									</span>
									<span class="menu_toggle__title">
										فهرست
									</span>
								</button>
								<!-- / menu button -->
								{login}
								<!-- menu button -->
								<button id="search_btn">
									<span>
										<svg class="icon icon-search"><use xlink:href="#icon-search"></use></svg>
										<svg class="icon icon-cross"><use xlink:href="#icon-cross"></use></svg>
									</span>
								</button>
								<!-- / menu button -->
							</div>
						</div>
						<div id="cat_menu">
							<nav class="cat_menu">
								<div class="cat_menu__tm">{include file="modules/topmenu.tpl"}</div>
								{catmenu}
							</nav>
							<div class="soc_links">
								<a class="soc_vk" href="#" title="VK">
									<svg class="icon icon-vk"><use xlink:href="#icon-vk"></use></svg>
								</a>
								<a class="soc_tw" href="#" title="Twitter">
									<svg class="icon icon-tw"><use xlink:href="#icon-tw"></use></svg>
								</a>
								<a class="soc_fb" href="#" title="Facebook">
									<svg class="icon icon-fb"><use xlink:href="#icon-fb"></use></svg>
								</a>
								<a class="soc_gp" href="#" title="Google">
									<svg class="icon icon-gp"><use xlink:href="#icon-gp"></use></svg>
								</a>
							</div>
						</div>
					</div>
				</div>
			</header>
			<!-- / Header -->
			<div class="conteiner">
				<div class="midside">
					<div class="content_top">
					{include file="modules/carousel.tpl"}
					{include file="modules/pagetools.tpl"}
					</div>
					<section id="content">
						{info}
						[page-title]<div class="box box_in story"><h2 class="title">{page-title}</h2>{page-description}</div>[/page-title]
						[available=lastcomments]
						<div class="box">
							<h1 class="heading h4">آخرین نظرات</h1>
							<div class="com_list">
								{content}
							</div>
						</div>
						[/available]
						[not-available=lastcomments]
						{content}
						[/not-available]
					</section>
					{include file="modules/footside.tpl"}
				</div>
				{include file="modules/rightside.tpl"}
			</div>
			{include file="modules/footmenu.tpl"}
		</div>
		{include file="modules/footer.tpl"}
	</div>
	[/not-available]
	[available=lostpassword|register]
		<div class="page_form">
			<a class="page_form__back" href="/" title="بازگشت به صفحه نخست"><svg class="icon icon-left"><use xlink:href="#icon-right"></use></svg></a>
			<div class="page_form__body">
				<div class="page_form__logo">
					<!-- Logo -->
					<a href="/">
						<svg class="icon icon-logo"><use xlink:href="#icon-logo"></use></svg>
						<span class="title_hide">دیتالایف انجین</span>
					</a>
					<!-- / Logo -->
				</div>
				{info}
				{content}
				<div class="page_form__foot grey">
					{include file="modules/copyright.tpl"}
				</div>
			</div>
		</div>
	[/available]
	{AJAX}
	<script src="{THEME}/js/lib.js"></script>
	<script>
		jQuery(function($){
			$.get("{THEME}/images/sprite.svg", function(data) {
			  var div = document.createElement("div");
			  div.innerHTML = new XMLSerializer().serializeToString(data.documentElement);
			  document.body.insertBefore(div, document.body.childNodes[0]);
			});
		});
	</script>
</body>
</html>