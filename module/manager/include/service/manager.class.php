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

class Manager_Service_Manager extends Phpfox_Service {
	/**
	 * Class constructor
	 */
	public function __construct()
	{

	}

	/**
	 * add prefix for select from
	 * @param array $aDatas
	 * @param string $sPrefix
	 * @param string $a
	 * @return string
	 */
	public function prefixSelect($aDatas = null, $sPrefix = '', $a = ''){
		if($aDatas){
			$sReturn = '';
			foreach ($aDatas as $key => $aData) {
				$sReturn .= $a .'.' . $aData . ' AS ' . $sPrefix . '_' . $aData . ',';
			}
			return trim($sReturn, ',');
		}
		return '';
	}
}