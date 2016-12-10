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
 * @package  		Module_manager
 * @version 		$Id: Process.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Project_Process extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableProject = Phpfox::getT('ns_project');
	}


	/**
	 * Thêm ProjectCategory
	 * @param array $aVals
	 * @return int ID
	 */
	public function addProjectCategory($aVals){
		if($aVals){
			$oParseInput           = Phpfox::getLib('parse.input');
			$aInsert               = array();
			$aInsert['code']       = $oParseInput->clean($aVals['code']);
			$aInsert['title']      = $oParseInput->clean($aVals['title']);
			$aInsert['user_id']    = Phpfox::getUserId();
			$aInsert['time_stamp'] = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableProject, $aInsert);
			return $iId;
		}
		return false;
	}


	/**
	 * Sửa ProjectCategory
	 * @param array $aVals
	 * @param int $iId
	 * @return boolean
	 */
	public function updateProjectCategory($aVals, $iId){
		if($aVals && $iId){
			$aRow = Phpfox::getService('manager.project')->getProjectCategory($iId);
			if($aRow){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['code']          = $oParseInput->clean($aVals['code']);
				$aUpdate['title']         = $oParseInput->clean($aVals['title']);
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableProject, $aUpdate, 'project_id = ' . (int) $iId)){
					$this->removeCacheProjectCategory($iId);
					return true;
				}
			}
		}
		return false;
	}


	/**
	 * Xóa ProjectCategory
	 * @param int $iId
	 * @return int
	 */
	public function deleteProjectCategory($iId){
		if($iId){
			$aRow = Phpfox::getService('manager.project')->getProjectCategory($iId);
			if($aRow){
				if($this->database()->delete($this->_sTableProject, 'project_id =' . (int)$iId)){
					$this->removeCacheProjectCategory($iId);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa cache FlooringMaterial
	 * @param string $sItem
	 */
	public function removeCacheProjectCategory($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'project_category_' . $sItem));
		}
		return true;
	}
}