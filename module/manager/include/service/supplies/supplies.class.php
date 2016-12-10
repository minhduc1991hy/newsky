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
 * @version 		$Id: Supplies.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Supplies_Supplies extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableHdf              = Phpfox::getT('ns_hdf');
		$this->_sTableCategory         = Phpfox::getT('ns_category');
		$this->_sTableSupplies         = Phpfox::getT('ns_supplies');
		$this->_sTableRawpaper         = Phpfox::getT('ns_rawpaper');
		$this->_sTableColorSchema      = Phpfox::getT('ns_color_schema');
		$this->_sTableFlooringMaterial = Phpfox::getT('ns_flooring_materials');
		$this->_sTableHotplate         = Phpfox::getT('ns_hotplate');
	}

	/**
	 * get nhiều Hdf
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getHdfs($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'h.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableHdf, 'h')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
		$aRows = $this->database()->select('h.*, ' . $sSelectCategory)
            ->from($this->_sTableHdf, 'h')
            ->leftjoin($this->_sTableCategory, 'c', 'c.product_id = h.product_id')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');
        if($aRows){
        	// foreach ($aRows as $key => $aRow) {
        		
        	// }
        }  
        return array($iCnt, $aRows);
	}

	/**
	 * getCount: Đếm số lượng HDF
	 * @param array $aCound
	 * @return array accounting product
	 */
	public function getCountHDF($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableHdf, 'h')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}


	/**
	 * get Hdf
	 * @param int $iProductId
	 * @return array accounting product
	 */
	public function getHdf($iHdfId){
		if($iHdfId){
			$sCacheId = $this->cache()->set(array('manager', 'hdf_mdf_' . $iHdfId));
			if(!$sOutput = $this->cache()->get($sCacheId)){

				$aCound          = array('AND h.hdf_id = "'.$iHdfId.'"');
				$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');

				$sOutput = $this->database()->select('h.*, ' . $sSelectCategory)
		    		->from($this->_sTableHdf, 'h')
		    		->leftjoin($this->_sTableCategory, 'c', 'c.product_id = h.product_id')
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
	 * get nhiều Hdf từ cache
	 * Nếu có cache lấy từ cache nếu chưa có lấy từ db và lưu vào cache
	 * @return array 
	 */
	public function getAllHdfs(){
		$sCacheId = $this->cache()->set(array('manager', 'hdf_all'));
		if(!$sOutput = $this->cache()->get($sCacheId)){

			$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
			$sOutput = $this->database()->select('h.*, ' . $sSelectCategory)
	            ->from($this->_sTableHdf, 'h')
	            ->leftjoin($this->_sTableCategory, 'c', 'c.product_id = h.product_id')
	            ->order('h.code ASC')
	            ->execute('getSlaveRows');

	        if($sOutput){
	        	$this->cache()->save($sCacheId, $sOutput);
	        }
		}
        return $sOutput;
	}

	/**
	 * get color schema
	 * @param string $iKey
	 * @return array
	 */
	public function getHdfField($iKey = null){
		$aReturn = array();
		$aSelect = array('product_id','code','description', 'width', 'length', 'thickness', 'user_id','time_stamp', 'userid_update', 'time_update');
		$sSelect = Phpfox::getService('manager')->prefixSelect($aSelect, 'hdf', 'h');
		$aReturn['sHdf'] = $sSelect;

		if($iKey){
			if(array_key_exists($iKey, $aReturn)){
				return $aReturn[$iKey];
			}else{
				return $aReturn;
			}
		}
		return $aReturn;
	}


	/**
	 * get Đếm số lượng Supplie
	 * @param array $aCound
	 * @return array accounting product
	 */
	public function getCountSupplie($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableSupplies, 's')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}

	/**
	 * get Field Supplie
	 * @param string $iKey
	 * @return array
	 */
	public function getSupplieField($iKey = null){
		$aReturn = array();
		$aSelect = array('supplie_id','code','name','address','description', 'user_id', 'time_stamp', 'userid_update', 'time_update');
		$sSelectSupplie = Phpfox::getService('manager')->prefixSelect($aSelect, 'supplie', 's');
		$aReturn['sSelectSupplie'] = $sSelectSupplie;
		if($iKey){
			if(array_key_exists($iKey, $aReturn)){
				return $aReturn[$iKey];
			}else{
				return '';
			}
		}
		return $aReturn;
	}

	/**
	 * get Supplie
	 * @param int $iProductId
	 * @return array
	 */
	public function getSupplie($iSupplieId){
		if($iSupplieId){
			$sCacheId = $this->cache()->set(array('manager', 'supplie_' . $iSupplieId));
			if(!$sOutput = $this->cache()->get($sCacheId)){
				$aCound          = array('AND s.supplie_id = "'.$iSupplieId.'"');

				$sOutput = $this->database()->select('s.*')
		    		->from($this->_sTableSupplies, 's')
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
	 * get nhiều Supplie
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getSupplies($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 's.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableSupplies, 's')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$aRows = $this->database()->select('s.*')
            ->from($this->_sTableSupplies, 's')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        return array($iCnt, $aRows);
	}
	

	/**
	 * get nhiều Supplie từ cache
	 * Nếu có cache lấy từ cache nếu chưa có lấy từ db và lưu vào cache
	 * @return array 
	 */
	public function getAllSupplies(){
		$sCacheId = $this->cache()->set(array('manager', 'supplie_all'));
		if(!$sOutput = $this->cache()->get($sCacheId)){
			$sOutput = $this->database()->select('s.*')
	            ->from($this->_sTableSupplies, 's')
	            ->order('s.code ASC')
	            ->execute('getSlaveRows');
	        if($sOutput){
	        	$this->cache()->save($sCacheId, $sOutput);
	        }
		}
        return $sOutput;
	}

	/**
	 * get Supplies
	 * @param string $iKey
	 * @return array
	 */
	public function getSuppliesField($iKey = null){
		$aReturn = array();
		$aSelect = array('code','name','address', 'phone','description','time_stamp', 'userid_update', 'time_update');
		$sSelect = Phpfox::getService('manager')->prefixSelect($aSelect, 'supplie', 's');
		$aReturn['sSupplies'] = $sSelect;

		if($iKey){
			if(array_key_exists($iKey, $aReturn)){
				return $aReturn[$iKey];
			}else{
				return $aReturn;
			}
		}
		return $aReturn;
	}


	/**
	 * getCount: Đếm số lượng Raw Paper
	 * @param array $aCound
	 * @return array
	 */
	public function getCountRawpaper($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableRawpaper, 'rp')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}

	/**
	 * get Rawpaper
	 * @param int $iRawPaperId
	 * @return array
	 */
	public function getRawpaper($iRawPaperId){
		if($iRawPaperId){
			$sCacheId = $this->cache()->set(array('manager', 'raw_paper_' . $iRawPaperId));
			if(!$sOutput = $this->cache()->get($sCacheId)){
				$aCound          = array('AND rp.rawpaper_id = "'.$iRawPaperId.'"');

				$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
				$sColorSchema    = Phpfox::getService('manager.plan')->getColorSchemaField('sColorSchema');
				$sSupplies       = $this->getSuppliesField('sSupplies');
				$sSelect         = 'rp.*,' . $sSelectCategory . ',' . $sColorSchema . ',' . $sSupplies;

				$sOutput = $this->database()->select($sSelect)
		    		->from($this->_sTableRawpaper, 'rp')
		    		->leftjoin($this->_sTableCategory, 'c', 'c.product_id = rp.product_id')
		            ->leftjoin($this->_sTableColorSchema, 'cs', 'cs.color_id = rp.color_id')
		            ->leftjoin($this->_sTableSupplies, 's', 's.supplie_id = rp.supplie_id')
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
	 * get nhiều Rawpaper
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getRawpapers($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'rp.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableRawpaper, 'rp')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
		$sColorSchema    = Phpfox::getService('manager.plan')->getColorSchemaField('sColorSchema');
		$sSupplies       = $this->getSuppliesField('sSupplies');
		$sSelect         = 'rp.*,' . $sSelectCategory . ',' . $sColorSchema . ',' . $sSupplies;

		$aRows = $this->database()->select($sSelect)
            ->from($this->_sTableRawpaper, 'rp')
            ->leftjoin($this->_sTableCategory, 'c', 'c.product_id = rp.product_id')
            ->leftjoin($this->_sTableColorSchema, 'cs', 'cs.color_id = rp.color_id')
            ->leftjoin($this->_sTableSupplies, 's', 's.supplie_id = rp.supplie_id')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        return array($iCnt, $aRows);
	}


	/**
	 * getCount: Đếm số lượng Flooring Material
	 * @param array $aCound
	 * @return array
	 */
	public function getCountFlooringMaterial($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableFlooringMaterial, 'fm')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}

	/**
	 * get Flooring Material
	 * @param int $iRawPaperId
	 * @return array
	 */
	public function getFlooringMaterial($iId){
		if($iId){
			$sCacheId = $this->cache()->set(array('manager', 'flooring_materials_' . $iId));
			if(!$sOutput = $this->cache()->get($sCacheId)){

				$aCound          = array('AND fm.material_id = "'.$iId.'"');
				$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');

				$sOutput = $this->database()->select('fm.*, ' . $sSelectCategory)
		    		->from($this->_sTableFlooringMaterial, 'fm')
		    		->leftjoin($this->_sTableCategory, 'c', 'c.product_id = fm.product_id')
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
	 * get nhiều Flooring Material
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getFlooringMaterials($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'fm.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableFlooringMaterial, 'fm')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
		$sSelect         = 'fm.*,' . $sSelectCategory;

		$aRows = $this->database()->select($sSelect)
            ->from($this->_sTableFlooringMaterial, 'fm')
            ->leftjoin($this->_sTableCategory, 'c', 'c.product_id = fm.product_id')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        return array($iCnt, $aRows);
	}


	/**
	 * getCount: Đếm số lượng Hotplate
	 * @param array $aCound
	 * @return array
	 */
	public function getCountHotplate($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableHotplate, 'hp')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}


	/**
	 * get Hotplate
	 * @param int $iId
	 * @return array
	 */
	public function getHotplate($iId){
		if($iId){
			$sCacheId = $this->cache()->set(array('manager', 'hotplate_' . $iId));
			if(!$sOutput = $this->cache()->get($sCacheId)){

				$aCound          = array('AND hp.hotplate_id = "'.$iId.'"');
				$sOutput = $this->database()->select('hp.*')
		    		->from($this->_sTableHotplate, 'hp')
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
	 * get nhiều Hotplate
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getHotplates($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'hp.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableHotplate, 'hp')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$sSupplies       = $this->getSuppliesField('sSupplies');
		$sSelect         = 'hp.*,' . $sSupplies;

		$aRows = $this->database()->select($sSelect)
            ->from($this->_sTableHotplate, 'hp')
            ->leftjoin($this->_sTableSupplies, 's', 's.supplie_id = hp.supplie_id')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        return array($iCnt, $aRows);
	}
}