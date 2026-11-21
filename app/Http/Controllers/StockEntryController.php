<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use App\Models\StockEntry;
use App\Models\Supplier;
use App\Support\AuditTrail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockEntryController extends Controller
{
    /**
     * Historial de entradas de inventario.
     */
    public function index(): View
    {
        $entries = StockEntry::with(['product', 'supplier', 'user'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('stock_entries.index', compact('entries'));
    }

    public function create(): View
    {
        $products  = Product::orderBy('product_name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('stock_entries.create', compact('products', 'suppliers'));
    }

    /**
     * Registra una entrada: sube el stock, guarda la entrada, crea el
     * movimiento de tipo "entrada" y deja el registro en audit_logs.
     * Todo en una transacción: o se guarda todo o no se guarda nada.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id'  => 'required|integer|exists:products,id',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'reference'   => 'nullable|string|max:100',
            'quantity'    => 'required|numeric|min:0.01',
            'notes'       => 'nullable|string|max:500',
        ]);

        $entry = DB::transaction(function () use ($validated) {
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);
            $before  = AuditTrail::snapshot($product);

            // Incremento atómico: UPDATE products SET stock = stock + X
            Product::where('id', $product->id)->increment('stock', $validated['quantity']);

            $entry = StockEntry::create($validated + ['user_id' => Auth::id()]);

            $supplierName = isset($validated['supplier_id'])
                ? Supplier::whereKey($validated['supplier_id'])->value('name')
                : null;

            $description = 'Entrada #' . $entry->id
                . ($supplierName ? " - Proveedor: {$supplierName}" : '')
                . (! empty($validated['reference']) ? " - Ref: {$validated['reference']}" : '');

            Movement::create([
                'product_id'  => $product->id,
                'type'        => 'entrada',
                'quantity'    => $validated['quantity'],
                'user_id'     => Auth::id(),
                'description' => mb_substr($description, 0, 250),
            ]);

            $product->refresh();

            AuditTrail::log(
                'Inventario',
                $entry,
                "Entrada #{$entry->id} - {$product->product_name}",
                'entrada',
                $before,
                AuditTrail::snapshot($product)
            );

            return $entry;
        });

        return redirect()
            ->route('stock-entries.index')
            ->with('success', "Entrada #{$entry->id} registrada: +{$validated['quantity']} unidades.");
    }
}
