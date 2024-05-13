<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $data)
 * @method static findOrFail($id)
 */
class TimberSupply extends Model
{
    use HasFactory;
    protected $table = "timber_supplies";
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();

        self::deleting(function ($model){
            $model->woods()->sync([]);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function woods(): BelongsToMany
    {
        return $this->belongsToMany(Wood::class, 'timber_supply_wood', 'timber_supply_id', 'wood_id');
    }
}
