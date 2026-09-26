<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendar_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crew_id')->constrained('crews')->cascadeOnDelete();
            $table->date('work_date');

            // Datos del trabajo (lo que se ve en el detalle de la pizarra)
            $table->string('client_name');
            $table->string('location')->nullable();          // Ej: "Sarchí", "Alajuela"
            $table->decimal('area_m2', 8, 2)->nullable();     // Ej: 25.00
            $table->string('material_type')->nullable();      // Ej: "Base", "Cemento", "Adoquín"
            $table->text('notes')->nullable();

            // Estado del trabajo: null = pendiente, true = completado, false = no completado
            $table->boolean('completed')->nullable();

            // Confirmación (cuadro verde de "CONFIRMACIÓN")
            $table->boolean('confirmed')->default(false);
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();

            $table->timestamps();

            // Una cuadrilla no puede tener dos trabajos el mismo día
            $table->unique(['crew_id', 'work_date']);
            $table->index('work_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendar_jobs');
    }
};
