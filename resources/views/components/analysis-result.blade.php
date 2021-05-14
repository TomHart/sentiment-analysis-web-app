<div
    class="shadow my-4 p-4 border-l-2 border-b-2 border-{{$this->result->getResult() === \TomHart\SentimentAnalysis\SentimentType::POSITIVE ? 'green' : 'red'}}-500">

    <p class="text-gray-700">
        That sentence has a {{$this->result->getResult()}} sentiment.
    </p>

    <p class="mt-3 text-sm text-gray-500">
        How sure am I?
    </p>

    <div class="bg-red-700 h-4 rounded" title="Negative accuracy: {{$this->result->getNegativeAccuracy()}}">
        <div
            class="bg-green-700 h-4 rounded"
            title="Positive accuracy: {{$this->result->getPositiveAccuracy()}}"
            style="width:{{$this->result->getPositiveAccuracy() * 100}}%">

        </div>
    </div>
</div>
