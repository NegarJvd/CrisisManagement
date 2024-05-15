<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static count()
 * @method static pluck(string $string)
 * @method static findOrFail($id)
 * @method static create(array $data)
 */
class Machine extends Model
{
    use HasFactory;
    protected $table = 'machines';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function designs(): BelongsToMany
    {
        return $this->belongsToMany(Design::class, 'design_machine', 'machine_id', 'design_id');
    }
    public function cnc_supplies(): BelongsToMany
    {
        return $this->belongsToMany(CNCSupply::class, 'cnc_supply_machine', 'machine_id', 'cnc_supply_id');
    }

}
