<div class="table">
	<div class="table_left">
		<label>{if isset($sTitle) && !empty($sTitle)}{$sTitle}{else}HDF{/if}{if $bRequired}{required}{/if}</label>
		<span class="label label-danger">
			<a href="{url link='manager.supplies.hdf.add'}" target="_blank" style="color: #fff; display: inline-block;">Thêm mới</a>
		</span>
	</div>
	<div class="table_right">
		<select name="val[hdf_id]" id="hdf_id" class="form-control">
			<option value="">Chọn:</option>
			{if isset($aItemRows) && !empty($aItemRows)}
				{foreach from=$aItemRows key=iKey item=aItemRow}
					<option value="{$aItemRow.hdf_id}" {value type='select' id='hdf_id' default=''.$aItemRow.hdf_id.''}>
						{$aItemRow.code}
						{if isset($aItemRow.description) && !empty($aItemRow.description)}
							({$aItemRow.description})
						{/if}
					</option>
				{/foreach}
			{/if}
		</select>
	</div>
	<div class="clear"></div>
</div>