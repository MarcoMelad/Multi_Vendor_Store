<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'slug', 'image', 'category_id', 'store_id',
        'price', 'compare_price', 'status'
    ];

    protected $hidden = [
        'created_at','updated_at', 'deleted_at','image'
    ];
    protected $appends = [
        'image_url'
    ];
    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());

        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://navajeevan.websites.co.in/obaju-turquoise/img/product-placeholder.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
    public function getSalePercentAttribute(){
        if (!$this->compare_price){
            return 0;
        }
        return round(100 - (100 * ($this->price / $this->compare_price)),1);
    }
    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ],$filters);

        $builder->when($options['store_id'],function ($builder, $value){
            $builder->where('store_id',$value);
        });
        $builder->when($options['category_id'],function ($builder, $value){
            $builder->where('category_id',$value);
        });
        $builder->when($options['tag_id'],function ($builder, $value){
            //$builder->whereRaw('Exist (SELECT 1 FROM product_tags WHERE tag_id = ? AND product_id = products.id)',[$value]);
            $builder->whereExist(function ($query) use ($value){
                $query->select(1)->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id',$value);
            });

        });
        $builder->when($options['status'],function ($builder){
            $builder->where('status','active');
        });
    }
}
