<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Traits\HasRoles;

class Menu extends Model
{

    use HasRoles;

    protected $guard_name = 'web';
    
    protected $fillable = [ 'parent_id', 'name', 'slug', 'icon', 'is_active', 'order_no' ];

    protected $casts = [ 'is_active' ];

    public function children()
    {
        return $this->hasMany('App\Menu', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Menu', 'parent_id', 'id');
    }

}
