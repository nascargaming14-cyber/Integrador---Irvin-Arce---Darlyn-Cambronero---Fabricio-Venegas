<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false; // solo usamos created_at

    protected $fillable = [
        'user_id',
        'module',
        'auditable_type',
        'auditable_id',
        'record_label',
        'action',
        'before',
        'after',
    ];

    protected function casts(): array
    {
        return [
            'before'     => 'array',
            'after'      => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Nombre "bonito" del módulo para mostrarlo en la vista.
     * Agrega aquí cada módulo que audites.
     */
    public static function moduleLabels(): array
    {
        return [
            'products'          => 'Productos',
            'categories'        => 'Categorías',
            'sub_categories'    => 'Subcategorías',
            'unit_measurements' => 'Unidades de medida',
            'suppliers'         => 'Proveedores',
            'product_suppliers' => 'Producto-Proveedor',
            'customers'         => 'Clientes',
            'header_orders'     => 'Órdenes',
            'order_details'     => 'Detalle de órdenes',
            'users'             => 'Usuarios',
            'roles'             => 'Roles',
        ];
    }

    public function moduleLabel(): string
    {
        return self::moduleLabels()[$this->module] ?? ucfirst($this->module);
    }

    public static function actionLabels(): array
    {
        return [
            'creado'    => 'Creado',
            'editado'   => 'Editado',
            'eliminado' => 'Eliminado',
        ];
    }

    /**
     * Traducción de nombres de campo a algo entendible para alguien
     * que no programa. Agrega aquí el campo si no aparece traducido.
     */
    public static function fieldLabels(): array
    {
        return [
            // Productos
            'product_name'      => 'Nombre del producto',
            'barcode'           => 'Código de barras',
            'stock'             => 'Stock',
            'minimum_stock'     => 'Stock mínimo',
            'price_sale'        => 'Precio de venta',
            'price_buy'         => 'Precio de compra',
            'sub_category_id'   => 'Subcategoría',
            'unit_id'           => 'Unidad de medida',

            // Comunes
            'status_id'         => 'Estado',
            'name'              => 'Nombre',

            // Usuarios / roles
            'user_name'         => 'Nombre',
            'email'             => 'Correo electrónico',
            'telephone'         => 'Teléfono',
            'role_id'           => 'Rol',
            'role_name'         => 'Nombre del rol',
            'status_name'       => 'Nombre del estado',

            // Categorías / subcategorías / unidades / proveedores / clientes
            'category_name'     => 'Categoría',
            'sub_category_name' => 'Subcategoría',
            'unit_name'         => 'Unidad de medida',
            'supplier_name'     => 'Proveedor',
            'customer_name'     => 'Nombre del cliente',
            'address'           => 'Dirección',

            // Órdenes
            'order_date'        => 'Fecha de la orden',
            'total'             => 'Total',
            'quantity'          => 'Cantidad',
            'product_id'        => 'Producto',
            'customer_id'       => 'Cliente',
        ];
    }

    /**
     * Nombre entendible de un campo. Si no está en el diccionario de arriba,
     * lo arma automáticamente (ej: "sub_category_id" -> "Sub category").
     */
    public function fieldLabel(string $field): string
    {
        if (isset(self::fieldLabels()[$field])) {
            return self::fieldLabels()[$field];
        }

        $limpio = preg_replace('/_id$/', '', $field);

        return ucfirst(str_replace('_', ' ', $limpio));
    }

    /**
     * Convierte un valor crudo en algo legible: vacíos, sí/no, etc.
     */
    public function formatValue(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '(vacío)';
        }

        if (is_bool($value)) {
            return $value ? 'Sí' : 'No';
        }

        return (string) $value;
    }

    /**
     * Lista de campos que cambiaron, lista para mostrar en la vista,
     * sin JSON ni llaves. Cada elemento trae: label, before, after.
     */
    public function changesList(): array
    {
        $campos = array_unique(array_merge(
            array_keys($this->before ?? []),
            array_keys($this->after ?? [])
        ));

        $lista = [];
        foreach ($campos as $campo) {
            $lista[] = [
                'label'  => $this->fieldLabel($campo),
                'before' => $this->before[$campo] ?? null,
                'after'  => $this->after[$campo] ?? null,
            ];
        }

        return $lista;
    }
}
