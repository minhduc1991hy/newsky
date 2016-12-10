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
 * @version 		$Id: account-systemclass.php 103 2009-01-27 11:32:36Z Nguyen Duc $
 */
class Manager_Component_Controller_Accounting_Account_System extends Phpfox_Component
{
	private $_bEdit           = false;
	private $_bAdd            = false;
	private $_sTypeIdCategory = 'rawpaper';
	private $_sName           = 'tài khoản kế toán';
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iDelete = $this->request()->getInt('delete');
		if($iDelete){
			$this->url()->clearParam('delete');
			if(!Phpfox::getUserParam('manager.can_del_account_system')){
				$this->url()->send('current');
			}

			$aRow = Phpfox::getService('manager.accounting')->getAccountSystem($iDelete);
			if(!$aRow){
				$this->url()->send('current', array(), 'ID '.$this->_sName.' không hợp lệ');
			}

			if(Phpfox::getService('manager.accounting.process')->deleteAccountSystem($iDelete)){
				$this->url()->send('current', array(), 'Xóa '.$this->_sName.' thành công!');
			}else{
				$this->url()->send('current', array(), 'Xóa '.$this->_sName.' không thành công!');
			}
		}


		$iId = $this->request()->getInt('id');
		$aRow = array();
		if($iId){
			$aRow = Phpfox::getService('manager.accounting')->getAccountSystem($iId);
			if($aRow){
				$this->_bEdit = true;
			}
		}
		$this->_permission_access();
		$this->_checkAdd();

		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form_manager_add', 'aParams' => array()));
		$aVals  = $this->request()->get('val');
		if($aVals){
			if(!$this->_bEdit){
				Phpfox::getUserParam('manager.can_add_account_system', true);
			}

			$this->_validateForm($aVals, $aRow);
			if ($oValid->isValid($aVals)){
				if(!$this->_bEdit){
					if($iId = Phpfox::getService('manager.accounting.process')->addAccountSystem($aVals)){
						$this->url()->send('current', null, 'Thêm '.$this->_sName.' thành công!');
					}else{
						Phpfox_Error::set('Thêm '.$this->_sName.' không thành công!');
					}
				}else{
					if(Phpfox::getService('manager.accounting.process')->updateAccountSystem($aVals, $iId)){
						$this->url()->send('current', null, 'Sửa '.$this->_sName.' thành công!');
					}else{
						Phpfox_Error::set('Sửa '.$this->_sName.' không thành công!');
					}
				}
			}
		}

		$this->template()->assign(array(
			'aForms'          => $aRow,
			'bEdit'           => $this->_bEdit,
			'sTypeIdCategory' => $this->_sTypeIdCategory,
			'sName'           => $this->_sName,
		));


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
        	$sOrder = 'acs.time_stamp DESC';
        }

        list($iCnt, $aRows) = Phpfox::getService('manager.accounting')->getAccountSystems($aSearchParams, $iPage, $iPageSize, $sOrder);
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
        Phpfox::getLib('url')->setParam('page', $iPage);
        $this->template()->assign(array(
			'aRows' => $aRows,
			'iNo'   => $iPageSize * ($iPage <= 0 ? $iPage : $iPage - 1),
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
		Phpfox::getService('manager.template')->getTemplate('Hệ thống ' . $this->_sName);
		if(Phpfox::getUserParam('manager.can_add_account_system')){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('manager.accounting.account-system.add').'" class="small">Thêm '.$this->_sName.'</a>';
			$this->template()->assign(array(
				'sTitleExtents' => $sTitleExtents,
			));
		}
	}

	/*
		Validate Input Form
	*/
	private function _validateForm(&$aVals, $aDataEdit = array()){
		$this->_permission_access();
		
		if(!isset($aVals['code']) || empty($aVals['code'])){
			Phpfox_Error::set('Bạn chưa nhập mã ' . $this->_sName);
			return false;
		}

		$aCound = array(
			'AND acs.code = "'.$aVals['code'].'"',
		);
		if($this->_bEdit){
			$aCound[] = 'AND acs.code <> "'.$aDataEdit['code'].'"';
		}
		if(Phpfox::getService('manager.accounting')->getCountAccountSystem($aCound)){
			Phpfox_Error::set('Mã '.$this->_sName.' đã trùng với một mã khác!');
			return false;
		}

		if(!isset($aVals['description']) || empty($aVals['description'])){
			Phpfox_Error::set('Bạn chưa nhập mô tả');
			return false;
		}

		if(!isset($aVals['tckd'])){
			Phpfox_Error::set('Bạn chưa chọn tính chất kết dư.');
			return false;
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
				'all'         => 'Tất cả',
				'code'        => 'Mã ' . $this->_sName,
				'description' => 'Mô tả',
            ),
        );

		$aDataDB = Phpfox::getService('manager.data')->getDataTinhChatKetDu();
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $sData) {
				if($ikey == 0) $ikey = 'khong';
	        	$aDatas[$ikey] = $sData;
	        }
        }
        $aFilters['tckd'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Tính chất kết dư'
        );

		$aFilters['sort'] = array(
			'type'         => 'select',
			'default_view' => 'rp.time_stamp',
			'mxlabel'      => 'Săp xếp',
			'class'        => 'form-control',
			'options'      => array(
				'acs.code'        => 'Mã ' . $this->_sName,
				'acs.description' => 'Mô tả',
				'acs.time_stamp'  => 'Thời gian tạo',
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
			'type'          => 'manager_accounting_account_system',
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
            		case 'code':
            		case 'description':
            			$oFilter->setCondition("AND acs.".$sSearchKey." LIKE '%".$sKeyword."%'");
            		break;

            		default:
						$oFilter->setCondition("OR acs.code LIKE '%".$sKeyword."%'");
						$oFilter->setCondition("OR acs.description LIKE '%".$sKeyword."%'");
            		break;
            	}
            }
        }

        if(($tckd = $oFilter->get('tckd')) || ($tckd = $this->request()->get('tckd'))){
        	if($tckd != 'all'){
        		$oFilter->setCondition("AND acs.tckd = " . $tckd);
        	}
        }

        return $oFilter->getConditions();
	}
}