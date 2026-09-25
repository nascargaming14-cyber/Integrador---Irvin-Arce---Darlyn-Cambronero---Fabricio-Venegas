<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @method static void created(\Closure|string $callback)
 * @method static void updated(\Closure|string $callback)
 * @method static void deleted(\Closure|string $callback)
 */
trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            $model->recordAudit('creado', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            unset($changes['updated_at']);

            if (empty($changes)) {
                return;
            }

            $original = array_intersect_key($model->getOriginal(), $changes);

            $model->recordAudit('editado', $original, $changes);
        });

        static::deleted(function ($model) {
            $model->recordAudit('eliminado', $model->getAttributes(), null);
        });
    }

    public function recordAudit(string $action, ?array $before, ?array $after): void
    {
        $exclude = array_merge(
            ['password', 'remember_token', 'created_at', 'updated_at'],
            property_exists($this, 'auditExclude') ? $this->auditExclude : []
        );

        if ($before) {
            $before = collect($before)->except($exclude)->toArray();
        }

        if ($after) {
            $after = collect($after)->except($exclude)->toArray();
        }

        AuditLog::create([
            'user_id'        => Auth::id(),
            'module'         => $this->auditModule ?? $this->getTable(),
            'auditable_type' => static::class,
            'auditable_id'   => $this->getKey(),
            'record_label'   => $this->auditLabel(),
            'action'         => $action,
            'before'         => $before ?: null,
            'after'          => $after ?: null,
        ]);
    }

    /**
     * Busca un campo "nombre" común para mostrarlo en el historial.
     * Agrega aquí el campo de tu modelo si no aparece en la lista.
     */
    public function auditLabel(): string
    {
        $candidates = [
            'product_name', 'user_name', 'role_name', 'status_name',
            'category_name', 'sub_category_name', 'unit_name',
            'supplier_name', 'customer_name', 'name',
        ];

        foreach ($candidates as $field) {
            $value = $this->getAttributes()[$field] ?? null;
            if ($value !== null && $value !== '') {
                return (string) $value;
            }
        }

        return '#' . $this->getKey();
    }
}
