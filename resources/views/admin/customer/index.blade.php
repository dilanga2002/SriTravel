@extends('layouts.admin')

@section('title', 'Customers - SriTravel Admin')
@section('page_title', 'Customers')

@section('content')

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto">
        
        <div class="bg-white rounded-xl shadow overflow-hidden">
            
            <!-- Page Header -->
            <div class="px-6 py-5 border-b flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">All Customers</h2>
                    <p class="text-gray-500">View all registered customers</p>
                </div>
                
                
            </div>

            @if($users->isEmpty())
                <div class="text-center py-16">
                    <i class="fas fa-users text-6xl text-gray-200 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-700">No customers found</h3>
                    <p class="text-gray-500 mt-2">There are no customers to display.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <img class="h-9 w-9 rounded-full mr-3" 
                                             src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
                                             alt="">
                                        <div class="font-medium">{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('admin.customers.show', $user->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    
                                    <form action="{{ route('admin.customers.destroy', $user->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this customer?')">
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

                <!-- Pagination -->
                <div class="px-6 py-4 border-t">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection