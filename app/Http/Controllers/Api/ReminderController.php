<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reminder\ReminderStoreRequest;
use App\Http\Resources\ReminderResource;
use App\Models\Reminder;
use App\Models\ReminderDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return ReminderResource::collection(
            $request->user()->reminders()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ReminderStoreRequest $request)
    {
        $days = collect($request->input('days', []))
            ->map(function($day) {
                return new ReminderDay([
                    'day' => $day
                ]);
        });

        $reminder = DB::transaction(function() use($request, $days) {
            /** @var Reminder $reminder */
            $reminder = $request->user()->reminders()->create($request->validated());
            $reminder->days()->saveMany($days);
            return $reminder;
        });

        return new ReminderResource($reminder);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
