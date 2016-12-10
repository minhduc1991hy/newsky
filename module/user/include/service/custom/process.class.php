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
 * @version 		$Id: process.class.php 7245 2014-03-31 19:24:29Z Nguyen Duc $
 */
class User_Service_Custom_Process extends Phpfox_Service 
{
	public function __construct()
	{
		$this->_sTableUser         = Phpfox::getT('user');
		$this->_sTableUserActivity = Phpfox::getT('user_activity');
		$this->_sTableUserField    = Phpfox::getT('user_field');
		$this->_sTableUserSpace    = Phpfox::getT('user_space');
		$this->_sTableUserCount    = Phpfox::getT('user_count');
		$this->_sTableUserIp   = Phpfox::getT('user_ip');
	}

	/**
	 * Thêm thành viên mới
	 * @param array $aVals
	 * @return int ID thành viên mới được thêm 
	 */
	public function add($aVals){
		if($aVals){
			$oParseInput = Phpfox::getLib('parse.input');
			$sSalt       = Phpfox::getService('user.process')->getSalt();

			$aInsert = array(
				'status_id'       => 0,
				'view_id'         => ((int)$aVals['user_group_id'] ? (int)$aVals['user_group_id'] : 1),
				'user_group_id'   => ((int)$aVals['user_group_id'] ? (int)$aVals['user_group_id'] : NORMAL_USER_ID),
				'full_name'       => $oParseInput->clean($aVals['full_name'], 255),
				'password'        => Phpfox::getLib('hash')->setHash($aVals['password'], $sSalt),
				'password_salt'   => $sSalt,
				'email'           => $aVals['email'],
				'phone'           => $oParseInput->clean($aVals['phone'], 255),
				'joined'          => PHPFOX_TIME,
				'gender'          => ((int)$aVals['gender'] ? (int)$aVals['gender'] : 0),
				'user_position'   => $oParseInput->clean($aVals['user_position'], 255),
				'user_contact'    => $oParseInput->clean($aVals['user_contact'], 255),
				'job_description' => $oParseInput->clean($aVals['job_description'], 255),
				'birthday'        => ($aVals['day'] && $aVals['month'] && $aVals['year'] ? Phpfox::getService('user')->buildAge($aVals['day'],$aVals['month'],$aVals['year']) : null),
				'birthday_search' => ($aVals['day'] && $aVals['month'] && $aVals['year'] ? Phpfox::getLib('date')->mktime(0, 0, 0, $aVals['month'], $aVals['day'], $aVals['year']) : 0),
				'last_ip_address' => Phpfox::getIp(),
				'last_activity'   => PHPFOX_TIME
			);

			$aVals['user_name']   = str_replace(' ', '_', $aVals['user_name']);
			$aInsert['user_name'] = $oParseInput->clean($aVals['user_name']);

			$iId = $this->database()->insert($this->_sTableUser, $aInsert);
			if(!$iId) return false;

			$aExtras = array( 'user_id' => $iId );
			$this->database()->insert($this->_sTableUserActivity, $aExtras);
			$this->database()->insert($this->_sTableUserField, $aExtras);
			$this->database()->insert($this->_sTableUserSpace, $aExtras);
			$this->database()->insert($this->_sTableUserCount, $aExtras);

			$this->database()->insert($this->_sTableUserIp, array(
					'user_id'    => $iId,
					'type_id'    => 'register',
					'ip_address' => Phpfox::getIp(),
					'time_stamp' => PHPFOX_TIME
				)
			);

			return $iId;
		}
		return false;
	}

	/**
	 * Sửa thông tin thành viên
	 * @param array $aVals
	 * @param int $iUserId
	 * @return boolean
	 */
	public function update($aVals, $iUserId){
		if($aVals && $iUserId){
			$oParseInput = Phpfox::getLib('parse.input');

			$aUpdate = array();
			if(isset($aVals['full_name'])){
				$aUpdate['full_name'] = $oParseInput->clean($aVals['full_name'], 255);
			}

			if(isset($aVals['user_name'])){
				$aVals['user_name']   = str_replace(' ', '_', $aVals['user_name']);
				$aUpdate['user_name'] = $oParseInput->clean($aVals['user_name']);
			}

			if(isset($aVals['email'])){
				$aUpdate['email'] = $aVals['email'];
			}

			if(isset($aVals['user_contact'])){
				$aUpdate['user_contact'] = $oParseInput->clean($aVals['user_contact'], 255);
			}

			if(isset($aVals['phone'])){
				$aUpdate['phone'] = $oParseInput->clean($aVals['phone'], 255);
			}

			if(isset($aVals['gender'])){
				$aUpdate['gender'] = ((int)$aVals['gender'] ? (int)$aVals['gender'] : 0);
			}

			if(isset($aVals['day']) && isset($aVals['month']) && isset($aVals['year'])){
				$aUpdate['birthday']        = Phpfox::getService('user')->buildAge($aVals['day'],$aVals['month'],$aVals['year']);
				$aUpdate['birthday_search'] = Phpfox::getLib('date')->mktime(0, 0, 0, $aVals['month'], $aVals['day'], $aVals['year']);
			}

			if(isset($aVals['user_group_id'])){
				$aUpdate['user_group_id'] = (int)$aVals['user_group_id'];
			}

			if(isset($aVals['user_position'])){
				$aUpdate['user_position'] = $oParseInput->clean($aVals['user_position'], 255);
			}

			if(isset($aVals['view_id']) && $aVals['view_id'] >= 0){
				$aUpdate['view_id'] = (int)$aVals['view_id'];
			}

			if(isset($aVals['job_description'])){
				$aUpdate['job_description'] = $oParseInput->clean($aVals['job_description'], 255);
			}

			// echo "<pre>";
			// print_r($aUpdate);
			// die();

			if($aUpdate){
				if($this->database()->update($this->_sTableUser, $aUpdate, 'user_id = ' . (int)$iUserId)){
					return true;
				}
			}
		}
		return false;
	}
}