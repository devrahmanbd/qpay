<?php

namespace Admin\Controllers;

use App\Libraries\ApiLogger;

class ApiAnalyticsController extends AdminController
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $logger = new ApiLogger();
        $period = $this->request->getGet('period') ?: '24h';
        $stats = $logger->getAdminStats($period);

        $db = db_connect();

        $merchants = [];
        if (!empty($stats['top_merchants'])) {
            $merchantIds = array_column($stats['top_merchants'], 'merchant_id');
            $users = $db->table('users')
                ->whereIn('id', $merchantIds)
                ->get()
                ->getResult();
            $userMap = [];
            foreach ($users as $u) {
                $userMap[$u->id] = $u;
            }
            foreach ($stats['top_merchants'] as $m) {
                $user = $userMap[$m->merchant_id] ?? null;
                $merchants[] = [
                    'id' => $m->merchant_id,
                    'name' => $user ? ($user->first_name . ' ' . ($user->last_name ?? '')) : 'Unknown',
                    'email' => $user->email ?? '',
                    'requests' => $m->request_count,
                ];
            }
        }

        $recentLogs = $db->table('api_logs')
            ->orderBy('created_at', 'DESC')
            ->limit(30)
            ->get()
            ->getResult();

        $this->data = [
            'stats' => $stats,
            'merchants' => $merchants,
            'recentLogs' => $recentLogs,
            'period' => $period,
        ];

        $this->template->view('api/index', $this->data)->render();
    }
}
