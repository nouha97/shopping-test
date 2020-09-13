<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;
    /**
     * @var string
     */
    protected $keyType = "string";
    /**
     * @var string
     */
    protected $primaryKey = 'identifier';

    protected $fillable = ['identifier','discount', 'content'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['qty','row_id']);
    }
}
