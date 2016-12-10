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
class Manager_Component_Block_Plan_Select_Flooring_Dim extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aItemRows = Phpfox::getService('manager.plan')->getAllFlooringDims();
		$this->template()->assign(array(
			'bRequired' => ($this->getParam('bRequired') == 'false' ? false : true),
			'aItemRows' => $aItemRows,
			'sTitle'    => $this->getParam('sTitle'),
		));

		$this->setParam('sTitle', '');
	}
}