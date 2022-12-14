<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.pages.profile.profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('backend.pages.profile.edit',['users'=>$users]);
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
        //
    }
}
