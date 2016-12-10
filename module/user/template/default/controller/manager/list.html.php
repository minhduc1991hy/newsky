<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
        {if isset($aUsers) && !empty($aUsers)}
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">STT</th>
                    <th class="text-center" style="width: 100px;">USER ID</th>
                    <th class="text-left">NỘI DUNG</th>
                    {if Phpfox::getUserParam('user.can_edit_user')}
                        <th class="text-center" style="width: 80px;">THAO TÁC</th>
                    {/if}
                </tr>
            </thead>
            <tbody>
                {foreach from=$aUsers key=iKey item=aUser}
                <tr>
                    <td class="text-center">{if $iNo = $iNo + 1}{$iNo}{/if}</td>
                    <td class="text-center">{$aUser.user_id}</td>
                    <td>
                        <div class="row">
                            <div class="col-md-6">
                                <div><strong>Họ và tên:</strong> {$aUser.full_name}</div>
                                <div><strong>Nhóm(Phòng ban):</strong> {$aUser.title_group}</div>
                                <div><strong>Chức danh:</strong> {$aUser.user_position}</div>
                                <div><strong>Tình trạng:</strong> {$aUser.html_text_view_id}</div>
                                <div><strong>Mô tả công việc:</strong> {$aUser.job_description}</div>
                            </div>
                            <div class="col-md-6">
                                <div><strong>User Name:</strong> {$aUser.user_name}</div>
                                <div><strong>Email:</strong> {$aUser.email}</div>
                                <div><strong>Số điện thoại:</strong> {$aUser.phone}</div>
                                <div><strong>Chi tiết liên hệ:</strong> {$aUser.user_contact}</div>
                            </div>
                        </div>
                    </td>
                    {if Phpfox::getUserParam('user.can_edit_user')}
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
                                {if Phpfox::getUserParam('user.can_edit_user')}
                                    <li><a href="{url link='user.manager.add' id=$aUser.user_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
                                {/if}
                            </ul>
                        </div>
                    </td>
                    {/if}
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            {no_item_message}
        {/if}
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix text-center">
        {pager}
    </div>
</div>
<!-- /.box -->