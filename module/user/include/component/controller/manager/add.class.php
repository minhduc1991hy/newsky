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
 * @package  		Module_User
 * @version 		$Id: login.class.php 7002 2013-12-20 13:46:31Z Miguel_Espinoza $
 */
class User_Component_Controller_Manager_Add extends Phpfox_Component 
{
	private $_bEdit = false;
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iUserId = $this->request()->getInt('id');
		$aUser = array();
		if($iUserId){
			$aUser = Phpfox::getService('user')->getUser($iUserId);
			if($aUser){
				$this->_bEdit = true;
				unset($aUser['password']);
				if (!empty($aUser['birthday'])){
					$aUser = array_merge($aUser, Phpfox::getService('user')->getAgeArray($aUser['birthday']));
				}
			}
		}

		$this->_permission_access();

		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form_manager_add', 'aParams' => array()));
		$aVals  = $this->request()->get('val');
		if($aVals){
			$this->_validateForm($aVals, $aUser);
			if ($oValid->isValid($aVals)){
				if(!$this->_bEdit){
					if($iUserId = Phpfox::getService('user.custom.process')->add($aVals)){
						$this->url()->send('current', null, 'Thêm thành viên mới thành công!');
					}else{
						Phpfox_Error::set('Thêm nhân viên mới không thành công!');
					}
				}else{
					if(Phpfox::getService('user.custom.process')->update($aVals, $iUserId)){
						$this->url()->send('current', null, 'Sửa thông tin thành viên thành công!');
					}else{
						Phpfox_Error::set('Sửa thông tin thành viên không thành công!');
					}
				}
			}
		}


		$this->template()->assign(array(
			'aForms' => $aUser,
		));

		
		
		$this->_getTemplate();
	}

	/*
		Quyền kết nối tới trang này
	*/
	private function _permission_access(){
		if($this->_bEdit){
			Phpfox::getUserParam('user.can_edit_user', true);
		}else{
			Phpfox::getUserParam('user.can_add_user', true);
		}
	}

	/*
		Get thông tin mặc định ra template
	*/
	private function _getTemplate(){
		$sTitle = 'Thêm nhân viên mới';

		if($this->_bEdit){
			$sTitle = 'Sửa thông tin thành viên';
			$this->setParam('sActiveCurrentMenu', 'user.manager.list');

			if(Phpfox::getUserParam('user.can_add_user')){
				$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('user.manager.add').'" class="small">Thêm nhân viên</a>';
				$this->template()->assign(array(
					'sTitleExtents' => $sTitleExtents,
				));
			}
		}
		Phpfox::getService('manager.template')->getTemplate($sTitle);

		$this->template()->assign(array(
			'sDobStart' => Phpfox::getParam('user.date_of_birth_start'),
			'sDobEnd'   => Phpfox::getParam('user.date_of_birth_end'),
			'bEdit'     => $this->_bEdit,
		));
	}

	/*
		Validate Input Form
	*/
	private function _validateForm(&$aVals, $aUser = array()){
		if(!isset($aVals['full_name']) || empty($aVals['full_name'])){
			Phpfox_Error::set('Bạn chưa nhập họ và tên');
			return false;
		}

		if(!isset($aVals['user_name']) || empty($aVals['user_name'])){
			Phpfox_Error::set('Bạn chưa nhập User Name');
			return false;
		}

		$aVals['user_name'] = str_replace(' ', '-', $aVals['user_name']);
		$aVals['user_name'] = str_replace('_', '-', $aVals['user_name']);
		$aCoundExt = array();
		if($this->_bEdit && $aUser){
			$aCoundExt = array(
				'AND user_id <> ' . (int) $aUser['user_id'],
			);
		}
		if(!Phpfox::getService('user.validate')->user($aVals['user_name'], $aCoundExt)){
			return false;
		}

		if(!isset($aVals['email']) || empty($aVals['email'])){
			Phpfox_Error::set('Bạn chưa nhập Email');
			return false;
		}

		if(!Phpfox::getService('user.validate')->email($aVals['email'], $aCoundExt)){
			return false;
		}
		
		if(!$this->_bEdit){		
			if(!isset($aVals['password']) || empty($aVals['password'])){
				Phpfox_Error::set('Bạn chưa nhập mật khẩu');
				return false;
			}
		
			if(!isset($aVals['re_password']) || empty($aVals['re_password'])){
				Phpfox_Error::set('Bạn chưa nhập lại mật khẩu');
				return false;
			}

			if(isset($aVals['re_password']) && !empty($aVals['re_password'])){
				if($aVals['re_password'] != $aVals['password']){
					Phpfox_Error::set('Mật khẩu nhập lại không khớp');
					return false;
				}
			}
		}

		if(!isset($aVals['phone']) || empty($aVals['phone'])){
			Phpfox_Error::set('Bạn chưa nhập số điện thoại');
			return false;
		}

		if(!Phpfox::getService('user.validate')->phone($aVals['phone'], $aCoundExt)){
			return false;
		}
		// print_r($aVals); die();
		if(!isset($aVals['gender']) || empty($aVals['gender'])){
			Phpfox_Error::set('Bạn chưa chọn giới tính');
			return false;
		}

		if(!isset($aVals['user_group_id']) || empty($aVals['user_group_id'])){
			Phpfox_Error::set('Bạn chưa chọn nhóm phòng ban');
			return false;
		}

		if(!isset($aVals['view_id']) || $aVals['view_id'] == ''){
			Phpfox_Error::set('Bạn chưa chọn trạng thái');
			return false;
		}
	}
}