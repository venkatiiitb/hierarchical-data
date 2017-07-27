<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tree';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lft', 'rgt',
    ];

}
