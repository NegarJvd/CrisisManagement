<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $only)
 * @method static findOrFail($id)
 * @method static pluck(string $string)
 */
class Design extends Model
{
    use HasFactory;
    protected $table = 'designs';
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
        return $this->belongsToMany(Wood::class, 'design_wood', 'design_id', 'wood_id');
    }
    public function timbers()
    {
        $wood_list = $this->woods()->pluck('wood.id');

        return TimberSupply::query()->whereHas('woods', function ($q) use($wood_list){
                            $q->whereIn('id', $wood_list);
                })->get();
    }

}
