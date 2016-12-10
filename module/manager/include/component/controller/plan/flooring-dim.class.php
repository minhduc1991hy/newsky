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
 * @version 		$Id: flooring-dim.class.php 103 2009-01-27 11:32:36Z Nguyen Duc $
 */
class Manager_Component_Controller_Plan_Flooring_Dim extends Phpfox_Component
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
			if(!Phpfox::getUserParam('manager.can_del_flooring_dim')){
				$this->url()->send('current');
			}

			$aFlooringDim = Phpfox::getService('manager.plan')->getFlooringDim($iDelete);
			if(!$aFlooringDim){
				$this->url()->send('current', array(), 'ID ván sàn không hợp lệ');
			}

			if(Phpfox::getService('manager.plan.process')->deleteFlooringDim($iDelete)){
				$this->url()->send('current', array(), 'Xóa ván sàn thành công!');
			}else{
				$this->url()->send('current', array(), 'Xóa ván sàn không thành công!');
			}
		}


		$iFlooringdimId = $this->request()->getInt('id');
		$aFlooringDim = array();
		if($iFlooringdimId){
			$aFlooringDim = Phpfox::getService('manager.plan')->getFlooringDim($iFlooringdimId);
			if($aFlooringDim){
				$this->_bEdit = true;
			}
		}

		$this->_permission_access();
		$this->_checkAdd();

		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form_manager_add', 'aParams' => array()));
		$aVals  = $this->request()->get('val');
		if($aVals){
			if(!$this->_bEdit){
				Phpfox::getUserParam('manager.can_add_flooring_dim', true);
			}

			$this->_validateForm($aVals, $aFlooringDim);
			if ($oValid->isValid($aVals)){
				if(!$this->_bEdit){
					if($iFlooringdimId = Phpfox::getService('manager.plan.process')->addFlooringDim($aVals)){
						$this->url()->send('current', null, 'Thêm ván sàn thành công!');
					}else{
						Phpfox_Error::set('Thêm ván sàn không thành công!');
					}
				}else{
					if(Phpfox::getService('manager.plan.process')->updateFlooringDim($aVals, $iFlooringdimId)){
						$this->url()->send('current', null, 'Sửa ván sàn thành công!');
					}else{
						Phpfox_Error::set('Sửa ván sàn không thành công!');
					}
				}
			}
		}

		$this->template()->assign(array(
			'aForms'          => $aFlooringDim,
			'bEdit'           => $this->_bEdit,
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
        	$sOrder = 'fd.time_stamp DESC';
        }

        list($iCnt, $aFlooringDims) = Phpfox::getService('manager.plan')->getFlooringDims($aSearchParams, $iPage, $iPageSize, $sOrder);
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
        Phpfox::getLib('url')->setParam('page', $iPage);
        $this->template()->assign(array(
			'aFlooringDims' => $aFlooringDims,
			'iNo'           => $iPageSize * ($iPage <= 0 ? $iPage : $iPage - 1),
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
			Phpfox::getUserParam('manager.can_edit_flooring_dim', true);
		}elseif($this->_bAdd){
			Phpfox::getUserParam('manager.can_add_flooring_dim', true);
		}else{
			Phpfox::getUserParam('manager.can_view_list_flooring_dim', true);
		}
	}
	
	/*
		Get thông tin mặc định ra template
	*/
	private function _getTemplate(){
		Phpfox::getService('manager.template')->getTemplate('Kích cỡ ván sàn NEWSKY ');
		if(Phpfox::getUserParam('manager.can_add_flooring_dim')){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('manager.plan.flooring-dim.add').'" class="small">Thêm ván sàn mới</a>';
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
			Phpfox_Error::set('Bạn chưa nhập mã ván sàn');
			return false;
		}

		$aCound = array(
			'AND fd.code = "'.$aVals['code'].'"',
		);
		if($this->_bEdit){
			$aCound[] = 'AND fd.code <> "'.$aDataEdit['code'].'"';
		}
		if(Phpfox::getService('manager.plan')->getCountFlooringDim($aCound)){
			Phpfox_Error::set('Mã ván sàn đã trùng với một mã khác!');
			return false;
		}

		if(!isset($aVals['width']) || empty($aVals['width'])){
			Phpfox_Error::set('Bạn chưa nhập chiều rộng cho ván sàn');
			return false;
		}

		if(!isset($aVals['length']) || empty($aVals['length'])){
			Phpfox_Error::set('Bạn chưa nhập chiều dài cho ván sàn');
			return false;
		}

		if(!isset($aVals['thickness']) || empty($aVals['thickness'])){
			Phpfox_Error::set('Bạn chưa nhập độ dày cho ván sàn');
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
				'code'  => 'Mã ván sàn',
            ),
        );

		$aFilters['sort'] = array(
			'type'         => 'select',
			'default_view' => 'fd.time_stamp',
			'mxlabel'      => 'Săp xếp',
			'class'        => 'form-control',
			'options'      => array(
				'fd.code'       => 'Mã ván sàn',
				'fd.width'      => 'Chiều rộng',
				'fd.length'     => 'Chiều dài',
				'fd.thickness'  => 'Độ dày',
				'fd.time_stamp' => 'Thời gian tạo',
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
			'type'          => 'manager_plan_flooring_dim',
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
            			$oFilter->setCondition("AND fd.".$sSearchKey." LIKE '%".$sKeyword."%'");
            		break;

            		default:
						$oFilter->setCondition("OR fd.code LIKE '%".$sKeyword."%'");
            		break;
            	}
            }
        }

        return $oFilter->getConditions();
	}
}