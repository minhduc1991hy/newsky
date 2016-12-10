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
 * @version 		$Id: process.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Supplies_Process extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableHdf              = Phpfox::getT('ns_hdf');
		$this->_sTableCategory         = Phpfox::getT('ns_category');
		$this->_sTableSupplies         = Phpfox::getT('ns_supplies');
		$this->_sTableRawpaper         = Phpfox::getT('ns_rawpaper');
		$this->_sTableFlooringMaterial = Phpfox::getT('ns_flooring_materials');
		$this->_sTableHotplate         = Phpfox::getT('ns_hotplate');
	}


	/**
	 * Thêm HDF, MDF
	 * @param array $aVals
	 * @return int ID
	 */
	public function addHDF($aVals){
		if($aVals){
			$oParseInput            = Phpfox::getLib('parse.input');
			$aInsert                = array();
			$aInsert['product_id']  = (int)$aVals['product_id'];
			$aInsert['code']        = $oParseInput->clean($aVals['code']);
			$aInsert['description'] = $oParseInput->clean($aVals['description']);
			$aInsert['width']       = (int)$aVals['width'];
			$aInsert['length']      = (int)$aVals['length'];
			$aInsert['thickness']   = (int)$aVals['thickness'];
			$aInsert['user_id']     = Phpfox::getUserId();
			$aInsert['time_stamp']  = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableHdf, $aInsert);
			$this->removeCacheHDF();
			return $iId;
		}
		return false;
	}


	/**
	 * Sửa HDF, MDF
	 * @param array $aVals
	 * @return boolean
	 */
	public function updateHDF($aVals, $iHdfId){
		if($aVals && $iHdfId){
			$aHdf = Phpfox::getService('manager.supplies')->getHdf($iHdfId);
			if($aHdf){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['product_id']    = (int)$aVals['product_id'];
				$aUpdate['code']          = $oParseInput->clean($aVals['code']);
				$aUpdate['description']   = $oParseInput->clean($aVals['description']);
				$aUpdate['width']         = (int)$aVals['width'];
				$aUpdate['length']        = (int)$aVals['length'];
				$aUpdate['thickness']     = (int)$aVals['thickness'];
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableHdf, $aUpdate, 'hdf_id = ' . (int) $iHdfId)){
					$this->removeCacheHDF($aHdf['hdf_id']);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa HDF
	 * @param array $aVals
	 * @return int product_id
	 */
	public function deleteHDF($iHdfId){
		if($iHdfId){
			$aHdf = Phpfox::getService('manager.supplies')->getHdf($iHdfId);
			if($aHdf){
				if($this->database()->delete($this->_sTableHdf, 'hdf_id =' . (int)$iHdfId)){
					$this->removeCacheHDF($aHdf['hdf_id']);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa cache HDF
	 * @param string $sItem
	 */
	public function removeCacheHDF($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'hdf_mdf_' . $sItem));
		}
		$this->cache()->remove(array('manager', 'hdf_all'));
		return true;
	}


	/**
	 * Thêm Supplie
	 * @param array $aVals
	 * @return int ID
	 */
	public function addSupplie($aVals){
		if($aVals){
			$oParseInput            = Phpfox::getLib('parse.input');
			$aInsert                = array();
			$aInsert['code']        = $oParseInput->clean($aVals['code']);
			$aInsert['name']        = $oParseInput->clean($aVals['name']);
			$aInsert['address']     = $oParseInput->clean($aVals['address']);
			$aInsert['phone']       = $oParseInput->clean($aVals['phone']);
			$aInsert['description'] = $oParseInput->clean($aVals['description']);
			$aInsert['user_id']     = Phpfox::getUserId();
			$aInsert['time_stamp']  = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableSupplies, $aInsert);
			if($iId){
				$this->removeCacheSupplie();
				return $iId;
			}
		}
		return false;
	}


	/**
	 * Sửa Supplie
	 * @param array $aVals
	 * @param int $iSupplieId
	 * @return boolean
	 */
	public function updateSupplie($aVals, $iSupplieId){
		if($aVals && $iSupplieId){
			$aSupplie = Phpfox::getService('manager.supplies')->getSupplie($iSupplieId);
			if($aSupplie){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['code']          = $oParseInput->clean($aVals['code']);
				$aUpdate['name']          = $oParseInput->clean($aVals['name']);
				$aUpdate['address']       = $oParseInput->clean($aVals['address']);
				$aUpdate['phone']         = $oParseInput->clean($aVals['phone']);
				$aUpdate['description']   = $oParseInput->clean($aVals['description']);
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableSupplies, $aUpdate, 'supplie_id = ' . (int) $iSupplieId)){
					$this->removeCacheSupplie($aSupplie['supplie_id']);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa Supplie
	 * @param int $iSupplieId
	 * @return boolean
	 */
	public function deleteSupplie($iSupplieId){
		if($iSupplieId){
			$aSupplie = Phpfox::getService('manager.supplies')->getSupplie($iSupplieId);
			if($aSupplie){
				if($this->database()->delete($this->_sTableSupplies, 'supplie_id =' . (int)$iSupplieId)){
					$this->removeCacheSupplie($aSupplie['supplie_id']);
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
	public function removeCacheSupplie($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'supplie_' . $sItem));
		}
		$this->cache()->remove(array('manager', 'supplie_all'));
		return true;
	}

	/**
	 * Thêm Rawpaper
	 * @param array $aVals
	 * @return int ID
	 */
	public function addRawpaper($aVals){
		if($aVals){
			$oParseInput           = Phpfox::getLib('parse.input');
			$aInsert               = array();
			$aInsert['color_id']   = (int)$aVals['color_id'];
			$aInsert['supplie_id'] = (int)$aVals['supplie_id'];
			$aInsert['product_id'] = (int)$aVals['product_id'];
			$aInsert['code']       = $oParseInput->clean($aVals['code']);
			$aInsert['title']      = $oParseInput->clean($aVals['title']);
			$aInsert['weight']     = (int)$aVals['weight'];
			$aInsert['user_id']    = Phpfox::getUserId();
			$aInsert['time_stamp'] = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableRawpaper, $aInsert);
			return $iId;
		}
		return false;
	}


	/**
	 * Sửa Rawpaper
	 * @param array $aVals
	 * @param int $iRawPaperId
	 * @return boolean
	 */
	public function updateRawpaper($aVals, $iRawPaperId){
		if($aVals && $iRawPaperId){
			$aRawpaper = Phpfox::getService('manager.supplies')->getRawpaper($iRawPaperId);
			if($aRawpaper){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['color_id']      = (int)$aVals['color_id'];
				$aUpdate['supplie_id']    = (int)$aVals['supplie_id'];
				$aUpdate['product_id']    = (int)$aVals['product_id'];
				$aUpdate['code']          = $oParseInput->clean($aVals['code']);
				$aUpdate['title']         = $oParseInput->clean($aVals['title']);
				$aUpdate['weight']        = (int)$aVals['weight'];
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableRawpaper, $aUpdate, 'rawpaper_id = ' . (int) $iRawPaperId)){
					$this->removeCacheRawpaper($iRawPaperId);
					return true;
				}
			}
		}
		return false;
	}


	/**
	 * Xóa Rawpaper
	 * @param int $iRawPaperId
	 * @return int
	 */
	public function deleteRawpaper($iRawPaperId){
		if($iRawPaperId){
			$aRow = Phpfox::getService('manager.supplies')->getRawpaper($iRawPaperId);
			if($aRow){
				if($this->database()->delete($this->_sTableRawpaper, 'rawpaper_id =' . (int)$iRawPaperId)){
					$this->removeCacheRawpaper($iRawPaperId);
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Xóa cache Rawpaper
	 * @param string $sItem
	 */
	public function removeCacheRawpaper($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'raw_paper_' . $sItem));
		}
		return true;
	}



	/**
	 * Thêm Flooring Material
	 * @param array $aVals
	 * @return int ID
	 */
	public function addFlooringMaterial($aVals){
		if($aVals){
			$oParseInput                 = Phpfox::getLib('parse.input');
			$aInsert                     = array();
			$aInsert['product_id']       = (int)$aVals['product_id'];
			$aInsert['inventoried_unit'] = (int)$aVals['inventoried_unit'];
			$aInsert['sale_unit']        = (int)$aVals['sale_unit'];
			$aInsert['code']             = $oParseInput->clean($aVals['code']);
			$aInsert['title']            = $oParseInput->clean($aVals['title']);
			$aInsert['width']            = (int)$aVals['width'];
			$aInsert['length']           = (int)$aVals['length'];
			$aInsert['user_id']          = Phpfox::getUserId();
			$aInsert['time_stamp']       = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableFlooringMaterial, $aInsert);
			return $iId;
		}
		return false;
	}


	/**
	 * Sửa FlooringMaterial
	 * @param array $aVals
	 * @param int $iId
	 * @return boolean
	 */
	public function updateFlooringMaterial($aVals, $iId){
		if($aVals && $iId){
			$aRow = Phpfox::getService('manager.supplies')->getFlooringMaterial($iId);
			if($aRow){
				$oParseInput                  = Phpfox::getLib('parse.input');
				$aUpdate                      = array();
				$aUpdate['product_id']       = (int)$aVals['product_id'];
				$aUpdate['inventoried_unit'] = (int)$aVals['inventoried_unit'];
				$aUpdate['sale_unit']        = (int)$aVals['sale_unit'];
				$aUpdate['code']             = $oParseInput->clean($aVals['code']);
				$aUpdate['title']            = $oParseInput->clean($aVals['title']);
				$aUpdate['width']            = (int)$aVals['width'];
				$aUpdate['length']           = (int)$aVals['length'];
				$aUpdate['userid_update']     = Phpfox::getUserId();
				$aUpdate['time_update']       = PHPFOX_TIME;
				if($this->database()->update($this->_sTableFlooringMaterial, $aUpdate, 'material_id = ' . (int) $iId)){
					$this->removeCacheFlooringMaterial($iId);
					return true;
				}
			}
		}
		return false;
	}


	/**
	 * Xóa FlooringMaterial
	 * @param int $iId
	 * @return int
	 */
	public function deleteFlooringMaterial($iId){
		if($iId){
			$aRow = Phpfox::getService('manager.supplies')->getFlooringMaterial($iId);
			if($aRow){
				if($this->database()->delete($this->_sTableFlooringMaterial, 'material_id =' . (int)$iId)){
					$this->removeCacheFlooringMaterial($iId);
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
	public function removeCacheFlooringMaterial($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'flooring_materials_' . $sItem));
		}
		return true;
	}


	/**
	 * Thêm Hotplate
	 * @param array $aVals
	 * @return int ID
	 */
	public function addHotplate($aVals){
		if($aVals){
			$oParseInput           = Phpfox::getLib('parse.input');
			$aInsert               = array();
			$aInsert['supplie_id'] = (int)$aVals['supplie_id'];
			$aInsert['code']       = $oParseInput->clean($aVals['code']);
			$aInsert['be_mat']     = (int)$aVals['be_mat'];
			$aInsert['position']   = (int)$aVals['position'];
			$aInsert['comment']    = $oParseInput->clean($aVals['comment']);
			$aInsert['user_id']    = Phpfox::getUserId();
			$aInsert['time_stamp'] = PHPFOX_TIME;
			$iId = $this->database()->insert($this->_sTableHotplate, $aInsert);
			return $iId;
		}
		return false;
	}


	/**
	 * Sửa Hotplate
	 * @param array $aVals
	 * @param int $iId
	 * @return boolean
	 */
	public function updateHotplate($aVals, $iId){
		if($aVals && $iId){
			$aRow = Phpfox::getService('manager.supplies')->getHotplate($iId);
			if($aRow){
				$oParseInput              = Phpfox::getLib('parse.input');
				$aUpdate                  = array();
				$aUpdate['be_mat']        = (int)$aVals['be_mat'];
				$aUpdate['supplie_id']    = (int)$aVals['supplie_id'];
				$aUpdate['code']          = $oParseInput->clean($aVals['code']);
				$aUpdate['position']      = (int)$aVals['position'];
				$aUpdate['comment']       = $oParseInput->clean($aVals['comment']);
				$aUpdate['userid_update'] = Phpfox::getUserId();
				$aUpdate['time_update']   = PHPFOX_TIME;
				if($this->database()->update($this->_sTableHotplate, $aUpdate, 'hotplate_id = ' . (int) $iId)){
					$this->removeCacheHotplate($iId);
					return true;
				}
			}
		}
		return false;
	}


	/**
	 * Xóa Hotplate
	 * @param int $iId
	 * @return int
	 */
	public function deleteHotplate($iId){
		if($iId){
			$aRow = Phpfox::getService('manager.supplies')->getHotplate($iId);
			if($aRow){
				if($this->database()->delete($this->_sTableHotplate, 'hotplate_id =' . (int)$iId)){
					$this->removeCacheHotplate($iId);
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
	public function removeCacheHotplate($sItem = ''){
		if($sItem){
			$this->cache()->remove(array('manager', 'hotplate_' . $sItem));
		}
		return true;
	}
}