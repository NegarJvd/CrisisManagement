<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $data)
 */
class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function design(): BelongsTo
    {
        return $this->belongsTo(Design::class, 'design_id');
    }
    public function timber_provider(): BelongsTo
    {
        return $this->belongsTo(TimberSupply::class, 'timber_id');
    }
    public function cnc_provider(): BelongsTo
    {
        return $this->belongsTo(CNCSupply::class, 'cnc_id');
    }


}
