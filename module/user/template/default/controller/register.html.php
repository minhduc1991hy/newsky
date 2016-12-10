<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: register.html.php 5143 2013-01-15 14:16:21Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!');

?>

<div class="register-box">
	<div class="login-logo">
		<a href="{url link='current'}"><b>NEW</b>SKY</a>
	</div>
	<div class="register-box-body">
		<p class="login-box-msg">Đăng ký tài khoản</p>
		{error}
		<form method="post" action="{url link='user.register'}" id="js_form" enctype="multipart/form-data">	
			{template file='user.block.register.step1'}
			{template file='user.block.register.step2'}
			<div class="row">
				<!-- /.col -->
				<div class="col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Đăng ký</button>
				</div>
				<!-- /.col -->
			</div>
		</form>
		<br>
		<p class="text-center">
			<a href="{url link='user.login'}" class="text-center">Bạn đã có tài khoản Đăng nhập</a>
		</p>
	</div>
	<!-- /.form-box -->
</div>
<!-- /.register-box -->