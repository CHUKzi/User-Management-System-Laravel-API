<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends AppBaseController
{
    public function getUsers(Request $request)
    {
        return $this->sendResponse(true, null, null, 'Users Not Found!');
    }
}
