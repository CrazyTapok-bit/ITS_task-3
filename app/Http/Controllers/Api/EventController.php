<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return EventResource::collection(
            $request->user()->events()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EventStoreRequest $request)
    {
        $event = $request->user()->events()->create(array_merge(
            $request->validated(),
            [
                'status' => Event::NEW
            ]
        ));
        return new EventResource($event);
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
     * @return \Illuminate\Http\Response
     */
    public function update(EventUpdateRequest $request, Event $event)
    {
        $event->update($request->validated());
        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $id)
    {
        $request->user()->events()->find($id)->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function complete(Request $request, $id)
    {
        $event = $request->user()->events()->find($id);
        $event->update(['status' => Event::COMPLETED]);
        return new EventResource($event);
    }
}
