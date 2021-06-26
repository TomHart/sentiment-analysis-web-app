<x-consumer-layout>

    <x-login-float/>

    <div class="site-splash bg-gray-100">

        <img class="site-splash__img" src="{{url('img/question_mark.jpg')}}"/>

        <p class="site-splash__title">
            Think What is a sentiment analysis platform.
        </p>
    </div>

    <div class="site-splash site-splash--right bg-blue-100">

        <img class="site-splash__img" src="{{url('img/thinking.jpg')}}"/>

        <p class="site-splash__title">
            You can get insight into how people feel about your business, product, or brand.
        </p>
    </div>

    <div class="site-splash bg-yellow-50">

        <img class="site-splash__img" src="{{url('img/ai.jpg')}}"/>

        <p class="site-splash__title">
            We use artificial intelligence to analysis text, and automatically determine whether people are
            saying positive or negative things.
        </p>
    </div>

    <div class="bg-purple-100 px-16 py-32">
        <p class="text-3xl">
            Try it out.
        </p>

        <livewire:use-brain :brain="$brain"/>
    </div>
</x-consumer-layout>
