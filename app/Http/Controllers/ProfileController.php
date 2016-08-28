<?php

namespace App\Http\Controllers;

use App\Mailers\AppMailer;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $mailer;
    public function __construct(AppMailer $mailer){
        $this->mailer = $mailer;
        $this->middleware('auth');

    }

    public function index(){
        $user = Auth::user();
        $verified = $user->verified;

        return view('auth.index', compact('user', 'verified'));
    }
    public function destroy($id){
        User::destroy($id);
        return redirect ('/');
    }
    public function resentConf(){
        $this->mailer->sendEmailConfirmationTo(Auth::user());
        return redirect('/profile')->with('message', 'Successfully resent confirmation email');
    }
}
