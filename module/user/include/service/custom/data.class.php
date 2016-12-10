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
 * @version 		$Id: data.class.php 7245 2014-03-31 19:24:29Z Nguyen Duc $
 */
class User_Service_Custom_Data extends Phpfox_Service 
{
	public function __construct()
	{
		
	}

	public function getTextUserViewId($iData = NULL, $bHtml = false){
		$aData = array(
            0 => array(
            	'text' => 'Đang làm việc',
            	'html' => '<span class="label label-success">Đang làm việc</span>',
            ),
            1 => array(
            	'text' => 'Chưa phê duyệt',
            	'html' => '<span class="label label-warning">Chưa phê duyệt</span>',
            ),
            2 => array(
            	'text' => 'Không được phê duyệt',
            	'html' => '<span class="label bg-purple">Không được phê duyệt</span>',
            ),
            3 => array(
            	'text' => 'Tạm nghỉ',
            	'html' => '<span class="label label-info">Tạm nghỉ</span>',
            ),
            4 => array(
            	'text' => 'Thôi việc',
            	'html' => '<span class="label label-danger">Thôi việc</span>',
            ),
        );
        if($iData !== NULL){
            if(array_key_exists($iData, $aData)){
            	if($bHtml){
            		return $aData[$iData]['html'];
            	}else{
            		return $aData[$iData]['text'];
            	}
            }
        }else{
            return $aData;
        }
        return false;
	}
}