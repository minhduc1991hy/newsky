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
 * @package  		Module_Manager
 * @version 		$Id: ajax.class.php 6742 2013-10-07 15:07:33Z Nguyen_Duc $
 */
class Manager_Component_Ajax_Category_Ajax extends Phpfox_Ajax
{
	/**
	 * Đây là function gọi block list danh mục sản phẩm
	 * @param string $sTypeId
	 * @return string html
	 */
	public function listCategory(){
		$aParams = array(
			'sTypeId' => $this->get('sTypeId'),
		);
		Phpfox::getBlock('manager.category.list-category', $aParams);
	}


	/**
	 * get block form category product
	 * @param string $sTypeId
	 * @param int $iProductId
	 * @return string html
	 */
	public function getFormAddCategory(){
		$aParams = array(
			'sTypeId'    => $this->get('sTypeId'),
			'iProductId' => $this->get('iProductId'),
		);
		Phpfox::getBlock('manager.category.add-category', $aParams);
		$this->html('#form_add_category_product', $this->getContent(false));
	}

	/**
	 * Đây là function xử lý khi submit form AddCategoryProduct
	 * @param array $aVals
	 * @return string html
	 */
	public function submitAddCategory(){
		$this->call('$Core.hideLoadding();');
		$aVals = $this->get('val');
		$bEdit = false;
		if(isset($aVals['product_id']) && !empty($aVals['product_id'])){
			$bEdit = true;
		}

		if(!isset($aVals['type_id']) || empty($aVals['type_id'])){
			return $this->alert('Không tồn tại TYPE ID');
		}

		$sTextTypeId = Phpfox::getService('manager.category.data')->getCategoryTypeIdData($aVals['type_id']);
		if(!$sTextTypeId){
			return $this->alert('TYPE ID không hợp lệ');
		}

		if(!isset($aVals['title']) || empty($aVals['title'])){
			return $this->alert('Bạn chưa nhập tiêu đề danh mục');
		}
		
		if($bEdit){
			if(Phpfox::getService('manager.category.process')->updateAccountingData($aVals, $aVals['product_id'])){

				$aParams = array('sTypeId' => $aVals['type_id']);
				Phpfox::getBlock('manager.category.list-category-display', $aParams);
				$this->html('#list_category_product_display', $this->getContent(false));
				
				return false;
			}else{
				return $this->alert('Sửa danh mục sản phẩm không thành công!');
			}
		}else{
			if($iId = Phpfox::getService('manager.category.process')->addAccountingData($aVals)){
				$this->call('$("#js_add_category_product input[type=text]").val("");');

				$aParams = array('sTypeId' => $aVals['type_id']);
				Phpfox::getBlock('manager.category.list-category-display', $aParams);
				$this->html('#list_category_product_display', $this->getContent(false));

				return false;
			}else{
				return $this->alert('Thêm mới danh mục sản phẩm không thành công!');
			}
		}
	}
}

?>