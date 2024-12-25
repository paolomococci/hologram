<div class="mb-4 w-11/12">
    @php
        if (isset($filterText) && $filterText === '') {
            $articles = [];
        } else {
            try {
                if (count($numberOfArticles) > self::ARTICLES_PER_PAGE) {
                    echo "<div class='mt-4 w-full text-slate-400'>";
                    echo $articles->links();
                    echo '</div>';
                }
            } catch (\Exception $e) {
                $articles = [];
            }
        }
    @endphp
    <table class="mt-4">
        <thead class="text-xs text-gray-400 uppercase bg-gray-700">
            @if (!empty($articles) && $onlyDeprecated)
                <tr class="text-slate-800 dark:text-slate-300">
                    <th class="px-6 py-3" colspan="3">
                        There are only deprecated articles! Try switching to these.
                    </th>
                </tr>
            @elseif (!empty($articles))
                <tr class="text-slate-800 dark:text-slate-300">
                    <th class="px-6 py-3">{{ $deprecated ? 'Deprecated' : 'Approved' }}</th>
                    <th class="px-6 py-3">Edit</th>
                    <th class="px-6 py-3">Set</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr wire:key="{{ $article['id'] }}" class="border-b-2 border-green-100 bg-slate-800">
                    <td class="px-6 py-3">
                        <h3
                            class="font-semibold text-md-center {{ $deprecated ? 'text-red-900 dark:text-red-400' : 'text-green-900 dark:text-green-400' }}">
                            {{ $article['title'] }}
                        </h3>
                    </td>
                    <td class="px-6 py-3">
                        <button class="p-2 text-cyan-200 bg-cyan-600 rounded-md hover:bg-cyan-800">
                            <a href="/dashboard/article/{{ $article['id'] }}/edit" wire:navigate>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-cyan-300 lucide lucide-pencil size-4 sm:size-3 lg:size-5">
                                    <title>edit</title>
                                    <path
                                        d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </a>
                        </button>
                    </td>
                    <td class="px-6 py-3">
                        <button
                            class="p-2 rounded-md {{ $deprecated ? 'text-green-200 bg-green-600 hover:bg-green-800' : 'text-red-200 bg-red-600 hover:bg-red-800' }}"
                            wire:click="deprecate({{ $article['id'] }})"
                            wire:confirm="Do you really want to {{ $deprecated ? 'approve' : 'deprecate' }} this article?">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="text-red-300 lucide lucide-circle-minus size-4 sm:size-3 lg:size-5">
                                <title>{{ !$deprecated ? 'set as deprecated' : 'set as approved' }}</title>
                                <circle cx="12" cy="12" r="10" />
                                <path d="M8 12h8" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (empty($articles))
        <div class="p-3 mt-5 rounded-sm border-1 bg-slate-800">
            filter by title
        </div>
    @endif
</div>
