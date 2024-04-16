<?php
// app/Models/Gate.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    protected $fillable = ['gate_id', 'pin', 'player_id', 'admin_id', 'playstyle_id', 'last_fed'];

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'gate_item');
    }

    public function package()
    {
        return $this->hasOne(Package::class);
    }

    public function playstyle()
{
    return $this->belongsTo(Playstyle::class, 'playstyle_id');
}
}
