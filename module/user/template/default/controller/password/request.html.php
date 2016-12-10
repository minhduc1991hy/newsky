<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: request.html.php 1245 2009-11-02 16:10:29Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 
?>

<div class="login-box">
	<div class="login-logo">
		<a href="{url link='current'}"><b>NEW</b>SKY</a>
	</div>
	<div class="login-box-body">
		<p class="login-box-msg">QUÊN MẬT KHẨU</p>
		{error}
		<form method="post" action="{url link='user.password.request'}">
			<div class="form-group has-feedback">
				<input type="text" name="val[email]" id="email" value="" class="form-control" placeholder="{phrase var='user.email'}">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			{if Phpfox::isModule('captcha')}{module name='captcha.form' sType='lostpassword'}{/if}

			<div class="row">
				<div class="col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat">{phrase var='user.request_new_password'}</button>
				</div>
			</div>
		</form>
		<br>
		<p class="text-center">
			<a href="{url link='user.login'}">Đăng nhập</a> /
			<a href="{url link='user.register'}" class="text-center">Đăng ký</a>
		</p>
	</div>
</div>