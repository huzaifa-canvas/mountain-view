<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasSlug;
    protected $table='listings';
    protected $primaryKey = 'listings_id';


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('listings_name')
            ->saveSlugsTo('listings_slug');
    }
}
