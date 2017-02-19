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
 * @version 		$Id: skirting.class.php 103 2009-01-27 11:32:36Z Nguyen Duc $
 */
class Manager_Component_Controller_Order_index extends Phpfox_Component
{
	private $_bEdit           = false;
	private $_bAdd            = false;
	private $_sTypeIdCategory = 'skirting';
	private $_sName           = 'đơn hàng';
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iDelete = $this->request()->getInt('delete');
		if($iDelete){
			$this->url()->clearParam('delete');
			if(!Phpfox::getUserParam('manager.can_del_skirting')){
				$this->url()->send('current');
			}

			$aRow = Phpfox::getService('manager.plan')->getSkirting($iDelete);
			if(!$aRow){
				$this->url()->send('current', array(), 'ID '.$this->_sName.' không hợp lệ');
			}

			if(Phpfox::getService('manager.plan.process')->deleteSkirting($iDelete)){
				$this->url()->send('current', array(), 'Xóa '.$this->_sName.' thành công!');
			}else{
				$this->url()->send('current', array(), 'Xóa '.$this->_sName.' không thành công!');
			}
		}

		$iId = $this->request()->getInt('id');
		$aRow = array();
		if($iId){
			$aRow = Phpfox::getService('manager.plan')->getSkirting($iId);
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
				Phpfox::getUserParam('manager.can_add_skirting', true);
			}

			$this->_validateForm($aVals, $aRow);
			if ($oValid->isValid($aVals)){
				if(!$this->_bEdit){
					if($iId = Phpfox::getService('manager.plan.process')->addSkirting($aVals)){
						$this->url()->send('current', null, 'Thêm '.$this->_sName.' thành công!');
					}else{
						Phpfox_Error::set('Thêm '.$this->_sName.' không thành công!');
					}
				}else{
					if(Phpfox::getService('manager.plan.process')->updateSkirting($aVals, $iId)){
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
        	$sOrder = 'o.time_stamp DESC';
        }

        list($iCnt, $aRows) = Phpfox::getService('manager.order')->getOrders($aSearchParams, $iPage, $iPageSize, $sOrder);
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
			Phpfox::getUserParam('manager.can_edit_skirting', true);
		}elseif($this->_bAdd){
			Phpfox::getUserParam('manager.can_add_skirting', true);
		}else{
			Phpfox::getUserParam('manager.can_view_list_skirting', true);
		}
	}
	
	/*
		Get thông tin mặc định ra template
	*/
	private function _getTemplate(){
		Phpfox::getService('manager.template')->getTemplate('Danh sách đơn hàng');
		if(Phpfox::getUserParam('manager.can_add_skirting')){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('manager.order.add').'" class="small">Thêm '.$this->_sName.'</a>';
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
			'AND sk.code = "'.$aVals['code'].'"',
		);
		if($this->_bEdit){
			$aCound[] = 'AND sk.code <> "'.$aDataEdit['code'].'"';
		}
		if(Phpfox::getService('manager.plan')->getCountSkirting($aCound)){
			Phpfox_Error::set('Mã '.$this->_sName.' đã trùng với một mã khác!');
			return false;
		}

		if(!isset($aVals['product_id']) || empty($aVals['product_id'])){
			Phpfox_Error::set('Bạn chưa chọn Class giá hoạch toán');
			return false;
		}

		if(!isset($aVals['color_id']) || empty($aVals['color_id'])){
			Phpfox_Error::set('Bạn chưa chọn giấy vân');
			return false;
		}

		if(!isset($aVals['hdf_id']) || empty($aVals['hdf_id'])){
			Phpfox_Error::set('Bạn chưa chọn HDF');
			return false;
		}

		if(!isset($aVals['flooringdim_id']) || empty($aVals['flooringdim_id'])){
			Phpfox_Error::set('Bạn chưa chọn kích thước');
			return false;
		}

		if(!isset($aVals['packing']) || empty($aVals['packing'])){
			Phpfox_Error::set('Bạn chưa nhập số lượng đóng gói');
			return false;
		}

		if(!isset($aVals['inventoried_unit'])){
			Phpfox_Error::set('Bạn chưa chọn đơn vị tính.');
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
				'all'   => 'Tất cả',
				'o.code'  => 'Mã ' . $this->_sName,
				'u.full_name'  => 'Tên khách hàng',
            ),
        );

		$aStatusOrder = ['all' => 'Tất cả'];
		$aStatusOrders = Phpfox::getService('manager.data')->getStatusOrder('all');
		if($aStatusOrders){
			foreach ($aStatusOrders as $key => $value) {
				$aStatusOrder[$key] = $value;
			}
		}

		$aFilters['status_id'] = array(
			'type'         => 'select',
			'options'      => $aStatusOrder,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Trạng thái đơn hàng'
        );

		$aFilters['sort'] = array(
			'type'         => 'select',
			'default_view' => 'sk.time_stamp',
			'mxlabel'      => 'Săp xếp',
			'class'        => 'form-control',
			'options'      => array(
				'o.code'       => 'Mã ' . $this->_sName,
				'o.time_stamp' => 'Thời gian tạo',
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
			'type'          => 'manager_order_index',
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
            		case 'all':
            			$oFilter->setCondition("OR o.code LIKE '%".$sKeyword."%'");
            			$oFilter->setCondition("OR u.full_name LIKE '%".$sKeyword."%'");
            		break;

            		default:
            			$oFilter->setCondition("AND ".$sSearchKey." LIKE '%".$sKeyword."%'");
            		break;
            	}
            }
        }

        if(($iStatusId = $oFilter->get('status_id')) || ($iStatusId = $this->request()->get('status_id'))){
        	if($iStatusId != 'all'){
        		$oFilter->setCondition("AND o.status_id = " . (int)$iStatusId);
        	}
        }
        
        return $oFilter->getConditions();
	}
}