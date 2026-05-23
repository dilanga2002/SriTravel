@extends('layouts.app')

@section('title', 'Create Booking - SriTravel')

@section('content')

    <div class="max-w-4xl mx-auto py-8">

        <div class="bg-white rounded-2xl shadow p-8">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-semibold">Book Vehicle</h1>
                    <p class="text-gray-600">{{ $vehicle->make }} {{ $vehicle->model }}</p>
                </div>
                <a href="{{ route('vehicles.index') }}" class="text-blue-600 hover:underline">← Back to Vehicles</a>
            </div>

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('bookings.store') }}" method="POST">
    @csrf
    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
    <input type="hidden" name="price_per_km" value="{{ $vehicle->price_per_km ?? '' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Booking Details -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold mb-4">Booking Details</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('start_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date *</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('end_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Time *</label>
                            <input type="time" name="pickup_time" value="{{ old('pickup_time') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('pickup_time')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Location *</label>
                            <input type="text" name="pickup_location" value="{{ old('pickup_location') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('pickup_location')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dropoff Location *</label>
                            <input type="text" name="dropoff_location" value="{{ old('dropoff_location') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('dropoff_location')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Destination *</label>
                            <input type="text" name="destination" value="{{ old('destination') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('destination')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold mb-4">Additional Information</h3>

                        <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Select Driver (Optional)</label>
    <select name="driver_id" id="driverSelect" 
            class="w-full border border-gray-300 rounded-lg px-4 py-3">
        <option value="">No Driver</option>
    </select>
    @error('driver_id')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Kilometers *</label>
                            <input type="number" name="total_KiloMeter" value="{{ old('total_KiloMeter') }}" 
                                   min="1" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('total_KiloMeter')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Special Requests</label>
                            <textarea name="special_requests" rows="4" 
                                      class="w-full border border-gray-300 rounded-lg px-4 py-3">{{ old('special_requests') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-semibold text-lg transition">
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.querySelector('input[name="start_date"]');
    const endDateInput   = document.querySelector('input[name="end_date"]');
    const driverSelect   = document.getElementById('driverSelect');

    function loadAvailableDrivers() {
        const startDate = startDateInput.value;
        const endDate   = endDateInput.value;

        if (!startDate || !endDate) return;

        fetch('{{ route("bookings.checkDriverAvailability") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                start_date: startDate,
                end_date: endDate
            })
        })
        .then(response => response.json())
        .then(data => {
            driverSelect.innerHTML = '<option value="">No Driver</option>';

            data.drivers.forEach(driver => {
                const option = document.createElement('option');
                option.value = driver.id;
                option.textContent = `${driver.name} (${driver.license_number})`;
                
                if (!driver.is_available) {
                    option.disabled = true;
                    option.textContent += ' (Not Available)';
                }
                
                driverSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
    }

    // Load drivers when dates change
    startDateInput.addEventListener('change', loadAvailableDrivers);
    endDateInput.addEventListener('change', loadAvailableDrivers);
});
</script>
@endsection