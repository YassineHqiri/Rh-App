<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->date('contract_end_date')->nullable()->after('hire_date');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->text('address')->nullable()->after('phone');
            $table->string('emergency_contact', 100)->nullable()->after('status');
            $table->string('emergency_phone', 20)->nullable()->after('emergency_contact');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['contract_end_date', 'date_of_birth', 'address', 'emergency_contact', 'emergency_phone']);
        });
    }
};
