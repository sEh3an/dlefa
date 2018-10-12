<div class="page_form__inner">
	<h1 class="title h1">
		[registration]ثبت نام کاربر جدید[/registration]
		[validation]بروزرسانی مشخصات کاربری[/validation]
	</h1>
	<div class="page_form__form">
		<div class="regtext">
		[registration]
			<b>سلام, به وبسایت ما خوش آمدید!</b><br /><br />
			با عضویت در سایت ما سطح دسترسی شما به امکانات سایت افزایش خواهد داشت.
			می توانید در سایت مطالب خود را انتشار دهید، ارسال نظر، مشاهده نوشته های پنهان و به خیلی امکانات بیشتری دسترسی خواهید داشت.
			<br/> اگر شما با هرگونه مشکلی در عضویت مواجه شدید، لطفا به <a href="/feedback.html"> مدیریت </a> سایت اطلاع دهید.
		[/registration]
		[validation]
			<b>کاربر گرامی,</b><br />
			حساب کاربری شما با موفقیت در سایت ایجاد شد. در صورت تمایل، می توانید فیلدهای زیر را کامل کنید
		[/validation]
		</div>
		<ul class="ui-form">
		[registration]
			<li class="form-group">
				<label for="name">نام کاربری</label>
				<div class="login_check">
					<input type="text" name="name" id="name" class="wide ltr" required>
					<button class="btn" title="Check username" onclick="CheckLogin(); return false;">چک کردن</button>
				</div>
				<div id="result-registration"></div>
			</li>
			<li class="form-group">
				<label for="password1">رمز عبور</label>
				<input type="password" name="password1" id="password1" class="wide ltr" required>
			</li>
			<li class="form-group">
				<label for="password2">تکرار رمز عبور</label>
				<input type="password" name="password2" id="password2" class="wide ltr" required>
			</li>
			<li class="form-group">
				<label for="email">ایمیل</label>
				<input type="email" name="email" id="email" class="wide ltr" required>
			</li>
		[question]
			<li class="form-group">
				<label for="question_answer">{question}</label>
				<input placeholder="پاسخ" type="text" name="question_answer" id="question_answer" class="wide" required>
			</li>
		[/question]
		[sec_code]
			<li class="form-group">
				<div class="c-captcha">
					{reg_code}
					<input placeholder="کد امنیتی" title="کد امنیتی را وارد کنید" type="text" name="sec_code" id="sec_code" required>
				</div>
			</li>
		[/sec_code]
		[recaptcha]
			<li>{recaptcha}</li>
		[/recaptcha]
		[/registration]
		[validation]
			<li class="form-group">
				<label for="fullname">نام کامل</label>
				<input type="text" id="fullname" name="fullname" class="wide">
			</li>
			<li class="form-group">
				<label for="land">محل سکونت</label>
				<input type="text" id="land" name="land" class="wide">
			</li>
			<li class="form-group">
				<label for="image">درباره من</label>
				<textarea id="info" name="info" rows="5" class="wide"></textarea>
			</li>
			<li class="form-group">
				<label for="image">آواتار</label>
				<input type="file" id="image" name="image" class="wide ltr">
			</li>
			<li class="form-group">
				<table class="xfields">
					{xfields}
				</table>
			</li>
		[/validation]
		</ul>
		<div class="form_submit">
			<button class="btn" name="submit" type="submit">ثبت فرم</button>
		</div>
	</div>
</div>


<div class="page addform">
	<table class="tableform">


	</table>
</div>