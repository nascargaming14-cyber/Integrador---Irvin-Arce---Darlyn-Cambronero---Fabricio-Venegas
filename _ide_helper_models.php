<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string $module
 * @property string $auditable_type
 * @property int|null $auditable_id
 * @property string|null $record_label
 * @property string $action
 * @property array<array-key, mixed>|null $before
 * @property array<array-key, mixed>|null $after
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAuditableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAuditableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereRecordLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserId($value)
 */
	class AuditLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $crew_id
 * @property \Illuminate\Support\Carbon $work_date
 * @property string $client_name
 * @property string|null $location
 * @property numeric|null $area_m2
 * @property string|null $material_type
 * @property string|null $notes
 * @property bool|null $completed
 * @property bool $confirmed
 * @property int|null $confirmed_by
 * @property \Illuminate\Support\Carbon|null $confirmed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $product_id
 * @property bool $stock_deducted
 * @property-read \App\Models\User|null $confirmedBy
 * @property-read \App\Models\Crew $crew
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereAreaM2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereConfirmedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereCrewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereMaterialType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereStockDeducted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarJob whereWorkDate($value)
 */
	class CalendarJob extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $category_name
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Status $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubCategory> $subCategories
 * @property-read int|null $sub_categories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string|null $name
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $label
 * @property int $sort_order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CalendarJob> $jobs
 * @property-read int|null $jobs_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crew whereUpdatedAt($value)
 */
	class Crew extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $customer_name
 * @property string|null $dni
 * @property string|null $email
 * @property string|null $telephone
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $country
 * @property string $id_type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HeaderOrder> $headerOrders
 * @property-read int|null $header_orders_count
 * @property-read \App\Models\Status $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereIdType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $customer_id
 * @property string|null $order_status
 * @property \Illuminate\Support\Carbon $order_date
 * @property numeric $order_amount
 * @property numeric $discount
 * @property numeric $total
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read float $payment_due
 * @property-read float $payment_paid
 * @property-read int $payment_percent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \App\Models\Status $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder whereOrderAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder whereOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeaderOrder whereUpdatedAt($value)
 */
	class HeaderOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property string $type
 * @property numeric $quantity
 * @property int|null $user_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $order_detail_id
 * @property-read \App\Models\OrderDetail|null $orderDetail
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereOrderDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereUserId($value)
 */
	class Movement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $header_order_id
 * @property int $product_id
 * @property numeric $quantity
 * @property string|null $barcode
 * @property string|null $product_name
 * @property numeric $price
 * @property numeric $subtotal
 * @property numeric $iva
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HeaderOrder $headerOrder
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Movement> $movements
 * @property-read int|null $movements_count
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Status $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereHeaderOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereUpdatedAt($value)
 */
	class OrderDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $barcode
 * @property string $product_name
 * @property numeric $stock
 * @property numeric $minimum_stock
 * @property numeric $price_sale
 * @property numeric $price_buy
 * @property int $sub_category_id
 * @property int $unit_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Movement> $movements
 * @property-read int|null $movements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSupplier> $productSuppliers
 * @property-read int|null $product_suppliers_count
 * @property-read \App\Models\Status $status
 * @property-read \App\Models\SubCategory $subCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Supplier> $suppliers
 * @property-read int|null $suppliers_count
 * @property-read \App\Models\UnitMeasurement $unitMeasurement
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMinimumStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePriceBuy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePriceSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property int $supplier_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Status $status
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSupplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSupplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSupplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSupplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSupplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSupplier whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSupplier whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSupplier whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSupplier whereUpdatedAt($value)
 */
	class ProductSupplier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $role_name
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Status $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $status_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Customer> $customers
 * @property-read int|null $customers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HeaderOrder> $headerOrders
 * @property-read int|null $header_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubCategory> $subCategories
 * @property-read int|null $sub_categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Supplier> $suppliers
 * @property-read int|null $suppliers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UnitMeasurement> $unitMeasurements
 * @property-read int|null $unit_measurements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status whereStatusName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status whereUpdatedAt($value)
 */
	class Status extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $subcategory_name
 * @property int $category_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UnitMeasurement> $allowedUnits
 * @property-read int|null $allowed_units_count
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Status $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereSubcategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereUpdatedAt($value)
 */
	class SubCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSupplier> $productSuppliers
 * @property-read int|null $product_suppliers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Status $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $unit_name
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Status $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitMeasurement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitMeasurement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitMeasurement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitMeasurement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitMeasurement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitMeasurement whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitMeasurement whereUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitMeasurement whereUpdatedAt($value)
 */
	class UnitMeasurement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $user_name
 * @property string $email
 * @property string|null $telephone
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property int $role_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $pin
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role $role
 * @property-read \App\Models\Status $status
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserName($value)
 */
	class User extends \Eloquent {}
}

