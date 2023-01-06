<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use FileVault;
use Str;

class StoreController extends Controller
{ 
    /**
     * Store a user uploaded file
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		return $this->renderView('page.uploadform');
	}
	 
    public function store(Request $request)
    {
        if ($request->hasFile('userFile') && $request->file('userFile')->isValid()) {
            $filename = Storage::putFile('files/' . auth()->user()->id, $request->file('userFile'));

            // Check to see if we have a valid file uploaded
            if ($filename) {
			 $enckey=$request->userencryptcode;
			 $encryptionkey=$enckey.$enckey.$enckey.$enckey.$enckey.$enckey.$enckey.$enckey;
			  FileVault::key($encryptionkey)->encrypt( $filename );
            // FileVault::encrypt( $filename );
            }
        }

        return redirect('uploadform')->with('message', 'Upload complete');
    }
	 public function downloadFile($filename)
    {
        // Basic validation to check if the file exists and is in the user directory
        if (!Storage::has('files/' . auth()->user()->id . '/' . $filename)) {
            abort(404);
        }

        return response()->streamDownload(function () use ($filename) {
            FileVault::key('12341234123412341234123412341234')->streamDecrypt('files/' . auth()->user()->id . '/' . $filename);
        }, Str::replaceLast('.enc', '', $filename));
    }
	 public function show()
    {

        $imgfiles = Storage::files('files/' . auth()->user()->id);
		
        return view('page.uploadimages', compact('imgfiles'));
		
    }
}
?>