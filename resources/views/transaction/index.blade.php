<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Type</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Fee</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($transactions->count() > 0)
                            @foreach($transactions as $key => $record)
                                <tr>
                                    <th scope="row">{{$key + 1}}</th>
                                    <td>{{ date('d-M-Y', strtotime($record->date)) }}</td>
                                    <td>{{ $record->transaction_type }}</td>
                                    <td>{{ $record->amount }}</td>
                                    <td>{{ $record->fee }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">{{ "No record found!" }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
