<?php

namespace Config;

use Admin\Filters\Admin_auth;
use App\Filters\Auth;
use App\Filters\ApiAuth;
use App\Filters\IPBlocker;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\SecurityHeaders;
use User\Filters\User_auth;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'            => CSRF::class,
        'toolbar'         => DebugToolbar::class,
        'honeypot'        => Honeypot::class,
        'invalidchars'    => InvalidChars::class,
        'secureheaders'   => SecureHeaders::class,
        'security_headers' => SecurityHeaders::class,
        'auth'            => Auth::class,
        'ipblocker'       => IPBlocker::class,
        'user_auth'       => User_auth::class,
        'admin_auth'      => Admin_auth::class,
        'api_auth'        => ApiAuth::class,
    ];

    public array $globals = [
        'before' => [
            'honeypot',
            'csrf' => [
                'except' => [
                    'user/add_funds/complete/*',
                    'api/*',
                    'invoice/*',
                    'get_total_notifiaction_count',
                    'get_user_notifications',
                ],
            ],
        ],
        'after' => [
            'toolbar',
            'honeypot',
            'security_headers',
        ],
    ];

    public array $methods = [];

    public array $filters = [];
}
