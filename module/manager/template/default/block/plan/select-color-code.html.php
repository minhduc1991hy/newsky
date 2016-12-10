<div class="table">
	<div class="table_left">
		<label>{if isset($sTitle) && !empty($sTitle)}{$sTitle}{else}Mã màu Newsky{/if}{if $bRequired}{required}{/if}</label>
		<span class="label label-danger">
			<a href="{url link='manager.plan.color-code.add'}" target="_blank" style="color: #fff; display: inline-block;">Thêm mới</a>
		</span>
	</div>
	<div class="table_right">
		<select name="val[color_id]" id="color_id" class="form-control">
			<option value="">Chọn:</option>
			{if isset($aColorSchemas) && !empty($aColorSchemas)}
				{foreach from=$aColorSchemas key=iKey item=aColorSchema}
					<option value="{$aColorSchema.color_id}" {value type='select' id='color_id' default=''.$aColorSchema.color_id.''}>
						{$aColorSchema.code}
						{if isset($aColorSchema.title) && !empty($aColorSchema.title)}
							({$aColorSchema.title})
						{/if}
					</option>
				{/foreach}
			{/if}
		</select>
	</div>
	<div class="clear"></div>
</div>