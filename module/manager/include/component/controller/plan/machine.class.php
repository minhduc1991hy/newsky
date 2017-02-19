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
class Manager_Component_Controller_Plan_Machine extends Phpfox_Component
{
	private $_bEdit           = false;
	private $_bAdd            = false;
	private $_sTypeIdCategory = 'segment';
	private $_sName           = 'máy móc thiết bị';
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iDelete = $this->request()->getInt('delete');
		if($iDelete){
			$this->url()->clearParam('delete');
			if(!Phpfox::getUserParam('manager.can_del_machine')){
				$this->url()->send('current');
			}

			$aRow = Phpfox::getService('manager.plan')->getMachine($iDelete);
			if(!$aRow){
				$this->url()->send('current', array(), 'ID '.$this->_sName.' không hợp lệ');
			}

			if(Phpfox::getService('manager.plan.process')->deleteMachine($iDelete)){
				$this->url()->send('current', array(), 'Xóa '.$this->_sName.' thành công!');
			}else{
				$this->url()->send('current', array(), 'Xóa '.$this->_sName.' không thành công!');
			}
		}

		$iId = $this->request()->getInt('id');
		$aRow = array();
		if($iId){
			$aRow = Phpfox::getService('manager.plan')->getMachine($iId);
			if($aRow){
				$aRow['price_buy'] = number_format($aRow['price_buy'], '0', '', '');
				$aRow['date_buy'] = Phpfox::getTime(Phpfox::getParam('manager.time_stamp'), $aRow['date_buy']);
				$this->_bEdit = true;
			}
		}
		$this->_permission_access();
		$this->_checkAdd();

		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form_manager_add', 'aParams' => array()));
		$aVals  = $this->request()->get('val');
		if($aVals){
			if(!$this->_bEdit){
				Phpfox::getUserParam('manager.can_add_machine', true);
			}

			$this->_validateForm($aVals, $aRow);
			if ($oValid->isValid($aVals)){
				if(!$this->_bEdit){
					if($iId = Phpfox::getService('manager.plan.process')->addMachine($aVals)){
						$this->url()->send('current', null, 'Thêm '.$this->_sName.' thành công!');
					}else{
						Phpfox_Error::set('Thêm '.$this->_sName.' không thành công!');
					}
				}else{
					if(Phpfox::getService('manager.plan.process')->updateMachine($aVals, $iId)){
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
        	$sOrder = 'ma.time_stamp DESC';
        }

        list($iCnt, $aRows) = Phpfox::getService('manager.plan')->getMachines($aSearchParams, $iPage, $iPageSize, $sOrder);
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
			Phpfox::getUserParam('manager.can_edit_machine', true);
		}elseif($this->_bAdd){
			Phpfox::getUserParam('manager.can_add_machine', true);
		}else{
			Phpfox::getUserParam('manager.can_view_list_machine', true);
		}
	}
	
	/*
		Get thông tin mặc định ra template
	*/
	private function _getTemplate(){
		Phpfox::getService('manager.template')->getTemplate('Danh mục ' . $this->_sName);
		if(Phpfox::getUserParam('manager.can_add_machine')){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('manager.plan.machine.add').'" class="small">Thêm '.$this->_sName.'</a>';
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
			'AND ma.code = "'.$aVals['code'].'"',
		);
		if($this->_bEdit){
			$aCound[] = 'AND ma.code <> "'.$aDataEdit['code'].'"';
		}
		if(Phpfox::getService('manager.plan')->getCountMachine($aCound)){
			Phpfox_Error::set('Mã '.$this->_sName.' đã trùng với một mã khác!');
			return false;
		}

		if(!isset($aVals['price_buy']) || empty($aVals['price_buy'])){
			Phpfox_Error::set('Bạn chưa nhập giá mua');
			return false;
		}

		if(!isset($aVals['date_buy']) || empty($aVals['date_buy'])){
			Phpfox_Error::set('Bạn chưa chọn ngày mua');
			return false;
		}

		if(!isset($aVals['product_id']) || empty($aVals['product_id'])){
			Phpfox_Error::set('Bạn chưa chọn công đoạn');
			return false;
		}

		$aDate = explode('/', $aVals['date_buy']);
		if(count($aDate) > 3 || count($aDate) < 3){
			Phpfox_Error::set('Định dạng ngày tháng phải ngày/tháng/năm.');
			return false;
		}
		$iDay   = $aDate[0];
		$iMonth = $aDate[1];
		$iYear  = $aDate[2];
		$aVals['date_buy'] = Phpfox::getLib('date')->mktime(12, 0, 0, $iMonth, $iDay, $iYear);
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
			'mxlabel'      => 'Công đoạn'
        );

        $aFilters['date_rage'] = array(
			'type'    => 'input:text',
			'size'    => 15,
			'class'   => 'date_rage form-control',
			'mxlabel' => 'Ngày mua'
        );

		$aFilters['sort'] = array(
			'type'         => 'select',
			'default_view' => 'ma.time_stamp',
			'mxlabel'      => 'Săp xếp',
			'class'        => 'form-control',
			'options'      => array(
				'ma.code'       => 'Mã ' . $this->_sName,
				'ma.time_stamp' => 'Thời gian tạo',
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
			'type'          => 'manager_plan_machine',
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
            			$oFilter->setCondition("AND ma.".$sSearchKey." LIKE '%".$sKeyword."%'");
            		break;

            		default:
						$oFilter->setCondition("OR ma.code LIKE '%".$sKeyword."%'");
            		break;
            	}
            }
        }

        if(($iProductId = $oFilter->get('product_id')) || ($iProductId = $this->request()->get('product_id'))){
        	if($iProductId != 'all'){
        		$oFilter->setCondition("AND ma.product_id = " . (int)$iProductId);
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
                    $oFilter->setCondition("AND ma.date_buy BETWEEN " . $iStart . " AND " . $iEnd);
                }
            }
        }

        return $oFilter->getConditions();
	}
}