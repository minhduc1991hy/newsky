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
class Manager_Service_Plan_Process extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableColorSchema = Phpfox::getT('ns_color_schema');
		$this->_sTableFlooringDim = Phpfox::getT('ns_flooringdim');
		$this->_sTableSkirting    = Phpfox::getT('ns_skirting');
		$this->_sTableMachine     = Phpfox::getT('ns_machine');
		$this->_sTableVansan      = Phpfox::getT('ns_vansan'); 
	}

	/**
	 * Thêm Color Schema
	 * @param array $aVals
	 * @return int ID
	 */
	public function addColorSchema($aVals){
		if($aVals){
			$oParseInput           = Phpfox::getLib('parse.input');
			$aInsert               = array();
			$aInsert['product_id'] = (int)$aVals['product_id'];
			$aInsert['code']       = $oParseInput->clean($aVals['code']);
			$aInsert['title']      = $oParseInput->clean($aVals['title']);
			$aInsert['user_id']    = Phpfox::getUserId();
			$aInsert['time_stamp'] = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableColorSchema, $aInsert);
			if($iId){
				$this->removeCacheColorSchema(0, $aVals['product_id']);
				return $iId;
			}
		}
		return false;
	}

	/**
	 * Sửa Color Schema
	 * @param array $aVals
	 * @param int $iColorId
	 * @return boolean
	 */
	public function updateColorSchema($aVals, $iColorId){
		if($aVals && $iColorId){
			$aColorSchema = Phpfox::getService('manager.plan')->getColorSchema($iColorId);
			if($aColorSchema){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['product_id']    = (int)$aVals['product_id'];
				$aUpdate['code']          = $oParseInput->clean($aVals['code']);
				$aUpdate['title']         = $oParseInput->clean($aVals['title']);
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableColorSchema, $aUpdate, 'color_id = ' . (int) $iColorId)){
					$this->removeCacheColorSchema($aColorSchema['color_id'], $aColorSchema['product_id']);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa Color Schema
	 * @param int $iColorId
	 * @return boolean
	 */
	public function deleteColorSchema($iColorId){
		if($iColorId){
			$aColorSchema = Phpfox::getService('manager.plan')->getColorSchema($iColorId);
			if($aColorSchema){
				if($this->database()->delete($this->_sTableColorSchema, 'color_id =' . (int)$iColorId)){
					$this->removeCacheColorSchema($aColorSchema['color_id'], $aColorSchema['product_id']);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa cache Supplie
	 * @param string $sItem
	 */
	public function removeCacheColorSchema($sItem = '', $iProductId = 0){
		if($sItem){
			$this->cache()->remove(array('manager', 'color_schema_' . $sItem));
		}

		if($iProductId){
			$this->cache()->remove(array('manager', 'color_schema_product_id_' . $iProductId));
		}

		$this->cache()->remove(array('manager', 'color_schema_all'));
		
		return true;
	}


	/**
	 * Thêm FlooringDim
	 * @param array $aVals
	 * @return int ID
	 */
	public function addFlooringDim($aVals){
		if($aVals){
			$oParseInput           = Phpfox::getLib('parse.input');
			$aInsert               = array();
			$aInsert['code']       = $oParseInput->clean($aVals['code']);
			$aInsert['width']      = (int)$aVals['width'];
			$aInsert['length']     = (int)$aVals['length'];
			$aInsert['thickness']  = (int)$aVals['thickness'];
			$aInsert['user_id']    = Phpfox::getUserId();
			$aInsert['time_stamp'] = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableFlooringDim, $aInsert);
			if($iId){
				$this->removeCacheFlooringDim();
				return $iId;
			}
		}
		return false;
	}

	/**
	 * Sửa FlooringDim
	 * @param array $aVals
	 * @param int $iColorId
	 * @return boolean
	 */
	public function updateFlooringDim($aVals, $iFlooringdimId){
		if($aVals && $iFlooringdimId){
			$aFlooringDim = Phpfox::getService('manager.plan')->getFlooringDim($iFlooringdimId);
			if($aFlooringDim){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['code']          = $oParseInput->clean($aVals['code']);
				$aUpdate['width']         = (int)$aVals['width'];
				$aUpdate['length']        = (int)$aVals['length'];
				$aUpdate['thickness']     = (int)$aVals['thickness'];
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableFlooringDim, $aUpdate, 'flooringdim_id = ' . (int) $iFlooringdimId)){
					$this->removeCacheFlooringDim($iFlooringdimId);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa FlooringDim
	 * @param int $iFlooringdimId
	 * @return boolean
	 */
	public function deleteFlooringDim($iFlooringdimId){
		if($iFlooringdimId){
			$aFlooringDim = Phpfox::getService('manager.plan')->getFlooringDim($iFlooringdimId);
			if($aFlooringDim){
				if($this->database()->delete($this->_sTableFlooringDim, 'flooringdim_id =' . (int)$iFlooringdimId)){
					$this->removeCacheFlooringDim($iFlooringdimId);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa cache FlooringDim
	 * @param string $sItem
	 */
	public function removeCacheFlooringDim($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'flooringdim_' . $sItem));
		}
		$this->cache()->remove(array('manager', 'flooringdim_all'));
		return true;
	}


	/**
	 * Thêm Skirting
	 * @param array $aVals
	 * @return int ID
	 */
	public function addSkirting($aVals){
		if($aVals){
			$oParseInput                 = Phpfox::getLib('parse.input');
			$aInsert                     = array();
			$aInsert['product_id']       = (int)$aVals['product_id'];
			$aInsert['color_id']         = (int)$aVals['color_id'];
			$aInsert['hdf_id']           = (int)$aVals['hdf_id'];
			$aInsert['flooringdim_id']   = (int)$aVals['flooringdim_id'];
			$aInsert['code']             = $oParseInput->clean($aVals['code']);
			$aInsert['inventoried_unit'] = (int)$aVals['inventoried_unit'];
			$aInsert['packing']          = (int)$aVals['packing'];
			$aInsert['user_id']          = Phpfox::getUserId();
			$aInsert['time_stamp']       = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableSkirting, $aInsert);
			if($iId){
				$this->removeCacheSkirting();
				return $iId;
			}
		}
		return false;
	}


	/**
	 * Sửa Skirting
	 * @param array $aVals
	 * @param int $iId
	 * @return boolean
	 */
	public function updateSkirting($aVals, $iId){
		if($aVals && $iId){
			$aRow = Phpfox::getService('manager.plan')->getSkirting($iId);
			if($aRow){
				$oParseInput                  = Phpfox::getLib('parse.input');
				$aUpdate                      = array();
				$aUpdate['product_id']       = (int)$aVals['product_id'];
				$aUpdate['color_id']         = (int)$aVals['color_id'];
				$aUpdate['hdf_id']           = (int)$aVals['hdf_id'];
				$aUpdate['flooringdim_id']   = (int)$aVals['flooringdim_id'];
				$aUpdate['code']             = $oParseInput->clean($aVals['code']);
				$aUpdate['inventoried_unit'] = (int)$aVals['inventoried_unit'];
				$aUpdate['packing']          = (int)$aVals['packing'];
				$aUpdate['userid_update']     = Phpfox::getUserId();
				$aUpdate['time_update']       = PHPFOX_TIME;
				if($this->database()->update($this->_sTableSkirting, $aUpdate, 'skirting_id = ' . (int) $iId)){
					$this->removeCacheSkirting($iId);
					return true;
				}
			}
		}
		return false;
	}


	/**
	 * Xóa Skirting
	 * @param int $iId
	 * @return int
	 */
	public function deleteSkirting($iId){
		if($iId){
			$aRow = Phpfox::getService('manager.plan')->getSkirting($iId);
			if($aRow){
				if($this->database()->delete($this->_sTableSkirting, 'skirting_id =' . (int)$iId)){
					$this->removeCacheSkirting($iId);
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
	public function removeCacheSkirting($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'skirting_' . $sItem));
		}
		$this->cache()->remove(array('manager', 'skirting_all'));
		return true;
	}

	/**
	 * Thêm Machine
	 * @param array $aVals
	 * @return int ID
	 */
	public function addMachine($aVals){
		if($aVals){
			$oParseInput           = Phpfox::getLib('parse.input');
			$aInsert               = array();
			$aInsert['product_id'] = (int)$aVals['product_id'];
			$aInsert['code']       = $oParseInput->clean($aVals['code']);
			$aInsert['note']       = $oParseInput->clean($aVals['note']);
			$aInsert['price_buy']  = (int)$aVals['price_buy'];
			$aInsert['date_buy']   = (int)$aVals['date_buy'];
			$aInsert['user_id']    = Phpfox::getUserId();
			$aInsert['time_stamp'] = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableMachine, $aInsert);
			if($iId){
				$this->removeCacheMachine();
				return $iId;
			}
		}
		return false;
	}


	/**
	 * Sửa Machine
	 * @param array $aVals
	 * @param int $iId
	 * @return boolean
	 */
	public function updateMachine($aVals, $iId){
		if($aVals && $iId){
			$aRow = Phpfox::getService('manager.plan')->getMachine($iId);
			if($aRow){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['product_id']    = (int)$aVals['product_id'];
				$aUpdate['code']          = $oParseInput->clean($aVals['code']);
				$aUpdate['note']          = $oParseInput->clean($aVals['note']);
				$aUpdate['price_buy']     = (int)$aVals['price_buy'];
				$aUpdate['date_buy']      = (int)$aVals['date_buy'];
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableMachine, $aUpdate, 'machine_id = ' . (int) $iId)){
					$this->removeCacheMachine($iId);
					return true;
				}
			}
		}
		return false;
	}


	/**
	 * Xóa Machine
	 * @param int $iId
	 * @return int
	 */
	public function deleteMachine($iId){
		if($iId){
			$aRow = Phpfox::getService('manager.plan')->getMachine($iId);
			if($aRow){
				if($this->database()->delete($this->_sTableMachine, 'machine_id =' . (int)$iId)){
					$this->removeCacheMachine($iId);
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
	public function removeCacheMachine($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'machine_' . $sItem));
		}
		return true;
	}

	/**
	 * Thêm Ván sàn
	 * @param array $aVals
	 * @return int ID
	 */
	public function addVansan($aVals){
		if($aVals){
			$oParseInput               = Phpfox::getLib('parse.input');
			$aInsert                   = array();
			$aInsert['product_id']     = (int)$aVals['product_id'];
			$aInsert['color_id']       = (int)$aVals['color_id'];
			$aInsert['color_id_cx']    = (int)$aVals['color_id_cx'];
			$aInsert['color_id_cb']    = (int)$aVals['color_id_cb'];
			$aInsert['hdf_id']         = (int)$aVals['hdf_id'];
			$aInsert['flooringdim_id'] = (int)$aVals['flooringdim_id'];
			$aInsert['code']           = $oParseInput->clean($aVals['code']);
			$aInsert['unit']           = (int)$aVals['unit'];
			$aInsert['vat_canh']       = (int)$aVals['vat_canh'];
			$aInsert['kieu_ranh']      = (int)$aVals['kieu_ranh'];
			$aInsert['be_mat']         = (int)$aVals['be_mat'];
			$aInsert['khuon_duoi']     = (int)$aVals['khuon_duoi'];
			$aInsert['packing']        = (int)$aVals['packing'];
			$aInsert['user_id']        = Phpfox::getUserId();
			$aInsert['time_stamp']     = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableVansan, $aInsert);
			if($iId){
				$this->removeCacheVansan();
				return $iId;
			}
		}
		return false;
	}


	/**
	 * Sửa Ván sàn
	 * @param array $aVals
	 * @param int $iId
	 * @return boolean
	 */
	public function updateVansan($aVals, $iId){
		if($aVals && $iId){
			$aRow = Phpfox::getService('manager.plan')->getVansan($iId);
			if($aRow){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['product_id']     = (int)$aVals['product_id'];
				$aUpdate['color_id']       = (int)$aVals['color_id'];
				$aUpdate['color_id_cx']    = (int)$aVals['color_id_cx'];
				$aUpdate['color_id_cb']    = (int)$aVals['color_id_cb'];
				$aUpdate['hdf_id']         = (int)$aVals['hdf_id'];
				$aUpdate['flooringdim_id'] = (int)$aVals['flooringdim_id'];
				$aUpdate['code']           = $oParseInput->clean($aVals['code']);
				$aUpdate['unit']           = (int)$aVals['unit'];
				$aUpdate['vat_canh']       = (int)$aVals['vat_canh'];
				$aUpdate['kieu_ranh']      = (int)$aVals['kieu_ranh'];
				$aUpdate['be_mat']         = (int)$aVals['be_mat'];
				$aUpdate['khuon_duoi']     = (int)$aVals['khuon_duoi'];
				$aUpdate['packing']        = (int)$aVals['packing'];
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableVansan, $aUpdate, 'vansan_id = ' . (int) $iId)){
					$this->removeCacheVansan($iId);
					return true;
				}
			}
		}
		return false;
	}


	/**
	 * Xóa ván sàn
	 * @param int $iId
	 * @return int
	 */
	public function deleteVansan($iId){
		if($iId){
			$aRow = Phpfox::getService('manager.plan')->getVansan($iId);
			if($aRow){
				if($this->database()->delete($this->_sTableVansan, 'vansan_id =' . (int)$iId)){
					$this->removeCacheVansan($iId);
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
	public function removeCacheVansan($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'vansan_' . $sItem));
		}
		$this->cache()->remove(array('manager', 'vansan_all'));
		return true;
	}
}
