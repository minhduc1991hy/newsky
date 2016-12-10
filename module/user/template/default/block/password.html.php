<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
<div id="js_progress_cache_loader"></div>
<form method="post" action="{url link='current'}" onsubmit="$(this).ajaxCall('user.updatePassword'); return false;">
	<div class="table">
		<div class="table_left"><label>{phrase var='user.old_password'}</label></div>
		<div class="table_right">
			<input type="password" name="val[old_password]" value="" class="form-control"/>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="separate"></div>
	
	<div class="table">
		<div class="table_left"><label>{phrase var='user.new_password'}</label></div>
		<div class="table_right">
			<input type="password" name="val[new_password]" value="" class="form-control"/>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left"><label>{phrase var='user.confirm_password'}</label></div>
		<div class="table_right">
			<input type="password" name="val[confirm_password]" value="" class="form-control"/>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='user.update'}" class="button btn btn-success btn-block" />
	</div>
</form>