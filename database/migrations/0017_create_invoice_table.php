<?php

use App\Models\BillingInfo;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Payment;
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
        Schema::create(Invoice::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->foreignId(Booking::getFK())->constrained(Booking::getTableName());
            $table->foreignId(Payment::getFK())->constrained(Payment::getTableName());
            $table->foreignId(BillingInfo::getFK())->constrained(BillingInfo::getTableName());
            $table->decimal('amount', 10, 2);
            $table->date('issued_at')->nullable();
            $table->date('due_at')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\InvoiceStatus::DRAFT);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Invoice::getTableName());
    }
};
