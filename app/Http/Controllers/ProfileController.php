<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AvatarRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function profile($id) {
        if(User::find($id) == null) {
            session()->flash('warning', 'Пользователь не найден!');
            return redirect()->route('index');
        }

        return(view('profile', ['user' => User::find($id), 'roles' => Role::all()]));
    }

    public function profiles() {
        return(view('profiles', ['users' => User::orderBy('id', 'asc')->paginate(config('variable.paginate.table'))]));
    }

    public function profilesControl() {
        return(view('profiles', ['users' => User::orderBy('id', 'asc')->paginate(config('variable.paginate.table'))]));
    }

    public function profileData($id) {
        return view('userdata', ['user' =>   $profile = User::find($id)]);
    }

    public function profileUpdate($id, ProfileRequest $request) {
        $user = User::find($id);

        Rule::unique('users')->ignore($user);

        if($user->id == auth()->user()->id || auth()->user()->role_id > 2) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->update();
            return redirect()->route('profile', ['id' => $id]);
        }
        else {
            session()->flash('warning', 'У Вас недостаточно прав!');
            return redirect()->route('index');
        }
    }

    public function setRole($id, $roleId, Request $request) {
        $user = User::find($id);
        $user->role_id = $roleId;
        $user->save();
        return redirect()->route('profile', ['id' => $id]);
    }

    public function profileUploadAvatar(AvatarRequest $request) {
        $profile = User::find(auth()->user()->id);
        $path = $request->file('avatar')->store('/avatars', 'public');

        if(!is_null($profile->avatar)) {
            Storage::disk('public')->delete($profile->avatar);
        }

        $profile->avatar =  $path;
        $profile->update();
        return redirect()->route('profile', ['id' => $profile->id]);
    }
}
