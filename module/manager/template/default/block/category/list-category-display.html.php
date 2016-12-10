{if isset($aCategories) && !empty($aCategories)}
	<table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">STT</th>
                <th class="text-center">TIÊU ĐỀ</th>
                <th class="text-left">MÔ TẢ</th>
                {if Phpfox::getUserParam('user.can_edit_user')}
                    <th class="text-center" style="width: 80px;">THAO TÁC</th>
                {/if}
            </tr>
        </thead>
        <tbody>
        	{if $i = 0}{/if}
	        {foreach from=$aCategories key=iKey item=aCategory}
		        {if $i = $i+1}{/if}
		        <tr>
		            <td class="text-center">{$i}</td>
		            <td><strong>{$aCategory.title}</strong></td>
		            <td>{$aCategory.description}</td>
		            <td class="text-center"><a href="javascript:void(0);" onclick="$.ajaxCall('manager.category.getFormAddCategory', 'sTypeId={$sTypeId}&iProductId={$aCategory.product_id}'); $Core.showLoadding(); return false;"><i class="fa fa-pencil"></i></a></td>
		        </tr>
	        {/foreach}
        </tbody>
    </table>
{/if}