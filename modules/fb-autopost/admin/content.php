<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2017 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 12 Mar 2017 09:48:41 GMT
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);

if ($row['id'] > 0) {
    $lang_module['content_add'] = $lang_module['content_edit'];
    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
    $row['hour'] = $row['minute'] = 0;
    if (!empty($row['queuetime'])) {
        $row['hour'] = nv_date('H', $row['queuetime']);
        $row['minute'] = nv_date('i', $row['queuetime']);
    }
} else {
    $row['id'] = 0;
    $row['subject'] = '';
    $row['message'] = '';
    $row['image'] = '';
    $row['link'] = '';
    $row['addtime'] = 0;
    $row['queuetime'] = 0;
    $row['hour'] = 0;
    $row['minute'] = 0;
    $row['description'] = '';
}

if ($nv_Request->isset_request('submit', 'post')) {
    $row['subject'] = $nv_Request->get_title('subject', 'post', '');
    $row['message'] = $nv_Request->get_textarea('message', 'post', 'br');
    $row['image'] = $nv_Request->get_title('image', 'post', '');
    $row['description'] = $nv_Request->get_textarea('description', 'post', 'br');

    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('queuetime', 'post'), $m)) {
        $hour = $nv_Request->get_int('hour', 'post', 0);
        $min = $nv_Request->get_int('minute', 'post', 0);
        $row['queuetime'] = mktime($hour, $min, 59, $m[2], $m[1], $m[3]);
    } else {
        $row['queuetime'] = 0;
    }

    if (is_file(NV_DOCUMENT_ROOT . $row['image'])) {
        $row['image'] = substr($row['image'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/'));
    } else {
        $row['image'] = '';
    }
    $row['link'] = $nv_Request->get_title('link', 'post', '');

    if (empty($row['link'])) {
        $error[] = $lang_module['error_required_link'];
    }

    if (empty($error)) {
        try {
            $newid = 0;
            if (empty($row['id'])) {
                $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (subject, message, image, link, description, addtime, queuetime) VALUES (:subject, :message, :image, :link, :description, ' . NV_CURRENTTIME . ', :queuetime)';
                $data_insert = array();
                $data_insert['subject'] = $row['subject'];
                $data_insert['message'] = $row['message'];
                $data_insert['image'] = $row['image'];
                $data_insert['link'] = $row['link'];
                $data_insert['description'] = $row['description'];
                $data_insert['queuetime'] = $row['queuetime'];
                $newid = $db->insert_id($_sql, 'id', $data_insert);
            } else {
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET subject = :subject, message = :message, image = :image, link = :link, description = :description, queuetime = :queuetime WHERE id=' . $row['id']);
                $stmt->bindParam(':subject', $row['subject'], PDO::PARAM_STR);
                $stmt->bindParam(':message', $row['message'], PDO::PARAM_STR, strlen($row['message']));
                $stmt->bindParam(':image', $row['image'], PDO::PARAM_STR);
                $stmt->bindParam(':link', $row['link'], PDO::PARAM_STR, strlen($row['link']));
                $stmt->bindParam(':description', $row['description'], PDO::PARAM_STR, strlen($row['description']));
                $stmt->bindParam(':queuetime', $row['queuetime'], PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $newid = $row['id'];
                }
            }

            if ($newid > 0) {

                // đăng tin tức thời
                if (empty($row['id']) && $array_config['cronjobs'] == 2) {
                    nv_post_facebook($newid, $row['link'], $row['subject'], $row['message'], $row['description'], $row['image']);
                }

                $nv_Cache->delMod($module_name);
                Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
                die();
            }
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
        }
    }
}

$current_path = NV_UPLOADS_DIR;
if (!empty($row['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $row['image'])) {
    $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $row['image'];
    $current_path = dirname($row['image']);
}
$row['description'] = nv_br2nl($row['description']);
$row['queuetime'] = !empty($row['queuetime']) ? nv_date('d/m/Y', $row['queuetime']) : '';

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('CURRENT_PATH', $current_path);

if ($array_config['cronjobs'] == 1) {
    for ($i = 0; $i <= 23; $i++) {
        $sl = $i == $row['hour'] ? 'selected="selected"' : '';
        $xtpl->assign('HOUR', array(
            'index' => $i,
            'selected' => $sl
        ));
        $xtpl->parse('main.queuetime.hour');
    }

    for ($i = 0; $i <= 59; $i++) {
        $sl = $i == $row['minute'] ? 'selected="selected"' : '';
        $xtpl->assign('MINUTE', array(
            'index' => $i,
            'selected' => $sl
        ));
        $xtpl->parse('main.queuetime.minute');
    }
    $xtpl->parse('main.queuetime');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['content_add'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';