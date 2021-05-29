<div
    class="shadow my-4 p-4 border-l-2 border-b-2 border-{{$this->result->getResult() === \TomHart\SentimentAnalysis\SentimentType::POSITIVE ? 'green' : 'red'}}-500">

    <p class="text-gray-700">
        That sentence has a {{$this->result->getResult()}} sentiment.
    </p>

    <p class="mt-3 text-sm text-gray-500">
        How sure am I?
    </p>

    <div class="bg-red-700 h-4 rounded my-2" title="Negative accuracy: {{$this->result->getNegativeAccuracy()}}">
        <div
            class="bg-green-700 h-4 rounded"
            title="Positive accuracy: {{$this->result->getPositiveAccuracy()}}"
            style="width:{{$this->result->getPositiveAccuracy() * 100}}%">
        </div>
    </div>

    <div class="text-gray-700">
        <p class="mb-3">Breakdown</p>


        @foreach($this->result->getWorkings() as $word => $breakdown)
            <div class="border-b-2 border-gray-400 border-b pb-3">
                <p class="text-lg">
                    {{$word}}
                </p>
                @foreach($breakdown as $type => $details)
                    <div class="p-3 bg-{{ match($type) { 'positive' => 'green', 'negative' => 'red'} }}-100">
                        <p class="">
                            {{ucwords($type)}}
                        </p>
                        @foreach($details as $key => $value)
                            <p class="ml-8 text-sm">
                                {{ucwords(str_replace('_', ' ', $key))}}: {{$value}}
                            </p>
                        @endforeach()
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
