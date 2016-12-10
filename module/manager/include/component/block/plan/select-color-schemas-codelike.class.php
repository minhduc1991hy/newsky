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
class Manager_Component_Block_Plan_Select_Color_Schemas_Codelike extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sLikeCode = $this->getParam('sLikeCode');
		$aColorSchemas = Phpfox::getService('manager.plan')->getCodeLikeColorSchemas($sLikeCode);
		$this->template()->assign(array(
			'bRequired'     => ($this->getParam('bRequired') == 'false' ? false : true),
			'aColorSchemas' => $aColorSchemas,
			'sTitle'        => $this->getParam('sTitle'),
			'sNameColor'    => 'color_id_' . $sLikeCode,
		));

		$this->setParam('sTitle', '');
		$this->setParam('sLikeCode', '');
		$this->setParam('sNameColor', '');
	}
}