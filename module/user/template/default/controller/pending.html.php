<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: pending.html.php 1578 2010-05-07 09:38:07Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="login-box">
	<div class="login-logo">
		<a href="{url link='current'}"><b>NEW</b>SKY</a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">PENDING</p>
		{error}
		<p>{if $iStatus == 1}
		    {phrase var='user.this_site_is_very_concerned_about_security'}
		{else}
		    {phrase var='user.your_account_is_pending_approval'}
		{/if}</p>
		<br>
		<p class="text-center">
			<a href="{url link='user.login'}">Đăng nhập tài khoản?</a> / 
			<a href="{url link='user.register'}" class="text-center">Đăng ký tài khoản?</a>
		</p>
	</div>
	<!-- /.login-box-body -->
</div>
<!-- /.login-box -->
