<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int    $id
 * @property int    $Client_id
 * @property int    $Doctor_id
 * @property int    $Rate
 */
class DoctorRating extends Model
{
    use HasFactory;
    protected $table='doctor_rating';
    protected $fillable = [
        'Client_id',
        'Doctor_id',
        'Rate'
    ];
    public function getClient():HasOne {
        return $this->hasOne(Client::class);
    } 
    public function getDoctor():HasOne {
        return $this->hasOne(Doctor::class);
    }
}
