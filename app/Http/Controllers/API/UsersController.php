<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetUser;
use App\Http\Requests\UserValidation;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends AppBaseController
{
    public function getUsers(Request $request)
    {
        try {
            $users = User::orderBy('created_at')->get();
            return $this->sendResponse(true, $users, count($users) . ' Records Found!', null); // Response: Status / Data / Success Message/ Error Message
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->sendResponse(false, null, null, 'It\'s a technical error! Please reach out to our customer service.');
        }
    }

    public function store(UserValidation $request)
    {
        try {
            $user = new User();
            $user->first_name =  $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->mobile = $request->input('mobile');
            $user->password = bcrypt($request->input('password'));
            $user->save();
            return $this->sendResponse(true, $user, 'User Registered Successfully!', null);
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->sendResponse(false, null, null, 'It\'s a technical error! Please reach out to our customer service.');
        }
    }

    public function getUser(GetUser $request)
    {
        try {
            $user = User::find($request->id);
            if($user){
                return $this->sendResponse(true, $user, 'Record found!', null);
            }
            return $this->sendResponse(false, null, null, 'User Not Found!');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->sendResponse(false, null, null, 'It\'s a technical error! Please reach out to our customer service.');
        }
    }

    public function update(UserValidation $request, $id)
    {
        try {
            $user = User::find($id);
            if($user){
                $user->first_name =  $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->email = $request->input('email');
                $user->mobile = $request->input('mobile');
                if($request->input('password')){
                    $user->password = bcrypt($request->input('password'));
                }
                $user->save();
                return $this->sendResponse(true, $user, 'User Updated Successfully!', null);
            }
            return $this->sendResponse(false, null, null, 'User Not Found!');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->sendResponse(false, null, null, 'It\'s a technical error! Please reach out to our customer service.');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if($user) {
                $user->delete();
                return $this->sendResponse(true, $user, 'User Deleted Successfully!', null);
            }
            return $this->sendResponse(false, null, null, 'User Not Found!');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->sendResponse(false, null, null, 'It\'s a technical error! Please reach out to our customer service.');
        }
    }
}
