<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = $this->filteredQuery($request)->paginate(20)->withQueryString();

        $modules = AuditLog::moduleLabels();
        $actions = AuditLog::actionLabels();
        $users   = User::orderBy('user_name')->get(['id', 'user_name']);

        return view('admin.audit.index', compact('logs', 'modules', 'actions', 'users'));
    }

    /**
     * Genera el PDF con los mismos filtros que estén aplicados en pantalla
     * (llegan como parámetros GET, igual que en el resto de reportes).
     */
    public function pdf(Request $request)
    {
        $logs = $this->filteredQuery($request)->get();

        $modules = AuditLog::moduleLabels();
        $actions = AuditLog::actionLabels();

        // Texto legible de los filtros usados, para mostrarlo arriba del PDF
        $filtrosTexto = $this->filtrosAplicados($request, $modules, $actions);

        $pdf = Pdf::loadView('admin.audit.pdf', [
            'logs'         => $logs,
            'filtrosTexto' => $filtrosTexto,
        ])->setPaper('letter', 'landscape');

        return $pdf->download('historial-movimientos.pdf');
    }

    /**
     * Arma el query con todos los filtros. Lo usan tanto index() como pdf(),
     * así nunca se pueden desincronizar.
     */
    protected function filteredQuery(Request $request): Builder
    {
        $query = AuditLog::with('user')->latest('created_at');

        if ($request->filled('module')) {
            $query->where('module', $request->input('module'));
        }

        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        if ($request->filled('search')) {
            $query->where('record_label', 'like', '%' . $request->input('search') . '%');
        }

        return $query;
    }

    protected function filtrosAplicados(Request $request, array $modules, array $actions): array
    {
        $texto = [];

        if ($request->filled('module')) {
            $texto[] = 'Módulo: ' . ($modules[$request->input('module')] ?? $request->input('module'));
        }
        if ($request->filled('action')) {
            $texto[] = 'Acción: ' . ($actions[$request->input('action')] ?? $request->input('action'));
        }
        if ($request->filled('user_id')) {
            $usuario = User::find($request->input('user_id'));
            $texto[] = 'Usuario: ' . ($usuario->user_name ?? $request->input('user_id'));
        }
        if ($request->filled('date_from')) {
            $texto[] = 'Desde: ' . $request->input('date_from');
        }
        if ($request->filled('date_to')) {
            $texto[] = 'Hasta: ' . $request->input('date_to');
        }
        if ($request->filled('search')) {
            $texto[] = 'Búsqueda: "' . $request->input('search') . '"';
        }

        return $texto;
    }
}
