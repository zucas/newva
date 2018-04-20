<?php

namespace App\Widgets;

use App\Repositories\PirepRepository;

/**
 * Show the latest PIREPs in a view
 * @package App\Widgets
 */
class LatestPireps extends BaseWidget
{
    protected $config = [
        'count' => 5,
    ];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function run()
    {
        $pirepRepo = app(PirepRepository::class);

        return $this->view('widgets.latest_pireps', [
            'config' => $this->config,
            'pireps' => $pirepRepo->recent($this->config['count']),
        ]);
    }
}
