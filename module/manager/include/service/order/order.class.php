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
		$this->_sTableUser         = Phpfox::getT('user');
		$this->_sTableSkirting     = Phpfox::getT('ns_skirting');
		$this->_sTableVansan       = Phpfox::getT('ns_vansan'); 
	}

	/**
	 * get session order
	 * @param string $sName
	 * @return array 
	 */
	public function getSessionOrder($sName = 'session_order'){
		$oSession = Phpfox::getLib('session');
		$aDatas = (array)$oSession->get($sName);
		unset($aDatas[0]);
		return $aDatas;
	}

	/**
	 * set session order
	 * @param array $aDatas
	 * @param string $sName
	 * @return array 
	 */
	public function setSessionOrder($aDatas, $sName = 'session_order'){
		$oSession = Phpfox::getLib('session');
		$oSession->set($sName, $aDatas);
		return $aDatas;
	}

	/**
	 * remove session order
	 * @param string $sName
	 * @return array 
	 */
	public function removeSessionOrder($sName = 'session_order'){
		$oSession = Phpfox::getLib('session');
		$oSession->remove($sName);
		return true;
	}

	/**
	 * validate session order
	 * @param int $iUserId
	 * @return array 
	 */
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

	/**
	 * Get info session order
	 * @param array $aDatas
	 * @return array 
	 */
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

	/**
	 * Xóa session order
	 * @param int $iUserId
	 * @return array 
	 */
	public function removeOrder($iUserId){
		$aDatas = $this->getSessionOrder();
		if($iUserId && $aDatas){
			unset($aDatas[$iUserId]);
			$this->setSessionOrder($aDatas);
			return key($aDatas);
		}
		return false;
	}

	/**
	 * get nhiều count order
	 * @param array $aCound
	 * @return array 
	 */
	public function countOrder($aCound = array()){
		$iCnt = $this->database()->select('count(*)')
			->from($this->_sTableOrder, 'o')
			->where($aCound)
			->execute('getSlaveField');
		return $iCnt;
	}

	/**
	 * get nhiều Order Code
	 * @return array 
	 */
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

	/**
	 * get nhiều Orders
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getOrders($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = 'o.time_stamp DESC'){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableOrder, 'o')
		    ->join($this->_sTableUser, 'u', 'u.user_id = o.customer_id')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);
		$sSelect = 'o.*, ' . Phpfox::getUserField();
		$aRows = $this->database()->select($sSelect)
            ->from($this->_sTableOrder, 'o')
            ->join($this->_sTableUser, 'u', 'u.user_id = o.customer_id')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');
        if($aRows){
        	foreach ($aRows as $key => $aRow) {
	        	$aRows[$key]['products'] = $this->getOrderProducts($aRow['order_id']);
	        }
        }

        return array($iCnt, $aRows);
	}

	/**
	 * get nhiều Orders Product
	 * @param int $iOrderId
	 * @return array 
	 */
	public function getOrderProducts($iOrderId){
		if($iOrderId){
			$aParams = array(
				'AND op.order_id = ' . (int)$iOrderId
			);
			$sSelect = 'op.*';
			$aRows = $this->database()->select($sSelect)
	            ->from($this->_sTableOrderProduct, 'op')
	            ->leftjoin($this->_sTableVansan, 'v', 'v.vansan_id = op.vansan_id')
	            ->leftjoin($this->_sTableSkirting, 's', 's.skirting_id = op.skirting_id')
	            ->where($aParams)
	            ->order('op.order_product_id ASC')
	            ->execute('getSlaveRows');
	        if($aRows){
	        	foreach ($aRows as $key => $aRow) {
	        		$aVanSan = Phpfox::getService('manager.plan')->getVansan($aRow['vansan_id']);
					$aRows[$key]['vansan'] = $aVanSan;

					$aSkirting = Phpfox::getService('manager.plan')->getSkirting($aRow['skirting_id']);
					$aRows[$key]['skirting'] = $aSkirting;
		        }
	        }
	        return $aRows;
		}
		return false;
	}

	/**
	 * get Order Product
	 * @param int $iProductId
	 * @return array 
	 */
	public function getOrderProduct($iProductId){
		if($iProductId){
			$aParams = array(
				'AND op.order_product_id = ' . (int)$iProductId
			);
			$sSelect = 'op.*';
			$aRow = $this->database()->select($sSelect)
	            ->from($this->_sTableOrderProduct, 'op')
	            ->leftjoin($this->_sTableVansan, 'v', 'v.vansan_id = op.vansan_id')
	            ->leftjoin($this->_sTableSkirting, 's', 's.skirting_id = op.skirting_id')
	            ->where($aParams)
	            ->execute('getSlaveRow');

	        if($aRow){
        		$aVanSan = Phpfox::getService('manager.plan')->getVansan($aRow['vansan_id']);
				$aRow['vansan'] = $aVanSan;

				$aSkirting = Phpfox::getService('manager.plan')->getSkirting($aRow['skirting_id']);
				$aRow['skirting'] = $aSkirting;
				return $aRow;
	        }
		}
		return false;
	}
}