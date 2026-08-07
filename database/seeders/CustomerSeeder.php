<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerLedger;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Royal Auto Garage',
                'mobile' => '9887766551',
                'email' => 'contact@royalauto.com',
                'gst_number' => '24AAAAA0001A1Z1',
                'address' => 'Near Highway, Main Road',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380001',
                'credit_limit' => 50000.00,
                'opening_balance' => 5000.00,
                'balance_type' => 'dr',
                'status' => 'active'
            ],
            [
                'name' => 'Swift Transport Services',
                'mobile' => '9887766552',
                'email' => 'info@swifttransport.com',
                'gst_number' => '24BBBBB0002B2Z2',
                'address' => 'Sector 5, Transport Nagar',
                'city' => 'Surat',
                'state' => 'Gujarat',
                'pincode' => '395001',
                'credit_limit' => 100000.00,
                'opening_balance' => 0.00,
                'balance_type' => 'dr',
                'status' => 'active'
            ],
            [
                'name' => 'Precision Motors',
                'mobile' => '9887766553',
                'email' => 'service@precisionmotors.in',
                'gst_number' => '24CCCCC0003C3Z3',
                'address' => 'Opposite Garden, Rajkot Road',
                'city' => 'Rajkot',
                'state' => 'Gujarat',
                'pincode' => '360001',
                'credit_limit' => 30000.00,
                'opening_balance' => 2500.00,
                'balance_type' => 'cr',
                'status' => 'active'
            ],
            [
                'name' => 'Globe Lubricants & Spares',
                'mobile' => '9887766554',
                'email' => 'sales@globelubricants.com',
                'gst_number' => '24DDDDD0004D4Z4',
                'address' => 'B-24, Industrial Estate',
                'city' => 'Vadodara',
                'state' => 'Gujarat',
                'pincode' => '390001',
                'credit_limit' => 75000.00,
                'opening_balance' => 12000.00,
                'balance_type' => 'dr',
                'status' => 'active'
            ],
            [
                'name' => 'Highway Express Workshop',
                'mobile' => '9887766555',
                'email' => 'highwayexpress@gmail.com',
                'gst_number' => null,
                'address' => 'NH-8, Bypass Junction',
                'city' => 'Anand',
                'state' => 'Gujarat',
                'pincode' => '388001',
                'credit_limit' => 20000.00,
                'opening_balance' => 0.00,
                'balance_type' => 'dr',
                'status' => 'active'
            ],
            [
                'name' => 'Elite Car Care',
                'mobile' => '9887766556',
                'email' => 'care@elitecars.com',
                'gst_number' => '24EEEEE0005E5Z5',
                'address' => 'Plot 112, GIDC Phase II',
                'city' => 'Vapi',
                'state' => 'Gujarat',
                'pincode' => '396191',
                'credit_limit' => 40000.00,
                'opening_balance' => 750.00,
                'balance_type' => 'dr',
                'status' => 'active'
            ],
            [
                'name' => 'Mahadev Earthmovers',
                'mobile' => '9887766557',
                'email' => 'mahadevearth@yahoo.com',
                'gst_number' => null,
                'address' => 'Station Road',
                'city' => 'Bhavnagar',
                'state' => 'Gujarat',
                'pincode' => '364001',
                'credit_limit' => 150000.00,
                'opening_balance' => 25000.00,
                'balance_type' => 'dr',
                'status' => 'active'
            ],
            [
                'name' => 'Super Sonic Service Center',
                'mobile' => '9887766558',
                'email' => 'supersonic@outlook.com',
                'gst_number' => '24FFFFF0006F6Z6',
                'address' => 'Link Road, Near Flyover',
                'city' => 'Bharuch',
                'state' => 'Gujarat',
                'pincode' => '392001',
                'credit_limit' => 25000.00,
                'opening_balance' => 3200.00,
                'balance_type' => 'cr',
                'status' => 'inactive'
            ],
            [
                'name' => 'Shreeji Oil & Filters',
                'mobile' => '9887766559',
                'email' => 'shreejioil@gmail.com',
                'gst_number' => null,
                'address' => 'Old Market Yard',
                'city' => 'Jamnagar',
                'state' => 'Gujarat',
                'pincode' => '361001',
                'credit_limit' => 50000.00,
                'opening_balance' => 0.00,
                'balance_type' => 'dr',
                'status' => 'active'
            ],
            [
                'name' => 'Navrang Auto Spares',
                'mobile' => '9887766550',
                'email' => 'navrangauto@gmail.com',
                'gst_number' => '24GGGGG0007G7Z7',
                'address' => 'Ring Road Circle',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380015',
                'credit_limit' => 100000.00,
                'opening_balance' => 18000.00,
                'balance_type' => 'dr',
                'status' => 'active'
            ]
        ];

        foreach ($customers as $custData) {
            DB::transaction(function () use ($custData) {
                // Determine current outstanding based on opening balance
                $opening_bal = $custData['opening_balance'];
                $bal_type = $custData['balance_type'];
                
                $debit = $bal_type === 'dr' ? $opening_bal : 0;
                $credit = $bal_type === 'cr' ? $opening_bal : 0;
                $current_outstanding = $debit - $credit;

                $custData['current_outstanding'] = $current_outstanding;

                $customer = Customer::updateOrCreate(
                    ['mobile' => $custData['mobile']],
                    $custData
                );

                if ($opening_bal > 0) {
                    CustomerLedger::updateOrCreate(
                        [
                            'customer_id' => $customer->id,
                            'transaction_type' => 'opening_balance',
                        ],
                        [
                            'transaction_date' => now(),
                            'debit' => $debit,
                            'credit' => $credit,
                            'balance' => $current_outstanding,
                            'description' => 'Opening Balance (Seeded)'
                        ]
                    );
                }
            });
        }
    }
}
