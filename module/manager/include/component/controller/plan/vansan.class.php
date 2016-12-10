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
 * @version 		$Id: Vansan.class.php 103 2009-01-27 11:32:36Z Nguyen Duc $
 */
class Manager_Component_Controller_Plan_Vansan extends Phpfox_Component
{
	private $_bEdit           = false;
	private $_bAdd            = false;
	private $_sTypeIdCategory = 'vansan';
	private $_sName           = 'ván sàn';
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iDelete = $this->request()->getInt('delete');
		if($iDelete){
			$this->url()->clearParam('delete');
			if(!Phpfox::getUserParam('manager.can_del_vansan')){
				$this->url()->send('current');
			}

			$aRow = Phpfox::getService('manager.plan')->getVansan($iDelete);
			if(!$aRow){
				$this->url()->send('current', array(), 'ID '.$this->_sName.' không hợp lệ');
			}

			if(Phpfox::getService('manager.plan.process')->deleteVansan($iDelete)){
				$this->url()->send('current', array(), 'Xóa '.$this->_sName.' thành công!');
			}else{
				$this->url()->send('current', array(), 'Xóa '.$this->_sName.' không thành công!');
			}
		}

		$iId = $this->request()->getInt('id');
		$aRow = array();
		if($iId){
			$aRow = Phpfox::getService('manager.plan')->getVansan($iId);
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
				Phpfox::getUserParam('manager.can_add_vansan', true);
			}

			$this->_validateForm($aVals, $aRow);
			if ($oValid->isValid($aVals)){
				if(!$this->_bEdit){
					if($iId = Phpfox::getService('manager.plan.process')->addVansan($aVals)){
						$this->url()->send('current', null, 'Thêm '.$this->_sName.' thành công!');
					}else{
						Phpfox_Error::set('Thêm '.$this->_sName.' không thành công!');
					}
				}else{
					if(Phpfox::getService('manager.plan.process')->updateVansan($aVals, $iId)){
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
        	$sOrder = 'vs.time_stamp DESC';
        }
        
        list($iCnt, $aRows) = Phpfox::getService('manager.plan')->getVansans($aSearchParams, $iPage, $iPageSize, $sOrder);
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
			Phpfox::getUserParam('manager.can_edit_vansan', true);
		}elseif($this->_bAdd){
			Phpfox::getUserParam('manager.can_add_vansan', true);
		}else{
			Phpfox::getUserParam('manager.can_view_list_vansan', true);
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

		Phpfox::getService('manager.template')->getTemplate('Danh mục ' . $this->_sName);
		if(Phpfox::getUserParam('manager.can_add_vansan')){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('manager.plan.vansan.add').'" class="small">Thêm '.$this->_sName.'</a>';
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
			'AND vs.code = "'.$aVals['code'].'"',
		);
		if($this->_bEdit){
			$aCound[] = 'AND vs.code <> "'.$aDataEdit['code'].'"';
		}

		if(Phpfox::getService('manager.plan')->getCountVansan($aCound)){
			Phpfox_Error::set('Mã '.$this->_sName.' đã trùng với một mã khác!');
			return false;
		}

		if(!isset($aVals['unit']) || $aVals['unit'] == ''){
			Phpfox_Error::set('Bạn chưa chọn đơn vị tính');
			return false;
		}

		if(!isset($aVals['product_id']) || empty($aVals['product_id'])){
			Phpfox_Error::set('Bạn chưa chọn giá hoạch toán');
			return false;
		}

		if(!isset($aVals['color_id']) || empty($aVals['color_id'])){
			Phpfox_Error::set('Bạn chưa chọn giấy vân');
			return false;
		}

		if(!isset($aVals['color_id_cx']) || empty($aVals['color_id_cx'])){
			Phpfox_Error::set('Bạn chưa chọn giấy chống xước');
			return false;
		}

		if(!isset($aVals['hdf_id']) || empty($aVals['hdf_id'])){
			Phpfox_Error::set('Bạn chưa chọn HDF');
			return false;
		}

		if(!isset($aVals['color_id_cb']) || empty($aVals['color_id_cb'])){
			Phpfox_Error::set('Bạn chưa chọn giấy cân bằng');
			return false;
		}

		if(!isset($aVals['vat_canh']) || $aVals['vat_canh'] == ''){
			Phpfox_Error::set('Bạn chưa chọn vát cạnh');
			return false;
		}

		if(!isset($aVals['kieu_ranh']) || $aVals['kieu_ranh'] == ''){
			Phpfox_Error::set('Bạn chưa chọn kiểu rãnh');
			return false;
		}

		if(!isset($aVals['be_mat']) || $aVals['be_mat'] == ''){
			Phpfox_Error::set('Bạn chưa chọn bề mặt');
			return false;
		}

		if(!isset($aVals['khuon_duoi']) || $aVals['khuon_duoi'] == ''){
			Phpfox_Error::set('Bạn chưa chọn khuôn dưới');
			return false;
		}

		if(!isset($aVals['flooringdim_id']) || empty($aVals['flooringdim_id'])){
			Phpfox_Error::set('Bạn chưa chọn kích thước');
			return false;
		}

		if(!isset($aVals['packing'])){
			Phpfox_Error::set('Bạn chưa nhập số lượng đóng gói');
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
				'code'  => 'Mã ' . $this->_sName,
            ),
        );

		$aDataDB = Phpfox::getService('manager.category')->getCategories($this->_sTypeIdCategory);
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $aData) {
	        	$aDatas[$aData['product_id']] = $aData['title'] . (!empty($aData['description']) ? ' ('.$aData['description'].')' : '');
	        }
        }

        $aFilters['product_id'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Class hoạch toán'
        );

        $aDataDB = Phpfox::getService('manager.plan')->getAllColorSchemas();
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $aData) {
	        	$aDatas[$aData['color_id']] = $aData['code'] . (!empty($aData['title']) ? ' ('.$aData['title'].')' : '');
	        }
        }

        $aFilters['color_id'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Giấy vân'
        );

        $aDataDB = Phpfox::getService('manager.plan')->getCodeLikeColorSchemas('cx');
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $aData) {
	        	$aDatas[$aData['color_id']] = $aData['code'] . (!empty($aData['title']) ? ' ('.$aData['title'].')' : '');
	        }
        }

        $aFilters['color_id_cx'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Giấy chống xước'
        );

        $aDataDB = Phpfox::getService('manager.plan')->getCodeLikeColorSchemas('cb');
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $aData) {
	        	$aDatas[$aData['color_id']] = $aData['code'] . (!empty($aData['title']) ? ' ('.$aData['title'].')' : '');
	        }
        }

        $aFilters['color_id_cb'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Giấy cân bằng'
        );

        $aDataDB = Phpfox::getService('manager.supplies')->getAllHdfs();
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $aData) {
	        	$aDatas[$aData['hdf_id']] = $aData['code'] . (!empty($aData['description']) ? ' ('.$aData['description'].')' : '');
	        }
        }

        $aFilters['hdf_id'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'HDF'
        );

        $aDataDB = Phpfox::getService('manager.plan')->getAllFlooringDims();
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $aData) {
	        	$aDatas[$aData['flooringdim_id']] = $aData['code'] . ' (' . $aData['width']. ' x ' . $aData['length']. ' x ' . $aData['thickness'] . ')';
	        }
        }

        $aFilters['flooringdim_id'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Kích thước'
        );

        $aDataDB = Phpfox::getService('manager.data')->getDataKieuVatCanh();
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $sData) {
				if($ikey == 0) $ikey = 'khong';
	        	$aDatas[$ikey] = $sData;
	        }
        }

        $aFilters['vat_canh'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Vát cạnh'
        );

        $aDataDB = Phpfox::getService('manager.data')->getDataKieuRanh();
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $sData) {
				if($ikey == 0) $ikey = 'khong';
	        	$aDatas[$ikey] = $sData;
	        }
        }

        $aFilters['kieu_ranh'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Kiểu rãnh'
        );

        $aDataDB = Phpfox::getService('manager.data')->getDataBeMat();
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $sData) {
				if($ikey == 0) $ikey = 'khong';
	        	$aDatas[$ikey] = $sData;
	        }
        }

        $aFilters['be_mat'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Bề mặt'
        );

        $aDataDB = Phpfox::getService('manager.data')->getDataKhuonDuoi();
		$aDatas = array('all' => 'Tất cả');
		if($aDataDB){
			foreach ($aDataDB as $ikey => $sData) {
				if($ikey == 0) $ikey = 'khong';
	        	$aDatas[$ikey] = $sData;
	        }
        }

        $aFilters['khuon_duoi'] = array(
			'type'         => 'select',
			'options'      => $aDatas,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Khuôn dưới'
        );

   //      $aFilters['date_rage'] = array(
			// 'type'    => 'input:text',
			// 'size'    => 15,
			// 'class'   => 'date_rage form-control',
			// 'mxlabel' => 'Ngày mua'
   //      );

		$aFilters['sort'] = array(
			'type'         => 'select',
			'default_view' => 'vs.time_stamp',
			'mxlabel'      => 'Săp xếp',
			'class'        => 'form-control',
			'options'      => array(
				'vs.code'       => 'Mã ' . $this->_sName,
				'vs.time_stamp' => 'Thời gian tạo',
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
			'type'          => 'manager_plan_vansan',
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
            			$oFilter->setCondition("AND vs.".$sSearchKey." LIKE '%".$sKeyword."%'");
            		break;

            		default:
						$oFilter->setCondition("OR vs.code LIKE '%".$sKeyword."%'");
            		break;
            	}
            }
        }

        if(($iProductId = $oFilter->get('product_id')) || ($iProductId = $this->request()->get('product_id'))){
        	if($iProductId != 'all'){
        		$oFilter->setCondition("AND vs.product_id = " . (int)$iProductId);
        	}
        }

        if(($color_id = $oFilter->get('color_id')) || ($color_id = $this->request()->get('color_id'))){
        	if($color_id != 'all'){
        		$oFilter->setCondition("AND vs.color_id = " . (int)$color_id);
        	}
        }

        if(($color_id_cx = $oFilter->get('color_id_cx')) || ($color_id_cx = $this->request()->get('color_id_cx'))){
        	if($color_id_cx != 'all'){
        		$oFilter->setCondition("AND vs.color_id_cx = " . (int)$color_id_cx);
        	}
        }

        if(($color_id_cb = $oFilter->get('color_id_cb')) || ($color_id_cb = $this->request()->get('color_id_cb'))){
        	if($color_id_cb != 'all'){
        		$oFilter->setCondition("AND vs.color_id_cb = " . (int)$color_id_cb);
        	}
        }

        if(($hdf_id = $oFilter->get('hdf_id')) || ($hdf_id = $this->request()->get('hdf_id'))){
        	if($hdf_id != 'all'){
        		$oFilter->setCondition("AND vs.hdf_id = " . (int)$hdf_id);
        	}
        }

        if(($flooringdim_id = $oFilter->get('flooringdim_id')) || ($flooringdim_id = $this->request()->get('flooringdim_id'))){
        	if($flooringdim_id != 'all'){
        		$oFilter->setCondition("AND vs.flooringdim_id = " . (int)$flooringdim_id);
        	}
        }


        if(($vat_canh = $oFilter->get('vat_canh')) || ($vat_canh = $this->request()->get('vat_canh'))){
        	if($vat_canh != 'all'){
        		$oFilter->setCondition("AND vs.vat_canh = " . (int)$vat_canh);
        	}
        }

        if(($kieu_ranh = $oFilter->get('kieu_ranh')) || ($kieu_ranh = $this->request()->get('kieu_ranh'))){
        	if($vat_canh != 'all'){
        		$oFilter->setCondition("AND vs.kieu_ranh = " . (int)$kieu_ranh);
        	}
        }

        if(($be_mat = $oFilter->get('be_mat')) || ($be_mat = $this->request()->get('be_mat'))){
        	if($vat_canh != 'all'){
        		$oFilter->setCondition("AND vs.be_mat = " . (int)$be_mat);
        	}
        }
        if(($khuon_duoi = $oFilter->get('khuon_duoi')) || ($khuon_duoi = $this->request()->get('khuon_duoi'))){
        	if($vat_canh != 'all'){
        		$oFilter->setCondition("AND vs.khuon_duoi = " . (int)$khuon_duoi);
        	}
        }

        if(($date_rage = $oFilter->get('date_rage')) || ($date_rage = $this->request()->get('date_rage'))){
            $date_rage = explode('-', $date_rage);
            if($date_rage){
	            foreach ($date_rage as $key => $value) {
	                $date_rage[$key] = trim($value);
	            }
            }
            if(!empty($date_rage)){
                $iStart = 0;
                $iEnd = 0;
                foreach ($date_rage as $key => $value) {
                    $Time = explode('/', $value);
                    if(isset($Time['1']) && isset($Time['0']) && $Time['2']){
	                    if($key == 0){
	                        $iStart = Phpfox::getLib('date')->mktime(0, 0, 0, $Time['1'], $Time['0'], $Time['2']);
	                    }else{
	                        $iEnd = Phpfox::getLib('date')->mktime(23, 59, 59, $Time['1'], $Time['0'], $Time['2']);
	                    }
                    }
                }
                if($iStart > 0 && $iEnd > 0){
                    $oFilter->setCondition("AND vs.time_stamp BETWEEN " . $iStart . " AND " . $iEnd);
                }
            }
        }

        return $oFilter->getConditions();
	}
}