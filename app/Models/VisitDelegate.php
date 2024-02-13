<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisitDelegate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'visit_delegates';

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
        'delegate_nurse_id',
        'visit_id',
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
        'visit_delegate_created_at'=>'datetime:d/m/Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'visit_delegate_created_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Get Visit RelationShip
     * @return BelongsTo
     */
    public function visit():BelongsTo
    {
        return $this->belongsTo(Visit::class, foreignKey: "visit_id");
    }


    /**
     * Get Nurse RelationShip
     * @return BelongsTo
     */
    public function nurse_delegate():BelongsTo
    {
        return $this->belongsTo(Nurse::class, foreignKey: "delegate_nurse_id");
    }


    /**
     * Get patients List By Doctor
     * @return HasMany
    */
    public function patients():HasMany
    {
        return $this->hasMany(Patient::class, foreignKey: 'doctor_id', localKey: 'id');
    }
}
