<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

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

    public static function countUniqueCustomersByTimeRange($timeRange)
    {
        $date = Carbon::now();

        switch ($timeRange) {
            case '1':
            case 'day':
                $startDate = $date->copy()->startOfDay();
                break;
            case '2':
            case 'week':
                $startDate = $date->copy()->startOfWeek();
                break;
            case '3':
            case 'month':
                $startDate = $date->copy()->startOfMonth();
                break;
            default:
                throw new InvalidArgumentException("Invalid time range provided.");
        }

        $endDate = $date->copy()->endOfDay();

        return DB::table('orders')
            ->select('customer_id')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('customer_id')
            ->havingRaw('COUNT(*) = 1')
            ->count();
    }

    public function employees(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'order_has_service', 'order_id', 'service_id')
            ->withTimestamps();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
