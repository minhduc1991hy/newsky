<div class="table">
	<div class="table_left">
		<label>{if isset($sTitle) && !empty($sTitle)}{$sTitle}{else}Phào chân tường{/if}{if $bRequired}{required}{/if}</label>
		<span class="label label-danger">
			<a href="{url link='manager.plan.skirting.add'}" target="_blank" style="color: #fff; display: inline-block;">Thêm mới</a>
		</span>
	</div>
	<div class="table_right">
		<select name="val[skirting_id]" id="skirting_id" class="form-control">
			<option value="">Chọn:</option>
			{if isset($aRows) && !empty($aRows)}
				{foreach from=$aRows key=iKey item=aRow}
					<option value="{$aRow.skirting_id}" {value type='select' id='skirting_id' default=''.$aRow.skirting_id.''}>
						{$aRow.code}
					</option>
				{/foreach}
			{/if}
		</select>
	</div>
	<div class="clear"></div>
</div>