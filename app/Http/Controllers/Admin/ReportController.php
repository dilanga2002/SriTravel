<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Report;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Display the reports dashboard.
     */
    public function index(Request $request)
    {
        $now = Carbon::now();

        $totalBookings = Booking::where('created_at', '>=', $now->startOfMonth())->count();

        $totalRevenue = Booking::where('status', 'confirmed')
            ->where('created_at', '>=', $now->startOfMonth())
            ->sum('total_amount');

        $totalVehicles = Vehicle::count();
        $bookedVehicles = Booking::where('status', 'confirmed')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->distinct('vehicle_id')
            ->count('vehicle_id');

        $utilizationRate = $totalVehicles > 0 
            ? round(($bookedVehicles / $totalVehicles) * 100, 2) 
            : 0;

        $recentReports = Report::latest()->take(5)->get();

        return view('admin.reports.index', compact(
            'totalBookings',
            'totalRevenue',
            'utilizationRate',
            'recentReports'
        ));
    }

    /**
     * Generate a new report.
     */
    public function generate(Request $request)
    {
        return $this->safeExecute(function () use ($request) {
            $validated = $request->validate([
                'report_type' => 'required|in:bookings,vehicle_usage',
                'start_date'  => 'required|date',
                'end_date'    => 'required|date|after_or_equal:start_date',
            ]);

            $start = Carbon::parse($validated['start_date'])->startOfDay();
            $end   = Carbon::parse($validated['end_date'])->endOfDay();

            // Prevent future dates
            if ($end->isAfter(today())) {
                $end = today()->endOfDay();
            }

            $reportData = match ($validated['report_type']) {
                'bookings'      => $this->generateBookingsReport($start, $end),
                'vehicle_usage' => $this->generateVehicleUsageReport($start, $end),
            };

            $report = Report::create([
                'admin_id'   => auth()->id(),
                'report_type'=> $validated['report_type'],
                'start_date' => $validated['start_date'],
                'end_date'   => $validated['end_date'],
                'data'       => json_encode($reportData)
            ]);

            return redirect()->route('admin.reports.download', $report)
                             ->with('success', 'Report generated successfully');
        }, 'Report generated successfully', 'Failed to generate report. Please try again.');
    }

    /**
     * Download report as PDF.
     */
    public function download(Report $report)
{
    try {
        $rawData = $report->data;
        $reportData = is_string($rawData) ? json_decode($rawData, true) : $rawData;

        if (!is_array($reportData)) {
            $reportData = (array) $reportData;
        }

        $pdf = match ($report->report_type) {
            'bookings'       => Pdf::loadView('admin.reports.bookings', [
                                    'report'     => $report,
                                    'reportData' => $reportData,
                                    'admin'      => null   // Hide admin info
                                ]),
            'vehicle_usage'  => Pdf::loadView('admin.reports.vehicle_usage', [
                                    'report'     => $report,
                                    'reportData' => $reportData
                                ]),
            default => throw new \Exception('Invalid report type'),
        };

        return $pdf->download('report_' . $report->id . '.pdf');

    } catch (\Exception $e) {
        Log::error('PDF generation error: ' . $e->getMessage());
        return redirect()->route('admin.reports.index')
                         ->with('error', 'Error generating PDF report.');
    }
}

    public function destroy(Report $report)
    {
        return $this->safeExecute(function () use ($report) {
            $report->delete();
            return 'Report deleted successfully';
        }, 'Report deleted successfully');
    }

    // ====================== Report Generators ======================

    protected function generateBookingsReport(Carbon $start, Carbon $end): array
{
    $bookings = Booking::with(['vehicle', 'user'])
        ->whereBetween('created_at', [$start, $end])
        ->get()
        ->map(fn($booking) => [
            'id'           => $booking->id,
            'customer_name'=> $booking->user->name ?? 'Unknown',
            'vehicle'      => $booking->vehicle ? $booking->vehicle->make . ' ' . $booking->vehicle->model : 'Unknown',
            'status'       => ucfirst($booking->status),
            'start_date'   => $booking->start_date->format('M d, Y'),
            'end_date'     => $booking->end_date->format('M d, Y'),
            'total_amount' => $booking->total_amount,   // Keep as number (not formatted)
        ])->toArray();

    $summary = Booking::whereBetween('created_at', [$start, $end])
        ->selectRaw('status, count(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();

    return [
        'bookings' => $bookings,
        'summary'  => [
            'total_bookings'     => array_sum($summary),
            'confirmed_bookings' => $summary['confirmed'] ?? 0,
            'pending_bookings'   => $summary['pending'] ?? 0,
            'cancelled_bookings' => $summary['cancelled'] ?? 0,
            'completed_bookings' => $summary['completed'] ?? 0,
        ],
    ];
}

    protected function generateVehicleUsageReport(Carbon $start, Carbon $end): array
    {
        $bookings = Booking::with('vehicle')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'confirmed')
            ->selectRaw('vehicle_id, count(*) as bookings_count')
            ->groupBy('vehicle_id')
            ->get();

        $vehicleUsage = $bookings->map(function ($item) use ($start, $end) {
            $daysRented = Booking::where('vehicle_id', $item->vehicle_id)
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'confirmed')
                ->sum(\DB::raw('DATEDIFF(end_date, start_date) + 1'));

            $totalDays = $start->diffInDays($end) + 1;
            $utilization = $totalDays > 0 ? round(($daysRented / $totalDays) * 100, 1) : 0;

            return [
                'vehicle_id'         => $item->vehicle_id,
                'make'               => $item->vehicle->make ?? 'Unknown',
                'model'              => $item->vehicle->model ?? 'Unknown',
                'type'               => $item->vehicle->type ?? 'Unknown',
                'registration_number'=> $item->vehicle->registration_number ?? 'Unknown',
                'bookings_count'     => $item->bookings_count,
                'days_rented'        => $daysRented,
                'utilization'        => $utilization,
            ];
        })->toArray();

        $typeUsage = collect($vehicleUsage)
            ->groupBy('type')
            ->map(fn($group) => [
                'type'              => $group->first()['type'],
                'total_bookings'    => $group->sum('bookings_count'),
                'total_days_rented' => $group->sum('days_rented'),
            ])
            ->sortByDesc('total_bookings')
            ->values()
            ->toArray();

        return [
            'vehicle_usage' => $vehicleUsage,
            'type_usage'    => $typeUsage,
        ];
    }
}