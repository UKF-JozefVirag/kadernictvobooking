<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $customerIds = Customer::pluck('id')->all();
        $employeeIds = Employee::pluck('id')->all();
        $serviceIds = Service::pluck('id')->all();

        $batchSize = 100;
        $orders = [];
        $orderServices = [];
        $year = 2024;

        for ($i = 0; $i < 1500; $i++) {
            $employeeId = $faker->randomElement($employeeIds);

            $datetimeFrom = $faker->dateTimeBetween("{$year}-01-01 08:00:00", "{$year}-12-31 18:00:00");
            $hour = $datetimeFrom->format('H');
            $minute = $datetimeFrom->format('i');

            if ($minute < 30) {
                $datetimeFrom->setTime($hour, 30);
            } else {
                $datetimeFrom->setTime($hour + 1, 0);
            }

            $datetimeTo = (clone $datetimeFrom)->modify('+' . rand(1, 8) . ' hours');
            if ($datetimeTo->format('H') > 18 || ($datetimeTo->format('H') == 18 && $datetimeTo->format('i') > 0)) {
                $datetimeTo->setTime(18, 0);
            }

            // Náhodne vyberieme 1 až 3 služby
            $numServices = rand(1, 3);
            $selectedServiceIds = $faker->randomElements($serviceIds, $numServices);

            // Vypočítať celkovú cenu vybraných služieb
            $totalPrice = Service::whereIn('id', $selectedServiceIds)->sum('price');

            $orders[] = [
                'datetime_from' => $datetimeFrom,
                'datetime_to' => $datetimeTo,
                'total_price' => $totalPrice,
                'employee_id' => $employeeId,
                'customer_id' => $faker->randomElement($customerIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $orderServices[] = $selectedServiceIds;
        }

        // Vloženie objednávok a ich ID
        DB::table('orders')->insert($orders);
        $orderIds = DB::table('orders')->orderBy('id', 'desc')->take(count($orders))->pluck('id')->reverse()->values();

        // Priradenie správnych `order_id` k službám
        $orderServiceData = [];
        foreach ($orderIds as $index => $orderId) {
            foreach ($orderServices[$index] as $serviceId) {
                $orderServiceData[] = [
                    'order_id' => $orderId,
                    'service_id' => $serviceId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        DB::table('order_has_service')->insert($orderServiceData);
    }
}
