<?php

use Carbon\Carbon;
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
        Schema::create('users', function (Blueprint $table) {

            // Primary
            $table->id();
            $table->string('name');
            $table->enum('role', ['admin', 'librarian', 'member'])->default('member');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('password');

            // Account/Legality
            $table->boolean('is_phone_verified')->default(false);
            $table->string('member_status')->nullable()->default('new');
            $table->enum('status_account', ['active', 'inactive', 'suspended'])->default('active');
            $table->date('expired_date')->nullable();

            // Profile/Biodata
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('birth_date')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable()->unique();
            $table->string('address')->nullable();
            $table->string('regency')->nullable();
            $table->string('province')->nullable();
            $table->string('jobs')->nullable();
            $table->string('education')->nullable();
            $table->string('class_department')->nullable();
            $table->string('profile_picture')->nullable();

            // Others
            $table->rememberToken();
            $table->timestamps();
            $table->date('email_verified_at')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
