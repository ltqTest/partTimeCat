<?php
/**
 * 辅助函数文件
 */
// 将当前请求的路由名称转换为 CSS 类名称，作用是允许我们针对某个页面做页面样式定制
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

// 如果 $condition 不为 True 即会返回字符串 `active`
function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}