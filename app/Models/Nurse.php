<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Nurse extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nurses';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nurse_fullname',
        'nurse_phone',
        'doctor_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nurse_created_at'=>'datetime:d/m/Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'nurse_created_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Get nurses list by Doctor
     * @return BelongsTo
     */
    public function doctor():BelongsTo
    {
        return $this->belongsTo(Doctor::class, foreignKey: "doctor_id");
    }

    /**
     * Get User profile
     * @return MorphOne
     */
    public function user():MorphOne
    {
        return $this->morphOne(User::class, 'profile');
    }


    /**
     * Get all Visit
     * @return HasMany
    */
    public function visits():HasMany
    {
        return $this->hasMany(Visit::class, foreignKey: 'nurse_id');
    }
}
