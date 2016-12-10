<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: login.html.php 3445 2011-11-03 13:11:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="login-box">
	<div class="login-logo">
		<a href="{url link='current'}"><b>NEW</b>SKY</a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Đăng nhập vào hệ thống</p>
		{error}
		<form method="post" action="{url link="user.login"}" id="js_login_form" onsubmit="{$sGetJsForm}">
			<div class="form-group has-feedback">
				<input type="text" name="val[login]" id="login" value="{$sDefaultEmailInfo}" class="form-control" placeholder="{if Phpfox::getParam('user.login_type') == 'user_name'}{phrase var='user.user_name'}{elseif Phpfox::getParam('user.login_type') == 'email'}{phrase var='user.email'}{else}{phrase var='user.login'}{/if}">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" name="val[password]" id="password" value="" class="form-control" placeholder="{phrase var='user.password'}">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-7">
					<label> <input type="checkbox" class="checkbox" name="val[remember_me]" value="" style="display: inline-block;" /> {phrase var='user.remember'}</label>
				</div>
				<!-- /.col -->
				<div class="col-xs-5">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
				</div>
				<!-- /.col -->
			</div>
		</form>
		<!-- /.social-auth-links -->
		<br>
		<p class="text-center">
			<a href="{url link='user.password.request'}">{phrase var='user.forgot_your_password'}</a> / 
			<a href="{url link='user.register'}" class="text-center">Đăng ký tài khoản?</a>
		</p>

	</div>
	<!-- /.login-box-body -->
</div>
<!-- /.login-box -->