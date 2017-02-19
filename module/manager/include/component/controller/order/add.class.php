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
		$aForms = array();
		$aOrderSessions = Phpfox::getService('manager.order')->getSessionOrder();
		if($iUserId){
			$aUser = Phpfox::getService('user')->get($iUserId);
			if(!$aUser || $aUser['user_group_id'] != GUEST_USER_ID){
				$this->url()->send('manager.order.add', array(), 'Khách hàng không tồn tại');
			}

			$aOrderSessions = Phpfox::getService('manager.order')->validateSessionOrder($iUserId);
			$aForms['user_id']      = $aUser['user_id'];
			$aForms['full_name']    = $aUser['full_name'];
			$aForms['phone']        = $aUser['phone'];
			$aForms['email']        = $aUser['email'];
			$aForms['user_contact'] = $aUser['user_contact'];
			
			$this->template()->assign(array(
				'aUser'     => $aUser,
			));
		}
		
		$aOrderSessions = Phpfox::getService('manager.order')->getInfoSessesionOrder($aOrderSessions);
		$OrderUser = (isset($aOrderSessions[$iUserId]) ? $aOrderSessions[$iUserId] : array());
		$this->template()->assign(array(
			'aForms'         => $aForms,
			'aOrderSessions' => $aOrderSessions,
			'OrderUser'      => $OrderUser,
		));
		
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
		Phpfox::getService('manager.template')->getTemplate('Thêm đơn hàng');
		$this->setParam('sActiveCurrentMenu', 'manager.order.index');
		if($this->_bEdit){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('manager.order.add').'" class="small">Thêm '.$this->_sName.'</a>';
			$this->template()->assign(array(
				'sTitleExtents' => $sTitleExtents,
			));
		}
	}
}