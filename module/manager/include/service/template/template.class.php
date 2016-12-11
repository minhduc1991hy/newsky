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
				'plugin/moment.min.js'           => 'style_script',
				'plugin/daterangepicker.js'      => 'style_script',
				'plugin/bootstrap-datepicker.js' => 'style_script',

                'main.js' => 'module_manager',
                'plugin/daterangepicker.css'     => 'style_css',
				'plugin/datepicker3.css'         => 'style_css',
			));

		$oTemplate->assign(array(
			'bInManager' => true,
		));
	}
}