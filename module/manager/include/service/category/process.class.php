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
 * @package  		Module_accounting
 * @version 		$Id: process.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Category_Process extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableCategory = Phpfox::getT('ns_category');
	}


	/**
	 * Thêm data accounting
	 * @param array $aVals
	 * @return int ID accounting data
	 */
	public function addAccountingData($aVals){
		if($aVals){
			$oParseInput            = Phpfox::getLib('parse.input');
			$aInsert                = array();
			$aInsert['type_id']     = $oParseInput->clean($aVals['type_id']);
			$aInsert['title']       = $oParseInput->clean($aVals['title']);
			$aInsert['description'] = $oParseInput->clean($aVals['description']);
			$aInsert['user_id']     = Phpfox::getUserId();
			$aInsert['time_stamp']  = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableCategory, $aInsert);
			if($iId){
				$this->removeCacheCategory($aVals['type_id']);
			}
			return $iId;
		}
		return false;
	}

	/**
	 * Thêm data accounting
	 * @param array $aVals
	 * @return int ID accounting data
	 */
	public function updateAccountingData($aVals, $iProductId){
		if($aVals && $iProductId){
			$aAccountingData = Phpfox::getService('manager.category')->getCategory($iProductId);
			if($aAccountingData){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['title']         = $oParseInput->clean($aVals['title']);
				$aUpdate['description']   = $oParseInput->clean($aVals['description']);
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableCategory, $aUpdate, 'product_id = ' . (int) $iProductId)){
					$this->removeCacheCategory($aAccountingData['type_id']);
					$this->removeCacheCategory($aAccountingData['product_id']);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa cache Accounting
	 * @param string $sItem
	 */
	public function removeCacheCategory($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'category_class_' . $sItem));
		}
	}

}