<article class="box story">
	<div class="box_in">
		<h1 class="title h1">پیام شخصی</h1>
		<div class="pm-box">
			<nav id="pm-menu">
				[inbox]<span>پیام‌های دریافتی</span>[/inbox]
				[outbox]<span>پیام‌های ارسالی</span>[/outbox]
				[new_pm]<span>ارسال پیام جدید</span>[/new_pm]
			</nav>
			<div class="pm_status">
				{pm-progress-bar}
				{proc-pm-limit} % / ({pm-limit} پیام)
			</div>
		</div>
		[pmlist]
		<div class="pmlist">
			{pmlist}
		</div>
		[/pmlist]
		[newpm]
		<h4 class="heading">ارسال پیام جدید</h4>
		<div class="addform addpm">
			<ul class="ui-form">
				<li class="form-group combo">
					<div class="combo_field">
						<input placeholder="گیرنده" type="text" name="name" value="{author}" class="wide" required>
					</div>
					<div class="combo_field">
						<input placeholder="عنوان پیام" type="text" name="subj" value="{subj}" class="wide" required>
					</div>
				</li>
				<li id="comment-editor">{editor}</li> 
				<li><input type="checkbox" id="outboxcopy" name="outboxcopy" value="1" /> <label for="outboxcopy">ذخیره پیام در پیام های ارسالی</label></li>				
			[recaptcha]
				<li>{recaptcha}</li>
			[/recaptcha]
			[question]
				<li class="form-group">
					<label for="question_answer">سوال امنیتی: {question}</label>
					<input placeholder="پاسخ" type="text" name="question_answer" id="question_answer" class="wide" required>
				</li>
			[/question]
			</ul>
			<div class="form_submit">
				[sec_code]
					<div class="c-captcha">
						{sec_code}
						<input placeholder="کد امنیتی" title="کد امنیتی را وارد کنید" type="text" name="sec_code" id="sec_code" required>
					</div>
				[/sec_code]
				<button class="btn btn-big" type="submit" name="add"><b>ارسال</b></button>
				<button class="btn-border btn-big" type="button" onclick="dlePMPreview()">پیش نمایش</button>
			</div>
		</div>
		[/newpm]
	</div>
	[readpm]
	<div class="comment" id="{comment-id}">
		<div class="com_info">
			<div class="avatar">
				<span class="cover" style="background-image: url({foto});">{login}</span>
				[online]<span class="com_online" title="{login} - online">آنلاین</span>[/online]
			</div>
			<div class="com_user">
				<b class="name">{author}</b>
				<span class="grey">
					در {date}
				</span>
			</div>
			<div class="meta">
				<ul class="left">
					<li class="reply grey" title="پاسخ">[reply]<svg class="icon icon-reply"><use xlink:href="#icon-reply"></use></svg><span>پاسخ</span>[/reply]</li>
					<li class="reply grey" title="افزودن به لیست سیاه">[ignore]<svg class="icon icon-reply"><use xlink:href="#icon-dislike"></use></svg><span>افزودن به لیست سیاه</span>[/ignore]</li>
					<li class="complaint" title="شکایت">[complaint]<svg class="icon icon-bad"><use xlink:href="#icon-bad"></use></svg><span class="title_hide">شکایت</span>[/complaint]</li>
					<li class="del" title="حذف">[del]<svg class="icon icon-cross"><use xlink:href="#icon-cross"></use></svg><span class="title_hide">حذف</span>[/del]</li>
				</ul>
			</div>
		</div>
		<div class="com_content">
			<h4 class="title">{subj}</h4>
			<div class="text">{text}</div>
			[signature]<div class="signature">--------------------<br />{signature}</div>[/signature]
		</div>
	</div>
	[/readpm]
</article>