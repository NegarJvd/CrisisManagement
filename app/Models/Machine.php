<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static count()
 */
class Machine extends Model
{
    use HasFactory;
    protected $table = 'machines';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
