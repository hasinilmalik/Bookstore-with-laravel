@extends('layouts.frontend')

@section('content')
    <div class="grid grid-cols-5 gap-4 mt-6">
        <div class="col-span-3">
            <div class="p-4 bg-white rounded-lg shadow-soft">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold tracking-widest text-gray-400 uppercase">Transaction Detail</p>
                    <p class="text-sm font-medium text-primary">#{{ $detail->reference }}</p>
                </div>
                <div class="mt-3">
                    <h3 class="text-3xl font-medium text-primary">Rp. {{ number_format($detail->amount) }}</h3>
                    {{-- <div class="inline-block px-2 py-1 mt-4 text-xs font-semibold text-green-600 bg-green-200 rounded-full">Paid</div> --}}
                    <div class="inline-block px-2 py-1 mt-4 text-xs font-semibold text-red-600 bg-red-200 rounded-full">
                        {{ $detail->status }}</div>
                </div>
            </div>
        </div>
        <div class="col-span-2">
            <div class="p-4 bg-white rounded-lg shadow-soft">
                <p class="text-xs font-semibold tracking-widest text-gray-400 uppercase">Instruction</p>
                @foreach ($detail->instructions as $instruksi)
                    <div tabindex="0" class="mt-3 collapse">
                        <div class="font-medium collapse-title" style="color: black">
                            <div class="flex items-center justify-between cursor-pointer">
                                <span>
                                    {{ $instruksi->title }}
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="collapse-content" style="color: black">
                            <ul>
                                @foreach ($instruksi->steps as $step)
                                    <li>{{ $loop->iteration }}. {!! $step !!}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
