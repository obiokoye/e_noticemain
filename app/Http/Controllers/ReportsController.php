<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Category;
use App\Models\Department;
use App\Models\Paymentcycle;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportsController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        $categories = Category::all();
        $paymentCycles = PaymentCycle::all();

        return view('reports.index', compact('departments', 'categories', 'paymentCycles'));
    }




    public function filter(Request $request)
    {
        $filterType = $request->get('filter_type');
        $filterValue = $request->get('filter_value');

        $subscriptions = Subscription::select(
            'subscriptions.id',
            'subscriptions.name as subscription_name',
            'users.fname as user_name',
            'users.department', 
            'subscriptions.category',
            'subscriptions.payment_cycle',
            'subscriptions.created_at',
            'subscriptions.description'
        )
            ->join('users', 'subscriptions.user', '=', 'users.id')
            ->when($filterType === 'department', function ($query) use ($filterValue) {
                return $query->where('users.department', $filterValue);
            })
            ->when($filterType === 'category', function ($query) use ($filterValue) {
                return $query->where('subscriptions.category', $filterValue);
            })
            ->when($filterType === 'payment_cycle', function ($query) use ($filterValue) {
                return $query->where('subscriptions.payment_cycle', $filterValue);
            })
            ->get()
            ->map(function ($subscription) {
                return [
                    'subscription_name' => $subscription->subscription_name,
                    'department' => Department::find($subscription->department)->name,
                    'description' => $subscription->description,
                    'category_name' => Category::find($subscription->category)->name,
                    'payment_cycle_name' => PaymentCycle::find($subscription->payment_cycle)->name,
                    'user_name' => $subscription->user_name,
                    'created_at' => $subscription->created_at->format('Y-m-d'),
                ];
            });

        return response()->json($subscriptions);
    }


}
