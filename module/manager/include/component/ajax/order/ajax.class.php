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
 * @package  		Module_Manager
 * @version 		$Id: ajax.class.php 6742 2013-10-07 15:07:33Z Nguyen_Duc $
 */
class Manager_Component_Ajax_Order_Ajax extends Phpfox_Ajax
{
	public function addProductOrder(){
		$aVals = $this->get('val');
		print_r($aVals);
	}
}