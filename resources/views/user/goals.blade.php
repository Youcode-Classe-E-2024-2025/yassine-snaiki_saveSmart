<x-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900">Saving Goals</h1>

            <!-- Current Goal Section -->
            <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Current Goal</h2>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Your active saving target</p>
                    </div>
                    @if($currentGoal)
                        <div class="flex space-x-2">
                            <button type="button" onclick="document.getElementById('edit-modal').classList.remove('hidden')" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Edit
                            </button>
                            <form action="{{ route('goals.destroy', $currentGoal) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this goal?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                @if($currentGoal)
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Target: ${{ number_format($currentGoal->amount, 2) }}</span>
                            <span class="text-sm font-medium text-gray-700">Saved: ${{ number_format($currentGoal->progress, 2) }}</span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                            <div class="bg-indigo-600 h-4 rounded-full" style="width: {{ min(($currentGoal->progress / $currentGoal->amount) * 100, 100) }}%"></div>
                        </div>

                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ min(($currentGoal->progress / $currentGoal->amount) * 100, 100)}}% Complete</span>
                            <span>${{ number_format($currentGoal->amount - $currentGoal->progress, 2) }} Remaining</span>
                        </div>
                    </div>
                @else
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <div id="no-goal-message">
                            <p class="text-gray-500">You don't have an active saving goal.</p>
                            <button
                                type="button"
                                onclick="document.getElementById('no-goal-message').classList.add('hidden'); document.getElementById('create-goal-form').classList.remove('hidden');"
                                class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create New Goal
                            </button>
                        </div>

                        <div id="create-goal-form" class="hidden">
                            <form action="{{ route('goals.store') }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label for="amount" class="block text-sm font-medium text-gray-700">Target Amount ($)</label>
                                        <div class="mt-1">
                                            <input type="number" step="0.01" min="0" name="amount" id="amount" required class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-3">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Save Goal
                                        </button>
                                        <button
                                            type="button"
                                            onclick="document.getElementById('create-goal-form').classList.add('hidden'); document.getElementById('no-goal-message').classList.remove('hidden');"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Past Goals Section -->
            <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h2 class="text-lg leading-6 font-medium text-gray-900">Past Goals</h2>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Your completed saving goals</p>
                </div>

                <div class="border-t border-gray-200">
                    @if(count($pastGoals) > 0)
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($pastGoals as $goal)
                                <li class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-indigo-600 truncate">{{ $goal->title }}</p>
                                            <p class="text-sm text-gray-500">
                                                Target: ${{ number_format($goal->amount, 2) }} ·
                                            </p>
                                        </div>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="px-4 py-5 sm:p-6 text-center text-gray-500">
                            You don't have any completed goals yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Goal Modal -->
    @if($currentGoal)
        <div id="edit-modal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('edit-modal').classList.add('hidden')"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('goals.update', $currentGoal) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Edit Saving Goal
                                    </h3>
                                    <div class="mt-4">
                                        <label for="amount" class="block text-sm font-medium text-gray-700">Target Amount ($)</label>
                                        <input type="number" step="0.01" min="0" name="amount" id="amount" value="{{ $currentGoal->amount }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Save Changes
                            </button>
                            <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-layout>
