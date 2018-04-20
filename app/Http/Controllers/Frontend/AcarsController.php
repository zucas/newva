<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\AcarsRepository;
use App\Services\GeoService;
use Illuminate\Http\Request;

class AcarsController extends Controller
{
    private $acarsRepo, $geoSvc;

    /**
     * AcarsController constructor.
     * @param AcarsRepository $acarsRepo
     * @param GeoService $geoSvc
     */
    public function __construct(
        AcarsRepository $acarsRepo,
        GeoService $geoSvc
    ) {
        $this->acarsRepo = $acarsRepo;
        $this->geoSvc = $geoSvc;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pireps = $this->acarsRepo->getPositions();
        $positions = $this->geoSvc->getFeatureForLiveFlights($pireps);

        return $this->view('acars.index',[
            'pireps' => $pireps,
            'positions' => $positions,
        ]);
    }
}
