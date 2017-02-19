<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Manager
 * @version 		$Id: main-sidebar.class.php 3342 2011-10-21 12:59:32Z Nguyen Duc $
 */
class Manager_Component_Block_Main_Sidebar extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		$aMenus = array();
		$aGlobalUser = Phpfox::getUserBy(null);

		// Bảng điều khiển
		$aMenus['dashboard'] = array(
			'name' => 'Bảng điều khiển',
			'link' => 'manager.index',
			'icon' => '<i class="fa fa-dashboard"></i>',
			'child' => array(),
		);
		// END: Bảng điều khiển

		// Sản xuất
		$aMenus['produce'] = array(
			'name' => 'Sản xuất',
			'link' => 'manager.produce.index',
			'icon' => '<i class="fa fa-pie-chart"></i>',
			'child' => array(),
		);
		$aMenus['produce']['child'][] = array(
			'name' => 'Danh mục đơn hàng',
			'link' => 'manager.order.index',
		);
		// END: Sản xuất

		// Kho
		$aMenus['warehouse'] = array(
			'name' => 'Kho',
			'link' => 'manager.warehouse.index',
			'icon' => '<i class="fa fa-th"></i>',
			'child' => array(),
		);
		// $aMenus['warehouse']['child'][] = array(
		// 	'name' => 'Tồn BTP ván sàn đầu kỳ',
		// 	'link' => 'manager.warehouse.index',
		// );
		// $aMenus['warehouse']['child'][] = array(
		// 	'name' => 'Tồn HDF đầu kỳ',
		// 	'link' => 'manager.warehouse.index',
		// );
		// $aMenus['warehouse']['child'][] = array(
		// 	'name' => 'Tồn giấy tẩm đầu kỳ',
		// 	'link' => 'manager.warehouse.index',
		// );
		// $aMenus['warehouse']['child'][] = array(
		// 	'name' => 'Tồn giấy tho đầu kỳ',
		// 	'link' => 'manager.warehouse.index',
		// );
		// END: Kho

		// Kinh doanh
		$aMenus['business'] = array(
			'name' => 'Kinh doanh',
			'link' => 'manager.business.index',
			'icon' => '<i class="fa fa-line-chart"></i>',
			'child' => array(),
		);
		// $aMenus['business']['child'][] = array(
		// 	'name' => 'Danh mục khách hàng',
		// 	'link' => 'manager.business.index',
		// );
		// $aMenus['business']['child'][] = array(
		// 	'name' => 'Xuất bản đại lý',
		// 	'link' => 'manager.business.index',
		// );
		// $aMenus['business']['child'][] = array(
		// 	'name' => 'Danh sách hàng đại lý',
		// 	'link' => 'manager.business.index',
		// );
		// END: Kinh doanh

		// Dự án
		if(Phpfox::getUserParam('manager.can_view_list_project_category')){
			$aMenus['project'] = array(
				'name' => 'Dự án',
				'link' => 'manager.project.index',
				'icon' => '<i class="glyphicon glyphicon-folder-open"></i>',
				'child' => array(),
			);
			
			if(Phpfox::getUserParam('manager.can_view_list_project_category')){
				$aMenus['project']['child'][] = array(
					'name' => 'Danh mục dự án',
					'link' => 'manager.project.category',
				);
			}
		}
		// END: Dự án

		// Vật tư
		if(	Phpfox::getUserParam('manager.can_view_list_supplies') ||
			Phpfox::getUserParam('manager.can_view_list_hdf') ||
			Phpfox::getUserParam('manager.can_view_list_hotplate') ||
			Phpfox::getUserParam('manager.can_view_list_raw_paper') ||
			Phpfox::getUserParam('manager.can_view_list_flooring_materials')
		){
			$aMenus['supplies'] = array(
				'name' => 'Vật tư',
				'link' => 'manager.supplies.index',
				'icon' => '<i class="fa fa-motorcycle"></i>',
				'child' => array(),
			);

			if(Phpfox::getUserParam('manager.can_view_list_supplies')){
				$aMenus['supplies']['child'][] = array(
					'name' => 'Danh sách nhà cung cấp',
					'link' => 'manager.supplies.index',
				);
			}

			if(Phpfox::getUserParam('manager.can_view_list_hdf')){
				$aMenus['supplies']['child'][] = array(
					'name' => 'Danh mục HDF, MDF',
					'link' => 'manager.supplies.hdf',
				);
			}

			if(Phpfox::getUserParam('manager.can_view_list_hotplate')){
				$aMenus['supplies']['child'][] = array(
					'name' => 'Danh mục khuôn ép',
					'link' => 'manager.supplies.hotplate',
				);
			}

			if(Phpfox::getUserParam('manager.can_view_list_raw_paper')){
				$aMenus['supplies']['child'][] = array(
					'name' => 'Danh mục giấy thô',
					'link' => 'manager.supplies.raw-paper',
				);
			}
			
			if(Phpfox::getUserParam('manager.can_view_list_flooring_materials')){
				$aMenus['supplies']['child'][] = array(
					'name' => 'DM vật tư phụ cho lát sàn',
					'link' => 'manager.supplies.flooring-materials',
				);
			}
		}

		// END: Vật tư

		// Kế toán
		if(Phpfox::getUserParam('manager.can_view_list_account_system')){
			$aMenus['accounting'] = array(
				'name' => 'Kế toán',
				'link' => '',
				'icon' => '<i class="fa fa-keyboard-o"></i>',
				'child' => array(),
			);

			if(Phpfox::getUserParam('manager.can_view_list_account_system')){
				$aMenus['accounting']['child'][] = array(
					'name' => 'Hệ thống tài khoản',
					'link' => 'manager.accounting.account-system',
				);
			}

			// $aMenus['accounting']['child'][] = array(
			// 	'name' => 'Danh sách class sản phẩm',
			// 	'link' => 'accounting.list-product-class',
			// );

			

			// $aMenus['accounting']['child'][] = array(
			// 	'name' => 'Định giá hạch toán',
			// 	'link' => 'manager.accounting.index',
			// );
			// $aMenus['accounting']['child'][] = array(
			// 	'name' => 'Nhập chứng từ tổng hợp',
			// 	'link' => 'manager.accounting.index',
			// );
			
			// $aMenus['accounting']['child'][] = array(
			// 	'name' => 'Nhập số dư lần đầu',
			// 	'link' => 'manager.accounting.index',	
			// );
			// $aMenus['accounting']['child'][] = array(
			// 	'name' => 'Số cái tờ rơi',
			// 	'link' => 'manager.accounting.index',
			// );
			// $aMenus['accounting']['child'][] = array(
			// 	'name' => 'Bảng cân đối tài khoản',
			// 	'link' => 'manager.accounting.index',
			// );
		}
		// END: Kế toán

		// Kế hoạch
		if(	Phpfox::getUserParam('manager.can_view_list_color_code') ||
			Phpfox::getUserParam('manager.can_view_list_flooring_dim') ||
			Phpfox::getUserParam('manager.can_view_list_skirting') ||
			Phpfox::getUserParam('manager.can_view_list_machine') ||
			Phpfox::getUserParam('manager.can_view_list_vansan')
		){
			$aMenus['plan'] = array(
				'name' => 'Kế hoạch',
				'link' => 'manager.plan.index',
				'icon' => '<i class="fa fa-calendar"></i>',
				'child' => array(),
			);
		
			if(Phpfox::getUserParam('manager.can_view_list_color_code')){
				$aMenus['plan']['child'][] = array(
					'name' => 'Bảng mã màu',
					'link' => 'manager.plan.color-code',
				);
			}

			if(Phpfox::getUserParam('manager.can_view_list_flooring_dim')){
				$aMenus['plan']['child'][] = array(
					'name' => 'Bảng kích thước thành phẩm',
					'link' => 'manager.plan.flooring-dim',
				);
			}
			
			if(Phpfox::getUserParam('manager.can_view_list_vansan')){
				$aMenus['plan']['child'][] = array(
					'name' => 'Danh mục ván sàn',
					'link' => 'manager.plan.vansan',
				);
			}

			if(Phpfox::getUserParam('manager.can_view_list_skirting')){
				$aMenus['plan']['child'][] = array(
					'name' => 'Danh mục phào chân tường',
					'link' => 'manager.plan.skirting',
				);
			}

			if(Phpfox::getUserParam('manager.can_view_list_machine')){
				$aMenus['plan']['child'][] = array(
					'name' => 'Danh mục máy móc thiết bị',
					'link' => 'manager.plan.machine',
				);
			}
		}
		// END: Kế hoạch

		// Nhân sự
		$aMenus['user'] = array(
			'name' => 'Thành viên',
			'link' => 'user.manager.list',
			'icon' => '<i class="fa fa-user-circle" aria-hidden="true"></i>',
			'child' => array(),
		);

		if(Phpfox::getUserParam('user.can_view_list_user')){
			$aMenus['user']['child'][] = array(
				'name' => 'Danh sách thành viên',
				'link' => 'user.manager.list',
			);
		}

		if(Phpfox::getUserParam('user.can_add_user')){
			$aMenus['user']['child'][] = array(
				'name' => 'Thêm thành viên mới',
				'link' => 'user.manager.add',
			);
		}

		$aMenus['user']['child'][] = array(
			'name' => 'Thiết lập tài khoản',
			'link' => 'user.setting',
		);
		// END: Nhân sự

		// khách hàng
		$aMenus['customer'] = array(
			'name' => 'Khách hàng',
			'link' => 'customer.manager.customer',
			'icon' => '<i class="fa fa-user-circle-o" aria-hidden="true"></i>',
			'child' => array(),
		);

		if(Phpfox::getUserParam('user.can_view_list_user')){
			$aMenus['customer']['child'][] = array(
				'name' => 'Danh sách khách hàng',
				'link' => 'user.manager.customer',
			);
		}

		if(Phpfox::getUserParam('user.can_add_user')){
			$aMenus['customer']['child'][] = array(
				'name' => 'Thêm khách hàng mới',
				'link' => 'user.manager.add.customer',
			);
		}
		// END: khách hàng

		$sLinkCurrent = '';
		$sReq1 = $this->request()->get('req1');
		if($sReq1){
			$sLinkCurrent .= '.' . $sReq1;
		}

		$sReq2 = $this->request()->get('req2');
		if($sReq2){
			$sLinkCurrent .= '.' . $sReq2;
		}

		$sReq3 = $this->request()->get('req3');
		if($sReq3){
			$sLinkCurrent .= '.' . $sReq3;
		}

		if($this->getParam('sActiveCurrentMenu')){
			$sLinkCurrent = $this->getParam('sActiveCurrentMenu');
		}

		$sLinkCurrent = trim($sLinkCurrent, '.');

		foreach ($aMenus as $key => $aMenu) {
			if($aMenu['link'] == $sLinkCurrent){
				$aMenus[$key]['active'] = true;
			}

			if(isset($aMenu['child']) && !empty($aMenu['child'])){
				foreach ($aMenu['child'] as $keyChild => $aChild) {
					if($aChild['link'] == $sLinkCurrent){
						$aMenus[$key]['active'] = true;
						$aMenus[$key]['child'][$keyChild]['active'] = true;
					}
				}
			}
		}

		$this->template()->assign(array(
			'aMenus' => $aMenus,
		));
	}
}