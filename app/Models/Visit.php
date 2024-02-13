<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'visits';

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
        'visit_date',
        'nurse_id',
        'patient_id'
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
        'visit_created_at'=>'datetime:d/m/Y H:i',
        'visit_date'=>'datetime:d/m/Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'visit_created_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Get nurse relationship
     * @return BelongsTo
     */
    public function nurse():BelongsTo
    {
        return $this->belongsTo(Nurse::class, foreignKey: "nurse_id");
    }



    /**
     * Get patient relationship
     * @return BelongsTo
     */
    public function patient():BelongsTo
    {
        return $this->belongsTo(Patient::class, foreignKey: "patient_id");
    }

    /**
     * Get Treatments
     * @return HasMany
    */
    public function treatments():HasMany
    {
        return $this->hasMany(PatientTreatment::class, foreignKey: 'visit_id', localKey: 'id');
    }
}
