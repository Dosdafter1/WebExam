<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property int $user_id
 * @property int $card_id
 * @property string $type
 * @property string $values
 * @property bool $completed
 */
class ResponseToAdmin extends Model
{
    use HasFactory;
    protected $table = 'response_to_admin';
    protected $fillable =[
        'user_id',
        'card_id',
        'type',
        'values',
        'completed'
    ];
}
