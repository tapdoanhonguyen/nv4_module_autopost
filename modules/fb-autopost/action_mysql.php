<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2017 mynukeviet. All rights reserved
 * @Createdate Sun, 12 Mar 2017 10:10:55 GMT
 */
if (! defined('NV_IS_FILE_MODULES'))
    die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data;

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  subject varchar(255) NOT NULL,
  message text NOT NULL,
  image varchar(255) NOT NULL,
  link text NOT NULL,
  description TEXT NOT NULL,
  addtime int(11) unsigned NOT NULL,
  queuetime INT(11) UNSIGNED NOT NULL DEFAULT '0',
  posttime INT(11) UNSIGNED NOT NULL DEFAULT '0',
  status tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$data = array();
$data['appid'] = '';
$data['secret'] = '';
$data['accesstoken'] = '';
$data['pagetoken'] = '';
$data['groupid'] = '';
$data['cronjobs'] = 1;
$data['remove'] = 0;

foreach ($data as $config_name => $config_value) {
    $sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', " . $db->quote($module_name) . ", " . $db->quote($config_name) . ", " . $db->quote($config_value) . ")";
}