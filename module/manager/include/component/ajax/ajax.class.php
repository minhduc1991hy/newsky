<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Nguyen Duc
 * @package  		Module_Manager
 * @version 		$Id: ajax.class.php 6742 2013-10-07 15:07:33Z Nguyen_Duc $
 */
class Manager_Component_Ajax_Ajax extends Phpfox_Ajax
{
	/*
		Đóng mở menu menu sidebar
	*/
	public function toggleMenuSideBar(){
		Phpfox::getService('manager.setting')->setToggleMenuSideBar();
	}

	/*
		Đóng mở search
	*/
	public function toggleFilterSearch(){
		Phpfox::getService('manager.setting')->setToggleFilterSearch();
	}

	
}