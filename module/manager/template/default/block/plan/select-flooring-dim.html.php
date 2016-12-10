<div class="table">
	<div class="table_left">
		<label>{if isset($sTitle) && !empty($sTitle)}{$sTitle}{else}Kích thước{/if}{if $bRequired}{required}{/if}</label>
		<span class="label label-danger">
			<a href="{url link='manager.plan.flooring-dim.add'}" target="_blank" style="color: #fff; display: inline-block;">Thêm mới</a>
		</span>
	</div>
	<div class="table_right">
		<select name="val[flooringdim_id]" id="flooringdim_id" class="form-control">
			<option value="">Chọn:</option>
			{if isset($aItemRows) && !empty($aItemRows)}
				{foreach from=$aItemRows key=iKey item=aItemRow}
					<option value="{$aItemRow.flooringdim_id}" {value type='select' id='flooringdim_id' default=''.$aItemRow.flooringdim_id.''}>
						{$aItemRow.code}
						({$aItemRow.width} x {$aItemRow.length} x {$aItemRow.thickness})
					</option>
				{/foreach}
			{/if}
		</select>
	</div>
	<div class="clear"></div>
</div>