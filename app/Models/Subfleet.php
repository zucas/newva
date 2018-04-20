<?php

namespace App\Models;

/**
 * Class Subfleet
 * @package App\Models
 */
class Subfleet extends BaseModel
{
    public $table = 'subfleets';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'airline_id',
        'name',
        'type',
        'fuel_type',
        'cargo_capacity',
        'fuel_capacity',
        'gross_weight',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'airline_id' => 'integer',
        'fuel_type' => 'integer',
        'cargo_capacity' => 'double',
        'fuel_capacity' => 'double',
        'gross_weight' => 'double',
    ];

    public static $rules = [
        'name' => 'required',
        'type' => 'required',
    ];

    /**
     * Modify some fields on the fly. Make sure the subfleet
     * names don't have spaces in them.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (filled($model->type)) {
                $model->type = str_replace(' ', '_', $model->type);
            }
        });

        static::updating(function ($model) {
            if (filled($model->type)) {
                $model->type = str_replace(' ', '_', $model->type);
            }
        });
    }

    /**
     * Relationships
     */

    public function aircraft()
    {
        return $this->hasMany(Aircraft::class, 'subfleet_id');
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_id');
    }

    public function fares()
    {
        return $this->belongsToMany(Fare::class, 'subfleet_fare')
                    ->withPivot('price', 'cost', 'capacity');
    }

    public function flights()
    {
        return $this->belongsToMany(Flight::class, 'subfleet_flight');
    }

    public function ranks()
    {
        return $this->belongsToMany(Rank::class, 'subfleet_rank')
                    ->withPivot('acars_pay', 'manual_pay');
    }
}
