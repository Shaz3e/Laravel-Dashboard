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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('ticket_status_id')->constrained();
            $table->foreignId('support_ticket_priority_id')->constrained();
            $table->string('title');
            $table->longText('message');
            $table->text('attachments')->nullable();
            $table->integer('assigned_to')->nullable();
            $table->boolean('is_locked')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
