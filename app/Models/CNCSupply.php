<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create($data)
 * @method static findOrFail($id)
 */
class CNCSupply extends Model
{
    use HasFactory;
    protected $table = "cnc_supplies";
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();

        self::deleting(function ($model){
            $model->machines()->sync([]);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(Machine::class, 'cnc_supply_machine', 'cnc_supply_id', 'machine_id');
    }
}
