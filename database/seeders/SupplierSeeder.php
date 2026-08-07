<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\SupplierRepository;

class SupplierSeeder extends Seeder
{
    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Patel Enterprise',
                'contact_person' => 'Rajesh Patel',
                'mobile' => '9876543210',
                'email' => 'rajesh.patel@example.com',
                'gst_number' => '24ABCDE1234F1Z5',
                'pan_number' => 'ABCDE1234F',
                'address' => 'Sarkhej-Gandhinagar Hwy, Vastrapur',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380015',
                'credit_limit' => 500000.00,
                'payment_terms' => 30,
                'opening_balance' => 15000.00,
                'balance_type' => 'cr',
                'status' => 'active',
                'bank_name' => 'State Bank of India',
                'account_number' => '123456789012',
                'ifsc_code' => 'SBIN0001234',
                'upi_id' => 'patel.ent@okaxis'
            ],
            [
                'name' => 'Surat Textiles Hub',
                'contact_person' => 'Sameer Shah',
                'mobile' => '9988776655',
                'email' => 'sameer.shah@example.com',
                'gst_number' => '24FGHIJ5678K2Z6',
                'pan_number' => 'FGHIJ5678K',
                'address' => 'Ring Road, Ring Road Textile Market',
                'city' => 'Surat',
                'state' => 'Gujarat',
                'pincode' => '395003',
                'credit_limit' => 1000000.00,
                'payment_terms' => 45,
                'opening_balance' => 50000.00,
                'balance_type' => 'cr',
                'status' => 'active',
                'bank_name' => 'HDFC Bank',
                'account_number' => '987654321098',
                'ifsc_code' => 'HDFC0000123',
                'upi_id' => 'surat.textiles@okhdfc'
            ],
            [
                'name' => 'Rajkot Machinery Parts',
                'contact_person' => 'Kiran Mehta',
                'mobile' => '9123456789',
                'email' => 'kiran.mehta@example.com',
                'gst_number' => '24KLMNO9012P3Z7',
                'pan_number' => 'KLMNO9012P',
                'address' => 'Aji Industrial Area, GIDC',
                'city' => 'Rajkot',
                'state' => 'Gujarat',
                'pincode' => '360003',
                'credit_limit' => 250000.00,
                'payment_terms' => 15,
                'opening_balance' => 5000.00,
                'balance_type' => 'dr',
                'status' => 'active',
                'bank_name' => 'Bank of Baroda',
                'account_number' => '456789012345',
                'ifsc_code' => 'BARB0VADRAJ',
                'upi_id' => 'rajkot.mach@okicici'
            ],
            [
                'name' => 'Vadodara Chemical Traders',
                'contact_person' => 'Amit Desai',
                'mobile' => '8877665544',
                'email' => 'amit.desai@example.com',
                'gst_number' => '24PQRST3456Q4Z8',
                'pan_number' => 'PQRST3456Q',
                'address' => 'GIDC Makarpura',
                'city' => 'Vadodara',
                'state' => 'Gujarat',
                'pincode' => '390010',
                'credit_limit' => 750000.00,
                'payment_terms' => 30,
                'opening_balance' => 0.00,
                'balance_type' => 'cr',
                'status' => 'active',
                'bank_name' => 'ICICI Bank',
                'account_number' => '321098765432',
                'ifsc_code' => 'ICIC0001122',
                'upi_id' => 'vad.chem@okaxis'
            ],
            [
                'name' => 'Bhavnagar Logistics',
                'contact_person' => 'Suresh Joshi',
                'mobile' => '7766554433',
                'email' => 'suresh.joshi@example.com',
                'gst_number' => '24UVWXY7890R5Z9',
                'pan_number' => 'UVWXY7890R',
                'address' => 'Phulchhab Chowk, Near Railway Station',
                'city' => 'Bhavnagar',
                'state' => 'Gujarat',
                'pincode' => '364001',
                'credit_limit' => 300000.00,
                'payment_terms' => 20,
                'opening_balance' => 2500.00,
                'balance_type' => 'cr',
                'status' => 'inactive',
                'bank_name' => 'Punjab National Bank',
                'account_number' => '654321098765',
                'ifsc_code' => 'PUNB0123456',
                'upi_id' => 'bhav.logist@okpnb'
            ]
        ];

        foreach ($suppliers as $supplierData) {
            $existing = \App\Models\Supplier::where('mobile', $supplierData['mobile'])->first();
            if (!$existing) {
                $this->supplierRepository->store($supplierData);
            }
        }
    }
}
