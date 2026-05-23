<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesImages;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    use HandlesImages;

    public function index(Request $request)
    {
        $search = $request->query('search');

        $users = User::where('role', 'customer')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.customer.index', compact('users', 'search'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'customer') {
            return redirect()->route('admin.customers.index')
                             ->with('error', 'Selected user is not a customer.');
        }

        $user->load(['bookings' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.customer.show', compact('user'));
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'customer') {
            abort(403, 'Unauthorized: This user is not a customer.');
        }

        return $this->safeExecute(function () use ($user) {
            if ($user->profile_photo) {
                $this->imageService->delete($user->profile_photo);
            }
            $user->delete();
            return 'Customer deleted successfully.';
        }, 'Customer deleted successfully.');
    }
}