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
class Manager_Component_Controller_Supplies_Hdf extends Phpfox_Component
{
	private $_bEdit           = false;
	private $_bAdd            = false;
	private $_sTypeIdCategory = 'hdf_mdf';
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iDelete = $this->request()->getInt('delete');
		if($iDelete){
			$this->url()->clearParam('delete');
			if(!Phpfox::getUserParam('manager.can_del_hdf')){
				$this->url()->send('current');
			}

			$aHdf = Phpfox::getService('manager.supplies')->getHdf($iDelete);
			if(!$aHdf){
				$this->url()->send('current', array(), 'ID HDF, MDF không hợp lệ');
			}

			if(Phpfox::getService('manager.supplies.process')->deleteHDF($iDelete)){
				$this->url()->send('current', array(), 'Xóa HDF, MDF thành công!');
			}else{
				$this->url()->send('current', array(), 'Xóa HDF, MDF không thành công!');
			}
		}


		$iHdfId = $this->request()->getInt('id');
		$aHdf = array();
		if($iHdfId){
			$aHdf = Phpfox::getService('manager.supplies')->getHdf($iHdfId);
			if($aHdf){
				$this->_bEdit = true;
			}
		}
		$this->_permission_access();
		$this->_checkAdd();

		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form_manager_add', 'aParams' => array()));
		$aVals  = $this->request()->get('val');
		if($aVals){
			if(!$this->_bEdit){
				Phpfox::getUserParam('manager.can_add_hdf', true);
			}

			$this->_validateForm($aVals, $aHdf);
			if ($oValid->isValid($aVals)){
				if(!$this->_bEdit){
					if($iHdfId = Phpfox::getService('manager.supplies.process')->addHDF($aVals)){
						$this->url()->send('current', null, 'Thêm HDF, MDF thành công!');
					}else{
						Phpfox_Error::set('Thêm HDF, MDF không thành công!');
					}
				}else{
					if(Phpfox::getService('manager.supplies.process')->updateHDF($aVals, $iHdfId)){
						$this->url()->send('current', null, 'Sửa HDF, MDF thành công!');
					}else{
						Phpfox_Error::set('Sửa HDF, MDF không thành công!');
					}
				}
			}
		}

		$this->template()->assign(array(
			'aForms'          => $aHdf,
			'bEdit'           => $this->_bEdit,
			'sTypeIdCategory' => $this->_sTypeIdCategory,
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
        	$sOrder = 'h.time_stamp DESC';
        }

		$aProducts = array();
		$iCnt      = 0;

        list($iCnt, $aHdfs) = Phpfox::getService('manager.supplies')->getHdfs($aSearchParams, $iPage, $iPageSize, $sOrder);
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
        Phpfox::getLib('url')->setParam('page', $iPage);
        $this->template()->assign(array(
			'aHdfs' => $aHdfs,
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
			Phpfox::getUserParam('manager.can_edit_hdf', true);
		}elseif($this->_bAdd){
			Phpfox::getUserParam('manager.can_add_hdf', true);
		}else{
			Phpfox::getUserParam('manager.can_view_list_hdf', true);
		}
	}
	
	/*
		Get thông tin mặc định ra template
	*/
	private function _getTemplate(){
		Phpfox::getService('manager.template')->getTemplate('Danh mục HDF, MDF');
		if(Phpfox::getUserParam('manager.can_add_hdf')){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('manager.supplies.hdf.add').'" class="small">Thêm HDF, MDF</a>';
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
			Phpfox_Error::set('Bạn chưa nhập mã HDF, MDF');
			return false;
		}

		$aCound = array(
			'AND h.code = "'.$aVals['code'].'"',
		);
		if($this->_bEdit){
			$aCound[] = 'AND h.code <> "'.$aDataEdit['code'].'"';
		}
		if(Phpfox::getService('manager.supplies')->getCountHDF($aCound)){
			Phpfox_Error::set('Mã HDF, MDF đã trùng với một mã khác!');
			return false;
		}

		if(!isset($aVals['description']) || empty($aVals['description'])){
			Phpfox_Error::set('Bạn chưa nhập nội dung mô tả');
			return false;
		}

		if(!isset($aVals['width']) || empty($aVals['width'])){
			Phpfox_Error::set('Bạn chưa nhập chiều rộng.');
			return false;
		}

		if(!isset($aVals['length']) || empty($aVals['length'])){
			Phpfox_Error::set('Bạn chưa nhập chiều dài.');
			return false;
		}

		if(!isset($aVals['thickness']) || empty($aVals['thickness'])){
			Phpfox_Error::set('Bạn chưa nhập độ dày.');
			return false;
		}

		if(!isset($aVals['product_id']) || empty($aVals['product_id'])){
			Phpfox_Error::set('Bạn chưa chọn danh mục');
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
				'code'        => 'Mã HDF, MDF',
				'description' => 'Mô tả',
            ),
        );

		$aAccountingDatas = Phpfox::getService('manager.category')->getCategories($this->_sTypeIdCategory);
		$aAccountingData = array('all' => 'Tất cả');
		foreach ($aAccountingDatas as $ikey => $aData) {
        	$aAccountingData[$aData['product_id']] = $aData['title'] . (!empty($aData['description']) ? ' ('.$aData['description'].')' : '');
        }

        $aFilters['product_id'] = array(
			'type'         => 'select',
			'options'      => $aAccountingData,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Danh mục'
        );

		$aFilters['sort'] = array(
			'type'         => 'select',
			'default_view' => 'h.time_stamp',
			'mxlabel'      => 'Săp xếp',
			'class'        => 'form-control',
			'options'      => array(
				'h.code'       => 'Mã HDF, MDF',
				'h.description' => 'Mô tả',
				'h.time_stamp'  => 'Thời gian tạo',
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
			'type'          => 'manager_supplies_hdf',
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
            			$oFilter->setCondition("AND h.".$sSearchKey." LIKE '%".$sKeyword."%'");
            		break;

            		default:
						$oFilter->setCondition("OR h.code LIKE '%".$sKeyword."%'");
						$oFilter->setCondition("OR h.description LIKE '%".$sKeyword."%'");
            		break;
            	}
            }
        }

        if(($iProductId = $oFilter->get('product_id')) || ($iProductId = $this->request()->get('product_id'))){
        	if($iProductId != 'all'){
        		$oFilter->setCondition("AND h.product_id = " . (int)$iProductId);
        	}
        }
        return $oFilter->getConditions();
	}
}