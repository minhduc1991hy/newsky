<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the image details when viewing an image.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_User
 * @version 		$Id: detail.class.php 254 2009-02-23 12:36:20Z Miguel_Espinoza $
 */

?>

<div class="login-box">
	<div class="login-logo">
		<a href="{url link='current'}"><b>NEW</b>SKY</a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Xác thực tài khoản</p>
		{error}
		{if !isset($sTime)}
			<p>{phrase var='user.this_site_is_very_concerned_about_security'}</p>			
			<input type="button" class="btn btn-primary btn-block btn-flat" value="{phrase var='user.resend_verification_email'}" class="button" onclick="$.ajaxCall('user.verifySendEmail', 'iUser={$iVerifyUserId}'); return false;" />
		{else}
			<p>{phrase var='user.the_link_that_brought_you_here_is_not_valid_it_may_already_have_expired' time=$sTime}</p>
		{/if}

		<br>
		<p class="text-center">
			<a href="{url link='user.login'}">Đăng nhập tài khoản?</a> / 
			<a href="{url link='user.register'}" class="text-center">Đăng ký tài khoản?</a>
		</p>
	</div>
	<!-- /.login-box-body -->
</div>
<!-- /.login-box -->