{{-- refactoring --}}
@php
    use App\Utils\CleaningUtility;
@endphp

<div>
    {{-- useful divide during testing TODO: modify the constant TEST_PHASE accordingly --}}
    @if (self::TEST_PHASE)
        <div class="w-2/5 h-full text-xs text-gray-700 dark:text-gray-300">
            <h3>livewire:article.catalog</h3>
            <h5>dispatched variables:</h5>
            <h6>$articleToggle:</h6>
            <p>{{ var_dump($articleToggle) }}</p>
            <h6>$filterText:</h6>
            <p>{{ var_dump($filterText) }}</p>
            <h6>$approvedArticlesDispatched:</h6>
            <p>{{ var_dump($approvedArticlesDispatched) }}</p>
            <h6>$deprecatedArticlesDispatched:</h6>
            <p>{{ var_dump($deprecatedArticlesDispatched) }}</p>
            <h5>computed variables:</h5>
            <h6>$this->approvedArticlesComputed:</h6>
            <p>{{ var_dump($this->approvedArticlesComputed) }}</p>
            <h6>$this->deprecatedArticlesComputed:</h6>
            <p>{{ var_dump($this->deprecatedArticlesComputed) }}</p>
            <h6>$this->totalNumberOfRetrievedArticles:</h6>
            <p>{{ var_dump($this->totalNumberOfRetrievedArticles) }}</p>
            <h6>$this->totalNumberOfApprovedArticles:</h6>
            <p>{{ var_dump($this->totalNumberOfApprovedArticles) }}</p>
            <h6>$this->totalNumberOfDeprecatedArticles:</h6>
            <p>{{ var_dump($this->totalNumberOfDeprecatedArticles) }}</p>
        </div>
        {{-- follows the actual view --}}
    @elseif (!self::TEST_PHASE)
        <div>
            @if (isset($filterText) && $filterText != '' && $this->totalNumberOfApprovedArticles && !$articleToggle)
                {{-- pagination of approved articles --}}
                <div class='mt-4 w-full text-slate-400'>
                    {{ $this->approvedArticlesComputed->onEachSide(0)->links() }}
                </div>
                <div>
                    <table class="mt-4">
                        <thead class="text-xs text-gray-400 uppercase bg-gray-700">
                            <tr class="text-slate-800 dark:text-slate-300">
                                <th class="px-6 py-3">Approved</th>
                                <th class="px-6 py-3">Edit</th>
                                <th class="px-6 py-3">Set</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->approvedArticlesComputed as $article)
                                <tr wire:key="{{ $article['id'] }}" class="border-b-2 border-green-100 bg-slate-800">
                                    <td class="px-6 py-3">
                                        <h3
                                            class="font-semibold text-xs uppercase lg:text-nowrap {{ $articleToggle ? 'text-red-900 dark:text-red-400' : 'text-green-900 dark:text-green-400' }}">
                                            {{ CleaningUtility::cleanTitle($article['title']) }}
                                        </h3>
                                    </td>
                                    <td class="px-6 py-3">
                                        <button class="p-2 text-cyan-200 bg-cyan-600 rounded-md hover:bg-cyan-800">
                                            <a href="/dashboard/article/{{ $article['id'] }}/edit" wire:navigate>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                            class="p-2 rounded-md {{ $articleToggle ? 'text-green-200 bg-green-600 hover:bg-green-800' : 'text-red-200 bg-red-600 hover:bg-red-800' }}"
                                            wire:click="deprecate({{ $article['id'] }})"
                                            wire:confirm="Do you really want to {{ $articleToggle ? 'approve' : 'deprecate' }} this article?">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="text-red-300 lucide lucide-circle-minus size-4 sm:size-3 lg:size-5">
                                                <title>{{ !$articleToggle ? 'set as deprecated' : 'set as approved' }}
                                                </title>
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="M8 12h8" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif (isset($filterText) && $filterText != '' && $this->totalNumberOfDeprecatedArticles && $articleToggle)
                {{-- pagination of deprecated articles --}}
                <div class='mt-4 w-full text-slate-400'>
                    {{ $this->deprecatedArticlesComputed->onEachSide(0)->links() }}
                </div>
                <div>
                    <table class="mt-4">
                        <thead class="text-xs text-gray-400 uppercase bg-gray-700">
                            <tr class="text-slate-800 dark:text-slate-300">
                                <th class="px-6 py-3">Deprecated</th>
                                <th class="px-6 py-3">Edit</th>
                                <th class="px-6 py-3">Set</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->deprecatedArticlesComputed as $article)
                                <tr wire:key="{{ $article['id'] }}" class="border-b-2 border-green-100 bg-slate-800">
                                    <td class="px-6 py-3">
                                        <h3
                                            class="font-semibold text-xs uppercase lg:text-nowrap {{ $articleToggle ? 'text-red-900 dark:text-red-400' : 'text-green-900 dark:text-green-400' }}">
                                            {{ CleaningUtility::cleanTitle($article['title']) }}
                                        </h3>
                                    </td>
                                    <td class="px-6 py-3">
                                        <button class="p-2 text-cyan-200 bg-cyan-600 rounded-md hover:bg-cyan-800">
                                            <a href="/dashboard/article/{{ $article['id'] }}/edit" wire:navigate>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                            class="p-2 rounded-md {{ $articleToggle ? 'text-green-200 bg-green-600 hover:bg-green-800' : 'text-red-200 bg-red-600 hover:bg-red-800' }}"
                                            wire:click="deprecate({{ $article['id'] }})"
                                            wire:confirm="Do you really want to {{ $articleToggle ? 'approve' : 'deprecate' }} this article?">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="text-red-300 lucide lucide-circle-minus size-4 sm:size-3 lg:size-5">
                                                <title>{{ !$articleToggle ? 'set as deprecated' : 'set as approved' }}
                                                </title>
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="M8 12h8" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- @elseif (isset($filterText) && $filterText != '' && $this->totalNumberOfApprovedArticles && $articleToggle) --}}
                {{-- TODO: approved articles equal or less than self::ARTICLES_PER_PAGE --}}
                {{-- @elseif (isset($filterText) && $filterText != '' && $this->totalNumberOfDeprecatedArticles && $articleToggle) --}}
                {{-- TODO: deprecate articles equal or less than self::ARTICLES_PER_PAGE --}}
            @elseif (isset($filterText) &&
                    $filterText != '' &&
                    $this->totalNumberOfApprovedArticles > 0 &&
                    $this->totalNumberOfDeprecatedArticles == 0)
                {{-- notice: only approved articles --}}
                <div class='mt-4 w-full text-slate-400'>
                    <p>
                        Only approved articles are present.
                    </p>
                    <p>
                        Please, switch to these.
                    </p>
                </div>
            @elseif (isset($filterText) &&
                    $filterText != '' &&
                    $this->totalNumberOfApprovedArticles === 0 &&
                    $this->totalNumberOfDeprecatedArticles > 0)
                {{-- notice: only deprecated articles --}}
                <div class='mt-4 w-full text-slate-400'>
                    <p>
                        Only deprecated articles are present.
                    </p>
                    <p>
                        Please, switch to these.
                    </p>
                </div>
            @elseif ($this->totalNumberOfRetrievedArticles === 0)
                {{-- no results available --}}
                <p class='mt-4 w-full text-xs uppercase text-slate-400'>
                    No results available.
                </p>
            @else
                {{-- empty filter field --}}
                <p class='mt-4 w-full text-xs uppercase text-slate-400'>
                    Try filtering by text.
                </p>
            @endif
        </div>
    @endif
</div>
