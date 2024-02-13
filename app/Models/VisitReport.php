<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitReport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'visit_reports';

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
        'visit_id',
        'nurse_id',
        'doctor_id'
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
        'report_created_at'=>'datetime:d/m/Y H:i',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'report_created_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Get Nurse
     * @return BelongsTo
    */
    public function nurse():BelongsTo
    {
        return $this->belongsTo(Nurse::class, foreignKey: 'nurse_id');
    }


    /**
     * Get Visit
     * @return BelongsTo
    */
    public function visit():BelongsTo
    {
        return $this->belongsTo(Visit::class, foreignKey: 'visit_id');
    }
}
