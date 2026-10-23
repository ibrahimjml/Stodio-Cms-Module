<?php 

if (! defined('ACL_LOGIN_PIPELINE')) {
    define('ACL_LOGIN_PIPELINE', 'check_two_factor_acl_login_pipeline');
}

if (! defined('LOG_AUTH_ACTION_AFTER_LOGIN_SYSTEM')) {
    define('LOG_AUTH_ACTION_AFTER_LOGIN_SYSTEM', 'log_action_after_login_system');
}

if (! defined('LOG_AUTH_ACTION_AFTER_LOGOUT_SYSTEM')) {
    define('LOG_AUTH_ACTION_AFTER_LOGOUT_SYSTEM', 'log_action_after_logout_system');
}
