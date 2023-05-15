<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.com)
 * @Copyright (C) 2017 mynukeviet. All rights reserved
 * @Createdate Sun, 12 Mar 2017 09:31:45 GMT
 */
if (! defined('NV_MAINFILE'))
    die('Stop!!!');

$module_version = array(
    'name' => 'Fb-autopost',
    'modfuncs' => 'main,cronjobs',
    'change_alias' => 'main',
    'submenu' => 'main',
    'is_sysmod' => 0,
    'virtual' => 0,
    'version' => '1.0.01',
    'date' => 'Sun, 12 Mar 2017 09:31:45 GMT',
    'author' => 'mynukeviet (contact@mynukeviet.com)',
    'uploads_dir' => array(
        $module_name
    ),
    'note' => ''
);