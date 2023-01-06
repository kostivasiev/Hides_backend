<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership;
Use Input;
class SearchController extends Controller
{
    function search(Request $request)
    {
		
		$q = $request->keyword;
		$user =  Membership::where('fullName','LIKE','%'.$q.'%')->orWhere('userAppleEmail','LIKE','%'.$q.'%')->paginate(3);
		if(count($user) > 0)
		return view('page.successlogin')->withDetails($user)->withQuery ( $q );
		else return view ('page.successlogin')->withMessage('No Details found. Try to search again !');
    }

}

?>