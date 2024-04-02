<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'name',
        'description',
        'parent_id',
        'status',
        'image',
        'slug',
    ];


    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'archived');
    }
    public function scopeStatus(Builder $builder, $status)
    {
        $builder->where('status', '=', $status);
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        if ($filters['name'] ?? false){
            $builder->where('name', 'LIKE', "%{$filters['name']}%");
        }
        if ($filters['status'] ?? false){
            $builder->where('status', '=', $filters['status']);
        }

/*        $builder->when($filters['name'] ?? false, function ($builder, $value){
            $builder->where('name', 'LIKE', "%{$value}%");
        });*/
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id')->withDefault([
            'name' => '-'
        ]);
    }
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

}
