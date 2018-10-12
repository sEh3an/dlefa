[not-available=showfull]
<aside class="rightside">
	<!-- Popular articles -->
	<div class="block top_block">
		<h4 class="title"><b>برترین مطالب</b></h4>
		<ol class="topnews">
			{topnews}
		</ol>
	</div>
	<!-- / Popular articles -->
	<!-- Banner 300X250 -->
	<div class="banner banner_300">
		<img src="{THEME}/images/tmp/banner_300x250.png" alt="">
	</div>
	<!-- / Banner 300X250 -->
	<!-- Banner 240X400 -->
	<div class="banner banner_240">
		<img src="{THEME}/images/tmp/banner_240x400.png" alt="">
	</div>
	<!-- / Banner 240X400 -->
	{vote}
	[available=main|cat]
	<!-- archive -->
	<div class="block arch_block">
		<div class="title h4 title_tabs">
			<h4>آرشیو خبری</h4>
			<ul>
				<li class="active">
					<a title="View as calendar" href="#arch_calendar" aria-controls="arch_calendar" data-toggle="tab">
						<svg class="icon icon-calendar"><use xlink:href="#icon-calendar"></use></svg><span class="title_hide">تقویم</span>
					</a>
				</li>
				<li>
					<a title="View as list" href="#arch_list" aria-controls="arch_list" data-toggle="tab">
						<svg class="icon icon-archive"><use xlink:href="#icon-archive"></use></svg><span class="title_hide">لیست ماهانه</span>
					</a>
				</li>
			</ul>
		</div>
		<div class="tab-content">
			<div class="tab-pane active" id="arch_calendar">{calendar}</div>
			<div class="tab-pane" id="arch_list">{archives}</div>
		</div>
	</div>
	<!-- / archive -->
	<!-- Design change-->
	<div class="block_bg change_skin">
		<h4 class="title">قالب</h4>
		<div class="styled_select">
			{changeskin}
			<svg class="icon icon-down"><use xlink:href="#icon-down"></use></svg>
		</div>
	</div>
	<!-- / Design change-->
	[/available]
	<!-- Tags Cloud-->
	<div class="block tags_block">
		<h4 class="title"><b>برچسب ها</b></h4>
		<div class="tag_list">
			{tags}
		</div>
	</div>
	<!-- / Tags -->
	<!-- Latest Comments -->
	[available=main]
	<div class="block top_block">
		<h4 class="title"><b>آخرین نظرات</b></h4>
		<ul class="lastcomm">
			{customcomments template="modules/lastcomments" available="global" from="0" limit="5" order="date" sort="desc" cache="yes"}
		</ul>
	</div>
	[/available]
	<!-- / Latest Comments -->
</aside>
[/not-available]