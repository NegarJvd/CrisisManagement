<?php

namespace App\Models;

use App\Enums\WoodTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static count()
 * @method static pluck(string $string)
 * @method static create(array $data)
 * @method static findOrFail($id)
 */
class Wood extends Model
{
    use HasFactory;

    protected $table = 'wood';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $casts = [
        'type' => WoodTypeEnum::class
    ];

    public function designs(): BelongsToMany
    {
        return $this->belongsToMany(Design::class, 'design_wood', 'wood_id', 'design_id');
    }
    public function timber_supplies(): BelongsToMany
    {
        return $this->belongsToMany(TimberSupply::class, 'timber_supply_wood', 'wood_id', 'timber_supply_id');
    }

}
