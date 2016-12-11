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
 * @version 		$Id: order.class.php 6216 07-03-2015 08:23:46Z Nguyen duc $
 */
class Manager_Service_Order_Order extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTableOrder        = Phpfox::getT('ns_order');
		$this->_sTableOrderProduct = Phpfox::getT('ns_order_product');
	}

	public function getSessionOrder($sName = 'session_order'){
		$oSession = Phpfox::getLib('session');
		$aDatas = (array)$oSession->get($sName);
		unset($aDatas[0]);
		return $aDatas;
	}

	public function setSessionOrder($aDatas, $sName = 'session_order'){
		$oSession = Phpfox::getLib('session');
		$oSession->set($sName, $aDatas);
		return $aDatas;
	}

	public function removeSessionOrder($sName = 'session_order'){
		$oSession = Phpfox::getLib('session');
		$oSession->remove($sName);
		return true;
	}

	public function validateSessionOrder($iUserId){
		$aDatas = $this->getSessionOrder();
		if($iUserId){
			if(!array_key_exists($iUserId, $aDatas)){
				$aDatas[$iUserId] = array();
				$aDatas = $this->setSessionOrder($aDatas);
			}
		}

		return $aDatas;
	}

	public function getInfoSessesionOrder($aDatas){
		$aDataReturns = $aDatas;
		if($aDataReturns){

			foreach ($aDataReturns as $iUserId => $aData) {
				$aUser = Phpfox::getService('user')->get($iUserId);
				if($aUser){
					$aDataReturns[$iUserId]['user'] = $aUser;
					$aProducts = (isset($aData['products']) ? $aData['products'] : array());
					if($aProducts){
						foreach ($aProducts as $key => $aProduct) {
							$bUnset = false;
							if(!$bUnset){
								$aVanSan = Phpfox::getService('manager.plan')->getVansan($aProduct['vansan_id']);
								$aDataReturns[$iUserId]['products'][$key]['vansan'] = $aVanSan;
								if(!$aVanSan) $bUnset = true;
							}
							
							if(!$bUnset){
								$aSkirting = Phpfox::getService('manager.plan')->getSkirting($aProduct['skirting_id']);
								$aDataReturns[$iUserId]['products'][$key]['skirting'] = $aSkirting;
								if(!$aSkirting) $bUnset = true;
							}
							
							if($bUnset){
								unset($aDataReturns[$iUserId]['products'][$key]);
								unset($aDatas[$iUserId]['products'][$key]);
								continue;
							}
						}
					}
				}else{
					unset($aDataReturns[$iUserId]);
					unset($aDatas[$iUserId]);
				}
			}

			$this->setSessionOrder($aDatas);
		}
		return $aDataReturns;
	}

	public function removeOrder($iUserId){
		$aDatas = $this->getSessionOrder();
		if($iUserId && $aDatas){
			unset($aDatas[$iUserId]);
			$this->setSessionOrder($aDatas);
			return key($aDatas);
		}
		return false;
	}

	public function countOrder($aCound = array()){
		$iCnt = $this->database()->select('count(*)')
			->from($this->_sTableOrder, 'o')
			->where($aCound)
			->execute('getSlaveField');
		return $iCnt;
	}

	public function getOrderCode(){
		$oHash = Phpfox::getLib('hash');
		for ($i=0; $i < 100; $i++) { 
			$sOrderCode = $oHash->setRandomCode();
			$aCound = array(
				'AND o.code = "'.$sOrderCode.'"',
			);
			if(!$this->countOrder($aCound)){
				return $sOrderCode;
			}
		}
		return false;
	}
}