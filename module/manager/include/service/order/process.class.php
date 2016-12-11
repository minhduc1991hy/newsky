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
 * @package  		Module_accounting
 * @version 		$Id: process.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Order_Process extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableOrder        = Phpfox::getT('ns_order');
		$this->_sTableOrderProduct = Phpfox::getT('ns_order_product');
	}

	public function add($iUserId, $aProducts){
		if($iUserId && $aProducts){
			$sOrderCode = Phpfox::getService('manager.order')->getOrderCode();
			if(!$sOrderCode){
				return Phpfox_Error::set('Không thể thêm đơn hàng do không lấy được mã đơn hàng');
			}
			$aInsert = array();
			$aInsert['code']        = $sOrderCode;
			$aInsert['customer_id'] = (int)$iUserId;
			$aInsert['status_id']   = 0;
			$aInsert['user_id']     = Phpfox::getUserId();
			$aInsert['time_stamp']  = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableOrder, $aInsert);
			if(!$iId){
				return Phpfox_Error::set('Thêm đơn hàng không thành công!');
			}

			foreach ($aProducts as $key => $aProduct) {
				$this->addProduct($iId, $aProduct);
			}
			return $iId;
		}
		return false;
	}

	public function addProduct($iOrderId, $aVals){
		if(isset($iOrderId) && !empty($aVals)){
			$oParseInput            = Phpfox::getLib('parse.input');

			$aInsert                = array();
			$aInsert['order_id']    = (int)$iOrderId;
			$aInsert['vansan_id']   = (int)$aVals['vansan_id'];
			$aInsert['skirting_id'] = (int)$aVals['skirting_id'];
			$aInsert['status_id']   = 0;
			$aInsert['quantity']    = (int)$aVals['quantity'];
			$aInsert['deadline']    = (int)$aVals['deadline'];
			$aInsert['description'] = $oParseInput->clean($aVals['description']);
			$this->database()->insert($this->_sTableOrderProduct, $aInsert);
			return true;
		}
		return false;
	}
}