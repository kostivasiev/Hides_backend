<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Membership;

class LoginController extends Controller
{
    function showlogin()
    {
     return view('page.login');
    }

   function checklogin(Request $request)
    {
     $this->validate($request, [
      'email'   => 'required|email',
      'password'  => 'required|alphaNum|min:3'
     ]);

     $user_data = array(
      'email'  => $request->get('email'),
      'password' => $request->get('password')
     );
	

     if(Auth::attempt($user_data))
     {
      return redirect('dashboard');
     }
     else
     {
      return back()->with('error', 'Wrong Login Details');
     }

    }

    function successlogin()
    {
	
	   $members=Membership::paginate(3);
	    
     $wordCount = $members->count();
     return view('page.successlogin',compact('members' ,'wordCount'));
    }

    function logout()
    {
     Auth::logout();
     return redirect('/');
    }
	
	function deleteusermembership($id=0)
	{ 
	
	Membership::find($id)->delete($id);
    echo "Delete successfully";
    exit;
	}
}

?>