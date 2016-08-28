<?php

namespace App\Http\Controllers;

use App\Deadline;
use App\Event;
use App\Helpers\CategoryHelper;
use App\Helpers\Deadlines;
use App\Helpers\Stage;
use App\Stages;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller {

    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('admin', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

        return view('pages.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = CategoryHelper::getList();
        $category_set = null;

        return view('pages.event.create', compact('category', 'category_set'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->hasFile('event_img'))
        {
            $file = $request->file('event_img');
        }

        $category = implode('-', $request->category);

        $event = new Event();
        $event->name = $request->name;
        $event->location = $request->location;
        $event->deadlines = $request->deadlines;
        $event->stages = $request->stages;
        $event->category = $category;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->si_rent = $request->si_rent;
        $event->save();

        $destination_path = public_path('/img/');
        $file->move($destination_path, $event->id . '.png');

        return redirect('admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  str slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $event = Event::whereSlug($slug)->firstOrFail();



            foreach ($event->deadline as $deadline)
            {
                $value1[] = explode('-', $deadline->value1);
            }
            foreach ($event->deadline as $deadline)
            {
                $value2[] = explode('-', $deadline->value2);
            }



        return view('pages.event.show', compact('event', 'value1', 'value2'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $event = Event::find($id);

        $category = CategoryHelper::getList();
        $category_set = explode('-', $event->category);

        $deadline_set = Deadlines::checkIfSet($event->id);
        $deadline = Deadline::where('event_id', $event->id)->first();

        (isset($deadline)) ? $deadline_id = $deadline->id : $deadline_id = null;

        return view('pages.event.edit', compact('event', 'deadline_set', 'deadline_id', 'category', 'category_set'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $deadline_check = Deadlines::checkIfSet($id);


        $registration = 0;
        if ($request->open == 1)
        {
            if ($deadline_check)
            {
                $registration = 1;
            } else
            {
                return Redirect::back()->with('message', 'Can\'t open registration, need to add Deadlines & Stages.');
            }
        }

        if ($request->hasFile('event_img'))
        {
            if (\File::exists(public_path('/img/' . $id . '.png')))
            {
                \File::delete(public_path('/img/' . $id . '.png'));
            }
            $file = $request->file('event_img');
            $file->move(public_path('/img/'), $id . '.png');
        }

        $category = implode('-', $request->category);

        $event = Event::find($id);

        $event->name = $request->name;
        $event->location = $request->location;
        $event->deadlines = $request->deadlines;
        $event->stages = $request->stages;
        $event->category = $category;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->si_rent = $request->si_rent;
        $event->open = $registration;

        $event->save();

        return redirect('event/' . $event->id . '/edit')->with('message', 'Successfully edited event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deadlines = Deadline::where('event_id', $id)->first();
        if (isset($deadlines))
        {
            $deadlines->delete();
        };

        \File::delete(public_path('/img/' . $id));

        Event::destroy($id);

        return redirect('/admin');
    }
}
