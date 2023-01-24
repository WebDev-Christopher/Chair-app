<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Chair;
use App\Mail\AddedChair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ChairController extends Controller
{

    protected $chairs;
    protected $users;

    public function __construct(){
        $this->chairs = new Chair();
        $this->users = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.chairs.index', [ 
            'items' => $this->chairs->getAllChairs(), 
            'user' => $this->users->getCurrentUser() 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForm()
    {
        return view('pages.chairs.create', [ 
            'user' => $this->users->getCurrentUser() 
        ]);
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
            'image' => 'required|image|max:2048',
            'image.*' => 'mimes:jpg,png,jpeg,gif,svg'
        ]);

        $mytime = date('m-Y-h-i-s');

        $file_prefix = $mytime . '_' ."chair-image";
        $imageExtension = $request->image->getClientOriginalExtension();
        $name = $request->file('image')->storeAs('/public/chairImages' , $file_prefix . "." . $imageExtension);

        $chair_data["image"] = $file_prefix . "." . $imageExtension;

        $allUsers = $this->users->getAllUsers();
        $CreateChair = $this->chairs->createChair($chair_data);

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
        return view('pages.chairs.show', [ 
            'user' => $this->users->getCurrentUser(), 
            'item' => $this->chairs->getChairsbyID($id) 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chair  $chair
     * @return \Illuminate\Http\Response
     */
    public function updateForm($id)
    {
        return view('pages.chairs.update', [ 
            'item' => $this->chairs->getChairsbyID($id) 
        ]);
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
            'new_image' => 'max:2048',
            'new_image.*' => 'mimes:jpg,png,jpeg,gif,svg'
        ]);

        $user = $this->users->getCurrentUser();

        if ($user->id == $chair_data['user_id']) {
            if (isset($chair_data["new_image"])) {

                $chair = Chair::select('image')->where('id', $chair_data["id"])->first();
                $imagedeletion = Storage::disk('local')->delete('public/chairImages/'.$chair["image"]);
                $mytime = date('m-Y-h-i-s');
                $file_prefix = $mytime . '_' ."chair-image";
                $imageExtension = $request->file("new_image")->getClientOriginalExtension();
                $name = $request->file('new_image')->storeAs('/public/chairImages' , $file_prefix . "." . $imageExtension);
                $chair_data["new_image"] = $file_prefix . "." . $imageExtension;

                if($this->chairs->updateChair($chair_data["id"], $chair_data["name"], $chair_data["amount"], $chair_data["body"], $chair_data["new_image"])) {
                    return redirect('/')->with('message', 'Chair has been updated');
                }
                else {
                    return redirect()->back()->with('message', "Chair could not be updated");
                }
            }
            else {
                if($this->chairs->updateChair($chair_data["id"], $chair_data["name"], $chair_data["amount"], $chair_data["body"], $chair_data["image"])) {
                    return redirect('/')->with('message', 'Chair has been updated');
                }
                else {
                    return redirect()->back()->with('message', "Chair could not be updated");
                }
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
        $chair = $this->chairs->selectChairimagebyID($id);
        $imagedeletion = Storage::disk('local')->delete('public/chairImages/'.$chair["image"]);
        
        $this->chairs->deleteChairsbyID($id);
        return redirect('/')->with('message', "chair has succesfully been deleted");
    }
}
