<?php

defined('PHPFOX') or exit('NO DICE!');

/**
 * [PHPFOX_HEADER]
 */

/**
 * @company		SocialEnginePRO
 * @author  	Nguyen Duc
 * @package  	Module_Manager
 */

class Manager_Service_Data extends Phpfox_Service {
	/**
	 * Class constructor
	 */
	public function __construct()
	{

	}

	/**
	 * get của InventoriedUnit
	 * @param int $sData
	 * @return string | array
	 */
	public function getDataInventoriedUnit($sData = NULL){
		$aData = array(
			1 => 'Cây',
			2 => 'm'
		);
		if($sData !== NULL){
			if(array_key_exists($sData, $aData)){
				return $aData[$sData];
			}
		}else{
			return $aData;
		}
		return false;
	}

	/**
	 * get của SaleUnit
	 * @param int $sData
	 * @return string | array
	 */
	public function getDataSaleUnit($sData = NULL){
		$aData = array(
			1 => 'md',
			2 => 'm'
		);
		if($sData !== NULL){
			if(array_key_exists($sData, $aData)){
				return $aData[$sData];
			}
		}else{
			return $aData;
		}
		return false;
	}


	/**
	 * get của Position
	 * @param int $sData
	 * @return string | array
	 */
	public function getDataPosition($sData = NULL){
		$aData = array(
			1 => 'Trên',
			2 => 'Dưới'
		);
		if($sData !== NULL){
			if(array_key_exists($sData, $aData)){
				return $aData[$sData];
			}
		}else{
			return $aData;
		}
		return false;
	}

	/**
	 * get của Unit
	 * @param int $sData
	 * @return string | array
	 */
	public function getDataUnit($sData = NULL){
		$aData = array(
			1 => 'Tấm',
		);
		if($sData !== NULL){
			if(array_key_exists($sData, $aData)){
				return $aData[$sData];
			}
		}else{
			return $aData;
		}
		return false;
	}

	/**
	 * get của KieuVatCanh
	 * @param int $sData
	 * @return string | array
	 */
	public function getDataKieuVatCanh($sData = NULL){
		$aData = array(
			1 => 'V - Sơn cạnh',
			2 => 'U - Ép cạnh',
			3 => 'P - Phẳng',
		);
		if($sData !== NULL){
			if(array_key_exists($sData, $aData)){
				return $aData[$sData];
			}
		}else{
			return $aData;
		}
		return false;
	}

	/**
	 * get của BeMat
	 * @param int $sData
	 * @return string | array
	 */
	public function getDataBeMat($sData = NULL){
		$aData = array(
			1 => 'Sần K',
			2 => 'Sần mưa',
			3 => 'Bóng mờ',
			4 => 'Sần da bò',
			5 => 'Sần thô',
			6 => 'U bóng',
			7 => 'U sần K',
		);
		if($sData !== NULL){
			if(array_key_exists($sData, $aData)){
				return $aData[$sData];
			}
		}else{
			return $aData;
		}
		return false;
	}

	/**
	 * get của KhuonDuoi
	 * @param int $sData
	 * @return string | array
	 */
	public function getDataKhuonDuoi($sData = NULL){
		$aData = array(
			1 => 'Bóng mờ',
			2 => 'Sần da bò',
			3 => 'Sần mưa',
			4 => 'Logo Newsky',
			5 => 'Logo Verselife',
		);
		if($sData !== NULL){
			if(array_key_exists($sData, $aData)){
				return $aData[$sData];
			}
		}else{
			return $aData;
		}
		return false;
	}

	/**
	 * get của KieuRanh
	 * @param int $sData
	 * @return string | array
	 */
	public function getDataKieuRanh($sData = NULL){
		$aData = array(
			1 => 'R1',
			2 => 'R2',
			3 => 'RP',
			4 => 'R8',
		);
		if($sData !== NULL){
			if(array_key_exists($sData, $aData)){
				return $aData[$sData];
			}
		}else{
			return $aData;
		}
		return false;
	}

	/**
	 * Tính chất kết dư tài khoản kế toán
	 * @param int $sData
	 * @return string | array
	 */
	public function getDataTinhChatKetDu($sData = NULL){
		$aData = array(
			1 => 'Nợ',
			2 => 'Có',
			3 => 'Lưỡng tính',
			4 => 'Triệt tiêu',
		);
		if($sData !== NULL){
			if(array_key_exists($sData, $aData)){
				return $aData[$sData];
			}
		}else{
			return $aData;
		}
		return false;
	}
}