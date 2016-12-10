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
 * @version 		$Id: index.class.php 103 2009-01-27 11:32:36Z Nguyen Duc $
 */
class Manager_Component_Controller_Supplies_Index extends Phpfox_Component
{
	private $_bEdit = false;
	private $_bAdd  = false;
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iDelete = $this->request()->getInt('delete');
		if($iDelete){
			$this->url()->clearParam('delete');
			if(!Phpfox::getUserParam('manager.can_del_supplies')){
				$this->url()->send('current');
			}

			$aSupplie = Phpfox::getService('manager.supplies')->getSupplie($iDelete);
			if(!$aSupplie){
				$this->url()->send('current', array(), 'ID nhà cung cấp không hợp lệ');
			}

			if(Phpfox::getService('manager.supplies.process')->deleteSupplie($iDelete)){
				$this->url()->send('current', array(), 'Xóa nhà cung cấp thành công!');
			}else{
				$this->url()->send('current', array(), 'Xóa nhà cung cấp không thành công!');
			}
		}


		$iSupplieId = $this->request()->getInt('id');
		$aSupplie = array();
		if($iSupplieId){
			$aSupplie = Phpfox::getService('manager.supplies')->getSupplie($iSupplieId);
			if($aSupplie){
				$this->_bEdit = true;
			}
		}
		$this->_permission_access();
		$this->_checkAdd();

		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form_manager_add', 'aParams' => array()));
		$aVals  = $this->request()->get('val');
		if($aVals){
			if(!$this->_bEdit){
				Phpfox::getUserParam('manager.can_add_supplies', true);
			}

			$this->_validateForm($aVals, $aSupplie);
			if ($oValid->isValid($aVals)){
				if(!$this->_bEdit){
					if($iSupplieId = Phpfox::getService('manager.supplies.process')->addSupplie($aVals)){
						$this->url()->send('current', null, 'Thêm nhà cung cấp thành công!');
					}else{
						Phpfox_Error::set('Thêm nhà cung cấp không thành công!');
					}
				}else{
					if(Phpfox::getService('manager.supplies.process')->updateSupplie($aVals, $iSupplieId)){
						$this->url()->send('current', null, 'Sửa nhà cung cấp thành công!');
					}else{
						Phpfox_Error::set('Sửa nhà cung cấp không thành công!');
					}
				}
			}
		}

		$this->template()->assign(array(
			'aForms' => $aSupplie,
			'bEdit'  => $this->_bEdit,
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
        	$sOrder = 's.time_stamp DESC';
        }

		$aProducts = array();
		$iCnt      = 0;

        list($iCnt, $aSupplies) = Phpfox::getService('manager.supplies')->getSupplies($aSearchParams, $iPage, $iPageSize, $sOrder);
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
        Phpfox::getLib('url')->setParam('page', $iPage);
        $this->template()->assign(array(
			'aSupplies' => $aSupplies,
			'iNo'    => $iPageSize * ($iPage <= 0 ? $iPage : $iPage - 1),
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
			Phpfox::getUserParam('manager.can_edit_supplies', true);
		}elseif($this->_bAdd){
			Phpfox::getUserParam('manager.can_add_supplies', true);
		}else{
			Phpfox::getUserParam('manager.can_view_list_supplies', true);
		}
	}
	
	/*
		Get thông tin mặc định ra template
	*/
	private function _getTemplate(){
		Phpfox::getService('manager.template')->getTemplate('Danh sách nhà cung cấp');
		if(Phpfox::getUserParam('manager.can_add_supplies')){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('manager.supplies.index.add').'" class="small">Thêm nhà cung cấp</a>';
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
			Phpfox_Error::set('Bạn chưa nhập mã nhà cung cấp');
			return false;
		}

		$aCound = array(
			'AND s.code = "'.$aVals['code'].'"',
		);
		if($this->_bEdit){
			$aCound[] = 'AND s.code <> "'.$aDataEdit['code'].'"';
		}
		if(Phpfox::getService('manager.supplies')->getCountSupplie($aCound)){
			Phpfox_Error::set('Mã nhà cung cấp đã trùng với một mã khác!');
			return false;
		}

		if(!isset($aVals['name']) || empty($aVals['name'])){
			Phpfox_Error::set('Bạn chưa nhập tên nhà cung cấp');
			return false;
		}

		if(!isset($aVals['address']) || empty($aVals['address'])){
			Phpfox_Error::set('Bạn chưa nhập địa chỉ nhà cung cấp.');
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
				'all'     => 'Tất cả',
				'code'    => 'Mã nhà cung cấp',
				'name'    => 'Tên nhà cung cấp',
				'address' => 'Địa chỉ',
				'phone'   => 'Số điện thoại',
            ),
        );

		$aFilters['sort'] = array(
			'type'         => 'select',
			'default_view' => 's.time_stamp',
			'mxlabel'      => 'Săp xếp',
			'class'        => 'form-control',
			'options'      => array(
				's.code'       => 'Mã nhà cung cấp',
				's.name'       => 'Tên nhà cung cấp',
				's.address'    => 'Địa chỉ',
				's.phone'      => 'Số điện thoại',
				's.time_stamp' => 'Thời gian tạo',
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
			'type'          => 'manager_supplies_index',
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
            		case 'name':
            		case 'address':
            		case 'phone':
            			$oFilter->setCondition("AND s.".$sSearchKey." LIKE '%".$sKeyword."%'");
            		break;

            		default:
						$oFilter->setCondition("OR s.code LIKE '%".$sKeyword."%'");
						$oFilter->setCondition("OR s.name LIKE '%".$sKeyword."%'");
						$oFilter->setCondition("OR s.address LIKE '%".$sKeyword."%'");
						$oFilter->setCondition("OR s.phone LIKE '%".$sKeyword."%'");
            		break;
            	}
            }
        }

        return $oFilter->getConditions();
	}
}