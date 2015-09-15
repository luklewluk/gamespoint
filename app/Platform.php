<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'platforms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The platforms which game is released on
     */
    public function games()
    {
        return $this->belongsToMany('App\Game');
    }
}
