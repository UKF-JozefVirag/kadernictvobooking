<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
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
                // Initialize the array with half-hour intervals from 08:00 to 18:00, all set to 0
                for ($hour = 8; $hour <= 18; $hour++) {
                    $ordersOverTime["{$hour}:00"] = 0;
                    $ordersOverTime["{$hour}:30"] = 0;
                }

                // Fetch orders with half-hour intervals
                $orders = Order::select(DB::raw("CONCAT(HOUR(datetime_from), ':', LPAD(MINUTE(datetime_from) DIV 30 * 30, 2, '0')) AS time_interval"), DB::raw('count(*) as count'))
                    ->whereDate('datetime_from', $now->toDateString())
                    ->groupBy('time_interval')
                    ->get();

                foreach ($orders as $order) {
                    // Update the array for each time interval
                    if (isset($ordersOverTime[$order->time_interval])) {
                        $ordersOverTime[$order->time_interval] = $order->count;
                    }
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
                for ($hour = 8; $hour <= 18; $hour++) {
                    $revenueOverTime["{$hour}:00"] = 0;
                    $revenueOverTime["{$hour}:30"] = 0;
                }

                // Fetch revenues with half-hour intervals
                $revenues = Order::select(DB::raw("CONCAT(HOUR(datetime_from), ':', LPAD(MINUTE(datetime_from) DIV 30 * 30, 2, '0')) AS time_interval"), DB::raw('sum(total_price) as total'))
                    ->whereDate('datetime_from', $now->toDateString())
                    ->groupBy('time_interval')
                    ->get();

                foreach ($revenues as $revenue) {
                    // Update the array for each time interval
                    if (isset($revenueOverTime[$revenue->time_interval])) {
                        $revenueOverTime[$revenue->time_interval] = $revenue->total;
                    }
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
            ->orderBy('id', 'desc')
            ->take(20)
            ->get();
        return response()->json($latestOrders);
    }

    public function getNewCustomers(Request $request)
    {
        $now = Carbon::now();
        $range = $request->query('range', 'day');

        if ($range === '1') {
            $today = $now->toDateString();

            $customerCountsByTime = [];
            for ($hour = 0; $hour < 24; $hour++) {
                $customerCountsByTime[sprintf('%02d:00', $hour)] = 0;
                $customerCountsByTime[sprintf('%02d:30', $hour)] = 0;
            }

            $customers = Order::select(DB::raw('FLOOR(MINUTE(created_at) / 30) * 30 as minute_interval'), DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(DISTINCT customer_id) as customer_count'))
                ->whereDate('created_at', $today)
                ->whereRaw('created_at = (SELECT MIN(created_at) FROM orders o WHERE o.customer_id = orders.customer_id)')
                ->groupBy(DB::raw('FLOOR(MINUTE(created_at) / 30) * 30'), DB::raw('HOUR(created_at)'))
                ->get();

            foreach ($customers as $customer) {
                $minuteKey = sprintf('%02d:%02d', $customer->hour, $customer->minute_interval);
                if (isset($customerCountsByTime[$minuteKey])) {
                    $customerCountsByTime[$minuteKey] = $customer->customer_count;
                }
            }

            return response()->json($customerCountsByTime);
        } elseif ($range === '2') {
            $startOfWeek = $now->copy()->startOfWeek();
            $endOfWeek = $now->copy()->endOfWeek();

            $customerCountsByDayOfWeek = [];
            for ($date = $startOfWeek->copy(); $date->lte($endOfWeek); $date->addDay()) {
                $customerCountsByDayOfWeek[$date->format('Y-m-d')] = 0;
            }

            $customers = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT customer_id) as customer_count'))
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->whereRaw('created_at = (SELECT MIN(created_at) FROM orders o WHERE o.customer_id = orders.customer_id)')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            foreach ($customers as $customer) {
                $customerCountsByDayOfWeek[$customer->date] = $customer->customer_count;
            }

            return response()->json($customerCountsByDayOfWeek);
        } elseif ($range === '3') {
            $startOfMonth = $now->copy()->startOfMonth();
            $endOfMonth = $now->copy()->endOfMonth();

            $customerCountsByDate = [];
            for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
                $customerCountsByDate[$date->format('Y-m-d')] = 0;
            }

            $customers = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT customer_id) as customer_count'))
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->whereRaw('created_at = (SELECT MIN(created_at) FROM orders o WHERE o.customer_id = orders.customer_id)')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            foreach ($customers as $customer) {
                $customerCountsByDate[$customer->date] = $customer->customer_count;
            }

            return response()->json($customerCountsByDate);
        } else {
            $today = $now->toDateString();

            $customerCountsByDate = [
                $today => 0
            ];

            $customers = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT customer_id) as customer_count'))
                ->whereDate('created_at', $today)
                ->whereRaw('created_at = (SELECT MIN(created_at) FROM orders o WHERE o.customer_id = orders.customer_id)')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            foreach ($customers as $customer) {
                $customerCountsByDate[$customer->date] = $customer->customer_count;
            }

            return response()->json($customerCountsByDate);
        }
    }

    public function getMostValuableEmployees(Request $request)
    {
        $timeRange = $request->query('range', '1');
        $now = Carbon::now();
        $query = Order::select('employee_id', DB::raw('SUM(total_price) as total_revenue'));

        switch ($timeRange) {
            case '1': // Day
                $query->addSelect(DB::raw('CONCAT(LPAD(HOUR(datetime_from), 2, "0"), \':\', LPAD(IF(MINUTE(datetime_from) >= 30, 30, 0), 2, "0")) as time_unit'))
                    ->whereDate('datetime_from', $now->toDateString())
                    ->whereBetween(DB::raw('HOUR(datetime_from)'), [8, 18])
                    ->groupBy('employee_id', 'time_unit')
                    ->orderBy('employee_id')
                    ->orderBy('time_unit', 'asc');
                break;
            case '2': // Week
                $query->addSelect(DB::raw('DATE(datetime_from) as date'))
                    ->whereBetween('datetime_from', [$now->startOfWeek()->toDateTimeString(), $now->endOfWeek()->toDateTimeString()])
                    ->whereBetween(DB::raw('HOUR(datetime_from)'), [8, 18])
                    ->groupBy('employee_id', 'date')
                    ->orderBy('employee_id')
                    ->orderBy('date', 'asc');
                break;
            case '3': // Month
                $query->addSelect(DB::raw('DATE(datetime_from) as date'))
                    ->whereBetween('datetime_from', [$now->startOfMonth()->toDateTimeString(), $now->endOfMonth()->toDateTimeString()])
                    ->whereBetween(DB::raw('HOUR(datetime_from)'), [8, 18])
                    ->groupBy('employee_id', 'date')
                    ->orderBy('employee_id')
                    ->orderBy('date', 'asc');
                break;
            default:
                throw new InvalidArgumentException("Invalid time range provided.");
        }

        $results = $query->get();

        // Load all employees
        $employees = Employee::select('id', 'first_name', 'last_name')->get();

        // Initialize results array
        $formattedResults = [];
        foreach ($employees as $employee) {
            $employeeResult = [
                'employee' => $employee->first_name . ' ' . $employee->last_name,
                'times' => []
            ];

            if ($timeRange == '2') { // For weekly range
                $daysOfWeek = $this->getDaysOfWeek();
                foreach ($daysOfWeek as $day) {
                    $employeeResult['times'][$day] = 0; // Initialize revenue to 0
                }
            } elseif ($timeRange == '3') { // For monthly range
                $daysOfMonth = $this->getDaysOfMonth();
                foreach ($daysOfMonth as $day) {
                    $employeeResult['times'][$day] = 0; // Initialize revenue to 0
                }
            } else { // For day range
                foreach ($this->generateTimeIntervals() as $interval) {
                    $employeeResult['times'][$interval] = 0; // Initialize revenue to 0
                }
            }

            $formattedResults[$employee->id] = $employeeResult;
        }

        // Fill in the actual revenue from the query results
        foreach ($results as $result) {
            $employeeId = $result->employee_id;
            if (isset($formattedResults[$employeeId])) {
                if ($timeRange == '2') { // Weekly range
                    $formattedResults[$employeeId]['times'][$result->date] = $result->total_revenue;
                } elseif ($timeRange == '3') { // Monthly range
                    $formattedResults[$employeeId]['times'][$result->date] = $result->total_revenue;
                } else { // Day range
                    $formattedResults[$employeeId]['times'][$result->time_unit] = $result->total_revenue;
                }
            }
        }

        // Convert the formatted results to a simple array
        $formattedResults = array_values($formattedResults);

        return response()->json($formattedResults);
    }

    private function generateTimeIntervals()
    {
        $intervals = [];
        for ($hour = 8; $hour <= 18; $hour++) {
            $intervals[] = sprintf('%02d:00', $hour);
            if ($hour < 18) {
                $intervals[] = sprintf('%02d:30', $hour);
            }
        }
        return $intervals;
    }

    private function getDaysOfWeek()
    {
        $daysOfWeek = [];
        $startOfWeek = Carbon::now()->startOfWeek();
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i)->format('Y-m-d');
            $daysOfWeek[$day] = $day;
        }
        return $daysOfWeek;
    }

    private function getDaysOfMonth()
    {
        $daysOfMonth = [];
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $currentDate = $startOfMonth->copy();

        while ($currentDate->lte($endOfMonth)) {
            $day = $currentDate->format('Y-m-d');
            $daysOfMonth[$day] = $day;
            $currentDate->addDay();
        }

        return $daysOfMonth;
    }

    public function getTodayOrders()
    {
        $today = Carbon::today();
        $now = Carbon::now();

        $employees = Employee::with(['orders' => function ($query) use ($today) {
            $query->whereDate('datetime_from', $today);
        }])->get();

        $data = $employees->map(function ($employee) use ($now) {
            $pending = $employee->orders->filter(function ($order) use ($now) {
                return $order->datetime_from > $now;
            })->count();

            $completed = $employee->orders->filter(function ($order) use ($now) {
                return $order->datetime_from <= $now;
            })->count();

            $cancelled = $employee->orders->filter(function ($order) {
                return $order->status == 'cancelled';
            })->count();

            return [
                'employee' => $employee,
                'pending' => $pending,
                'completed' => $completed,
                'cancelled' => $cancelled,
            ];
        });

        return response()->json($data);
    }

}

