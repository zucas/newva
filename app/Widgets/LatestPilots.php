<?php

namespace App\Widgets;

use App\Repositories\UserRepository;

/**
 * Show the latest pilots in a view
 * @package App\Widgets
 */
class LatestPilots extends BaseWidget
{
    protected $config = [
        'count' => 5,
    ];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function run()
    {
        $userRepo = app(UserRepository::class);

        return $this->view('widgets.latest_pilots', [
            'config' => $this->config,
            'users' => $userRepo->recent($this->config['count']),
        ]);
    }
}
