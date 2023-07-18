<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int    $id
 * @property int    $Client_id
 * @property int    $Doctor_id
 * @property string $Symptoms
 * @property date   $Visit_date
 * @property time   $Visit_time
 * @property bool   $completed
 */
class Card extends Model
{
    use HasFactory;
    protected $table='cards';
    protected $fillable = [
        'Client_id',
        'Doctor_id',
        'Symptoms',
        'Visit_date',
        'Visit_time',
        'completed'
    ];
    public function getClient($id) {
        $clients = User::where('role',2)->find($id);
        return $clients;
    } 
    public function getDoctor($id) {
        $doctors = User::where('role',3)->find($id);
        return $doctors;
    }
}
