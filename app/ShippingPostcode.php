<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use App\Role;

class ShippingPostcode extends Model
{
    

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }



    public function category() {
        return $this->belongsTo(ProductCategory::class);
    }
    
    public function role() {
        return $this->belongsTo(Role::class);
    }

    
}
