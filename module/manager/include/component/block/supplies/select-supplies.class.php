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
class Manager_Component_Block_Supplies_Select_Supplies extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aSupplies = Phpfox::getService('manager.supplies')->getAllSupplies();
		$this->template()->assign(array(
			'bRequired'     => ($this->getParam('bRequired') == 'false' ? false : true),
			'aSupplies' => $aSupplies,
		));
	}
}