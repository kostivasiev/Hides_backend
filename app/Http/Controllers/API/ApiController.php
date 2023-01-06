<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use App\Models\Membership;
use App\Models\MembersImages;
use File;
use FileVault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Str;

class ApiController extends Controller
{

    public function loginmembers(Request $request)
    {

        $fullname = $request->input('fullName');
        $userAppleID = $request->input('userAppleID');
        $userAppleEmail = $request->input('userAppleEmail');
        
        if(isset($userAppleEmail)){
        $rules = array(
            'userAppleID' => 'required',
            'userAppleEmail' => 'email',
        );
        }else{

        $rules = array(
            'userAppleID' => 'required'       
        );



        }

        $messages = array(
            'fullname.required' => 'fullname  is required field',
            'userAppleID.required' => 'userAppleID is required field',
            'userAppleEmail.required' => 'userAppleEmail is required field',
            'userAppleEmail.email' => 'userAppleEmail field should be an email value',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $members = Membership::where('userAppleID', $userAppleID)->first();

            if (!empty($members)) {
                return response(array(
                    "succeess" => "1",
                    "userAppleID" => $members->userAppleID,
                    "userAppleEmail" => $members->userAppleEmail,
                    "fullname" => $members->fullName,
                    "subscriptionStatus" => $members->subscriptionStatus,
                ), 200);
            } else {
                return response()->json([
                    "errors" => "Not Found",
                ], 404);
            }
        }

    }

    public function updatedmemberprofile(Request $request)
    {

        $userAppleID = $request->input('userAppleID');
        $subscriptionStatus = $request->subscriptionStatus;

        $rules = array(
            'userAppleID' => 'required',
            'subscriptionStatus' => 'required|numeric|max:2',
        );

        $messages = array(
            'userAppleID.required' => 'userAppleID is a required field',
            'subscriptionStatus.required' => 'subscriptionStatus is a required field',
            'subscriptionStatus.max' => 'invalid subscriptionStatus',
            'subscriptionStatus.numeric' => 'invalid subscriptionStatus',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            $membership = Membership::where('userAppleID', $userAppleID)->first();

            if ($membership) {

                try {

                    $membership->subscriptionStatus = $subscriptionStatus;
                    $membership->save();

                    return response(array(
                        "succeess" => true,
                    ), 200);

                } catch (\Exception $e) {

                    return response()->json(['errors' => 'something went wrong']);

                }

            } else {

                return response()->json([
                    "errors" => "Not Found",
                ], 404);
            }
        }
    }

    public function uploadimage(Request $request)
    {

        $userdata = $request->all();
        $messages = array(
            "userAppleID.required" => "userAppleID is required field",
            "encryptionKey.required" => 'encryptionKeyKey is required field',
            "images.requires" => "Images field is required field",
            "images.*.mimes" => "Invalid image type",
        );
        $rules = [
            'userAppleID' => 'required',
            'encryptionKey' => 'required',
            'images' => 'required',
            'images.*' => 'mimes:jpeg,png,jpg,gif',
        ];

        $validator = Validator::make($userdata, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            $membership = Membership::where('userAppleID', $request->userAppleID)->first();

            if (!$membership) {

                return response()->json([
                    "errors" => "Not Found",
                ], 404);

            }

            if ($request->hasFile('images')) {

                $number_of_images = $membership->photos;

                try {
                    $files = $request->file('images');

                    foreach ($files as $file) {

                        $number_of_images++;

                        $extension = $file->getClientOriginalExtension();

                        $orignal_fileName = Str::random(5) . "-" . date('his') . "-" . Str::random(3) . "." . $extension;
                        $filename = $file->move(storage_path('app/public/secured_files'), $orignal_fileName);

                        //Upload File to s3
                        //Storage::disk('s3')->put($orignal_fileName, fopen($request->file('images'), 'r+'), 'public');
                        $file_path = 'public/secured_files/' . $orignal_fileName;

                        $userAppleEmail = $request->userAppleEmail;
                        $client_enckey = $request->encryptionKey;

                        $server_encrypted_client_enckey = $this->my_encrypt($client_enckey);

                        $imagename = FileVault::key($server_encrypted_client_enckey)->encrypt($file_path);

                        MembersImages::create([
                            'member_id' => $membership->id,
                            'member_file_name' => $orignal_fileName . '.enc',
                        ]);

                    }

                    $membership->photos = $number_of_images;
                    $membership->save();

                    return response(array(
                        "succeess" => true,
                    ), 200);
                } catch (\Exception $e) {

                    return response()->json([
                        "errors" => "Something Went Wrong",
                    ]);
                }

            } else {
                return response()->json([
                    "errors" => "Images are missing",
                ], 404);
            }

        }

    }

    public function downloadFile(Request $request)
    {

        $userdata["userAppleID"] = $request->input('userAppleID');
        $userdata["encryptionKey"] = $request->input('encryptionKey');

        $messages = array(
            "userAppleID.required" => "userAppleID is required field",
            "encryptionKey.required" => 'encryptionKey is required field',
        );

        $rules = [
            'userAppleID' => 'required',
            'encryptionKey' => 'required',
        ];

        $validator = Validator::make($userdata, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $member = Membership::where('userAppleID', $userdata["userAppleID"])->first();

        if (!$member) {
            return response()->json([
                "errors" => "Not Found",
            ], 404);

        }

        $number_of_images = MembersImages::where("member_id", $member->id)->count();

        if ($number_of_images <= 0) {

            return response()->json([
                "errors" => "No Images Found",
            ], 404);

        }

        $all_images = MembersImages::where("member_id", $member->id)->get();

        $encryptionKey = $this->my_encrypt($userdata["encryptionKey"]);
        $all_images_data = array();
        try {

            foreach ($all_images as $key => $member) {
                $images = $member->member_file_name;
                $full_path = 'public/secured_files/' . $images;
                $downloadable_image_name = str_replace('.enc', '', $images);

                $download_path = 'public/downloadable/' . $downloadable_image_name;
                $result = FileVault::key($encryptionKey)->decryptCopy($full_path, $download_path);
                $all_images_data[$key]['url'] = asset('storage/downloadable/' . $downloadable_image_name);
                $all_images_data[$key]['id'] = $member->id;

            }

            return response(array(
                "success" => true,
                "images" => $all_images_data,

            ), 200);
        } catch (\Exception $e) {

            return response()->json([
                "errors" => "Wrong Encryption key",
            ]);

        }

    }

    public function deleteFile(Request $request)
    {

        $userdata["userAppleID"] = $request->input('userAppleID');
        $userdata["imagesIds"] = $request->input('imagesIds');

        $messages = array(
            "userAppleID.required" => "userAppleID is required field",
            "imagesIds.required" => "imagesIds are required",
        );

        $rules = [
            'userAppleID' => 'required',
            'imagesIds' => 'required',
        ];

        $validator = Validator::make($userdata, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $allimagesIds = json_decode($userdata["imagesIds"], true);

        if (empty($allimagesIds)) {

            return response()->json([
                "errors" => "Invalid imagesIds field",
            ], 200);

        }

        $member = Membership::where('userAppleID', $userdata["userAppleID"])->first();

        if (!$member) {
            return response()->json([
                "errors" => "Not Found",
            ], 404);

        }

        $all_images = MembersImages::where("member_id", $member->id)->whereIn('id', $allimagesIds)->get();

        if ($all_images->isEmpty()) {

            return response()->json([
                "errors" => "ImagesId are not found",
            ], 404);

        }

        try {

            foreach ($all_images as $member) {
                $images = $member->member_file_name;
                $downloadable_image_name = str_replace('.enc', '', $images);

                $image_path = storage_path() . '/app/public/downloadable/' . $downloadable_image_name;

                $encrypted_image_path =  storage_path('public/secured_files/'.$images);

                

                if (File::exists($image_path)) {

                    File::delete($image_path);
                }

                if (File::exists($encrypted_image_path)) {

                    File::delete($encrypted_image_path);
                }

                $member->delete();

            }




            return response(array(
                "success" => true,
            ), 200);

        } catch (\Exception $e) {

            return response()->json([
                "success" => "false",
            ], 200);

        }

    }

    public function my_encrypt($string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = '{#>sD~k2Ej:-eC7{TASvNj1a@`e`H+8=T?U&Kbl2BdB~QO<:&uRVypzqR#Yrb$^n';
        $secret_iv = 'yVu 2i-M%c}n^.Z_9nj$rsBKhUl&O[nU_uWi]ntX$$t4![DH5{m( P;q,`VhucOn';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    public function my_decrypt($string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = '{#>sD~k2Ej:-eC7{TASvNj1a@`e`H+8=T?U&Kbl2BdB~QO<:&uRVypzqR#Yrb$^n';
        $secret_iv = 'yVu 2i-M%c}n^.Z_9nj$rsBKhUl&O[nU_uWi]ntX$$t4![DH5{m( P;q,`VhucOn';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 32);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }

    public function createmembershipuser(Request $request)
    {
        $fullname = $request->input('fullName');
        $userAppleID = $request->input('userAppleID');
        $userAppleEmail = $request->input('userAppleEmail');
        
        if(isset($userAppleEmail)){
        $rules = array(
            'userAppleID' => 'required|unique:Users_membership',
            'userAppleEmail' => 'email|unique:Users_membership',
        );
        }else{
          $rules = array(
            'userAppleID' => 'required|unique:Users_membership'
        );

        }

        $messages = array(
            'fullname.required' => 'fullname  is required field',
            'userAppleID.required' => 'userAppleID is required field',
            'userAppleID.unique' => 'userAppleID  is already exists',
            'userAppleEmail.required' => 'userAppleEmail is required field',
            'userAppleEmail.email' => 'userAppleEmail field should be an email value',
            'userAppleEmail.unique' => 'userAppleEmail is already exists',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        } else {

            $result = Membership::create([
                'fullName' => $fullname??NULL,
                'userAppleID' => $userAppleID,
                'userAppleEmail' => $userAppleEmail,
            ]);

            if ($result) {

                return response()->json([
                    "success" => true,
                    "userAppleID" => $userAppleID,
                    "userAppleEmail" => $userAppleEmail,
                    "fullName" => $fullname??NULL,
                    "subscriptionStatus" => "0",
                ], 200);

            } else {
                return response()->json(['errors' => 'Something Went Wrong']);
            }
        }
    }

    public function cloudStatus(Request $request)
    {

        $userAppleID = $request->input('userAppleID');

        $rules = array(
            'userAppleID' => 'required',
        );

        $messages = array(
            'userAppleID.required' => 'userAppleID is required field',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);

        } else {
            try {

                $member_exist = Membership::where('userAppleID', $userAppleID)->first();

                if ($member_exist) {

                    return response()->json([
                        "success" => true,
                        "total" => 10000,
                        "used" => $member_exist->photos,
                    ], 200);

                } else {

                    return response()->json([
                        "errors" => "Not Found",
                    ], 404);

                }

            } catch (\Exception $e) {
                return response()->json(['errors' => 'Something Went Wrong']);
            }
        }
    }

    public function sendVerificationCode(Request $request)
    {

        $userAppleID = $request->input('userAppleID');
        $email = $request->input('useremail');
        

        $rules = array(
            'userAppleID' => 'required',
            'useremail'=>'required|email'
        );

        $messages = array(
            'userAppleID.required' => 'userAppleID is required field',
            'useremail.required' => 'useremail is required field'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {

            $member_exist = Membership::where('userAppleID', $userAppleID)->first();

            if (!$member_exist) {

                return response()->json([
                    "errors" => "Not Found",
                ], 404);

            }

        } catch (\Exception $e) {

            return response()->json(['errors' => 'Something Went Wrong']);

        }

        $otpCode = mt_rand(1000, 9999);

        try {
            $email = $email;
            $member_exist->otp_code = $otpCode;
            $member_exist->save();

        } catch (\Exception $e) {

            return response()->json(['errors' => 'Something Went Wrong']);
        }

        $data = [
            'no-reply' => 'techgeekrohit07@gmail.com',
            'Email' => $email,
            'otp' => $otpCode,
        ];
           
        try{

        Mail::send('mails.otp', ['data' => $data],
            function ($message) use ($data) {
                $message
                    ->from($data['no-reply'])
                    ->to($data['Email'])->subject('Your OTP code for verification - Tuck App');
            });

            return response()->json([
                "success" => true,
            ], 200);

        }catch(\Exception $e){
          
            return response()->json(['errors' => 'Something Went Wrong']);

        }

    }

    public function checkOTPcode(Request $request){
        $userAppleID = $request->input('userAppleID');
        $otp = $request->input('otp');

        $rules = array(
            'otp' => 'required',
            'userAppleID' => 'required',
        );

        $messages = array(
            'otp.required' => 'OTP  is required field',
            'userAppleID.required' => 'userAppleID is required field',
            'userAppleID.unique' => 'userAppleID  is already exists',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);

        } else {
            try {

                $member_exist = Membership::where('userAppleID', $userAppleID)->first();

                if (!$member_exist) {

                    return response()->json([
                        "errors" => "Not Found",
                    ], 404);

                } 

                if($member_exist->otp_code != $otp ){
                    return response()->json(['errors' => 'OTP does not match']);

                }else{
                    return response()->json([
                        "success" => true,
                    ], 200);
                }

            } catch (\Exception $e) {
                return response()->json(['errors' => 'Something Went Wrong']);
            }
        }

    }

}
