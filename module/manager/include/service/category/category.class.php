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
class Manager_Service_Category_Category extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableCategory = Phpfox::getT('ns_category');
	}

	/**
	 * get nhiều Danh mục theo type ID
	 * @param string $sTypeId
	 * @return array category data
	 */
	public function getCategories($sTypeId){
		if($sTypeId){
			$sCacheId = $this->cache()->set(array('manager', 'category_class_' . $sTypeId));
			if(!$sOutputs = $this->cache()->get($sCacheId)){
				$aCound = array('AND c.type_id = "'.$sTypeId.'"');
				$sOutputs = $this->database()->select('c.*')
		    		->from($this->_sTableCategory, 'c')
		    		->where($aCound)
		    		->order('c.product_id DESC')
		    		->execute('getSlaveRows');

		    	if($sOutputs){
		    		$this->cache()->save($sCacheId, $sOutputs);
		    		foreach ($sOutputs as $key => $sOutput) {
		    			if($sOutput){
				    		$sCacheId = $this->cache()->set(array('manager', 'category_class_' . $sOutput['product_id']));
				    		if(!$this->cache()->get($sCacheId)){
					    		$this->cache()->save($sCacheId, $sOutput);
				    		}
			    		}
			    	}
		    	}
			}
			return $sOutputs;
		}
		return false;
	}

	/**
	 * get Danh mục theo type ID
	 * @param int $iProductId
	 * @return array accounting data
	 */
	public function getCategory($iProductId){
		if($iProductId){
			$sCacheId = $this->cache()->set(array('manager', 'category_class_' . $iProductId));
			if(!$sOutput = $this->cache()->get($sCacheId)){

				$aCound = array('AND c.product_id = "'.$iProductId.'"');
				$sOutput = $this->database()->select('c.*')
		    		->from($this->_sTableCategory, 'c')
		    		->where($aCound)
		    		->execute('getSlaveRow');

		    	$this->cache()->save($sCacheId, $sOutput);
			}
			return $sOutput;
		}
		return false;
	}

	/**
	 * get Field Category
	 * @param string $iKey
	 * @return array
	 */
	public function getCategoryField($iKey = null){
		$aReturn = array();
		$aSelect = array('type_id','title','description','user_id','time_stamp', 'userid_update', 'time_update');
		$sSelectCategory = Phpfox::getService('manager')->prefixSelect($aSelect, 'data', 'c');
		$aReturn['sSelectCategory'] = $sSelectCategory;

		if($iKey){
			if(array_key_exists($iKey, $aReturn)){
				return $aReturn[$iKey];
			}else{
				return '';
			}
		}
		return $aReturn;
	}
}