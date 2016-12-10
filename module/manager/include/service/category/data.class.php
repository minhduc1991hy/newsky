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
 * @version 		$Id: data.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Category_Data extends Phpfox_Service
{
	public function __construct()
	{
		
	}

	/**
	 * Lấy type ID của accouting Data
	 * @param string $sData
	 * @return string | array
	 */
	public function getCategoryTypeIdData($sData = NULL){
		$aData = array(
			'category_product'   => 'Danh mục sản phẩm',
			'hdf_mdf'            => 'Danh mục HDF',
			'color_schema'       => 'Danh mục trang mã màu',
			'rawpaper'           => 'Danh mục giấy thô',
			'flooring_materials' => 'Danh mục vật liệu phụ lát sàn',
			// 'hotplate'           => 'Bề mặt khuôn ép',
			'skirting'           => 'Danh mục phào chân tường',
			'segment'            => 'Công đoạn danh mục máy móc thiết bị',
			'vansan'			 => 'Danh mục ván sàn'
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

