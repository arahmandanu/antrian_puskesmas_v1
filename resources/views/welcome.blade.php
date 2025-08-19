@extends('shared.main')

@section('content')
    <div class="flex-grow flex items-center justify-center p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl w-full">

            <!-- Loket List -->
            <a href="{{ route('loket_antrian.list') }}"
                class="flex flex-col items-center justify-center w-48 aspect-square bg-blue-500 text-white rounded-lg shadow-md hover:opacity-90 transition">
                <i class="fa fa-list fa-fw fa-4x mb-2"></i>
                <span class="text-xl font-semibold text-center">Loket List</span>
            </a>

            <!-- Poli List -->
            <a href="{{ route('loket_antrian.poli_list') }}"
                class="flex flex-col items-center justify-center w-48 aspect-square bg-yellow-500 text-white rounded-lg shadow-md hover:opacity-90 transition">
                <i class="fa fa-hospital-o fa-4x mb-2"></i>
                <span class="text-xl font-semibold">Poli List</span>
            </a>

            <!-- Loket Antrian -->
            <a href="{{ route('loket_antrian.index') }}"
                class="flex flex-col items-center justify-center w-48 aspect-square bg-red-500 text-white rounded-lg shadow-md hover:opacity-90 transition">
                <i class="fa fa-bell fa-4x mb-2"></i>
                <span class="text-xl font-semibold text-center">Loket Antrian</span>
            </a>

            <!-- Play Suara -->
            <a href="{{ route('play_suara') }}"
                class="flex flex-col items-center justify-center w-48 aspect-square bg-purple-500 text-white rounded-lg shadow-md hover:opacity-90 transition">
                <i class="fa fa-volume-up fa-4x mb-2"></i>
                <span class="text-xl font-semibold text-center">Play Suara</span>
            </a>

            <!-- Admin -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex flex-col items-center justify-center w-48 aspect-square bg-green-500 text-white rounded-lg shadow-md hover:opacity-90 transition">
                <i class="fa fa-th fa-fw fa-4x mb-2"></i>
                <span class="text-xl font-semibold">Admin</span>
            </a>
        </div>
    </div>
@endsection
