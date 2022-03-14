@extends('layouts.frontend')

@section('content')
    <a href="{{ url()->previous() }}"
        class="inline-block mt-6 text-sm transition duration-300 ease-in-out text-primary hover:text-black">
        < Kembali </a>
            <h2 class="mt-3 text-lg font-medium text-primary">Choose your payment method</h2>
            <div class="grid grid-cols-5 gap-3 mt-6">
                <div class="col-span-4">
                    <div class="grid grid-cols-4 gap-3">
                        @foreach ($channels as $channel)
                            @if ($channel->active)
                                <form action="{{ route('transaction.store') }}" method="POST">
                                    @method('POST')
                                    @csrf
                                    <button type="submit">
                                        <input type="hidden" value="{{ $channel->code }}" name="method">
                                        <input type="hidden" value="{{ $book->id }}" name="book_id">
                                        <div class="flex items-center h-32 p-5 bg-white rounded-md w-36 shadow-soft">
                                            <div>
                                                <img src="{{ asset('storage/bank/') . '/' . $channel->code . '.png' }}"
                                                    class="w-full" alt="">
                                                <p class="mt-3 text-xs text-gray-600">{{ $channel->name }}</p>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-span-1">
                    <img class="object-contain rounded-md" src="{{ asset('storage/' . $book->cover_image) }}" alt="">
                    <p class="mt-3 text-lg text-primary">{{ $book->title }}</p>
                    <p class="mt-1 text-sm font-bold text-primary">Rp.{{ number_format($book->price) }}</p>
                </div>
            </div>
        @endsection
