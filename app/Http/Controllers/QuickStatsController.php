<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class QuickStatsController extends Controller
{
    public function getOrders(Request $request)
    {
        $timeRange = $request->query('range', 'day');
        $ordersCount = $this->getOrdersCount($timeRange);
        $ordersOverTime = $this->getOrdersOverTime($timeRange);

        return response()->json([
            'title' => 'Orders',
            'value' => $ordersCount,
            'color' => 'green',
            'sparklineColor' => 'success',
            'data' => $ordersOverTime,
        ]);
    }

    private function getOrdersCount($timeRange)
    {
        $query = Order::query();
        $query = $this->applyDateRangeFilter($query, $timeRange);
        return $query->count();
    }

    private function getOrdersOverTime($timeRange)
    {
        $now = Carbon::now();
        $ordersOverTime = [];

        switch ($timeRange) {
            case '1':
            case 'day':
                $orders = Order::select(DB::raw('HOUR(datetime_from) as hour'), DB::raw('count(*) as count'))
                    ->whereDate('datetime_from', $now->toDateString())
                    ->groupBy('hour')
                    ->get();
                foreach ($orders as $order) {
                    $ordersOverTime[$order->hour] = $order->count;
                }
                break;
            case '2':
            case 'week':
                $orders = Order::select(DB::raw('DATE(datetime_from) as date'), DB::raw('count(*) as count'))
                    ->whereBetween('datetime_from', [$now->startOfWeek()->toDateTimeString(), $now->endOfWeek()->toDateTimeString()])
                    ->groupBy('date')
                    ->get();
                foreach ($orders as $order) {
                    $ordersOverTime[$order->date] = $order->count;
                }
                break;
            case '3':
            case 'month':
                $orders = Order::select(DB::raw('DATE(datetime_from) as date'), DB::raw('count(*) as count'))
                    ->whereBetween('datetime_from', [$now->startOfMonth()->toDateTimeString(), $now->endOfMonth()->toDateTimeString()])
                    ->groupBy('date')
                    ->get();
                foreach ($orders as $order) {
                    $ordersOverTime[$order->date] = $order->count;
                }
                break;
        }

        return $ordersOverTime;
    }

    public function getRevenue(Request $request)
    {
        $timeRange = $request->query('range', 'day');
        $revenue = $this->getRevenueAmount($timeRange);
        $revenueOverTime = $this->getRevenueOverTime($timeRange);

        return response()->json([
            'title' => 'Revenue',
            'value' => $revenue,
            'color' => 'blue',
            'sparklineColor' => 'info',
            'data' => $revenueOverTime,
        ]);
    }

    private function getRevenueOverTime($timeRange)
    {
        $now = Carbon::now();
        $revenueOverTime = [];

        switch ($timeRange) {
            case '1':
            case 'day':
                $revenues = Order::select(DB::raw('HOUR(datetime_from) as hour'), DB::raw('sum(total_price) as total'))
                    ->whereDate('datetime_from', $now->toDateString())
                    ->groupBy('hour')
                    ->get();
                foreach ($revenues as $revenue) {
                    $revenueOverTime[$revenue->hour] = $revenue->total;
                }
                break;
            case '2':
            case 'week':
                $revenues = Order::select(DB::raw('DATE(datetime_from) as date'), DB::raw('sum(total_price) as total'))
                    ->whereBetween('datetime_from', [$now->startOfWeek()->toDateTimeString(), $now->endOfWeek()->toDateTimeString()])
                    ->groupBy('date')
                    ->get();
                foreach ($revenues as $revenue) {
                    $revenueOverTime[$revenue->date] = $revenue->total;
                }
                break;
            case '3':
            case 'month':
                $revenues = Order::select(DB::raw('DATE(datetime_from) as date'), DB::raw('sum(total_price) as total'))
                    ->whereBetween('datetime_from', [$now->startOfMonth()->toDateTimeString(), $now->endOfMonth()->toDateTimeString()])
                    ->groupBy('date')
                    ->get();
                foreach ($revenues as $revenue) {
                    $revenueOverTime[$revenue->date] = $revenue->total;
                }
                break;
        }

        return $revenueOverTime;
    }

    private function getRevenueAmount($timeRange)
    {
        $query = Order::query();
        $query = $this->applyDateRangeFilter($query, $timeRange);
        return $query->sum('total_price');
    }

    public function getEmployeeRevenue(Request $request)
    {
        $timeRange = $request->query('range', '1'); // Default to '1' (day)
        $revenueOverTime = $this->getEmployeeRevenueOverTime($timeRange);

        return response()->json([
            'title' => 'Employee Revenue',
            'data' => $revenueOverTime,
        ]);
    }

    private function getEmployeeRevenueOverTime($timeRange)
    {
        $now = Carbon::now();
        $revenueOverTime = [];

        switch ($timeRange) {
            case '1': // Day
                $revenues = Order::select('employee_id', DB::raw('HOUR(datetime_from) as hour'), DB::raw('SUM(total_price) as total_revenue'))
                    ->whereDate('datetime_from', $now->toDateString())
                    ->groupBy('employee_id', 'hour')
                    ->orderBy('employee_id')
                    ->orderBy('hour')
                    ->get();
                foreach ($revenues as $revenue) {
                    $revenueOverTime[] = [
                        'employee_id' => $revenue->employee_id,
                        'hour' => $revenue->hour,
                        'total_revenue' => $revenue->total_revenue,
                    ];
                }
                break;

            case '2': // Week
                $revenues = Order::select('employee_id', DB::raw('DATE(datetime_from) as date'), DB::raw('SUM(total_price) as total_revenue'))
                    ->whereBetween('datetime_from', [$now->startOfWeek()->toDateTimeString(), $now->endOfWeek()->toDateTimeString()])
                    ->groupBy('employee_id', 'date')
                    ->orderBy('employee_id')
                    ->orderBy('date')
                    ->get();
                foreach ($revenues as $revenue) {
                    $revenueOverTime[] = [
                        'employee_id' => $revenue->employee_id,
                        'date' => $revenue->date,
                        'total_revenue' => $revenue->total_revenue,
                    ];
                }
                break;

            case '3': // Month
                $revenues = Order::select('employee_id', DB::raw('DATE(datetime_from) as date'), DB::raw('SUM(total_price) as total_revenue'))
                    ->whereBetween('datetime_from', [$now->startOfMonth()->toDateTimeString(), $now->endOfMonth()->toDateTimeString()])
                    ->groupBy('employee_id', 'date')
                    ->orderBy('employee_id')
                    ->orderBy('date')
                    ->get();
                foreach ($revenues as $revenue) {
                    $revenueOverTime[] = [
                        'employee_id' => $revenue->employee_id,
                        'date' => $revenue->date,
                        'total_revenue' => $revenue->total_revenue,
                    ];
                }
                break;

            default:
                throw new InvalidArgumentException("Invalid time range provided.");
        }

        return $revenueOverTime;
    }

    private function applyDateRangeFilter($query, $timeRange)
    {
        $now = Carbon::now();
        switch ($timeRange) {
            case '1':
            case 'day':
                return $query->whereDate('datetime_from', $now->toDateString());
            case '2':
            case 'week':
                return $query->whereBetween('datetime_from', [$now->startOfWeek()->toDateTimeString(), $now->endOfWeek()->toDateTimeString()]);
            case '3':
            case 'month':
                return $query->whereBetween('datetime_from', [$now->startOfMonth()->toDateTimeString(), $now->endOfMonth()->toDateTimeLocalString()]);
            default:
                return $query;
        }
    }

    public function getLatestOrders()
    {
        $latestOrders = Order::with('employee', 'services')
            ->orderBy('datetime_from', 'desc')
            ->take(20)
            ->get();

        return response()->json($latestOrders);
    }

    public function getMostValuableEmployees($timeRange)
    {
        $now = Carbon::now();
        $query = Order::select('employee_id',
                               DB::raw('sum(total_price) as total_revenue'));

        switch ($timeRange) {
            case '1': // Day
                $query->addSelect(DB::raw('HOUR(datetime_from) as time_unit'))
                      ->whereDate('datetime_from', $now->toDateString());
                break;
            case '2': // Week
                $query->addSelect(DB::raw('DATE(datetime_from) as time_unit'))
                      ->whereBetween('datetime_from', [$now->startOfWeek()->toDateTimeString(), $now->endOfWeek()->toDateTimeString()]);
                break;
            case '3': // Month
                $query->addSelect(DB::raw('DATE(datetime_from) as time_unit'))
                      ->whereBetween('datetime_from', [$now->startOfMonth()->toDateTimeString(), $now->endOfMonth()->toDateTimeString()]);
                break;
            default:
                throw new InvalidArgumentException("Invalid time range provided.");
        }

        $query->groupBy('employee_id', 'time_unit')
              ->orderBy('total_revenue', 'desc');

        $results = $query->get();

        return response()->json($results);
    }

}

