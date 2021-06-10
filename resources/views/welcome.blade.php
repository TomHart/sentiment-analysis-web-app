<x-consumer-layout>
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif


        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 text-gray-700">
            <h1 class="text-5xl my-8">Think What</h1>

            <div class="bg-white p-8 shadow rounded">
                <p class="text-4xl">
                    Think What is a sentiment analysis platform.
                </p>

                {{-- TODO: Animate business/product/brand to be words that switch out --}}
                <p class="text-xl my-6">
                    You can get insight into how people feel about your business, product, or brand.
                </p>

                <p class="text-xl my-6">
                    We use artificial intelligence to analysis text, and automatically determine whether people are
                    talking positively or negatively about you.
                </p>

                <div class="text-xl my-6">
                    Try it out.

                    <livewire:use-brain :brain="$brain" />
                </div>
            </div>
        </div>
    </div>
</x-consumer-layout>
