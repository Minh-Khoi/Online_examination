<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UpdateUserController extends Controller
{
    /**
     * This function update the fields 'occupation', 'address', 'phone', 'is_admin' of an User instance
     * @param mixed $param might be id or email of the User instance
     * @param Request $request including FormData which contains array of updated values for the fields mentioned above
     * @return boolean true if update successfully
     */
    public function update_user(Request $request, $param)
    {
        $user = null;
        if (is_int($param)) {
            $user = User::find($param);
        } else if (filter_var($param, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $param)->get()->all()[0];
        } else {
            return false;
        }
        $user->occupation = $request->occupation;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->is_admin = $request->is_admin;
        $user->save();
        return true;
    }
}