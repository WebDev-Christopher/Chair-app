<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use App\Models\User;
use App\Mail\AddedChair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ChairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Chair::all()->sortByDesc("created_at");
        $user = Auth::user();
        return view('pages.chairs.index')->with(compact("items", "user"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForm()
    {
        $user = Auth::user();
        return view('pages.chairs.create')->with(compact("user"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createChair(Request $request)
    {
        $chair_data = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'body' => 'required',
            'image' => 'required',
        ]);

        $allUsers = User::all();
        $CreateChair = Chair::create($chair_data);

        

        if($allUsers || $CreateChair) {
            Mail::to($allUsers)->queue(new AddedChair($CreateChair));
            return redirect('/')->with('message', 'Chair has been created');
        }
        else {
            return redirect()->back()->with('message', 'Chair was not created');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chair  $chair
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Chair::find($id);
        $user = Auth::user();
        return view('pages.chairs.show')->with(compact('item', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chair  $chair
     * @return \Illuminate\Http\Response
     */
    public function updateForm($id)
    {
        $item = Chair::find($id);
        return view('pages.chairs.update')->with(compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chair  $chair
     * @return \Illuminate\Http\Response
     */
    public function updateChair(Request $request)
    {
        $chair_data = $request->validate([
            'id' => 'required',
            'user_id' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'body' => 'required',
            'image' => 'required',
        ]);

        $user = Auth::user();

        if ($user->id == $chair_data['user_id']) {
            if(Chair::where('id', $chair_data["id"])->update(['name'=> $chair_data["name"], 'amount'=> $chair_data["amount"], 'body'=> $chair_data["body"]])) {
                return redirect('/')->with('message', 'Chair has been updated');
            }
            else {
                return redirect()->back()->with('message', "Chair could not be updated");
            }
        }
        else {
            return redirect()->back()->with('message', "You're not OP user");
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chair  $chair
     * @return \Illuminate\Http\Response
     */
    public function deleteChair($id)
    {   
        Chair::where('id', $id)->delete();
        return redirect('/');
    }
}
