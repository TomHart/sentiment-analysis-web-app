<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Brain;
use Illuminate\Contracts\View\View;

/**
 * Class BrainController
 * @package App\Http\Controllers
 */
class BrainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.brains.index', [
            'brains' => $this->getUser()->brains()->with('results')->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Brain $brain
     * @return View
     */
    public function show(Brain $brain): View
    {
        return view('dashboard.brains.show', [
            'brain' => $brain
        ]);
    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return Response
//     */
//    public function create(): Response
//    {
//        //
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param Request $request
//     * @return Response
//     */
//    public function store(Request $request): Response
//    {
//        //
//    }
//
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param int $id
//     * @return void
//     */
//    public function edit($id): void
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param Request $request
//     * @param int $id
//     * @return Response
//     */
//    public function update(Request $request, $id): Response
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param int $id
//     * @return Response
//     */
//    public function destroy($id): Response
//    {
//        //
//    }
}
