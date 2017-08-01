<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    public function getUserPage(User $user)
    {

        $data = [
            'userName' => $user->name,
            'userEmail' => $user->email,
            'profileImagePath' => $user->getImageLink(),
        ];

        return view('user.one', $data);
    }

    public function getUserSettings()
    {
        $data = [
            'userName' => auth()->user()->name,
            'userEmail' => auth()->user()->email,
            'profileImagePath' => auth()->user()->getImageLink(),
        ];
        
        return view('user.settings', $data);

    }

    public function postUserProfileImage(\App\Http\Requests\UserUpdateImageForm $request)
    {
        $user_repository = new \App\Repositories\UserRepository(auth()->user());
        $uploadedImage = $request->file('profile_image');
        $user_repository->updateUserImage($uploadedImage);

        return redirect()->back();
        
    }
}
