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
class Manager_Component_Block_Category_Select_Category extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sTypeId = $this->getParam('sTypeId');
		$aCategories = Phpfox::getService('manager.category')->getCategories($sTypeId);
		$this->template()->assign(array(
			'sTypeId'     => $sTypeId,
			'sTitle'      => $this->getParam('sTitle'),
			'bRequired'   => ($this->getParam('bRequired') == 'false' ? false : true),
			'aCategories' => $aCategories,
		));

		$this->setParam('sTitle', '');
		$this->setParam('sTypeId', '');
		$this->setParam('bRequired', '');
		$this->setParam('aCategories', null);
	}
}