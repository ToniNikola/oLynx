<?php

namespace App\Http\Controllers;

use App\Deadline;
use App\Event;
use App\EventRegistration;
use App\Helpers\CategoryHelper;
use App\Helpers\Deadlines;
use App\Helpers\ExportHelper;
use App\Helpers\ImportHelper;
use App\Helpers\RegistrationHelper;
use App\Stages;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class EventRegistrationController extends Controller {

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('verified', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return view('pages.eventRegistration.index');
    }

    public function create($slug)
    {
        $event = Event::whereSlug($slug)->first();

        if (!$event->open)
        {
            return redirect('event/' . $event->slug);
        }
        $check_if_registered = RegistrationHelper::checkIfRegistered($event->id);


        $category = explode('-', $event->category);

        return view('pages.eventRegistration.create', compact('event', 'check_if_registered', 'category'));
    }

    public function store(Request $request)
    {


        $event_id = $request->event_id;
        $runners = $request->except('_token', 'event_id');


        $event = Event::find($event_id);
        if (!$event->open)
        {
            return redirect('event/' . $event->slug);
        }
        $event_deadline = $event->deadline()->get();
        foreach ($event_deadline as $date)
        {
            $deadlines_array[] = $date->deadline;
        }


        $runners_count = count($runners['first_name']);


        $default = [];
        for ($s = 0; $s < $event->stages; $s ++)
        {
            $default[] = 0;
        }

        $no_entry_default = implode('-', $default);


        $stages = array_chunk($runners['stages'], $event->stages);

        for ($r = 0; $r < $runners_count; $r ++)
        {

            $deadline = Deadlines::compare(Carbon::now(), $deadlines_array);
            if (\Auth::user()->admin && isset($runners['deadline'][$r]))
            {
                $deadline = $runners['deadline'][$r];
            }
            $stages_per_runner = implode('-', $stages[$r]);

            if ($stages_per_runner == $no_entry_default)
            {
                return Redirect::back()->with('message', 'You can\'t registrate if you don\'t run any stages. Please check your form.');
            }
            $registration = new EventRegistration();

            $admin_id = 0;
            if (\Auth::user()->admin)
            {
                $admin_id = 1;
            }

            $payed = 0;
            if (isset($runners['payed'][$r]) && $runners['payed'][$r] == 1) //NOT SET WHEN USER IS CREATING IT
            {
                $payed = 1;
            }

            $registration->event_id = $event_id;
            $registration->user_id = \Auth::id();
            $registration->admin_id = $admin_id;
            $registration->first_name = $runners['first_name'][$r];
            $registration->last_name = $runners['last_name'][$r];
            $registration->gender = $runners['gender'][$r];
            $registration->birth_year = $runners['birth_year'][$r];
            $registration->club = (is_array($request->club)) ? $runners['club'][$r] : $runners['club'];
            $registration->country = $runners['country'][$r];
            $registration->category = $runners['category'][$r];
            $registration->deadline = $deadline;
            if ($runners['si_chip'][$r] == '')
            {
                $registration->rented = true;
                $registration->si_chip = $runners['si_chip'][$r];
            } else
            {
                $registration->rented = false;
                $registration->si_chip = $runners['si_chip'][$r];
            }
            $registration->stages = $stages_per_runner;
            $registration->payed = $payed;

            $registration->save();
        }

        return redirect('/event/' . $event->slug . '/registration/edit');
    }

    public function show($slug)
    {
        $event = Event::whereSlug($slug)->first();
        $registration_list = $event->registration()->get();
        $stages_num = $event->stages;
        foreach ($registration_list as $runner)
        {
            $runner->stages = explode('-', $runner->stages);
        }


        return view('pages.eventRegistration.show', compact('registration_list', 'stages_num', 'slug'));
    }

    public function edit($slug)
    {
        $event = Event::whereSlug($slug)->first();

        if (!RegistrationHelper::checkIfRegistered($event->id))
        {
            return redirect('/event/' . $event->slug . '/registration/create');
        }


        $registration_list = $event->registration()->where('user_id', \Auth::id())->get();


        foreach ($registration_list as $runner)
        {
            $id[] = $runner->id;
            $runner->stages = explode('-', $runner->stages);
        }
        $runner_id = implode('-', $id);

        $category = explode('-', $event->category);

        return view('pages.eventRegistration.edit', compact('registration_list', 'event', 'runner_id', 'category'));
    }

    public function update(Request $request)
    {
        $event_id = $request->event_id;
        $event = Event::find($event_id);
        $auth_id = \Auth::id();
        $id = $request->id;
        if ($id == null) //Delete all registered runners with AuthID
        {
            DB::delete(DB::raw('DELETE FROM event_registrations WHERE user_id = :user '), ['user' => $auth_id]);

            return redirect('/event/' . $event->slug . '/registration/create');
        }


        if (!isset($request->rented))
        {
            $runner_id = explode('-', $request->runner_id);
            $delete_id = array_diff($runner_id, $id);
            if ($delete_id !== 0)
            { //Delete all registered runners with delete_id
                foreach ($delete_id as $id)
                {
                    DB::delete(DB::raw('DELETE FROM event_registrations WHERE id = :id '), ['id' => $id]);
                }
            }
        }
        $stages = array_chunk($request->stages, $event->stages);

        for ($a = 0; $a < count($id); $a ++)
        {
            $stages_per_runner = implode('-', $stages[$a]);
            $runner = EventRegistration::find($request->id[$a]);

            $payed = 0;
            if (\Auth::user()->admin && $request->payed[$a] == 1)
            {
                $payed = 1;
            }
            $rented = false;
            if (isset($request->rented) && $request->si_chip !== null)
            {
                $rented = true;
            }

            $runner->first_name = $request->first_name[$a];
            $runner->last_name = $request->last_name[$a];
            $runner->gender = $request->gender[$a];
            $runner->birth_year = $request->birth_year[$a];
            $runner->club = $request->club[$a];
            $runner->country = $request->country[$a];
            $runner->category = $request->category[$a];
            $runner->si_chip = $request->si_chip[$a];
            $runner->rented = $rented;
            $runner->stages = $stages_per_runner;
            $runner->payed = $payed;
            if (\Auth::user()->admin)
            {
                $runner->deadline = $request->deadline[$a];
            }

            $runner->save();


        }
        if ($request->rented)
        {
            return redirect('/event/' . $event->id . '/registration/manageRented')->with('message', 'Successfully edited rented Si-Chip');
        }

        if (\Auth::user()->admin)
        {
            return redirect('/event/' . $event->id . '/registration/manage')->with('message', 'Successfully edited registration');
        }

        return redirect('/event/' . $event->slug . '/registration/edit')->with('message', 'Successfully edited registration');

    }

    public function admin($id, Request $request)
    {
        $event = Event::find($id);

        return view('pages.admin.registration', compact('event', 'registration'));
    }

    public function manage($id)
    {
        $event = Event::find($id);

        $registration_list = $event->registration()->get();
        $id = [];
        foreach ($registration_list as $runner)
        {
            $id[] = $runner->id;
            $runner->stages = explode('-', $runner->stages);
        }
        $runner_id = implode('-', $id);

        $rent_num = $event->registration()->where('si_chip', '')->count();

        $category = explode('-', $event->category);

        return view('pages.admin.manage', compact('event', 'registration_list', 'runner_id', 'rent_num', 'category'));
    }

    public function manageRented($id)
    {
        $event = Event::find($id);

        $registration_list = $event->registration()->get();
        $id = [];
        foreach ($registration_list as $runner)
        {
            $id[] = $runner->id;
            $runner->stages = explode('-', $runner->stages);
        }
        $runner_id = implode('-', $id);

        $rent_num = $event->registration()->where('rented', true)->count();

        $category = explode('-', $event->category);

        return view('pages.admin.manageRented', compact('event', 'registration_list', 'runner_id', 'rent_num', 'category'));
    }

    public function exportRegistration(Request $request)
    {

        $export = new ExportHelper();

        return $export->exportRegistrationToCSV($request->event);
    }

    public function exportCategory(Request $request)
    {


        $export = new ExportHelper();

        return $export->exportCategoryToCSV($request->event);
    }

    public function importRegistration($id, Request $request)
    {

        if ($request->file('file') == null)
        {
            return Redirect::back()->with('message', 'No file uploaded, try again.');
        }
        $import = new ImportHelper();
        $event = Event::find($id);
        $registration_file = $import->importRunners($request);

        $category = explode('-', $event->category);

        foreach ($category as $cat)
        {
            $category_array[$cat] = $cat;
        }

        return view('pages.admin.editImport', compact('registration_file', 'event', 'category_array'));
    }

    public function deadline($event_id)
    {
        $deadlines = Deadline::where('event_id', $event_id)->first();
        $event = Event::find($event_id);
        $deadline_num = $event->deadlines;


    }
}
