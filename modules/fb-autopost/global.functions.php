<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.com)
 * @Copyright (C) 2017 mynukeviet. All rights reserved
 * @Createdate Sun, 12 Mar 2017 09:31:45 GMT
 */
if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$array_config = $module_config['fb-autopost'];

// nếu chưa autoload thì include thư viện
if (!class_exists('Facebook\Facebook')) {
    if (file_exists(NV_ROOTDIR . '/modules/fb-autopost/Facebook/autoload.php')) {
        include_once NV_ROOTDIR . '/modules/fb-autopost/Facebook/autoload.php';
    }
}

if (isset($site_mods['fb-autopost'])) {
    define('NV_FBPOST_GLOBAL', true);
}

function nv_post_facebook($id, $link, $name = '', $message = '', $description = '', $image = '')
{
    global $db, $array_config;

    if (!class_exists('Facebook\Facebook') or empty($array_config['appid']) or empty($array_config['secret']) or empty($array_config['accesstoken']) or (empty($array_config['pagetoken']) and empty($array_config['groupid']))) {
        return false;
    }

    $fb = new Facebook\Facebook([
        'app_id' => $array_config['appid'],
        'app_secret' => $array_config['secret']
    ]);

    if (!empty($image) and file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $image)) {
        $image = NV_MY_DOMAIN . NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $image;
    } else {
        $image = '';
    }
    $message = strip_tags(nv_unhtmlspecialchars(html_entity_decode($message)), 'br');

    $linkData = [
        'link' => $link,
        'message' => html_entity_decode($message),
        'name' => $name,
        'description' => $description,
        'picture' => $image
    ];

    if (!empty($array_config['pagetoken'])) {
        $array_config['pagetoken'] = unserialize($array_config['pagetoken']);

        // Cập nhật trạng thái Đang đăng
        $db->query('UPDATE ' . NV_PREFIXLANG . '_fb_autopost SET status=2 WHERE id=' . $id);

        foreach ($array_config['pagetoken'] as $page) {
            if ($page['active']) {
                try {
                    $response = $fb->post('/me/feed', $linkData, $page['token']);
                } catch (Facebook\Exceptions\FacebookResponseException $e) {
                    trigger_error($e->getMessage());
                    return false;
                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                    trigger_error($e->getMessage());
                    return false;
                }
            }
        }
    }

    if (!empty($array_config['groupid'])) {
        $array_config['groupid'] = unserialize($array_config['groupid']);
        foreach ($array_config['groupid'] as $group) {
            if ($group['active']) {
                try {
                    $response = $fb->post($group['gid'] . '/feed', $linkData, $array_config['accesstoken']);
                } catch (Facebook\Exceptions\FacebookResponseException $e) {
                    trigger_error($e->getMessage());
                    return false;
                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                    trigger_error($e->getMessage());
                    return false;
                }
            }
        }
    }

    if ($array_config['remove'] and !empty($id)) {
        // Xóa nếu đăng thành công
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $id);
        return true;
    }

    // Cập nhật trạng thái Đã đăng
    $db->query('UPDATE ' . NV_PREFIXLANG . '_fb_autopost SET status=1, posttime = ' . NV_CURRENTTIME . ' WHERE id=' . $id);

    return true;
}

function nv_add_fb_queue($link, $name = '', $message = '', $description = '', $image = '')
{
    global $db, $module_config;

    $array_config = $module_config['fb-autopost'];

    if (empty($array_config['appid']) or empty($array_config['secret']) or empty($array_config['accesstoken'])) {
        return false;
    }

    try {
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_fb_autopost(subject, message, image, link, description, addtime) VALUES(:subject, :message, :image, :link, :description, ' . NV_CURRENTTIME . ')';
        $data_insert = array();
        $data_insert['subject'] = $name;
        $data_insert['message'] = $message;
        $data_insert['image'] = $image;
        $data_insert['link'] = $link;
        $data_insert['description'] = $description;
        return $db->insert_id($_sql, 'id', $data_insert);
    } catch (Exception $e) {
        trigger_error($e->getMessage());
        return false;
    }
}