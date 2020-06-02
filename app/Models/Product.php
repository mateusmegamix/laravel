<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'description', 'image'];

    public function search($filter = null)
    {
        $results = $this->where(function ($query) use($filter){
            if($filter){
                $query->where('name', 'like', "%{$filter}%");
            }
        })//->toSql();
        ->paginate();

        return $results;
    }
}
