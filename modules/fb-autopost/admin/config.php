<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$page_title = $lang_module['config'];

if ($nv_Request->isset_request('savesetting', 'post')) {
    $data['appid'] = $nv_Request->get_title('appid', 'post', 'đ');
    $data['secret'] = $nv_Request->get_title('secret', 'post', '');
    $data['accesstoken'] = $nv_Request->get_title('accesstoken', 'post', '');
    $data['cronjobs'] = $nv_Request->get_int('cronjobs', 'post', 1);
    $data['remove'] = $nv_Request->get_int('remove', 'post', 0);

    $data['pagetoken'] = $nv_Request->get_array('pagetoken', 'post');
    if (!empty($data['pagetoken'])) {
        foreach ($data['pagetoken'] as $index => $config) {
            if (empty($config['token'])) {
                unset($data['pagetoken'][$index]);
            }
        }
    }
    $data['pagetoken'] = !empty($data['pagetoken']) ? serialize($data['pagetoken']) : '';

    $data['groupid'] = $nv_Request->get_array('groupid', 'post');
    if (!empty($data['groupid'])) {
        foreach ($data['groupid'] as $index => $config) {
            if (empty($config['gid'])) {
                unset($data['groupid'][$index]);
            }
        }
    }
    $data['groupid'] = !empty($data['groupid']) ? serialize($data['groupid']) : '';

    $sth = $db->prepare("UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = '" . NV_LANG_DATA . "' AND module = :module_name AND config_name = :config_name");
    $sth->bindParam(':module_name', $module_name, PDO::PARAM_STR);
    foreach ($data as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['config'], "Config", $admin_info['userid']);
    $nv_Cache->delMod('settings');

    Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . '=' . $op);
    die();
}

$array_config['ck_remove'] = $array_config['remove'] ? 'checked="checked"' : '';

$xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('DATA', $array_config);

if (!empty($array_config['pagetoken'])) {
    $array_config['pagetoken'] = unserialize($array_config['pagetoken']);
} else {
    $array_config['pagetoken'][0] = array(
        'title' => '',
        'token' => ''
    );
}

foreach ($array_config['pagetoken'] as $index => $config) {
    $config['index'] = $index;
    $config['checked'] = (isset($config['active']) && intval($config['active'])) ? 'checked="checked"' : '';
    $xtpl->assign('PAGE', $config);
    $xtpl->parse('main.pagetoken');
}
$xtpl->assign('PAGE_COUNT', sizeof($array_config['pagetoken']));

if (!empty($array_config['groupid'])) {
    $array_config['groupid'] = unserialize($array_config['groupid']);
} else {
    $array_config['groupid'][0] = array(
        'title' => '',
        'gid' => ''
    );
}

foreach ($array_config['groupid'] as $index => $config) {
    $config['index'] = $index;
    $config['checked'] = (isset($config['active']) && intval($config['active'])) ? 'checked="checked"' : '';
    $xtpl->assign('GROUP', $config);
    $xtpl->parse('main.groupid');
}
$xtpl->assign('GROUP_COUNT', sizeof($array_config['groupid']));

$array_type = array(
    1 => array(
        'title' => $lang_module['config_type_1'],
        'note' => $lang_module['config_type_1_note']
    ),
    2 => array(
        'title' => $lang_module['config_type_2'],
        'note' => $lang_module['config_type_2_note']
    )
);
foreach ($array_type as $index => $value) {
    $sl = $index == $array_config['cronjobs'] ? 'checked="checked"' : '';
    $xtpl->assign('TYPE', array(
        'index' => $index,
        'value' => $value,
        'checked' => $sl
    ));
    $xtpl->parse('main.type');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';