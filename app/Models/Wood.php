<?php

namespace App\Models;

use App\Enums\WoodTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wood extends Model
{
    use HasFactory;

    protected $table = 'wood';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $casts = [
        'type' => WoodTypeEnum::class
    ];
}
