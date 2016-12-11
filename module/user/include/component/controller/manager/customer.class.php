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
 * @version 		$Id: customer.class.php 7002 2013-12-20 13:46:31Z Miguel_Espinoza $
 */
class User_Component_Controller_Manager_Customer extends Phpfox_Component 
{	
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->_permission_access();
		$this->_getTemplate();
		
		$oFilter       = $this->_getDataSearch();
		$aSearchParams = $this->_actionSearch($oFilter);
		
		$iPage         = $this->request()->getInt('page');
		if(($iPageSize = $oFilter->get('iPageSize')) || ($iPageSize = $this->request()->get('iPageSize'))){
            $iPageSize = $iPageSize;
        }else{
            $iPageSize = 20;
        }

        if(($sSort = $oFilter->get('sort')) || ($sSort = $this->request()->get('sort'))){
            $sOrder = trim($oFilter->getSort());
        }else{
        	$sOrder = 'u.user_id DESC';
        }

		list($iCnt, $aUsers) = Phpfox::getService('user.custom.user')->getUsers($aSearchParams, $iPage, $iPageSize, $sOrder);
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
        Phpfox::getLib('url')->setParam('page', $iPage);
        $this->template()->assign(array(
			'aUsers' => $aUsers,
			'iNo'    => $iPageSize * ($iPage <= 0 ? $iPage : $iPage - 1),
		));
	}

	/*
		Quyền kết nối tới trang này
	*/
	private function _permission_access(){
		Phpfox::getUserParam('user.can_view_list_user', true);
	}

	/*
		Get thông tin mặc định ra template
	*/
	private function _getTemplate(){
		Phpfox::getService('manager.template')->getTemplate('Danh sách khách hàng');
		if(Phpfox::getUserParam('user.can_add_user')){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('user.manager.add.customer').'" class="small">Thêm khách hàng</a>';
			$this->template()->assign(array(
				'sTitleExtents' => $sTitleExtents,
			));
		}
	}

	private function _getDataSearch(){
		$aFilters = array();
		$aFilters['keyword'] = array(
			'type'    => 'input:text',
			'size'    => 15,
			'class'   => 'form-control',
			'mxlabel' => 'Từ khóa'
        );

		$aFilters['search_key'] = array(
			'type'         => 'select',
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Tìm theo',
			'options'      => array(
				'all'           => 'Tất cả',
				'user_id'       => 'Mã thành viên',
				'user_name'     => 'User Name',
				'full_name'     => 'Full Name',
				'phone'         => 'Số điện thoại',
				'email'         => 'Email',
            ),
        );

		$aFilters['sort'] = array(
			'type'         => 'select',
			'default_view' => 'u.user_id',
			'mxlabel'      => 'Săp xếp',
			'class'        => 'form-control',
			'options'      => array(
				'u.user_id'       => 'User ID',
				'u.user_name'     => 'User Name',
				'u.full_name'     => 'Họ và Tên',
				'u.gender'        => 'Giới tính',
				'u.birthday'      => 'Tuổi',
				'u.phone'         => 'Số điện thoại',
				'u.email'         => 'Email',
				'u.joined'        => 'Ngày đăng ký',
				'u.last_login'    => 'Đăng nhập cuối',
				'u.last_activity' => 'Hoạt động cuối',
            ),
        );
        $aFilters['sort_by'] = array(
			'type'    => 'select',
			'default' => 'DESC',
			'class'   => 'form-control',
			'options' => array(
				'DESC' => 'Giảm dần',
				'ASC'  => 'Tăng dần'
            ),
            
        );

        $aFilters['iPageSize'] = array(
			'type'         => 'select',
			'class'        => 'form-control',
			'default_view' => 20,
			'mxlabel'      => 'Hiển thị',
			'options'      => array(
				1   => 1,
				10  => 10,
				20  => 20,
				50  => 50,
				100 => 100,
				200 => 200,
            ),
            
        );

		$this->setParam('aFilterSearchs', $aFilters);
        $this->template()->assign(array('aFilterSearchs' => $aFilters));

        $aSearchParams = array(
			'type'          => 'user_manager_customer',
			'filters'       => $aFilters,
			'search'        => 'keyword',
			'custom_search' => true
        );
        $oFilter = Phpfox::getLib('search')->set($aSearchParams);
        return $oFilter;
	}

	private function _actionSearch($oFilter){
		$sKeyword = $oFilter->get('keyword');

		if(isset($sKeyword) && !empty($sKeyword) || $sKeyword != ''){
            if(($sSearchKey = $oFilter->get('search_key')) || ($sSearchKey = $this->request()->get('search_key'))){
            	switch ($sSearchKey) {
            		case 'user_id':
            			$oFilter->setCondition("AND u.user_id = " . (int)$sKeyword);
            		break;

            		case 'user_name':
            			$oFilter->setCondition("AND u.user_name LIKE '%".$sKeyword."%'");
            		break;

            		case 'full_name':
            			$oFilter->setCondition("AND u.full_name LIKE '%".$sKeyword."%'");
            		break;

            		case 'phone':
            			$oFilter->setCondition("AND u.phone LIKE '%".$sKeyword."%'");
            		break;
            		
            		case 'email':
            			$oFilter->setCondition("AND u.email LIKE '%".$sKeyword."%'");
            		break;

            		default:
            			$oFilter->setCondition("OR u.user_id = " . (int)$sKeyword);
						$oFilter->setCondition("OR u.user_name LIKE '%".$sKeyword."%'");
						$oFilter->setCondition("OR u.full_name LIKE '%".$sKeyword."%'");
						$oFilter->setCondition("OR u.phone LIKE '%".$sKeyword."%'");
						$oFilter->setCondition("OR u.email LIKE '%".$sKeyword."%'");
            		break;
            	}
            }
        }

        $oFilter->setCondition("AND u.user_group_id = " . GUEST_USER_ID);
        return $oFilter->getConditions();
	}
}