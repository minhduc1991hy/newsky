<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Component
 * @version 		$Id: index.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Manager_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->_permission_access();
		$this->_getTemplate();
	}

	/*
		Quyền kết nối tới trang này
	*/
	private function _permission_access(){
		Phpfox::isUser(true);
	}
	
	/*
		Get thông tin mặc định ra template
	*/
	private function _getTemplate(){
		Phpfox::getService('manager.template')->getTemplate('Bảng điều khiển');
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('manager.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>