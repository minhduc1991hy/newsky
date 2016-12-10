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
 * @package 		Phpfox_Component
 * @version 		$Id: add.class.php 103 2009-01-27 11:32:36Z Nguyen Duc $
 */
class Manager_Component_Controller_Order_Add extends Phpfox_Component
{
	private $_bEdit           = false;
	private $_bAdd            = false;
	private $_sTypeIdCategory = 'order';
	private $_sName           = 'đơn hàng';
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->_permission_access();

		$iUserId = $this->request()->getInt('user');
		if($iUserId){
			$aUser = Phpfox::getService('user')->get($iUserId);
			if(!$aUser || $aUser['user_group_id'] != GUEST_USER_ID){
				$this->url()->send('manager.order.add', array(), 'Khách hàng không tồn tại');
			}

			$this->template()->assign(array(
				'aForms' => $aUser,
			));
		}
		
		$this->_getTemplate();
	}

	/*
		Check ADD
	*/
	private function _checkAdd(){
		$aReq4 = $this->request()->get('req4');
		if($aReq4){
			$this->_bAdd = true;
		}

		$this->template()->assign(array(
			'bAdd' => $this->_bAdd,
		));
	}

	/*
		Quyền kết nối tới trang này
	*/
	private function _permission_access(){
		if($this->_bEdit){
			Phpfox::getUserParam('manager.can_edit_account_system', true);
		}elseif($this->_bAdd){
			Phpfox::getUserParam('manager.can_add_account_system', true);
		}else{
			Phpfox::getUserParam('manager.can_view_list_account_system', true);
		}
	}
	
	/*
		Get thông tin mặc định ra template
	*/
	private function _getTemplate(){
		$this->template()->setHeader(array(
			'plugin/moment.min.js'           => 'style_script',
			'plugin/daterangepicker.js'      => 'style_script',
			'plugin/bootstrap-datepicker.js' => 'style_script',
			
			'plugin/daterangepicker.css'     => 'style_css',
			'plugin/datepicker3.css'         => 'style_css',
		));
		Phpfox::getService('manager.template')->getTemplate('Thêm đơn hàng');
		if($this->_bEdit){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('manager.order.add').'" class="small">Thêm '.$this->_sName.'</a>';
			$this->template()->assign(array(
				'sTitleExtents' => $sTitleExtents,
			));
		}
	}
}