<x-playout :profile="$profile">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Welcome to SaveSmart, {{ Auth::user()->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Income Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Income</h2>
                <p class="text-2xl font-bold text-green-600">$5,000</p>
                <a href="/income/add" class="text-blue-500 hover:underline mt-2 inline-block">Add Income</a>
            </div>

            <!-- Expenses Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Expenses</h2>
                <p class="text-2xl font-bold text-red-600">$3,500</p>
                <a href="/expenses/add" class="text-blue-500 hover:underline mt-2 inline-block">Add Expense</a>
            </div>

            <!-- Financial Goals Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Financial Goals</h2>
                <p class="text-lg">Savings Goal: $10,000</p>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                </div>
                <a href="/goals/add" class="text-blue-500 hover:underline mt-2 inline-block">Set New Goal</a>
            </div>
        </div>

        <!-- Budget Distribution -->
        <div class="mt-12">
            <h2 class="text-2xl font-semibold mb-4">Budget Distribution</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center">
                    <div class="w-1/3 text-center">
                        <div class="text-lg font-semibold">Needs</div>
                        <div class="text-3xl font-bold text-blue-600">50%</div>
                    </div>
                    <div class="w-1/3 text-center">
                        <div class="text-lg font-semibold">Wants</div>
                        <div class="text-3xl font-bold text-green-600">30%</div>
                    </div>
                    <div class="w-1/3 text-center">
                        <div class="text-lg font-semibold">Savings</div>
                        <div class="text-3xl font-bold text-purple-600">20%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-semibold mb-4">Transactions</h2>

            <!-- Add Transaction Form -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-4">
                <h3 class="text-lg font-semibold mb-4">Add Transaction</h3>
                <form action="/transactions/add" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="w-full sm:w-1/4">
                        <select name="category_id"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" class="hidden" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-1/4">
                        <select name="type"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" class="hidden" disabled selected>Select Type</option>
                            <option value="d">Deposit</option>
                            <option value="w">Withdrawal</option>

                        </select>
                    </div>
                    <div class="w-full sm:w-1/4">
                        <input type="number" name="amount" placeholder="Amount"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                    <div class="w-full sm:w-1/4">
                        <button type="submit"
                            class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Add Transaction
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
                            <th class="text-left py-2">Category</th>
                            <th class="text-right py-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Auth::user()->profiles as $profile)
                        @foreach ($profile->transactions as $transaction)
                            <tr class="border-b">
                                <td class="py-3">{{ $transaction->created_at }}</td>
                                <td>{{ $transaction->category->name }}</td>
                                <td
                                    class="text-right font-medium {{ $transaction->type === 'w' ? 'text-red-600' : 'text-green-600' }}">
                                    ${{ $transaction->amount }}</td>
                            </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-semibold mb-4">Expense Categories</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <li><a href="/categories/food" class="text-blue-500 hover:underline">Food</a></li>
                    <li><a href="/categories/housing" class="text-blue-500 hover:underline">Housing</a></li>
                    <li><a href="/categories/transportation" class="text-blue-500 hover:underline">Transportation</a>
                    </li>
                    <li><a href="/categories/entertainment" class="text-blue-500 hover:underline">Entertainment</a></li>
                    <li><a href="/categories/add" class="text-green-500 hover:underline">+ Add Category</a></li>
                </ul>
            </div>
        </div>

        <!-- Family Account Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-semibold mb-4">Family Account</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="mb-4">Manage your family members and their access to the account.</p>
                <a href="/family/manage" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Manage
                    Family Members</a>
            </div>
        </div>
    </div>
</x-playout>
