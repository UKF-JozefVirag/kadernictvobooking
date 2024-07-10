<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


    public function getNewCustomers(Request $request)
    {
        $timeRange = $request->query('range', 'day');
        $newCustomersOverTime = $this->getNewCustomersOverTime($timeRange);

        return response()->json([
            'title' => 'New Customers',
            'value' => $newCustomersOverTime,
            'color' => 'blue',
            'sparklineColor' => 'info',
        ]);
    }

    private function getNewCustomersOverTime($timeRange)
    {
        $now = Carbon::now();
        $newCustomersOverTime = [];

        $startDate = $this->getStartDate($timeRange, $now);
        $endDate = $this->getEndDate($timeRange, $now);

        switch ($timeRange) {
            case '1':
            case 'day':
                $customers = Order::select(DB::raw('HOUR(datetime_from) as hour'), DB::raw('count(distinct customer_email) as count'))
                    ->whereBetween('datetime_from', [$startDate, $endDate])
                    ->whereNotIn('customer_email', function($query) use ($startDate) {
                        $query->select('customer_email')
                            ->from('orders')
                            ->where('datetime_from', '<', $startDate);
                    })
                    ->groupBy('hour')
                    ->get();
                foreach ($customers as $customer) {
                    $newCustomersOverTime[$customer->hour] = $customer->count;
                }
                break;
            case '2':
            case 'week':
                $customers = Order::select(DB::raw('DATE(datetime_from) as date'), DB::raw('count(distinct customer_email) as count'))
                    ->whereBetween('datetime_from', [$startDate, $endDate])
                    ->whereNotIn('customer_email', function($query) use ($startDate) {
                        $query->select('customer_email')
                            ->from('orders')
                            ->where('datetime_from', '<', $startDate);
                    })
                    ->groupBy('date')
                    ->get();
                foreach ($customers as $customer) {
                    $newCustomersOverTime[$customer->date] = $customer->count;
                }
                break;
            case '3':
            case 'month':
                $customers = Order::select(DB::raw('DATE(datetime_from) as date'), DB::raw('count(distinct customer_email) as count'))
                    ->whereBetween('datetime_from', [$startDate, $endDate])
                    ->whereNotIn('customer_email', function($query) use ($startDate) {
                        $query->select('customer_email')
                            ->from('orders')
                            ->where('datetime_from', '<', $startDate);
                    })
                    ->groupBy('date')
                    ->get();
                foreach ($customers as $customer) {
                    $newCustomersOverTime[$customer->date] = $customer->count;
                }
                break;
        }

        return $newCustomersOverTime;
    }

    private function getStartDate($timeRange, $now)
    {
        switch ($timeRange) {
            case '1':
            case 'day':
                return $now->startOfDay();
            case '2':
            case 'week':
                return $now->startOfWeek();
            case '3':
            case 'month':
                return $now->startOfMonth();
            default:
                return $now->startOfDay();
        }
    }

    private function getEndDate($timeRange, $now)
    {
        switch ($timeRange) {
            case '1':
            case 'day':
                return $now->endOfDay();
            case '2':
            case 'week':
                return $now->endOfWeek();
            case '3':
            case 'month':
                return $now->endOfMonth();
            default:
                return $now->endOfDay();
        }
    }

    public function getCustomerRetention(Request $request)
    {
        $timeRange = $request->query('range', 'day');
        $retentionRate = $this->getCustomerRetentionRate($timeRange);

        return response()->json([
            'title' => 'Customer Retention',
            'value' => $retentionRate,
            'color' => 'orange',
            'sparklineColor' => 'warning',
        ]);
    }

    private function getRevenueAmount($timeRange)
    {
        $query = Order::query();
        $query = $this->applyDateRangeFilter($query, $timeRange);
        return $query->sum('total_price');
    }

    private function getCustomerRetentionRate($timeRange)
    {
        $totalCustomersQuery = Order::query();
        $totalCustomersQuery = $this->applyDateRangeFilter($totalCustomersQuery, $timeRange);
        $totalCustomers = $totalCustomersQuery->distinct('customer_id')->count('customer_id');

        $retainedCustomersQuery = Order::query()
            ->select('customer_id', DB::raw('count(*) as order_count'))
            ->groupBy('customer_id')
            ->having('order_count', '>', 1);
        $retainedCustomersQuery = $this->applyDateRangeFilter($retainedCustomersQuery, $timeRange);
        $retainedCustomers = $retainedCustomersQuery->distinct('customer_id')->count('customer_id');

        return $totalCustomers > 0 ? ($retainedCustomers / $totalCustomers) * 100 : 0;
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

}
