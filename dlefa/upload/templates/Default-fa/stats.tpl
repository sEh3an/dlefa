<article class="box story">
	<div class="box_in dark_top stats_head">
		<h1 class="title">آمار وب سایت</h1>
		<ul>
			<li class="stats_d"><b>امروز</b> <span>{news_day} خبر، {comm_day} نظر و {user_day} کاربر</span></li>
			<li class="stats_w"><b>هفته اخیر</b> <span>{news_week} خبر، {comm_week} نظر و {user_week} کاربر</span></li>
			<li class="stats_m"><b>ماه اخیر</b> <span>{news_month} خبر، {comm_month} نظر و {user_month} کاربر</span></li>
		</ul>
	</div>
	<div class="box_in">
		<div class="statistics">
			<div class="stat_group">
				<h5 class="blue">اخبار</h5>
				<ul>
					<li>تعداد کل اخبار <b class="left">{news_num}</b></li>
					<li>منتشر شده ها <b class="left">{news_allow}</b></li>
					<li>منتشر شده فقط در صفحه اصلی <b class="left">{news_main}</b></li>
					<li>در انتظار تائید <b class="left">{news_moder}</b></li>
				</ul>
			</div>
			<div class="stat_group">
				<h5 class="blue">کاربران</h5>
				<ul>
					<li>تعداد کل کاربران ثبت نام شده <b class="left">{user_num}</b></li>
					<li>کاربران اخراج شده <b class="left">{user_banned}</b></li>
				</ul>
			</div>
			<div class="stat_group">
				<h5 class="blue">نظرات</h5>
				<ul>
					<li>تعداد کل نظرات ارسال شده <b class="left">{comm_num}</b></li>
					<li><a href="/?do=lastcomments">مشاهده آخرین نظرات</a></li>
				</ul>
			</div>
			<p class="grey">حجم کل بانک اطلاعاتی: {datenbank}</p>
		</div>
		<h4 class="heading">برترین نویسندگان</h4>
		<div class="table_top_users">
			<table class="userstop">{topusers}</table>
		</div>
	</div>
</article>