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
class Manager_Component_Ajax_Order_Ajax extends Phpfox_Ajax
{
	/**
	 * Thêm sản phẩm session
	 */
	public function addProductOrder(){
		$this->call('$Core.hideLoadding();');
		$aVals = $this->get('val');

		switch ($aVals['type_id']) {
			case 'edit_product':
				if(!isset($aVals['item_id']) || empty($aVals['item_id'])){
					return Phpfox_Error::set('ID sản phẩm không tồn tại');
				}
			break;

			case 'add_product':
				if(!isset($aVals['item_id']) || empty($aVals['item_id'])){
					return Phpfox_Error::set('Không tồn tại mã giỏ hàng');
				}
			break;

			default:
				
				if(!isset($aVals['item_id']) || empty($aVals['item_id'])){
					return Phpfox_Error::set('Thông tin thành viên không tồn tại.');
				}

			break;
		}

		if(!isset($aVals['vansan_id']) || empty($aVals['vansan_id'])){
			return Phpfox_Error::set('Bạn chưa chọn ván sàn');
		}

		if(!isset($aVals['skirting_id']) || empty($aVals['skirting_id'])){
			return Phpfox_Error::set('Bạn chưa chọn phào chân tường');
		}

		if(!isset($aVals['quantity']) || (int)$aVals['quantity'] <= 0){
			return Phpfox_Error::set('Số lượng phải lớn hơn 0');
		}

		if(!isset($aVals['deadline']) || empty($aVals['deadline'])){
			return Phpfox_Error::set('Bạn chưa chọn ngày giao hàng');
		}

		$aDeadline = explode('/', $aVals['deadline']);
		if(!isset($aDeadline[0]) || !isset($aDeadline[1]) || !isset($aDeadline[2])){
			return Phpfox_Error::set('Bạn chưa chọn ngày tháng hoặc ngày tháng không đúng định dạng (dd/mm/yyyy)');
		}
		$aVals['deadline'] = Phpfox::getLib('date')->mktime(12, 0, 0, $aDeadline['1'], $aDeadline[0], $aDeadline['2']);
		if($aVals['deadline'] < PHPFOX_TIME){
			return Phpfox_Error::set('Ngày giao hàng phải lơn hơn ngày hiện tại');
		}
		
		$aProduct = array(
			'vansan_id'   => $aVals['vansan_id'],
			'skirting_id' => $aVals['skirting_id'],
			'quantity'    => $aVals['quantity'],
			'deadline'    => $aVals['deadline'],
			'description' => $aVals['description'],
		);

		switch ($aVals['type_id']) {
			case 'edit_product':

				if(Phpfox::getService('manager.order.process')->updateProduct($aVals['item_id'], $aProduct)){
					$this->call('location.reload();');
				}else{
					return Phpfox_Error::set('Sửa sản phẩm không thành công!');
				}

			break;

			case 'add_product':
			
				if(Phpfox::getService('manager.order.process')->addProduct($aVals['item_id'], $aProduct)){
					$this->call('location.reload();');
				}else{
					return Phpfox_Error::set('Sửa sản phẩm không thành công!');
				}

			break;

			default:
				
				$aOrderSession = Phpfox::getService('manager.order')->getSessionOrder();
				$iUserId       = $aVals['item_id'];
				$aOrderSession[$iUserId]['products'][] = $aProduct;
				Phpfox::getService('manager.order')->setSessionOrder($aOrderSession);
				$this->call('location.reload();');

			break;
		}
		

		
	}

	/**
	 * Get form thêm sản phẩm
	 */
	public function formAddProduct(){
		Phpfox::getBlock('manager.order.add-product', array(
			'type'    => $this->get('type'),
			'item_id' => $this->get('item_id'),
		));
	}

	/**
	 * search Customer Form
	 */
	public function searchCustomerForm(){
		Phpfox::getBlock('manager.order.search-customer', array(
			'type_id'    => $this->get('type_id'),
			'item_id' => $this->get('item_id'),
		));
	}

	/**
	 * Remove order Session
	 */
	public function removeOrder(){
		$this->call('$Core.hideLoadding();');
		$iUserId        = $this->get('user_id');
		$iUserIdCurrent = $this->get('user_id_current');
		$iUserRedirect = Phpfox::getService('manager.order')->removeOrder($iUserId);
		if($iUserIdCurrent == $iUserId){
			$aParam = array();
			if($iUserRedirect){
				$aParam = array('user' => $iUserRedirect);
			}
			$LinkRedirect = Phpfox::getLib('url')->makeUrl('manager.order.add', $aParam);
			$this->call('window.location="'.$LinkRedirect.'";');
		}else{
			$this->call('location.reload();');
		}
	}

	/**
	 * Reset sản phẩm session
	 */
	public function resetProduct(){
		$this->call('$Core.hideLoadding();');
		$aOrderSession = Phpfox::getService('manager.order')->getSessionOrder();
		$iUserId       = $this->get('user_id');
		$aOrderSession[$iUserId]['products'] = array();
		Phpfox::getService('manager.order')->setSessionOrder($aOrderSession);
		$this->call('location.reload();');
	}

	/**
	 * Remove sản phẩm session
	 */
	public function removeProduct(){
		$this->call('$Core.hideLoadding();');
		$aOrderSession = Phpfox::getService('manager.order')->getSessionOrder();
		$iUserId       = $this->get('user_id');
		$iProductId    = $this->get('product_id');
		unset($aOrderSession[$iUserId]['products'][$iProductId]);
		Phpfox::getService('manager.order')->setSessionOrder($aOrderSession);
		$this->call('location.reload();');
	}

	/**
	 * Insert Order to Database
	 */
	public function addOrder(){
		$this->call('$Core.hideLoadding();');
		$iUserId       = $this->get('user_id');
		$aOrderSession = Phpfox::getService('manager.order')->getSessionOrder();
		if(!isset($aOrderSession[$iUserId]['products']) || empty($aOrderSession[$iUserId]['products'])){
			return Phpfox_Error::set('Thông tin sản phẩm đơn hàng không tồn tại');
		}

		if(Phpfox::getService('manager.order.process')->add($iUserId, $aOrderSession[$iUserId]['products'])){
			$iUserRedirect = Phpfox::getService('manager.order')->removeOrder($iUserId);
			$aParam = array();
			if($iUserRedirect){
				$aParam = array('user' => $iUserRedirect);
			}
			$LinkRedirect = Phpfox::getLib('url')->makeUrl('manager.order.add', $aParam);
			$this->call('window.location="'.$LinkRedirect.'";');
		}else{
			return Phpfox_Error::set('Đặt hàng không thành công!');
		}
	}

	/**
	 * Delete Product In database
	 */
	public function deleteProduct(){
		$this->call('$Core.hideLoadding();');
		$iProductId = $this->get('product_id');
		if(Phpfox::getService('manager.order.process')->deleteProduct($iProductId)){
			$this->call('$(".product_'.$iProductId.'").remove();');
		}else{
			return Phpfox_Error::set('Xóa sản phẩm đơn hàng không thành công!');
		}
	}

	/**
	 * Update customer order
	 */
	public function updateCustomerOrder(){
		$OrderId = $this->get('OrderId');
		$iUserId = $this->get('iUserId');
		if(Phpfox::getService('manager.order.process')->updateCustomerOrder($OrderId, $iUserId)){
			$this->call('location.reload();');
		}else{
			return Phpfox_Error::set('Cập nhật khách hàng mới không thành công!');
		}
	}
}