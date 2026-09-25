@extends('layouts.base')

@section('body')
<div class="min-h-screen flex flex-col justify-between">
    <!-- Public Header Navigation -->
    @include('layouts.navigation')

    <!-- Main Page Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Public Footer -->
    @include('layouts.footer')
</div>
@endsection
