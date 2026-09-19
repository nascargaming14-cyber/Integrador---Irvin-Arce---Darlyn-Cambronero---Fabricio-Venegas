<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Cantidad de dígitos de teléfono esperada por país.
     * Ajusta estos valores si tu operación necesita otro formato.
     */
    private const PHONE_DIGITS = [
        'CR' => 8, 'MX' => 10, 'US' => 10, 'GT' => 8, 'HN' => 8, 'SV' => 8,
        'NI' => 8, 'PA' => 8, 'CO' => 10, 'VE' => 10, 'EC' => 9, 'PE' => 9,
        'BO' => 8, 'CL' => 9, 'AR' => 10, 'UY' => 9, 'PY' => 9, 'BR' => 11,
        'ES' => 9, 'DO' => 10, 'CU' => 8,
    ];

    private const DEFAULT_PHONE_DIGITS = 8;

    /**
     * Largo máximo de cédula/DNI por país. Costa Rica distingue
     * física (9) de jurídica (10); el resto de países usa un solo
     * máximo porque no tenemos el formato jurídico confirmado.
     */
    private const DNI_MAX = [
        'CR' => ['fisica' => 9, 'juridica' => 10],
        'MX' => 18, 'US' => 9, 'GT' => 13, 'HN' => 13, 'SV' => 14, 'NI' => 14,
        'PA' => 13, 'CO' => 10, 'VE' => 10, 'EC' => 13, 'PE' => 11, 'BO' => 10,
        'CL' => 9, 'AR' => 11, 'UY' => 12, 'PY' => 8, 'BR' => 14, 'ES' => 9,
        'DO' => 11, 'CU' => 11,
    ];

    private const DEFAULT_DNI_MAX = 16;

    public function index(): View
    {
        $customers = Customer::with('status')
            ->orderBy('id')
            ->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        $statuses = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('customers.create', compact('statuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        Customer::create($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    public function show(string $id): View
    {
        $customer = Customer::with(['status', 'headerOrders'])
            ->findOrFail($id);

        return view('customers.show', compact('customer'));
    }

    public function edit(string $id): View
    {
        $customer = Customer::findOrFail($id);
        $statuses = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('customers.edit', compact('customer', 'statuses'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $customer = Customer::findOrFail($id);

        $validated = $this->validated($request);

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $customer = Customer::findOrFail($id);

        try {
            $customer->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('customers.index')
                ->with('error', 'No se puede eliminar el cliente porque tiene órdenes asociadas.');
        }

        return redirect()
            ->route('customers.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }

    /**
     * Valida el request calculando el largo de teléfono y cédula
     * en función del país (y tipo de identificación) enviados.
     */
    private function validated(Request $request): array
    {
        $country = $request->input('country');
        $idType  = $request->input('id_type', 'fisica');

        $phoneDigits = self::PHONE_DIGITS[$country] ?? self::DEFAULT_PHONE_DIGITS;

        $dniMax = self::DNI_MAX[$country] ?? self::DEFAULT_DNI_MAX;
        if (is_array($dniMax)) {
            $dniMax = $dniMax[$idType] ?? max($dniMax);
        }

        return $request->validate([
            'customer_name' => 'required|string|max:150',
            'id_type'       => 'nullable|in:fisica,juridica',
            'dni'           => "nullable|string|max:{$dniMax}",
            'email'         => 'nullable|email|max:150',
            'telephone'     => "nullable|digits:{$phoneDigits}",
            'country'       => 'nullable|string|size:2',
            'status_id'     => 'required|integer|exists:status,id',
        ]);
    }
}
