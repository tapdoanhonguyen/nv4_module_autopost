<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2016 mynukeviet. All rights reserved
 * @Createdate Sun, 20 Nov 2016 07:31:04 GMT
 */
if (!defined('NV_IS_MOD_FB_AUTOPOST')) die('Stop!!!');

if ($array_config['cronjobs'] != 1) {
    die();
}

if ($sys_info['allowed_set_time_limit']) {
    set_time_limit(0);
}

if (class_exists('Facebook\Facebook') and !empty($array_config['appid']) and !empty($array_config['secret']) and !empty($array_config['accesstoken'])) {
    $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE status=0 AND (queuetime=0 OR queuetime <= ' . NV_CURRENTTIME . ')');
    while ($row = $result->fetch()) {
        nv_post_facebook($row['id'], $row['link'], $row['subject'], $row['message'], $row['description'], $row['image']);
    }
}