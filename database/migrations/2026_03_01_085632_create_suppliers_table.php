<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code')->unique();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('mobile')->unique()->index();
            $table->string('email')->nullable();
            $table->string('gst_number')->nullable()->index();
            $table->string('pan_number')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->index();

            // Financial Fields
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->integer('payment_terms')->default(0); // in days
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->string('balance_type')->default('cr'); // dr or cr
            $table->decimal('current_outstanding', 15, 2)->default(0);

            // Bank Details
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('upi_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
