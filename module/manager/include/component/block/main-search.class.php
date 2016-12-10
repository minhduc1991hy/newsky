<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Manager
 * @version 		$Id: main-search.class.php 3342 2011-10-21 12:59:32Z Nguyen Duc $
 */
class Manager_Component_Block_Main_Search extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		$bCloseFilterSearch = Phpfox::getService('manager.setting')->getToggleFilterSearch();
		$this->template()->assign(array(
			'bCloseFilterSearch' => $bCloseFilterSearch,
		));
	}
}