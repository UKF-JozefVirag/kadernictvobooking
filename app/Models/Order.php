<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'datetime_from',
        'datetime_to',
        'employee_id',
        'total_price',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'order_has_service', 'order_id', 'service_id')
            ->withTimestamps();
    }
}
