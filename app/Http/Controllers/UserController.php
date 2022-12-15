<?php

namespace App\Http\Controllers;

use App\Mail\UserDelete;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('backend.pages.all_user', ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'country'     => ['required', 'string'],
            'state'       => ['required', 'string'],
            'postal_code' => ['required', 'integer'],
            'phone'       => ['required', 'integer'],
            'birthday'    => ['required', 'date','max:255'],
            'status'      => ['required', 'string','max:255'],
            'avater'      => ['required', 'image','mimes:jpg,jpeg,png']
        ]);
        

        $avater      = $request->file('avater');
        $ext         = $avater->getClientOriginalExtension();
        $unique_name = uniqid().'.'.$ext;
        $avater->move('profile/', $unique_name);

        $user = $request->user()->create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => $request->status,
            'avater'   => $unique_name,
        ]);

        $user->address()->create([
            'user_id'     => $user->id,
            'country_id'  => $request->country,
            'state'       => $request->state,
            'postal_code' => $request->postal_code,
            'phone'       => $request->phone,
            'birthday'    => $request->birthday,
        ]);
        return back()->with('success', 'User Created Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::findOrFail($id);
        return view('backend.pages.edit', ['users'=>$users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::where('id',$id)->first();
        
        $avater_uniqueName = $request->avater_hidden;
        
        
        if($request->hasFile('avater')){
            if($user->avater != null){
                file_exists('profile/'.$user->avater) ? unlink('profile/'.$user->avater) : false;
            }
            
            $avater = $request->file('avater');
            $ext = $avater->getClientOriginalExtension();
            $avater_uniqueName = uniqid().'.'.$ext;
            $avater->move('profile/', $avater_uniqueName);
        }


        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'status'   => $request->status,
            'avater'   => $avater_uniqueName,
        ]);

        $user->address()->update([
            'country_id'  => $request->country,
            'state'       => $request->state,
            'postal_code' => $request->postal_code,
            'phone'       => $request->phone,
            'birthday'    => $request->birthday,
        ]);
        return back()->with('success', 'User Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id',$id)->first();

        Mail::to($user->email)->send(new UserDelete($user));

        if($user->avater != null){
            if(file_exists('profile/'.$user->avater)){
                unlink('profile/'.$user->avater);
            }
        }
        
        $user->delete();

        return back()->with('success', 'User Deleted Success!');
    }
}
