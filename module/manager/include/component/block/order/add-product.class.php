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
 * @package  		Module_Accounting
 * @version 		$Id: add-product.class.php 5973 2013-05-28 11:04:04Z Nguyen Duc $
 */
class Manager_Component_Block_Order_Add_Product extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sType   = $this->getParam('type');
		$iItemId = $this->getParam('item_id');
		
		switch ($sType) {
			case 'edit_product':

				$aOrderProduct = Phpfox::getService('manager.order')->getOrderProduct($iItemId);
				if($aOrderProduct){
					$aOrderProduct['deadline'] = Phpfox::getTime(Phpfox::getParam('manager.time_stamp'), $aOrderProduct['deadline']);
				}

				$this->template()->assign(array(
					'aForms' => $aOrderProduct,
				));

			break;
			default:
				$aUser = Phpfox::getService('user')->get($iItemId);
				$this->template()->assign(array(
					'aUser' => $aUser,
				));
			break;
		}

		$this->template()->assign(array(
			'sType' => $sType,
			'iItemId' => $iItemId,
		));
	}
}