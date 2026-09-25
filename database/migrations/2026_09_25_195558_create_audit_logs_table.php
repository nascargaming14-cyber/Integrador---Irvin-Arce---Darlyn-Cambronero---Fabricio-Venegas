<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // Quién hizo el cambio. nullOnDelete: si se borra el usuario,
            // el registro del historial se conserva (queda user_id = null).
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Módulo afectado, ej: 'products', 'categories', 'users'
            $table->string('module', 60)->index();

            // Clase completa del modelo y su id, ej: App\Models\Product / 15
            $table->string('auditable_type');
            $table->unsignedBigInteger('auditable_id')->nullable();

            // Texto legible del registro afectado, ej: "Césped Amarillo"
            $table->string('record_label')->nullable();

            // creado | editado | eliminado
            $table->string('action', 20)->index();

            // Valores antes/después de los campos que cambiaron (solo en 'editado'
            // y 'eliminado' antes trae el registro completo)
            $table->json('before')->nullable();
            $table->json('after')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['auditable_type', 'auditable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
