<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $only)
 * @method static findOrFail($id)
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
            $model->machines()->sync([]);

            if ($model->file_path)
            {
                $path = public_path('storage/'.$model->file_path);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
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
    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(Machine::class, 'design_machine', 'design_id', 'machine_id');
    }
}
