<!-- Table -->
<table class='mx-auto max-w-4xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
    <thead class="bg-gray-100">
    <tr class="text-gray-600 text-left">
        @foreach($columns as $column)
            <th class="font-semibold text-sm uppercase px-6 py-4">
                {{$column}}
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">

    @foreach($items as $item)
        <tr>
            @foreach($columns as $column)
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        {{$item->$column}}
                    </div>
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
