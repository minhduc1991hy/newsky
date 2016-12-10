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
class Manager_Component_Controller_Plan_Color_Code extends Phpfox_Component
{
	private $_bEdit           = false;
	private $_bAdd            = false;
	private $_sTypeIdCategory = 'color_schema';
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iDelete = $this->request()->getInt('delete');
		if($iDelete){
			$this->url()->clearParam('delete');
			if(!Phpfox::getUserParam('manager.can_del_color_code')){
				$this->url()->send('current');
			}

			$aColorSchema = Phpfox::getService('manager.plan')->getColorSchema($iDelete);
			if(!$aColorSchema){
				$this->url()->send('current', array(), 'ID màu không hợp lệ');
			}

			if(Phpfox::getService('manager.plan.process')->deleteColorSchema($iDelete)){
				$this->url()->send('current', array(), 'Xóa màu thành công!');
			}else{
				$this->url()->send('current', array(), 'Xóa màu không thành công!');
			}
		}


		$iColorId = $this->request()->getInt('id');
		$aColorSchema = array();
		if($iColorId){
			$aColorSchema = Phpfox::getService('manager.plan')->getColorSchema($iColorId);
			if($aColorSchema){
				$this->_bEdit = true;
			}
		}
		$this->_permission_access();
		$this->_checkAdd();

		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form_manager_add', 'aParams' => array()));
		$aVals  = $this->request()->get('val');
		if($aVals){
			if(!$this->_bEdit){
				Phpfox::getUserParam('manager.can_add_color_code', true);
			}

			$this->_validateForm($aVals, $aColorSchema);
			if ($oValid->isValid($aVals)){
				if(!$this->_bEdit){
					if($iColorId = Phpfox::getService('manager.plan.process')->addColorSchema($aVals)){
						$this->url()->send('current', null, 'Thêm màu thành công!');
					}else{
						Phpfox_Error::set('Thêm màu không thành công!');
					}
				}else{
					if(Phpfox::getService('manager.plan.process')->updateColorSchema($aVals, $iColorId)){
						$this->url()->send('current', null, 'Sửa màu thành công!');
					}else{
						Phpfox_Error::set('Sửa màu không thành công!');
					}
				}
			}
		}

		$this->template()->assign(array(
			'aForms'          => $aColorSchema,
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
        	$sOrder = 'cs.time_stamp DESC';
        }

        list($iCnt, $aColorSchemas) = Phpfox::getService('manager.plan')->getColorSchemas($aSearchParams, $iPage, $iPageSize, $sOrder);
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
        Phpfox::getLib('url')->setParam('page', $iPage);
        $this->template()->assign(array(
			'aColorSchemas' => $aColorSchemas,
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
			Phpfox::getUserParam('manager.can_edit_color_code', true);
		}elseif($this->_bAdd){
			Phpfox::getUserParam('manager.can_add_color_code', true);
		}else{
			Phpfox::getUserParam('manager.can_view_list_color_code', true);
		}
	}
	
	/*
		Get thông tin mặc định ra template
	*/
	private function _getTemplate(){
		Phpfox::getService('manager.template')->getTemplate('Bảng màu NEWSKY');
		if(Phpfox::getUserParam('manager.can_add_color_code')){
			$sTitleExtents = '<a href="'.Phpfox::getLib('url')->makeUrl('manager.plan.color-code.add').'" class="small">Thêm màu mới</a>';
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
			Phpfox_Error::set('Bạn chưa nhập mã màu');
			return false;
		}

		$aCound = array(
			'AND cs.code = "'.$aVals['code'].'"',
		);
		if($this->_bEdit){
			$aCound[] = 'AND cs.code <> "'.$aDataEdit['code'].'"';
		}
		if(Phpfox::getService('manager.plan')->getCountColorSchema($aCound)){
			Phpfox_Error::set('Mã màu đã trùng với một mã khác!');
			return false;
		}

		if(!isset($aVals['title']) || empty($aVals['title'])){
			Phpfox_Error::set('Bạn chưa nhập tiêu đề màu');
			return false;
		}

		if(!isset($aVals['product_id']) || empty($aVals['product_id'])){
			Phpfox_Error::set('Bạn chưa chọn danh mục cho mã màu');
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
				'code'  => 'Mã màu',
				'title' => 'Tiêu đề',
            ),
        );

        $aCategorys = Phpfox::getService('manager.category')->getCategories($this->_sTypeIdCategory);
		$aCategory = array('all' => 'Tất cả');
		foreach ($aCategorys as $ikey => $aValue) {
        	$aCategory[$aValue['product_id']] = $aValue['title'] . (!empty($aValue['description']) ? ' ('.$aData['description'].')' : '');
        }

        $aFilters['product_id'] = array(
			'type'         => 'select',
			'options'      => $aCategory,
			'default_view' => 'all',
			'class'        => 'form-control',
			'mxlabel'      => 'Danh mục'
        );

		$aFilters['sort'] = array(
			'type'         => 'select',
			'default_view' => 's.time_stamp',
			'mxlabel'      => 'Săp xếp',
			'class'        => 'form-control',
			'options'      => array(
				'cs.code'       => 'Mã màu',
				'cs.title'      => 'Tiêu đề',
				'cs.time_stamp' => 'Thời gian tạo',
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
			'type'          => 'manager_plan_color_code',
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
            		case 'title':
            			$oFilter->setCondition("AND cs.".$sSearchKey." LIKE '%".$sKeyword."%'");
            		break;

            		default:
						$oFilter->setCondition("OR cs.code LIKE '%".$sKeyword."%'");
						$oFilter->setCondition("OR cs.title LIKE '%".$sKeyword."%'");
            		break;
            	}
            }
        }

        if(($iProductId = $oFilter->get('product_id')) || ($iProductId = $this->request()->get('product_id'))){
        	if($iProductId != 'all'){
        		$oFilter->setCondition("AND cs.product_id = " . (int)$iProductId);
        	}
        }

        return $oFilter->getConditions();
	}
}