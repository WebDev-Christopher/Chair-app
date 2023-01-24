<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chair extends Model
{
    use HasFactory;
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'amount',
        'body',
        'image',
    ];

    public function getAllChairs() {
        return $this::all()->sortByDesc("created_at");
    }

    public function getChairsbyID($id) {
        return $this::find($id);
    }

    public function selectChairimagebyID($id) {
        return $this::select('image')->where('id', $id)->first();
    }

    public function createChair($chair_Data) {
        return $this::create($chair_Data);
    }

    public function updateChair($id, $name, $amount, $body, $image) {
        return $this::where('id', $id)->update(['name'=> $name, 'amount'=> $amount, 'body'=> $body, 'image'=> $image]);
    }

    public function deleteChairsbyID($id) {
        return $this::where('id', $id)->delete();
    }
}
