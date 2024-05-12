<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TimberSupply extends Model
{
    use HasFactory;
    protected $table = "timber_supplies";
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function woods(): BelongsToMany
    {
        return $this->belongsToMany(Wood::class, 'timber_supply_wood', 'timber_supply_id', 'wood_id');
    }
}
