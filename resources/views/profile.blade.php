@extends('layouts.app')

@push('styles')
<style>
    .credit-card {
        background: linear-gradient(135deg, #60A5FA 0%, #3B82F6 100%);
    }
</style>
@endpush

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg">
        <div class="flex items-center gap-2 p-6">
            <img src="{{ asset('images/logo.svg') }}" alt="Pelio" class="h-8 w-8">
            <span class="text-xl font-bold">PELIO</span>
        </div>

        <nav class="mt-6 px-4">
            <a href="#" class="flex items-center gap-3 rounded-lg bg-blue-50 px-4 py-3 text-blue-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="#" class="mt-2 flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <span>My Wallet</span>
            </a>

            <a href="#" class="mt-2 flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span>Payment</span>
            </a>

            <a href="#" class="mt-2 flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span>Invoice</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 flex-1 p-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Dashboard</h1>

            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" placeholder="Search here..." class="w-64 rounded-lg border border-gray-200 py-2 pl-10 pr-4 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <div class="flex items-center gap-3">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile" class="h-10 w-10 rounded-full">
                    <span class="font-medium">Hi {{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="mb-8 grid grid-cols-4 gap-6">
            <div class="rounded-xl bg-emerald-500 p-6 text-white">
                <div class="text-sm opacity-80">Total Balance</div>
                <div class="mt-1 text-2xl font-bold">32,568</div>
            </div>

            <div class="rounded-xl bg-blue-500 p-6 text-white">
                <div class="text-sm opacity-80">Total Progress</div>
                <div class="mt-1 text-2xl font-bold">8,558</div>
            </div>

            <div class="rounded-xl bg-amber-500 p-6 text-white">
                <div class="text-sm opacity-80">Total Income</div>
                <div class="mt-1 text-2xl font-bold">2,568</div>
            </div>

            <div class="rounded-xl bg-red-500 p-6 text-white">
                <div class="text-sm opacity-80">Total Expense</div>
                <div class="mt-1 text-2xl font-bold">668</div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Transactions -->
            <div class="col-span-8 rounded-xl bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Latest Transactions</h2>
                </div>

                <div class="space-y-4">
                    @foreach([
                        ['name' => 'CodeMonkey.com', 'amount' => 1437.99, 'time' => '2 min ago', 'color' => 'blue'],
                        ['name' => 'HDJExpress.com', 'amount' => 89.99, 'time' => '5 min ago', 'color' => 'yellow'],
                        ['name' => 'SmartDevices.biz', 'amount' => 3141.59, 'time' => '15 min ago', 'color' => 'green'],
                        ['name' => 'GlobalSoft.net', 'amount' => 2207.99, 'time' => '1 hour ago', 'color' => 'red']
                    ] as $transaction)
                    <div class="flex items-center justify-between rounded-lg border border-gray-100 p-4">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-lg bg-{{ $transaction['color'] }}-100 flex items-center justify-center">
                                <span class="text-{{ $transaction['color'] }}-600">$</span>
                            </div>
                            <div>
                                <div class="font-medium">{{ $transaction['name'] }}</div>
                                <div class="text-sm text-gray-500">{{ $transaction['time'] }}</div>
                            </div>
                        </div>
                        <div class="text-lg font-semibold">${{ number_format($transaction['amount'], 2) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Statistics -->
            <div class="col-span-4 rounded-xl bg-white p-6 shadow-sm">
                <h2 class="mb-6 text-lg font-semibold">Statistics</h2>
                <canvas id="statisticsChart" class="w-full"></canvas>
            </div>

            <!-- Credit Card -->
            <div class="col-span-4">
                <div class="credit-card rounded-xl p-6 text-white">
                    <div class="mb-8">
                        <div class="text-sm opacity-80">Balance</div>
                        <div class="text-3xl font-bold">$4,929</div>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <div class="text-sm opacity-80">Card Number</div>
                            <div class="mt-1">**** **** **** 3456</div>
                        </div>
                        <div class="flex gap-2">
                            <div class="h-8 w-8 rounded-full bg-white/30"></div>
                            <div class="h-8 w-8 rounded-full bg-white/30"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 rounded-lg bg-white p-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">Card Usage</div>
                        <div class="text-sm font-medium">5,783</div>
                    </div>
                    <div class="mt-2">
                        <div class="h-2 w-full rounded-full bg-gray-100">
                            <div class="h-2 w-3/4 rounded-full bg-blue-500"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Balance Details -->
            <div class="col-span-4 rounded-xl bg-white p-6 shadow-sm">
                <h2 class="mb-6 text-lg font-semibold">Balance Details</h2>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Balance</span>
                        <span class="font-medium">$221,478</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Month</span>
                        <span class="font-medium">$14,849</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Expenses</span>
                        <span class="font-medium">$256.25</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total</span>
                        <span class="font-medium">$365,478</span>
                    </div>
                </div>
            </div>

            <!-- Monthly Overview -->
            <div class="col-span-4 rounded-xl bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold">Monthly Overview</h2>
                <div class="mb-6 text-3xl font-bold">$48,284</div>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-semibold text-emerald-500">287</div>
                        <div class="text-sm text-gray-500">Earn</div>
                    </div>
                    <div>
                        <div class="text-2xl font-semibold text-red-500">312</div>
                        <div class="text-sm text-gray-500">Spent</div>
                    </div>
                    <div>
                        <div class="text-2xl font-semibold">476</div>
                        <div class="text-sm text-gray-500">Total</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('statisticsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Income',
                data: [65, 59, 80, 81, 56, 55],
                backgroundColor: '#10B981',
                borderRadius: 4
            }, {
                label: 'Expenses',
                data: [-45, -39, -60, -61, -36, -35],
                backgroundColor: '#EF4444',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    grid: {
                        borderDash: [2, 4]
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush
