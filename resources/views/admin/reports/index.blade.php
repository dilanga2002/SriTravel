@extends('layouts.admin')

@section('title', 'Reports - SriTravel Admin')
@section('page_title', 'Reports')

@section('content')

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto">

        <!-- Generate New Report -->
        <div class="bg-white rounded-xl shadow p-8 mb-8">
            <h2 class="text-2xl font-semibold mb-2">Generate New Report</h2>
            <p class="text-gray-500 mb-6">Create a new bookings or vehicle usage report</p>

            <form action="{{ route('admin.reports.generate') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                    <select name="report_type" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                        <option value="bookings">Bookings Report</option>
                        <option value="vehicle_usage">Vehicle Usage Report</option>
                    </select>
                    @error('report_type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    @error('start_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    @error('end_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-3 flex justify-end">
                    <button type="submit" 
                            class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Generate PDF Report
                    </button>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Total Bookings</p>
                        <p class="text-4xl font-bold mt-2">{{ $totalBookings ?? 0 }}</p>
                    </div>
                    <div class="text-4xl text-blue-500">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-4">This month</p>
            </div>

            <div class="bg-white rounded-xl p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Vehicle Utilization</p>
                        <p class="text-4xl font-bold mt-2">{{ $utilizationRate ?? 0 }}%</p>
                    </div>
                    <div class="text-4xl text-emerald-500">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-4">Current rate</p>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-xl shadow">
            <div class="px-6 py-5 border-b flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold">Recent Reports</h2>
                    <p class="text-gray-500">Latest generated reports</p>
                </div>
                <select class="border border-gray-300 rounded-lg px-4 py-2">
                    <option>Newest</option>
                    <option>Oldest</option>
                </select>
            </div>

            @if($recentReports->isEmpty())
                <div class="text-center py-16">
                    <i class="fas fa-file-alt text-6xl text-gray-200 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-700">No reports found</h3>
                    <p class="text-gray-500 mt-2">Generate your first report above.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Report ID</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Date Range</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Generated On</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentReports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium">Rp-{{ $report->id }}</td>
                                <td class="px-6 py-4">{{ ucfirst(str_replace('_', ' ', $report->report_type)) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    {{ $report->start_date->format('M d, Y') }} - {{ $report->end_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $report->created_at->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('admin.reports.download', $report->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                        Download
                                    </a>
                                    <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this report?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection