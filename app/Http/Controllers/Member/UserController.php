<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // $data = User::orderBy('id','desc')->paginate(2);
        $data = User::where(function ($query) use ($request) {
            if ($request->search) {
                # code...
                $query->where('name','like',"%{$request->search}%")->orWhere('email','like',"%{$request->search}%");
            }
        })->orderBy('id','desc')->paginate(2)->withQueryString();
        return view('member.users.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        $data = $user;
        return view('member.users.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'new_password' => 'nullable|min:6|same:new_password_confirmation|required_with:new_password_confirmation',
            'new_password_confirmation' => 'required_with:new_password'
        ],[
            'name.required' => 'nama wajib diisi',
            'email.required' => 'email wajib diisi',
            'email.emial' => 'format.email ' .$request->email.' tidak sesuai',
            'email.unique' => 'email sudah ada',
            'new_password.required_with' => 'password konfirmasuk harus diisi',
            'new_password_confirmation.required_with' => 'password harus diisi'

        ]);

        $email_verified_at = $user->email_verified_at ? $user->email_verified_at : Carbon::now();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $email_verified_at,
            'password' => $request -> new_password ? bcrypt($request->new_password):$user->password 
        ];

        User::where('id', $user->id)->update($data);
        return redirect()->route('member.users.index')->with('succsess','data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function toggleBlock(User $user){
        $pesan = '';
        if ($user->blocked_at==null) {
            # code...
            $data = [
                'blocked_at' => now()
            ];
            $pesan = "User ".$user->name." telah di-block";
        } else {
            # code...
              # code...
            $data = [
                'blocked_at' => null
            ];
            $pesan = "User ".$user->name." telah di-unblock";
        }
        User::where('id',$user->id)->update($data);
        return redirect()->back()->with('success',$pesan);
    }
}
