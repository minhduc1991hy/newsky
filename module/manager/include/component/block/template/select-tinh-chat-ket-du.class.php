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
 * @version 		$Id: select-tinh-chat-ket-du.class.php 5973 2013-05-28 11:04:04Z Nguyen Duc $
 */
class Manager_Component_Block_Template_Select_Tinh_Chat_Ket_Du extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->assign(array(
			'bRequired' => ($this->getParam('bRequired') == 'false' ? false : true),
			'aDatas'    => Phpfox::getService('manager.data')->getDataTinhChatKetDu(),
			'sTitle'    => $this->getParam('sTitle'),
		));
		$this->setParam('sTitle', '');
		$this->setParam('bRequired', '');
	}
}