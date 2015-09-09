<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'games';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'original_release_date', 'small_image'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The users that belong to the game.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * The platforms which game is released on
     */
    public function platforms()
    {
        return $this->belongsToMany('App\Platform');
    }
}
