<?php

defined('PHPFOX') or exit('NO DICE!');

/**
 * [PHPFOX_HEADER]
 */

/**
 * @company		SocialEnginePRO
 * @author  		Inomjon Narmatov
 * @package  		Module_Backuprestore
 */

class Manager_Service_Template_Template extends Phpfox_Service {
	/**
	 * Class constructor
	 */
	public function __construct()
	{

	}

	public function getTemplate($sTitle = '', $sDescription = '', $sKeywords = '', $bSearch = true){
		$oTemplate    = Phpfox::getLib('template');
		$oParseOutput = Phpfox::getLib('parse.output');
		$oTemplate->setTitle($sTitle)
			->setMeta('description', $oParseOutput->parse($sDescription))
			->setMeta('keywords', $oParseOutput->parse($sKeywords))
			->setHeader(array(
                'main.js' => 'module_manager',
                'bInManager' => true,
			));

		$oTemplate->assign(array(
			'bInManager' => true,
		));
	}
}