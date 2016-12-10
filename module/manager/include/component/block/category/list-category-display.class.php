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
 * @version 		$Id: list-category-product.class.php 5973 2013-05-28 11:04:04Z Nguyen Duc $
 */
class Manager_Component_Block_Category_List_Category_Display extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sTypeId = $this->getParam('sTypeId');
		$sTextTypeId = Phpfox::getService('manager.category.data')->getCategoryTypeIdData($sTypeId);
		if(!$sTextTypeId){
			Phpfox_Error::displayMsg('Type Id không tồn tại', 'bg-warning text-center');
			return false;
		}

		$aCategories = Phpfox::getService('manager.category')->getCategories($sTypeId);
		$this->template()->assign(array(
			'aCategories' => $aCategories,
			'sTypeId' => $sTypeId,
		));
	}
}