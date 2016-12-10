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
 * @version 		$Id: Project.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Project_Project extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableProject = Phpfox::getT('ns_project');
	}

	/**
	 * getCount: Đếm số lượng ProjectCategory
	 * @param array $aCound
	 * @return array
	 */
	public function getCountProjectCategory($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableProject, 'pc')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}

	/**
	 * get ProjectCategory
	 * @param int $iId
	 * @return array
	 */
	public function getProjectCategory($iId){
		if($iId){
			$sCacheId = $this->cache()->set(array('manager', 'project_category_' . $iId));
			if(!$sOutput = $this->cache()->get($sCacheId)){
				$aCound = array(
					'AND pc.project_id = ' . (int)$iId
				);
				$sOutput = $this->database()->select('pc.*')
		    		->from($this->_sTableProject, 'pc')
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
	 * get nhiều ProjectCategory
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getProjectCategorys($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'pc.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableProject, 'pc')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$sSelect = 'pc.*';
		$aRows = $this->database()->select($sSelect)
            ->from($this->_sTableProject, 'pc')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        return array($iCnt, $aRows);
	}
}