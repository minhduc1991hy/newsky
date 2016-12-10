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
 * @package  		Module_User
 * @version 		$Id: user.class.php 7245 2014-03-31 19:24:29Z Nguyen Duc $
 */
class User_Service_Custom_User extends Phpfox_Service 
{
	public function __construct()
	{
		$this->_sTableUser = Phpfox::getT('user');
		$this->_sTableUserGroup = Phpfox::getT('user_group');
	}

	/**
	 * Lấy thông tin danh sách tất cả thành viên
	 * @param array $aParams
	 * @param int $iPage
	 * @param int $iPageSize
	 * @param string $sOrder
	 * @return array 
	 */
	public function getUsers($aParams = null, $iPage = 1, $iPageSize = 10, $sOrder = ''){
		$iCnt = $this->database()->select('COUNT(*)')
		    ->from($this->_sTableUser, 'u')
		    ->join($this->_sTableUserGroup, 'ug', 'ug.user_group_id = u.user_group_id')
			->where($aParams)
			->execute('getSlaveField');

		if(!$iCnt) return array($iCnt, null);

		$aRows = $this->database()->select('u.*, ug.title AS title_group')
            ->from($this->_sTableUser, 'u')
            ->join($this->_sTableUserGroup, 'ug', 'ug.user_group_id = u.user_group_id')
            ->where($aParams)
            ->limit($iPage, $iPageSize, $iCnt)
            ->order($sOrder)
            ->execute('getSlaveRows');

        if($aRows){
        	foreach ($aRows as $key => $aRow) {
        		$aRows[$key]['text_view_id'] = $this->addTextViewId($aRow['view_id']);
        		$aRows[$key]['html_text_view_id'] = $this->addTextViewId($aRow['view_id'], true);
        	}

        	// echo "<pre>";
        	// print_r($aRows);
        	// echo "</pre>";
        	// die;
        }  

        return array($iCnt, $aRows);
	}

	public function addTextViewId($iViewId, $bHtml = false){
		return Phpfox::getService('user.custom.data')->getTextUserViewId($iViewId, $bHtml);
		
	}
}