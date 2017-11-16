<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件




/**
 * 返回json数据
 */
function retData($msg = "", $type = 1, $is_end = true) {
    $json['code'] = $type;
    if (is_array($msg)) {
        foreach ($msg as $key => $v) {
            $json[$key] = $v;
        }
    } elseif (!empty($msg)) {
        $json['message'] = $msg;
    }
    if ($is_end) {
        echo json_encode($json);
        exit;
    } else {
        echo json_encode($json);
        exit;
    }
}

