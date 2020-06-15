<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommercialRoomRequest;
use App\Models\CommercialRoom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CommercialRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return CommercialRoom::with('schedules')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommercialRoomRequest $request
     * @return JsonResponse
     */
    public function store(CommercialRoomRequest $request)
    {
        DB::beginTransaction();
        try {
            $commercialRoom = CommercialRoom::create($request->all());
            DB::commit();
            return response()->json($commercialRoom, 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            return response()->json(CommercialRoom::with('schedules')->findOrFail($id), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json($e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommercialRoomRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CommercialRoomRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $commercialRoom = CommercialRoom::findOrFail($id);
            $commercialRoom->fill($request->all())->save();
            DB::commit();
            return response()->json($commercialRoom, 200);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 404);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $commercialRoom = CommercialRoom::findOrFail($id);
            $commercialRoom->delete();
            return response()->json('success', 204);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 404);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }
}
