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
 * @version 		$Id: accounting.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Accounting_Accounting extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableAccountSystem = Phpfox::getT('ns_account_system');
	}

	/**
	 * getCount: Đếm số lượng AccountSystem
	 * @param array $aCound
	 * @return array
	 */
	public function getCountAccountSystem($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableAccountSystem, 'acs')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}

	/**
	 * get AccountSystem
	 * @param int $iId
	 * @return array
	 */
	public function getAccountSystem($iId){
		if($iId){
			$sCacheId = $this->cache()->set(array('manager', 'account_system_' . $iId));
			if(!$sOutput = $this->cache()->get($sCacheId)){
				$aCound          = array('AND acs.account_system_id = "'.$iId.'"');
				$sSelect         = 'acs.*';
				$sOutput = $this->database()->select($sSelect)
		    		->from($this->_sTableAccountSystem, 'acs')
		    		->where($aCound)
		    		->execute('getSlaveRow');

		    	if($sOutput){
		    		$this->cache()->save($sCacheId, $sOutput);
		    	}
			}
			return $sOutput;
		}

		return false;
	}

	/**
	 * get nhiều AccountSystem
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getAccountSystems($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'acs.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableAccountSystem, 'acs')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);
		$sSelect = 'acs.*';
		$aRows = $this->database()->select($sSelect)
            ->from($this->_sTableAccountSystem, 'acs')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        return array($iCnt, $aRows);
	}
}