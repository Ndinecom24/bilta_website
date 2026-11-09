<?php

namespace App\Http\Controllers;

use App\Services\Support\SupportReportService;
use App\Services\Support\XlsxWriter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupportReportController extends Controller
{
    /** GET support/reports/export?type=&format=xlsx|pdf&from=&to=&category_id=... */
    public function export(Request $request, SupportReportService $service)
    {
        $user = $request->user();
        abort_unless($user->can('view-support-reports'), 403);

        $validated = $request->validate([
            'type' => 'required|in:' . implode(',', array_keys(SupportReportService::TYPES)),
            'format' => 'required|in:xlsx,pdf',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'category_id' => 'nullable|integer',
            'system_id' => 'nullable|integer',
            'priority_id' => 'nullable|integer',
            'developer_id' => 'nullable|integer',
        ]);

        $report = $service->build($validated['type'], $validated, $user->can('manage-support-billing'));
        $filename = 'support-' . $validated['type'] . '-' . now()->format('Ymd-His');

        if ($validated['format'] === 'xlsx') {
            $path = XlsxWriter::build($report['title'], $report['subtitle'], $report['columns'], $report['rows'], $report['totals']);

            return response()->download($path, $filename . '.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])->deleteFileAfterSend(true);
        }

        $pdf = Pdf::loadView('pdf.support-report', ['report' => $report, 'generatedBy' => $user->name])
            ->setPaper('a4', 'landscape');

        return $pdf->download($filename . '.pdf');
    }
}
