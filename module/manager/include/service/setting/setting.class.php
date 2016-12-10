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
 * @package 		Phpfox_Service
 * @version 		$Id: setting.class.php 5112 2013-01-11 06:56:25Z Nguyen_Duc $
 */
class Manager_Service_Setting_Setting extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		
	}

	/*
		Đóng mở sidebar left
	*/
	public function setToggleMenuSideBar(){
		$oSession = Phpfox::getLib('session');
		if($this->getToggleMenuSideBar()){
			$oSession->remove('toggleMenuSideBar');
		}else{
			$oSession->set('toggleMenuSideBar', 1);
		}
	}

	public function getToggleMenuSideBar(){
		$oSession = Phpfox::getLib('session');
		return $oSession->get('toggleMenuSideBar');
	}
	/*
		END: Đóng mở sidebar left
	*/


	/*
		Đóng mở search
	*/
	public function setToggleFilterSearch(){
		$oSession = Phpfox::getLib('session');
		if($this->getToggleFilterSearch()){
			$oSession->remove('toggleFilterSearch');
		}else{
			$oSession->set('toggleFilterSearch', 1);
		}
	}

	public function getToggleFilterSearch(){
		$oSession = Phpfox::getLib('session');
		return $oSession->get('toggleFilterSearch');
	}
	/*
		END: Đóng mở search
	*/
	
}