/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.com)
 * @Copyright (C) 2017 mynukeviet. All rights reserved
 * @Createdate Sun, 12 Mar 2017 09:31:45 GMT
 */

function nv_list_action(action, url_action, del_confirm_no_post) {
	var listall = [];
	$('input.post:checked').each(function() {
		listall.push($(this).val());
	});

	if (listall.length < 1) {
		alert(del_confirm_no_post);
		return false;
	}

	if (action == 'delete_list_id') {
		if (confirm(nv_is_del_confirm[0])) {
			$.ajax({
				type : 'POST',
				url : url_action,
				data : 'delete_list=1&listall=' + listall,
				success : function(data) {
					var r_split = data.split('_');
					if (r_split[0] == 'OK') {
						window.location.href = window.location.href;
					} else {
						alert(nv_is_del_confirm[2]);
					}
				}
			});
		}
	}

	return false;
}

function nv_fb_post(id, lang_confirm) {
	if (confirm(lang_confirm)) {
		$.ajax({
			type : 'POST',
			url : script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main',
			data : 'fb_post=1&id=' + id,
			success : function(data) {
				var r_split = data.split('_');
				alert(r_split[1]);
				if (r_split[0] == 'OK') {
					$('#row_' + id).text(r_split[2]);
					$('.btn-post-' + id).hide();
				}
			}
		});
	}
}