<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_punches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->enum('punch_type', ['entrada', 'saida', 'pausa_inicio', 'pausa_fim']);

            $table->timestamp('recorded_at')->useCurrent();

            $table->double('lat', 10, 7);
            $table->double('lng', 10, 7);

            $table->decimal('accuracy_m', 8, 2)->nullable();
            $table->text('formatted_address')->nullable();
            $table->string('google_place_id', 255)->nullable();
            $table->json('raw_api_response')->nullable();
            $table->string('ip_address', 45)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_punches');
    }
};
