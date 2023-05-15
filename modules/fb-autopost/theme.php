<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.com)
 * @Copyright (C) 2017 mynukeviet. All rights reserved
 * @Createdate Sun, 12 Mar 2017 09:31:45 GMT
 */
if (! defined('NV_IS_MOD_FB_AUTOPOST'))
    die('Stop!!!');

/**
 * nv_theme_fb_autopost_main()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_fb_autopost_main($array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;
    
    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}