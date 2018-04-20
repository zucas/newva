<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSubfleetRequest;
use App\Http\Requests\UpdateSubfleetRequest;
use App\Models\Airline;
use App\Models\Enums\FuelType;
use App\Models\Subfleet;
use App\Repositories\AircraftRepository;
use App\Repositories\FareRepository;
use App\Repositories\RankRepository;
use App\Repositories\SubfleetRepository;
use App\Services\FareService;
use Flash;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SubfleetController extends BaseController
{
    /** @var  SubfleetRepository */
    private $aircraftRepo, $rankRepo, $subfleetRepo, $fareRepo, $fareSvc;

    /**
     * SubfleetController constructor.
     * @param AircraftRepository $aircraftRepo
     * @param SubfleetRepository $subfleetRepo
     * @param FareRepository $fareRepo
     * @param FareService $fareSvc
     */
    public function __construct(
        AircraftRepository $aircraftRepo,
        RankRepository $rankRepo,
        SubfleetRepository $subfleetRepo,
        FareRepository $fareRepo,
        FareService $fareSvc
    ) {
        $this->aircraftRepo = $aircraftRepo;
        $this->rankRepo = $rankRepo;
        $this->subfleetRepo = $subfleetRepo;
        $this->fareRepo = $fareRepo;
        $this->fareSvc = $fareSvc;
    }

    /**
     * Get the ranks that are available to the subfleet
     * @param $subfleet
     * @return array
     */
    protected function getAvailRanks($subfleet)
    {
        $retval = [];
        $all_ranks = $this->rankRepo->all();
        $avail_ranks = $all_ranks->except($subfleet->ranks->modelKeys());
        foreach ($avail_ranks as $rank) {
            $retval[$rank->id] = $rank->name;
        }

        return $retval;
    }

    /**
     * Get all the fares that haven't been assigned to a given subfleet
     */
    protected function getAvailFares($subfleet)
    {
        $retval = [];
        $all_fares = $this->fareRepo->all();
        $avail_fares = $all_fares->except($subfleet->fares->modelKeys());
        foreach ($avail_fares as $fare) {
            $retval[$fare->id] = $fare->name.
                ' (price: '.$fare->price.
                ', cost: '.$fare->cost.
                ', capacity: '.$fare->capacity.')';
        }

        return $retval;
    }

    /**
     * Display a listing of the Subfleet.
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $this->subfleetRepo->pushCriteria(new RequestCriteria($request));
        $subfleets = $this->subfleetRepo->all();

        return view('admin.subfleets.index', [
            'subfleets' => $subfleets,
        ]);
    }

    /**
     * Show the form for creating a new Subfleet.
     * @return Response
     */
    public function create()
    {
        return view('admin.subfleets.create', [
            'airlines' => Airline::all()->pluck('name', 'id'),
            'fuel_types' => FuelType::labels(),
        ]);
    }

    /**
     * Store a newly created Subfleet in storage.
     * @param CreateSubfleetRequest $request
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateSubfleetRequest $request)
    {
        $input = $request->all();
        $subfleet = $this->subfleetRepo->create($input);

        Flash::success('Subfleet saved successfully.');
        return redirect(route('admin.subfleets.edit', ['id' => $subfleet->id]));
    }

    /**
     * Display the specified Subfleet.
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $subfleet = $this->subfleetRepo->findWithoutFail($id);

        if (empty($subfleet)) {
            Flash::error('Subfleet not found');
            return redirect(route('admin.subfleets.index'));
        }

        $avail_fares = $this->getAvailFares($subfleet);
        return view('admin.subfleets.show', [
            'subfleet' => $subfleet,
            'avail_fares' => $avail_fares,
        ]);
    }

    /**
     * Show the form for editing the specified Subfleet.
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $subfleet = $this->subfleetRepo->findWithoutFail($id);

        if (empty($subfleet)) {
            Flash::error('Subfleet not found');
            return redirect(route('admin.subfleets.index'));
        }

        $avail_fares = $this->getAvailFares($subfleet);
        $avail_ranks = $this->getAvailRanks($subfleet);

        return view('admin.subfleets.edit', [
            'airlines' => Airline::all()->pluck('name', 'id'),
            'fuel_types'    => FuelType::labels(),
            'avail_fares'   => $avail_fares,
            'avail_ranks'   => $avail_ranks,
            'subfleet'      => $subfleet,
        ]);
    }

    /**
     * Update the specified Subfleet in storage.
     * @param  int $id
     * @param UpdateSubfleetRequest $request
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateSubfleetRequest $request)
    {
        $subfleet = $this->subfleetRepo->findWithoutFail($id);

        if (empty($subfleet)) {
            Flash::error('Subfleet not found');
            return redirect(route('admin.subfleets.index'));
        }

        $this->subfleetRepo->update($request->all(), $id);

        Flash::success('Subfleet updated successfully.');
        return redirect(route('admin.subfleets.index'));
    }

    /**
     * Remove the specified Subfleet from storage.
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $subfleet = $this->subfleetRepo->findWithoutFail($id);

        if (empty($subfleet)) {
            Flash::error('Subfleet not found');
            return redirect(route('admin.subfleets.index'));
        }

        # Make sure no aircraft are assigned to this subfleet
        # before trying to delete it, or else things might go boom
        $aircraft = $this->aircraftRepo->findWhere(['subfleet_id' => $id], ['id']);
        if($aircraft->count() > 0) {
            Flash::error('There are aircraft still assigned to this subfleet, you can\'t delete it!')->important();
            return redirect(route('admin.subfleets.index'));
        }

        $this->subfleetRepo->delete($id);

        Flash::success('Subfleet deleted successfully.');
        return redirect(route('admin.subfleets.index'));
    }

    /**
     * @param Subfleet $subfleet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function return_ranks_view(Subfleet $subfleet)
    {
        $subfleet->refresh();

        $avail_ranks = $this->getAvailRanks($subfleet);

        return view('admin.subfleets.ranks', [
            'subfleet' => $subfleet,
            'avail_ranks' => $avail_ranks,
        ]);
    }

    /**
     * @param Subfleet $subfleet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function return_fares_view(Subfleet $subfleet)
    {
        $subfleet->refresh();

        $avail_fares = $this->getAvailFares($subfleet);

        return view('admin.subfleets.fares', [
            'subfleet'    => $subfleet,
            'avail_fares' => $avail_fares,
        ]);
    }

    /**
     * Operations for associating ranks to the subfleet
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ranks($id, Request $request)
    {
        $subfleet = $this->subfleetRepo->findWithoutFail($id);
        if (empty($subfleet)) {
            return $this->return_ranks_view($subfleet);
        }

        if ($request->isMethod('get')) {
            return $this->return_ranks_view($subfleet);
        }

        /**
         * update specific rank data
         */
        if ($request->isMethod('post')) {
            $subfleet->ranks()->syncWithoutDetaching([$request->input('rank_id')]);
        }

        // dissassociate fare from teh aircraft
        elseif ($request->isMethod('delete')) {
            $subfleet->ranks()->detach($request->input('rank_id'));
        }

        $subfleet->save();
        return $this->return_ranks_view($subfleet);
    }

    /**
     * Operations on fares to the subfleet
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fares($id, Request $request)
    {
        $subfleet = $this->subfleetRepo->findWithoutFail($id);
        if (empty($subfleet)) {
            return $this->return_fares_view($subfleet);
            //return view('admin.aircraft.fares', ['fares' => []]);
        }

        if ($request->isMethod('get')) {
            return $this->return_fares_view($subfleet);
        }

        /**
         * update specific fare data
         */
        if ($request->isMethod('post')) {
            $fare = $this->fareRepo->findWithoutFail($request->fare_id);
            $this->fareSvc->setForSubfleet($subfleet, $fare);
        }

        // update the pivot table with overrides for the fares
        elseif ($request->isMethod('put')) {
            $override = [];
            $fare = $this->fareRepo->findWithoutFail($request->fare_id);
            $override[$request->name] = $request->value;
            $this->fareSvc->setForSubfleet($subfleet, $fare, $override);
        }

        // dissassociate fare from teh aircraft
        elseif ($request->isMethod('delete')) {
            $fare = $this->fareRepo->findWithoutFail($request->fare_id);
            $this->fareSvc->delFareFromSubfleet($subfleet, $fare);
        }

        return $this->return_fares_view($subfleet);
    }
}
