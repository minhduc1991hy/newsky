<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: template.html.php 6620 2013-09-11 12:10:20Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>{if !PHPFOX_IS_AJAX_PAGE}
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$sLocaleDirection}" lang="{$sLocaleCode}">
	<head>
		<title>{title}</title>	
		{header}
	</head>
	<body class="hold-transition fixed skin-green sidebar-mini {body_class}">
		{if isset($bInManager) && $bInManager == true}
		<div class="wrapper">
			{module name='manager.header'}
			<!-- Left side column. contains the logo and sidebar -->
			{module name="manager.main-sidebar"}
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<section class="content-header">
					<h1>{title} {if isset($sTitleExtents) && !empty($sTitleExtents)}{$sTitleExtents}{/if}</h1>
				</section>

				<!-- Main content -->
				<section class="content">
					<div {content_class}>{content}</div>
				</section> <!-- /.content -->
			</div> <!-- /.content-wrapper -->
			{module name="manager.main-search"}
			<footer class="main-footer">
				<strong>Copyright © <a href="{url link=''}">NEWSKY</a>.</strong> All rights reserved.
			</footer>
		</div> <!-- ./wrapper -->
		{else}
			<div {content_class}>{content}</div>
		{/if}
		{loading}
		{footer}
    </body>
</html>
{/if}