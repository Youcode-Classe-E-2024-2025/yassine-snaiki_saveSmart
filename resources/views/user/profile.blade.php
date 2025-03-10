
<x-playout :profile="$profile">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">This month stats, {{ Auth::user()->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Income Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Income</h2>
                <p class="text-2xl font-bold text-green-600">${{$totalIncome}}</p>
            </div>
            <!-- Expenses Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Expenses</h2>
                <p class="text-2xl font-bold text-red-600">${{$totalExpense}}</p>
            </div>

            <!-- Financial Goals Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Financial Goal</h2>
                @if($goal)
                <p class="text-lg">Savings Goal: ${{ $goal->amount }}</p>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min(($goal->progress / $goal->amount) * 100, 100) }}%"></div>
                </div>
                @else
                <div class="w-full bg-gray-200 px-4">
                    <p>No goals determined</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Transactions Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-semibold mb-4">Expenses</h2>

            <!-- Add Transaction Form -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-4">
                <h3 class="text-lg font-semibold mb-4">Add an Expense</h3>
                <form action="/transactions/add" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="w-full sm:w-1/3">
                        <input type="hidden" name="confirmed" value="0">
                        <select name="category_id"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" class="hidden" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full sm:w-1/3">
                        <input type="number" name="amount" placeholder="Amount"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                
                    <div class="w-full sm:w-1/3">
                        <button type="submit"
                            class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Add Expense
                        </button>
                    </div>
                </form>
            </div>

            <!-- Transactions List -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Date</th>
                            <th class="text-left py-2">Profile</th>
                            <th class="text-left py-2">Category</th>
                            <th class="text-right py-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="border-b">
                                <td class="py-3">{{ $transaction->created_at }}</td>
                                <td class="py-3">{{ $transaction->profile->username }}</td>
                                <td>{{ $transaction->category ? $transaction->category->name : 'others' }}</td>
                                <td
                                    class="text-right font-medium {{ $transaction->type === 'w' ? 'text-red-600' : 'text-green-600' }}">
                                    ${{ $transaction->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <div class="bg-white p-6 rounded-lg shadow-md mb-4 mt-5">
            <h3 class="text-lg font-semibold mb-4">Add Category</h3>
            <form action="/category/add" method="POST" class="flex flex-col sm:flex-row gap-4">
                @csrf
                <div class="w-full sm:w-3/4">
                    <input type="text" name="name" placeholder="name"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="w-full sm:w-1/4">
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Add Category
                    </button>
                </div>
            </form>
        </div>

          <!-- Categories Section -->
          <div class="mt-12">
            <h2 class="text-2xl font-semibold mb-4">Expense Categories</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <ul class="flex flex-col gap-4">
                    @foreach ($categories as $category)
                    <li class="flex justify-between">
                        <p  class="text-blue-500 hover:underline">{{ $category->name }}</p>
                        <form action="/category/delete" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $category->id }}">

                            <button type="submit">
                                <svg class="w-4 h-4" fill="red" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal for exceeding 20% saving percentage -->
    @if(session('isExceeded'))
    <div id="savingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-xl font-bold mb-4 text-red-600">Warning!</h2>
            <p class="mb-6 text-gray-800">{{ session('isExceeded') }}</p>

            <form action="/transactions/add" method="POST">
                @csrf
                <div class="hidden">
                    <input type="hidden" name="category_id" value="{{ session('validated')['category_id'] }}">
                    <input type="hidden" name="amount" value="{{  session('validated')['amount']}}">
                    <input type="hidden" name="confirmed" value="1">
                </div>

                <div class="flex justify-between">
                    <button type="button" onclick="document.getElementById('savingModal').style.display = 'none';"
                        class="bg-gray-300 text-gray-800 py-2 px-4 rounded hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</x-playout>

