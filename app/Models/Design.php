<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Design extends Model
{
    use HasFactory;
    protected $table = 'designs';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function woods(): BelongsToMany
    {
        return $this->belongsToMany(Wood::class, 'design_wood', 'design_id', 'wood_id');
    }
    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(Machine::class, 'design_machine', 'design_id', 'machine_id');
    }
}
