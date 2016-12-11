<form action="{url link='current'}" method="POST" id="js_form_manager_add">
	{error}
	<div class="row">
		<div class="col-sm-6">
			<div class="table">
				<div class="table_left">
					<label>Họ và tên{required}</label>
				</div>
				<div class="table_right">
					<div class="form-group has-feedback">
						<input type="text" name="val[full_name]" id="full_name" value="{value type='input' id='full_name'}" class="form-control" placeholder="Họ và Tên">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
				</div>			
			</div>
			
			<div class="table">
				<div class="table_left">
					<label>User Name{required}</label>
				</div>
				<div class="table_right">
					<div class="form-group has-feedback">
						<input type="text" name="val[user_name]" id="user_name" value="{value type='input' id='user_name'}" class="form-control" placeholder="Chọn Username" autocomplete="off">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
				</div>
			</div>
			
			<div class="table">
				<div class="table_left">
					<label>Email{required}</label>
				</div>
				<div class="table_right">
					<div class="form-group has-feedback">
						<input type="text" name="val[email]" id="email" value="{value type='input' id='email'}" class="form-control" placeholder="Email">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
				</div>			
			</div>
			
			{if !isset($bCustomer) || !$bCustomer}
				{if !$bEdit}
				<div class="table">
					<div class="table_left">
						<label>Mật khẩu{required}</label>
					</div>
					<div class="table_right">
						<div class="form-group has-feedback">
							<input type="password" class="form-control" name="val[password]" id="password" value="{value type='input' id='password'}" placeholder="Mật khẩu">
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						</div>
					</div>			
				</div>
				

				<div class="table">
					<div class="table_left">
						<label>Nhập lại mật khẩu{required}</label>
					</div>
					<div class="table_right">
						<div class="form-group has-feedback">
							<input type="password" class="form-control" name="val[re_password]" id="re_password" value="{value type='input' id='re_password'}" placeholder="Nhập lại mật khẩu">
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						</div>
					</div>			
				</div>
				{/if}

				
				<div class="table">
					<div class="table_left">
						<label for="user_contact">Thông tin liên hệ</label>
					</div>
					<div class="table_right">
						<textarea name="val[user_contact]" style="resize: vertical;" id="user_contact" cols="30" rows="3" class="form-control" placeholder="Địa chỉ: Số nhà, tên đường/làng, Xã, quận huyện, tỉnh thành">{value type='textarea' id='user_contact'}</textarea>
					</div>
					<div class="clear"></div>
				</div>

			{/if}
		</div>
		<div class="col-sm-6">
			<div class="table">
				<div class="table_left">
					<label>Số điện thoại{required}</label>
				</div>
				<div class="table_right">
					<div class="form-group has-feedback">
						<input type="tel" name="val[phone]" id="phone" value="{value type='input' id='phone'}" class="form-control" placeholder="Số điện thoại">
						<span class="glyphicon glyphicon-earphone form-control-feedback"></span>
					</div>
				</div>			
			</div>

			<div class="table">
				<div class="table_left">
					<label>Giới tính{required}</label>
				</div>
				<div class="table_right">
					{select_gender}
				</div>			
			</div>
			
			{if !isset($bCustomer) || !$bCustomer}
			<div class="table">
				<div class="table_left">
					<label>{phrase var='user.birthday'}</label>
				</div>
				<div class="table_right">						
					{select_date start_year=$sDobStart end_year=$sDobEnd field_separator=' / ' field_order='DMY' bUseDatepicker=false sort_years='DESC'}
				</div>			
			</div>
			
			<div class="row">
				<div class="col-sm-6">
					<div class="table">
						<div class="table_left">
							<label>Nhóm{required}</label>
						</div>
						<div class="table_right">{select_user_group_id}</div>			
					</div>
				</div>
				<div class="col-sm-6">
					<div class="table">
						<div class="table_left">
							<label for="user_position">Chức vụ</label>
						</div>
						<div class="table_right">
							<input type="text" class="form-control" name="val[user_position]" id="user_position" value="{value type='input' id='user_position'}" placeholder="Nhập chức vụ">
						</div>			
					</div>
				</div>
			</div>
			
			<div class="table">
				<div class="table_left">
					<label for="view_id">Trạng thái{required}</label>
				</div>
				<div class="table_right">{select_user_view_id}</div>
				<div class="clear"></div>
			</div>

			<div class="table">
				<div class="table_left">
					<label for="job_description">Mô tả công việc</label>
				</div>
				<div class="table_right">
					<textarea name="val[job_description]" style="resize: vertical;" id="job_description" cols="30" rows="3" class="form-control" placeholder="Mô tả công việc">{value type='textarea' id='job_description'}</textarea>
				</div>
				<div class="clear"></div>
			</div>
			{else}
			<div class="table">
				<div class="table_left">
					<label for="user_contact">Thông tin liên hệ</label>
				</div>
				<div class="table_right">
					<textarea name="val[user_contact]" style="resize: vertical;" id="user_contact" cols="30" rows="3" class="form-control" placeholder="Địa chỉ: Số nhà, tên đường/làng, Xã, quận huyện, tỉnh thành">{value type='textarea' id='user_contact'}</textarea>
				</div>
				<div class="clear"></div>
			</div>
			{/if}
		</div>
		<div class="col-sm-12">
			<div class="table_clear text-center">
				{if !$bEdit}
					<input type="submit" value="{if !isset($bCustomer) || !$bCustomer}Thêm nhân viên{else}Khách hàng{/if}" class="button btn btn-success "/>
				{else}
					<input type="submit" value="Cập nhật" class="button btn btn-success "/>
				{/if}
			</div>
		</div>
	</div>
</form>