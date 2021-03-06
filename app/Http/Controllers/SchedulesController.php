<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchedulesRequest;
use App\Models\Schedules;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return Schedules::with('client', 'commercialRoom')->paginate(10);
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
     * @param SchedulesRequest $request
     * @return JsonResponse
     */
    public function store(SchedulesRequest $request)
    {
        DB::beginTransaction();
        try {
            $checkDay = Schedules::where([
                ['schedule_date', $request->schedule_date],
                ['commercial_room_id', $request->commercial_room_id]
            ])->get();
            if (count($checkDay) > 0) {
                return response()->json(['message' => 'Sala já agendada nesse dia'], 201);
            } else {
                $schedule = Schedules::create($request->all());
                DB::commit();
                return response()->json($schedule, 201);
            }
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
            return response()->json(Schedules::with('clients', 'commercialRoom')->findOrFail($id), 200);
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
     * @param SchedulesRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(SchedulesRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $checkDay = Schedules::where([
                ['schedule_date', $request->schedule_date],
                ['commercial_room_id', $request->commercial_room_id]
            ])->get();
            if (count($checkDay) > 0) {
                return response()->json(['message' => 'Sala já agendada nesse dia'], 201);
            } else {
                $schedule = Schedules::findOrFail($id);
                $schedule->fill($request->all())->save();
                DB::commit();
                return response()->json($schedule, 201);
            }
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
            $client = Schedules::findOrFail($id);
            $client->delete();
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
