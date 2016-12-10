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
 * @package  		Module_Core
 * @version 		$Id: index-member.class.php 5908 2013-05-13 07:28:31Z Raymond_Benc $
 */
class Core_Component_Controller_Index_Member extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->url()->send('manager');
	}
}

?>