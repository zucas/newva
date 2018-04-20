<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateAirlineRequest;
use App\Http\Requests\UpdateAirlineRequest;
use App\Repositories\AirlineRepository;
use App\Support\Countries;
use Flash;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AirlinesController extends BaseController
{
    /** @var  AirlineRepository */
    private $airlineRepo;

    /**
     * AirlinesController constructor.
     * @param AirlineRepository $airlinesRepo
     */
    public function __construct(
        AirlineRepository $airlinesRepo
    ) {
        $this->airlineRepo = $airlinesRepo;
    }

    /**
     * Display a listing of the Airlines.
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $this->airlineRepo->pushCriteria(new RequestCriteria($request));
        $airlines = $this->airlineRepo->all();

        return view('admin.airlines.index')
            ->with('airlines', $airlines);
    }

    /**
     * Show the form for creating a new Airlines.
     */
    public function create()
    {
        return view('admin.airlines.create', [
            'countries' => Countries::getSelectList(),
        ]);
    }

    /**
     * Store a newly created Airlines in storage.
     */
    public function store(CreateAirlineRequest $request)
    {
        $input = $request->all();
        $airlines = $this->airlineRepo->create($input);

        Flash::success('Airlines saved successfully.');
        return redirect(route('admin.airlines.index'));
    }

    /**
     * Display the specified Airlines.
     * @param  int $id
     * @return mixed
     */
    public function show($id)
    {
        $airlines = $this->airlineRepo->findWithoutFail($id);

        if (empty($airlines)) {
            Flash::error('Airlines not found');
            return redirect(route('admin.airlines.index'));
        }

        return view('admin.airlines.show', [
            'airlines' => $airlines,
        ]);
    }

    /**
     * Show the form for editing the specified Airlines.
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $airline = $this->airlineRepo->findWithoutFail($id);

        if (empty($airline)) {
            Flash::error('Airline not found');
            return redirect(route('admin.airlines.index'));
        }

        return view('admin.airlines.edit', [
            'airline' => $airline,
            'countries' => Countries::getSelectList(),
        ]);
    }

    /**
     * Update the specified Airlines in storage.
     * @param  int $id
     * @param UpdateAirlineRequest $request
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateAirlineRequest $request)
    {
        $airlines = $this->airlineRepo->findWithoutFail($id);

        if (empty($airlines)) {
            Flash::error('Airlines not found');
            return redirect(route('admin.airlines.index'));
        }

        $airlines = $this->airlineRepo->update($request->all(), $id);

        Flash::success('Airlines updated successfully.');

        return redirect(route('admin.airlines.index'));
    }

    /**
     * Remove the specified Airlines from storage.
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $airlines = $this->airlineRepo->findWithoutFail($id);

        if (empty($airlines)) {
            Flash::error('Airlines not found');
            return redirect(route('admin.airlines.index'));
        }

        $this->airlineRepo->delete($id);

        Flash::success('Airlines deleted successfully.');
        return redirect(route('admin.airlines.index'));
    }
}
