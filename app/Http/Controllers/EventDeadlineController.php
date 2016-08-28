<?php

namespace App\Http\Controllers;

use App\Deadline;
use App\Event;
use App\Helpers\Deadlines;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EventDeadlineController extends Controller {

    public function __construct()
    {
        $this->middleware('admin', ['except' => ['store', 'update', 'destroy']]);
    }

    /**
     * Show Deadline
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        dd($request->all());

        $event_id = $request->event;
        $deadline = Deadline::where('event_id', $event_id)->first();
        dd($deadline);
    }

    /**
     * Create Deadline
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {

        $event_id = $request->event;

        $event = Event::find($event_id);
        $deadline_num = $event->deadlines;

        return view('pages.deadline.create', compact('event_id', 'deadline_num'));
    }

    public function store(Request $request)
    {


        $event_id = $request->event_id;
        $event = Event::find($event_id);

        if (Deadlines::checkIfSet($event_id))
        {
            Session::flash('message', "Already set the deadlines, please delete them instead!");
            Session::flash('alert-class', 'alert-danger');

            return Redirect::back();
        } else
        {
            for ($a = 0; $a < $event->deadlines; $a ++)
            {
                $deadline = new Deadline();
                $deadline->event_id = $event_id;
                $deadline->deadline = $request->deadline[$a];
                $deadline->value1 = $request->stage_min[$a].'-'.$request->stage_max[$a];
                $deadline->value2 = $request->all_min[$a].'-'.$request->all_max[$a];
                $deadline->value3 = null;

            $deadline->save();
            }

        }

        return redirect('/event/' . $event_id . '/edit')->with('message', "Successfully created deadlines.");
    }

    public function edit(Request $request)
    {
        $event_id = $request->event;
        $deadline_num = Event::find($event_id)->first()->deadlines;
        $deadline_list = Deadline::where('event_id', $event_id)->get();




        return view('pages.deadline.edit', compact('deadline_num', 'event_id', 'deadline_id', 'deadline_list'));
    }

    public function update(Request $request)
    {
        $deadline = Deadline::where('event_id', $request->event)->first();
        $deadline->update($request->all());

        return Redirect::back()->with('message', 'Successfully changed the deadline dates!');

    }
}
