<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Withdrawal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('transaction.withdrawal.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">User</label>
                            <select name="user_id" id="" class="form-select" required>
                                <option value="">Select User</option>
                                @foreach($users as $record)
                                    <option value="{{ $record->id }}">{{ $record->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <span class="text-sm text-red-600 space-y-1">{{ $errors->first('user_id') }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" step="any" class="form-control" id="amount" name="amount" required>
                            @error('amount')
                            <span class="text-sm text-red-600 space-y-1">{{ $errors->first('amount') }}</span>
                            @enderror
                        </div>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
