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
 * @version 		$Id: process.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Accounting_Process extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableAccountSystem = Phpfox::getT('ns_account_system');
	}

	/**
	 * Thêm AccountSystem
	 * @param array $aVals
	 * @return int ID
	 */
	public function addAccountSystem($aVals){
		if($aVals){
			$oParseInput            = Phpfox::getLib('parse.input');
			$aInsert                = array();
			$aInsert['code']        = $oParseInput->clean($aVals['code']);
			$aInsert['description'] = $oParseInput->clean($aVals['description']);
			$aInsert['tckd']        = (int)$aVals['tckd'];
			$aInsert['user_id']     = Phpfox::getUserId();
			$aInsert['time_stamp']  = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableAccountSystem, $aInsert);
			return $iId;
		}
		return false;
	}


	/**
	 * Sửa AccountSystem
	 * @param array $aVals
	 * @param int $iId
	 * @return boolean
	 */
	public function updateAccountSystem($aVals, $iId){
		if($aVals && $iId){
			$aRow = Phpfox::getService('manager.accounting')->getAccountSystem($iId);
			if($aRow){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['code']          = $oParseInput->clean($aVals['code']);
				$aUpdate['description']   = $oParseInput->clean($aVals['description']);
				$aUpdate['tckd']          = (int)$aVals['tckd'];
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableAccountSystem, $aUpdate, 'account_system_id = ' . (int) $iId)){
					$this->removeCacheAccountSystem($iId);
					return true;
				}
			}
		}
		return false;
	}


	/**
	 * Xóa AccountSystem
	 * @param int $iId
	 * @return int
	 */
	public function deleteAccountSystem($iId){
		if($iId){
			$aRow = Phpfox::getService('manager.accounting')->getAccountSystem($iId);
			if($aRow){
				if($this->database()->delete($this->_sTableAccountSystem, 'account_system_id =' . (int)$iId)){
					$this->removeCacheAccountSystem($iId);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa cache AccountSystem
	 * @param string $sItem
	 */
	public function removeCacheAccountSystem($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'account_system_' . $sItem));
		}
		return true;
	}
}