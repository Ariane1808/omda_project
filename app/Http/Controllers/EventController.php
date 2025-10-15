<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $formattedEvents = [];

        foreach ($events as $event) {
            $formattedEvents[] = [
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'description' => $event->description,
            ];
        }

        return view('admin.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'nullable|date',
        ]);

        Event::create($request->all());
        return redirect()->back()->with('success', 'Événement ajouté !');
    }

    public function update(Request $request, $id){
    $event = Event::findOrFail($id);
    $event->title = $request->title;
    $event->start = $request->start;
    $event->end = $request->end;
    $event->description = $request->description;
    $event->save();

    return response()->json(['success' => true]);
}

public function destroy($id){
    $event = Event::findOrFail($id);
    $event->delete();

    return response()->json(['success' => true]);
}

}
