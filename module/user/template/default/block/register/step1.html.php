	<div id="js_register_step1">
		{plugin call='user.template_default_block_register_step1_3'}
		{if Phpfox::getParam('user.split_full_name')}
		<div><input type="hidden" name="val[full_name]" id="full_name" value="stock" size="30" /></div>
		<div class="table">
			<div class="table_left">
				<label for="first_name">{required}{phrase var='user.first_name'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[first_name]" id="first_name" value="{value type='input' id='first_name'}" size="30" />
			</div>			
		</div>		
		<div class="table">
			<div class="table_left">
				<label for="last_name">{required}{phrase var='user.last_name'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[last_name]" id="last_name" value="{value type='input' id='last_name'}" size="30" />
			</div>			
		</div>		
		<div class="separate"></div>
		{else}
		<div class="form-group has-feedback">
			<input type="text" name="val[full_name]" id="full_name" value="{value type='input' id='full_name'}" class="form-control" placeholder="{phrase var='user.full_name'}">
			<span class="glyphicon glyphicon-user form-control-feedback"></span>
		</div>
		{/if}
		{if !Phpfox::getParam('user.profile_use_id') && !Phpfox::getParam('user.disable_username_on_sign_up')}
		<div class="form-group has-feedback">
			<input type="text" name="val[user_name]" id="user_name" value="{value type='input' id='user_name'}" class="form-control" placeholder="{phrase var='user.choose_a_username'}" autocomplete="off">
			<span class="glyphicon glyphicon-user form-control-feedback"></span>
		</div>
		{/if}
		{if Phpfox::getParam('user.reenter_email_on_signup')}
		<div class="separate"></div>
		{/if}

		<div class="form-group has-feedback">
			<input type="text" name="val[email]" id="email" value="{value type='input' id='email'}" class="form-control" placeholder="{phrase var='user.email'}">
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>

		<div class="form-group has-feedback">
			<input type="tel" name="val[phone]" id="phone" value="{value type='input' id='phone'}" class="form-control" placeholder="Số điện thoại">
			<span class="glyphicon glyphicon-earphone form-control-feedback"></span>
		</div>


		{if Phpfox::getParam('user.reenter_email_on_signup')}
		<div class="table">
			<div class="table_left"></div>
			<div class="table_right">
				<strong>{phrase var='user.please_reenter_your_email_again_below'}</strong>
				<div class="p_top_8">
					<input type="text" name="val[confirm_email]" id="confirm_email" value="{value type='input' id='confirm_email'}" size="30" onblur="$('#js_form').ajaxCall('user.confirmEmail');" />
				</div>
				<div id="js_confirm_email_error" style="display:none;"><div class="error_message">{phrase var='user.email_s_do_not_match'}</div></div>
			</div>			
		</div>				
		<div class="separate"></div>
		{/if}

		{plugin call='user.template_default_block_register_step1_5'}
		<div class="form-group has-feedback">
			<input type="password" class="form-control" name="val[password]" id="password" value="{value type='input' id='password'}" placeholder="{phrase var='user.password'}" />
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>

		<div class="form-group has-feedback">
			<input type="password" class="form-control" name="val[re_password]" id="re_password" value="{value type='input' id='re_password'}" placeholder="Nhập lại mật khẩu" />
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		{plugin call='user.template_default_block_register_step1_4'}
	</div>