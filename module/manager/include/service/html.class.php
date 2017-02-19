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

class Manager_Service_Html extends Phpfox_Service {
	/**
	 * Class constructor
	 */
	public function __construct()
	{

	}

	/**
	 * Lấy giá trị đơn vị kiểm kê Trong setting
	 * @param int $iKey
	 * @return string
	 */
	public function getNewskyInventoriedUnit($iKey = ''){
		echo (string)Phpfox::getService('manager.data')->getDataInventoriedUnit($iKey);
	}

	/**
	 * Lấy giá trị đơn vị bán Trong setting
	 * @param int $iKey
	 * @return string
	 */
	public function getNewskySaleUnit($iKey = ''){
		echo (string)Phpfox::getService('manager.data')->getDataSaleUnit($iKey);
	}

	/**
	 * Lấy giá trị đơn vị tính
	 * @param int $iKey
	 * @return string
	 */
	public function getNewskyUnit($iKey = ''){
		echo (string)Phpfox::getService('manager.data')->getDataUnit($iKey);
	}
	
	/**
	 * Lấy giá trị vị trí Trong setting
	 * @param int $iKey
	 * @return string
	 */
	public function getNewskyPosition($iKey = ''){
		echo (string)Phpfox::getService('manager.data')->getDataPosition($iKey);
	}

	/**
	 * Lấy giá trị bề mặt
	 * @param int $iKey
	 * @return string
	 */
	public function getNewskyBeMat($iKey = ''){
		echo (string)Phpfox::getService('manager.data')->getDataBeMat($iKey);
	}


	/**
	 * Lấy giá trị kiểu vát
	 * @param int $iKey
	 * @return string
	 */
	public function getNewskyKieuVat($iKey = ''){
		echo (string)Phpfox::getService('manager.data')->getDataKieuVatCanh($iKey);
	}

	/**
	 * Lấy giá trị khuôn dưới
	 * @param int $iKey
	 * @return string
	 */
	public function getNewskyKhuonDuoi($iKey = ''){
		echo (string)Phpfox::getService('manager.data')->getDataKhuonDuoi($iKey);
	}

	/**
	 * Lấy giá trị khuôn dưới
	 * @param int $iKey
	 * @return string
	 */
	public function getNewskyKieuRanh($iKey = ''){
		echo (string)Phpfox::getService('manager.data')->getDataKieuRanh($iKey);
	}

	/**
	 * Lấy tính chất kết dư
	 * @param int $iKey
	 * @return string
	 */
	public function getNewskyTinhChatKetDu($iKey = ''){
		echo (string)Phpfox::getService('manager.data')->getDataTinhChatKetDu($iKey);
	}

	/**
	 * Lấy status order
	 * @param int $iKey
	 * @return string
	 */
	public function getNewskyStatusOrder($iKey = ''){
		echo (string)Phpfox::getService('manager.data')->getStatusOrderHtml($iKey);
	}
	
}