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
 * @version 		$Id: Plan.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Plan_Plan extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableColorSchema = Phpfox::getT('ns_color_schema');
		$this->_sTableCategory    = Phpfox::getT('ns_category');
		$this->_sTableFlooringDim = Phpfox::getT('ns_flooringdim');
		$this->_sTableSkirting    = Phpfox::getT('ns_skirting');
		$this->_sTableMachine     = Phpfox::getT('ns_machine');
		$this->_sTableHdf         = Phpfox::getT('ns_hdf');
		$this->_sTableVansan      = Phpfox::getT('ns_vansan'); 
	}

	/**
	 * get Đếm số lượng color schema
	 * @param array $aParams
	 * @return int
	 */
	public function getCountColorSchema($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableColorSchema, 'cs')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}


	/**
	 * get nhiều color schema
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getColorSchemas($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'cs.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableColorSchema, 'cs')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');

		$aRows = $this->database()->select('cs.*, ' . $sSelectCategory)
            ->from($this->_sTableColorSchema, 'cs')
            ->leftjoin($this->_sTableCategory, 'c', 'c.product_id = cs.product_id')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        return array($iCnt, $aRows);
	}


	/**
	 * get tất cả ColorSchemas
	 * @return array 
	 */
	public function getAllColorSchemas(){
		$sCacheId = $this->cache()->set(array('manager', 'color_schema_all'));
		if(!$sOutput = $this->cache()->get($sCacheId)){
			$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
			$sOutput = $this->database()->select('cs.*, ' . $sSelectCategory)
	            ->from($this->_sTableColorSchema, 'cs')
	            ->leftjoin($this->_sTableCategory, 'c', 'c.product_id = cs.product_id')
	            ->order('cs.code ASC')
	            ->execute('getSlaveRows');
	        if($sOutput){
		    	$this->cache()->save($sCacheId, $sOutput);
	    	}
		}
        return $sOutput;
	}

	/**
	 * get tất cả Giấy thuộc product_id
	 * @return array 
	 */
	public function getAllColorSchemasProductId($iProductId){
		$sCacheId = $this->cache()->set(array('manager', 'color_schema_product_id_' . ($iProductId)));
		if(!$sOutput = $this->cache()->get($sCacheId)){
			$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
			$aCound = array(
				'AND cs.product_id = ' . (int)$iProductId,
			);
			$sOutput = $this->database()->select('cs.*, ' . $sSelectCategory)
	            ->from($this->_sTableColorSchema, 'cs')
	            ->leftjoin($this->_sTableCategory, 'c', 'c.product_id = cs.product_id')
	            ->where($aCound)
	            ->order('cs.code ASC')
	            ->execute('getSlaveRows');
	        if($sOutput){
		    	$this->cache()->save($sCacheId, $sOutput);
	    	}
		}
        return $sOutput;
	}

	/**
	 * get tất cả giấy thuộc code LIKE
	 * @return array 
	 */
	public function getCodeLikeColorSchemas($sCode = ''){
		if($sCode){
			$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
			$aCound = array(
				'AND cs.code LIKE "'.$sCode.'%"',
			);
			$sOutput = $this->database()->select('cs.*, ' . $sSelectCategory)
	            ->from($this->_sTableColorSchema, 'cs')
	            ->leftjoin($this->_sTableCategory, 'c', 'c.product_id = cs.product_id')
	            ->where($aCound)
	            ->order('cs.code ASC')
	            ->execute('getSlaveRows');
	        return $sOutput;
        }
        return false;
	}

	/**
	 * get color schema
	 * @param int $iColorId
	 * @return array
	 */
	public function getColorSchema($iColorId){
		if($iColorId){
			$sCacheId = $this->cache()->set(array('manager', 'color_schema_' . $iColorId));
			if(!$sOutput = $this->cache()->get($sCacheId)){
				$aCound = array('AND cs.color_id = "'.$iColorId.'"');

				$sOutput = $this->database()->select('cs.*')
		    		->from($this->_sTableColorSchema, 'cs')
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
	 * get color schema
	 * @param string $iKey
	 * @return array
	 */
	public function getColorSchemaField($iKey = null, $sPrefixField = 'cs', $sPrefix = 'color'){
		$aReturn = array();
		$aSelect = array('product_id','code','title','user_id','time_stamp', 'userid_update', 'time_update');
		$sSelect = Phpfox::getService('manager')->prefixSelect($aSelect, $sPrefix, $sPrefixField);
		$aReturn['sColorSchema'] = $sSelect;

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
	 * get Đếm số lượng Flooring Dim
	 * @param array $aParams
	 * @return int
	 */
	public function getCountFlooringDim($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableFlooringDim, 'fd')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}

	/**
	 * get FlooringDim
	 * @param int $iFlooringdimId
	 * @return array
	 */
	public function getFlooringDim($iFlooringdimId){
		if($iFlooringdimId){
			$sCacheId = $this->cache()->set(array('manager', 'flooringdim_' . $iFlooringdimId));
			if(!$sOutput = $this->cache()->get($sCacheId)){
				$aCound = array('AND fd.flooringdim_id = "'.$iFlooringdimId.'"');

				$sOutput = $this->database()->select('fd.*')
		    		->from($this->_sTableFlooringDim, 'fd')
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
	 * get nhiều FlooringDim
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getFlooringDims($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'fd.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableFlooringDim, 'fd')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$aRows = $this->database()->select('fd.*')
            ->from($this->_sTableFlooringDim, 'fd')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        return array($iCnt, $aRows);
	}

	/**
	 * get tất cả FlooringDims
	 * @return array 
	 */
	public function getAllFlooringDims(){
		$sCacheId = $this->cache()->set(array('manager', 'flooringdim_all'));
		if(!$sOutput = $this->cache()->get($sCacheId)){
			$sOutput = $this->database()->select('fd.*')
	            ->from($this->_sTableFlooringDim, 'fd')
	            ->order('fd.code ASC')
	            ->execute('getSlaveRows');
	        if($sOutput){
		    	$this->cache()->save($sCacheId, $sOutput);
	    	}
		}
        return $sOutput;
	}

	/**
	 * get FlooringDim
	 * @param string $iKey
	 * @return array
	 */
	public function getFlooringDimField($iKey = null){
		$aReturn = array();
		$aSelect = array('code','width','length','thickness','user_id','time_stamp', 'userid_update', 'time_update');
		$sSelect = Phpfox::getService('manager')->prefixSelect($aSelect, 'flooring_dim', 'fd');
		$aReturn['sFlooringDim'] = $sSelect;

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
	 * getCount: Đếm số lượng skirting
	 * @param array $aCound
	 * @return array
	 */
	public function getCountSkirting($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableSkirting, 'sk')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}

	/**
	 * get Skirting
	 * @param int $iRawPaperId
	 * @return array
	 */
	public function getSkirting($iId){
		if($iId){
			$sCacheId = $this->cache()->set(array('manager', 'skirting_' . $iId));
			if(!$sOutput = $this->cache()->get($sCacheId)){

				$aCound          = array('AND sk.skirting_id = "'.$iId.'"');

				$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
				$sColorSchema    = $this->getColorSchemaField('sColorSchema');
				$sHdf            = Phpfox::getService('manager.supplies')->getHdfField('sHdf');
				$sFlooringDim    = $this->getFlooringDimField('sFlooringDim');

				$sSelect = 'sk.*, ' . $sSelectCategory . ',' . $sColorSchema . ',' . $sHdf . ',' . $sFlooringDim;
				$sOutput = $this->database()->select($sSelect)
		    		->from($this->_sTableSkirting, 'sk')
		    		->leftjoin($this->_sTableCategory, 'c', 'c.product_id = sk.product_id')
		    		->leftjoin($this->_sTableColorSchema, 'cs', 'cs.color_id = sk.color_id')
		    		->leftjoin($this->_sTableHdf, 'h', 'h.hdf_id = sk.hdf_id')
		    		->leftjoin($this->_sTableFlooringDim, 'fd', 'fd.flooringdim_id = sk.flooringdim_id')
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
	 * get nhiều Skirting
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getSkirtings($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'sk.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableSkirting, 'sk')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
		$sColorSchema    = $this->getColorSchemaField('sColorSchema');
		$sHdf            = Phpfox::getService('manager.supplies')->getHdfField('sHdf');
		$sFlooringDim    = $this->getFlooringDimField('sFlooringDim');
		$sSelect         = 'sk.*, ' . $sSelectCategory . ',' . $sColorSchema . ',' . $sHdf . ',' . $sFlooringDim;

		$aRows = $this->database()->select($sSelect)
            ->from($this->_sTableSkirting, 'sk')
    		->leftjoin($this->_sTableCategory, 'c', 'c.product_id = sk.product_id')
    		->leftjoin($this->_sTableColorSchema, 'cs', 'cs.color_id = sk.color_id')
    		->leftjoin($this->_sTableHdf, 'h', 'h.hdf_id = sk.hdf_id')
    		->leftjoin($this->_sTableFlooringDim, 'fd', 'fd.flooringdim_id = sk.flooringdim_id')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        return array($iCnt, $aRows);
	}

	/**
	 * getCount: Đếm số lượng machine
	 * @param array $aCound
	 * @return array
	 */
	public function getCountMachine($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableMachine, 'ma')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}


	/**
	 * get Machine
	 * @param int $iRawPaperId
	 * @return array
	 */
	public function getMachine($iId){
		if($iId){
			$sCacheId = $this->cache()->set(array('manager', 'machine_' . $iId));
			if(!$sOutput = $this->cache()->get($sCacheId)){

				$aCound          = array('AND ma.machine_id = "'.$iId.'"');

				$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
				$sSelect = 'ma.*, ' . $sSelectCategory;
				$sOutput = $this->database()->select($sSelect)
		    		->from($this->_sTableMachine, 'ma')
		    		->leftjoin($this->_sTableCategory, 'c', 'c.product_id = ma.product_id')
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
	 * get nhiều Machine
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getMachines($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'ma.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableMachine, 'ma')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
		$sSelect = 'ma.*, ' . $sSelectCategory;
		$aRows = $this->database()->select($sSelect)
    		->from($this->_sTableMachine, 'ma')
    		->leftjoin($this->_sTableCategory, 'c', 'c.product_id = ma.product_id')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        return array($iCnt, $aRows);
	}


	/**
	 * getCount: Đếm số lượng ván sàn
	 * @param array $aCound
	 * @return array
	 */
	public function getCountVansan($aParams = array()){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableVansan, 'vs')
			->where($aParams)
			->execute('getSlaveField');
		return $iCnt;
	}

	/**
	 * get ván sàn
	 * @param int $iRawPaperId
	 * @return array
	 */
	public function getVansan($iId){
		if($iId){
			$sCacheId = $this->cache()->set(array('manager', 'vansan_' . $iId));
			if(!$sOutput = $this->cache()->get($sCacheId)){

				$aCound          = array('AND vs.vansan_id = "'.$iId.'"');

				$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
				$sColorSchema    = $this->getColorSchemaField('sColorSchema');
				$sColorSchemacx  = $this->getColorSchemaField('sColorSchema', 'cscx','colorcx');
				$sColorSchemacb  = $this->getColorSchemaField('sColorSchema', 'cscb','colorbx');
				$sHdf            = Phpfox::getService('manager.supplies')->getHdfField('sHdf');
				$sFlooringDim    = $this->getFlooringDimField('sFlooringDim');
				$sSelect         = 'vs.*, ' . $sSelectCategory . ',' . $sColorSchema . ',' . $sColorSchemacx . ',' . $sColorSchemacb . ',' . $sHdf . ',' . $sFlooringDim;

				$sOutput = $this->database()->select($sSelect)
		    		->from($this->_sTableVansan, 'vs')
		    		->leftjoin($this->_sTableCategory, 'c', 'c.product_id = vs.product_id')
		    		->leftjoin($this->_sTableColorSchema, 'cs', 'cs.color_id = vs.color_id')
		    		->leftjoin($this->_sTableColorSchema, 'cscx', 'cscx.color_id = vs.color_id_cx')
		    		->leftjoin($this->_sTableColorSchema, 'cscb', 'cscb.color_id = vs.color_id_cb')
		    		->leftjoin($this->_sTableHdf, 'h', 'h.hdf_id = vs.hdf_id')
		    		->leftjoin($this->_sTableFlooringDim, 'fd', 'fd.flooringdim_id = vs.flooringdim_id')
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
	 * get nhiều Machine
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getVansans($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'vs.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableVansan, 'vs')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$sSelectCategory = Phpfox::getService('manager.category')->getCategoryField('sSelectCategory');
		$sColorSchema    = $this->getColorSchemaField('sColorSchema');
		$sColorSchemacx  = $this->getColorSchemaField('sColorSchema', 'cscx','colorcx');
		$sColorSchemacb  = $this->getColorSchemaField('sColorSchema', 'cscb','colorbx');
		$sHdf            = Phpfox::getService('manager.supplies')->getHdfField('sHdf');
		$sFlooringDim    = $this->getFlooringDimField('sFlooringDim');

		$sSelect         = 'vs.*, ' . $sSelectCategory . ',' . $sColorSchema . ',' . $sColorSchemacx . ',' . $sColorSchemacb . ',' . $sHdf . ',' . $sFlooringDim;
		$aRows = $this->database()->select($sSelect)
    		->from($this->_sTableVansan, 'vs')
		    ->leftjoin($this->_sTableCategory, 'c', 'c.product_id = vs.product_id')
    		->leftjoin($this->_sTableColorSchema, 'cs', 'cs.color_id = vs.color_id')
    		->leftjoin($this->_sTableColorSchema, 'cscx', 'cscx.color_id = vs.color_id_cx')
    		->leftjoin($this->_sTableColorSchema, 'cscb', 'cscb.color_id = vs.color_id_cb')
    		->leftjoin($this->_sTableHdf, 'h', 'h.hdf_id = vs.hdf_id')
    		->leftjoin($this->_sTableFlooringDim, 'fd', 'fd.flooringdim_id = vs.flooringdim_id')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');
        return array($iCnt, $aRows);
	}
}