<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property int $doctor_id
 * @property string $speciality
 */
class DoctorSpeciality extends Model
{
    use HasFactory;
    protected $table='doctor_specializations';
    protected $fillable=[
        'doctor_id',
        'speciality'
    ];
}
