<!-- BEGIN: main -->

<!-- BEGIN: warning -->
<div class="alert alert-warning">{LANG.warning}</div>
<!-- END: warning -->

<form class="form-inline m-bottom">
    <select class="form-control" id="action_top">
        <!-- BEGIN: action_top -->
        <option value="{ACTION.key}">{ACTION.value}</option>
        <!-- END: action_top -->
    </select>
    <button class="btn btn-primary" onclick="nv_list_action( $('#action_top').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">{LANG.perform}</button>
    <a href="{URL_ADD}" class="btn btn-primary">{LANG.content_add}</a>
</form>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center w50"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);"></th>
					<th>{LANG.subject}</th>
					<th>{LANG.link}</th>
					<th class="w150">{LANG.addtime}</th>
					<th class="w200">{LANG.status}</th>
					<th class="w150">&nbsp;</th>
				</tr>
			</thead>
			<!-- BEGIN: generate_page -->
			<tfoot>
				<tr>
					<td class="text-center" colspan="7">{NV_GENERATE_PAGE}</td>
				</tr>
			</tfoot>
			<!-- END: generate_page -->
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td class="text-center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{VIEW.id}" name="idcheck[]" class="post"></td>
					<td>
                        <strong class="show">{VIEW.subject}</strong>
                        {VIEW.description}
                    </td>
					<td><a href="{VIEW.link}" target="_blank">{VIEW.link}</a></td>
					<td>{VIEW.addtime}</td>
					<td id="row_{VIEW.id}">{VIEW.status_f}<!-- BEGIN: posttime --> - {VIEW.posttime}<!-- END: posttime --></td>
					<td class="text-center">
						<!-- BEGIN: post -->
						<a href="javascript:void(0);" class="btn btn-default btn-xs btn-post-{VIEW.id}" onclick="nv_fb_post({VIEW.id}, '{LANG.post_confirm}'); return !1;" data-toggle="tooltip" data-original-title="{LANG.post}"><i class="fa fa-arrow-circle-up"></i></a>
						<!-- END: post -->
                        <!-- BEGIN: refresh -->
                        <a href="javascript:void(0);" class="btn btn-default btn-xs btn-post-{VIEW.id}" onclick="nv_fb_post({VIEW.id}, '{LANG.post_confirm}'); return !1;" data-toggle="tooltip" data-original-title="{LANG.refresh}"><i class="fa fa-refresh"></i></a>
                        <!-- END: refresh -->
						<a href="{VIEW.link_edit}" data-toggle="tooltip" data-original-title="{LANG.edit}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
						<a href="{VIEW.link_delete}" class="btn btn-default btn-xs" onclick="return confirm(nv_is_del_confirm[0]);" data-toggle="tooltip" data-original-title="{LANG.delete}"><em class="fa fa-trash-o"></em></a>
					</td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<form class="form-inline m-bottom">
    <select class="form-control" id="action_bottom">
        <!-- BEGIN: action_bottom -->
        <option value="{ACTION.key}">{ACTION.value}</option>
        <!-- END: action_bottom -->
    </select>
    <button class="btn btn-primary" onclick="nv_list_action( $('#action_bottom').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">{LANG.perform}</button>
</form>
<!-- END: main -->