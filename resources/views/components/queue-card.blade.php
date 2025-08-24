{{-- resources/views/components/queue-card.blade.php --}}
<div id="{{ $queue['type'] }}-{{ $queue['staff']['id'] }}"
    class="bg-white rounded-3xl shadow-2xl border border-gray-200 flex flex-col items-center justify-between text-center px-8 py-6 w-fit h-fit mx-auto">
    <!-- Header Poli -->
    <p
        class="text-white font-bold mb-2 px-4 py-1 rounded-full bg-gradient-to-r from-blue-500 to-blue-700 shadow-lg text-[clamp(0.8rem,1.2vw,2rem)] leading-tight text-center break-words max-w-100 max-h-[2.5em] overflow-hidden">
        {{ $queue['name'] }}
    </p>
    <!-- Nomor Antrian -->
    <span
        class="font-extrabold text-green-700 drop-shadow-xl nomor-antrian text-[clamp(3rem,4vw,5rem)] leading-tight tracking-tighter text-center break-words">
        @if (isset($queue['queue']))
            {{ $queue['queue']['number_code'] }}{{ $queue['queue']['number_queue'] }}
        @else
            -
        @endif
    </span>
</div>
