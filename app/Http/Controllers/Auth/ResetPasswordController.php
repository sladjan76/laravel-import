<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Model\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Reset user password
     * 
     * @return [view]
     */
    public function getResetPassword($id, $key)
    {
        if($key != '67ab20df58e9308b05d57fe25cdf16ac') {
            return abort(404);
        }

        return view('pages.reset_password', compact('id'));
    }

    /**
     * Reset user password
     * 
     * @return [view]
     */
    public function postResetPassword(Request $request)
    {
        $input = $request->all();

        $user = User::findOrFail($input['id']);
        
        if(strlen($input['new_password']) < 6) {

    
            Session::flash('update_failure', 'Password must be at least 6 characters long');
    
            return view('pages.reset_password');
            
        }else{
            
            $user->password = Hash::make($input['new_password']);

            $user->save();
    
            Session::flash('update_success', 'Password successfully saved');
    
            return view('pages.reset_password_done');
    

        }

    }

    /**
     * Reset user password done
     * 
     * @return [view]
     */
    public function resetPasswordDone()
    {
        return view('pages.reset_password_done');
    }


}
