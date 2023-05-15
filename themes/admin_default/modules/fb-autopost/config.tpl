<!-- BEGIN: main -->
<form action="" method="post" class="form-horizontal">
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_system}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.config_appid}</strong></label>
				<div class="col-sm-21">
					<input type="text" name="appid" class="form-control" value="{DATA.appid}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.config_secret}</strong></label>
				<div class="col-sm-21">
					<input type="text" name="secret" class="form-control" value="{DATA.secret}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.config_accesstoken}</strong></label>
				<div class="col-sm-21">
					<input type="text" name="accesstoken" class="form-control" value="{DATA.accesstoken}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right"><strong>{LANG.config_cronjobs}</strong></label>
				<div class="col-sm-21">
                    <!-- BEGIN: type -->
					<label data-toggle="tooltip" data-original-title="{TYPE.value.note}"><input type="radio" name="cronjobs" class="form-control" value="{TYPE.index}" {TYPE.checked} />{TYPE.value.title}</label>&nbsp;&nbsp;&nbsp;
                    <!-- END: type -->
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right"><strong>{LANG.config_remove}</strong></label>
				<div class="col-sm-21">
					<label><input type="checkbox" name="remove" class="form-control" value="1" {DATA.ck_remove} />{LANG.config_remove_note}</label>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_page}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.config_pagetoken}</strong></label>
				<div class="col-sm-21">
					<div id="config_page">
						<!-- BEGIN: pagetoken -->
						<div class="row m-bottom">
							<div class="col-xs-8">
								<input type="text" name="pagetoken[{PAGE.index}][title]" class="form-control" value="{PAGE.title}" />
							</div>
							<div class="col-xs-15">
								<input type="text" name="pagetoken[{PAGE.index}][token]" class="form-control" value="{PAGE.token}" />
							</div>
							<div class="col-xs-1 text-middle">
								<input type="checkbox" name="pagetoken[{PAGE.index}][active]" class="form-control" value="1" {PAGE.checked} />
							</div>
						</div>
						<!-- END: pagetoken -->
					</div>
					<button class="btn btn-success btn-xs" onclick="nv_config_pages_add(); return !1;">{LANG.config_page_add}</button>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_group}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.config_groupid}</strong></label>
				<div class="col-sm-21">
					<div id="config_group">
						<!-- BEGIN: groupid -->
						<div class="row m-bottom">
							<div class="col-xs-8">
								<input type="text" name="groupid[{GROUP.index}][title]" class="form-control" value="{GROUP.title}" />
							</div>
							<div class="col-xs-15">
								<input type="text" name="groupid[{GROUP.index}][gid]" class="form-control" value="{GROUP.gid}" />
							</div>
							<div class="col-xs-1 text-middle">
								<input type="checkbox" name="groupid[{GROUP.index}][active]" class="form-control" value="1" {GROUP.checked} />
							</div>
						</div>
						<!-- END: groupid -->
					</div>
					<button class="btn btn-success btn-xs" onclick="nv_config_groups_add(); return !1;">{LANG.config_group_add}</button>
				</div>
			</div>
		</div>
	</div>

	<div class="text-center">
		<input type="submit" class="btn btn-primary" value="{LANG.save}" name="savesetting" />
	</div>
</form>
<script>
	var page_count = {PAGE_COUNT};
	function nv_config_pages_add()
	{
		var html = '';
		html += '<div class="row m-bottom">';
		html += '	<div class="col-xs-8">';
		html += '		<input type="text" name="pagetoken[' + page_count + '][title]" class="form-control" />';
		html += '	</div>';
		html += '	<div class="col-xs-15">';
		html += '		<input type="text" name="pagetoken[' + page_count + '][token]" class="form-control" />';
		html += '	</div>';
		html += '	<div class="col-xs-1 text-middle">';
		html += '		<input type="checkbox" name="pagetoken[' + page_count + '][active]" class="form-control" value="1" checked="checked" />';
		html += '	</div>';
		html += '</div>';
		page_count++;
		$('#config_page').append(html);
	}
	
	var group_count = {GROUP_COUNT};
	function nv_config_groups_add()
	{
		var html = '';
		html += '<div class="row m-bottom">';
		html += '	<div class="col-xs-8">';
		html += '		<input type="text" name="groupid[' + group_count + '][title]" class="form-control" />';
		html += '	</div>';
		html += '	<div class="col-xs-15">';
		html += '		<input type="text" name="groupid[' + group_count + '][gid]" class="form-control" />';
		html += '	</div>';
		html += '	<div class="col-xs-1 text-middle">';
		html += '		<input type="checkbox" name="groupid[' + group_count + '][active]" class="form-control" value="1" checked="checked" />';
		html += '	</div>';
		html += '</div>';
		group_count++;
		$('#config_group').append(html);
	}
</script>
<!-- END: main -->