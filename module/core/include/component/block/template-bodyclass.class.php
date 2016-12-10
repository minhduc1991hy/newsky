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
 * @package 		Phpfox_Component
 * @version 		$Id: template-bodyclass.class.php 2913 2011-08-29 08:14:28Z Nguyen Duc $
 */
class Core_Component_Block_Template_Bodyclass extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aClassBody = (array)$this->getParam('aClassBody');
		$bCloseMenuSideBar = Phpfox::getService('manager.setting')->getToggleMenuSideBar();
		if($bCloseMenuSideBar){
			$aClassBody[] = 'sidebar-collapse';
		}


		
		$aFilterSearchs = $this->getParam('aFilterSearchs');
		if($aFilterSearchs){
			$aClassBody['has-search'] = 'has-search';
		}

		$bCloseFilterSearch = Phpfox::getService('manager.setting')->getToggleFilterSearch();
		if($bCloseFilterSearch && isset($aClassBody['has-search'])){
			unset($aClassBody['has-search']);
		}

		$this->template()->assign(array(
			'aClassBody' => implode(' ', $aClassBody),
		));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_template_bodyclass_clean')) ? eval($sPlugin) : false);
	}
}

?>