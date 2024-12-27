{{-- refactoring --}}
@php
    use App\Utils\CleaningUtility;

    if (isset($filterText) && $filterText === '') {
        $approved = [];
        $deprecated = [];
        $this->totalNumberOfRetrievedArticles = 0;
        $this->totalNumberOfApprovedArticles = 0;
        $this->totalNumberOfDeprecatedArticles = 0;
    }
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
            <h6>$approved:</h6>
            <p>{{ var_dump($approved) }}</p>
            <h6>$deprecated:</h6>
            <p>{{ var_dump($deprecated) }}</p>
            <h5>computed variables:</h5>
            <h6>$this->approvedArticles:</h6>
            <p>{{ var_dump($this->approvedArticles) }}</p>
            <h6>$this->deprecatedArticles:</h6>
            <p>{{ var_dump($this->deprecatedArticles) }}</p>
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
            <p>livewire:article.catalog</p>
        </div>
        <div>
            @if (isset($filterText) && $filterText != '' && $this->totalNumberOfApprovedArticles && !$articleToggle)
                {{-- pagination of approved articles --}}
                <div class='mt-4 w-full text-slate-400'>
                    {{ $this->approvedArticles->onEachSide(0)->links() }}
                </div>
            @elseif (isset($filterText) && $filterText != '' && $this->totalNumberOfDeprecatedArticles && $articleToggle)
                {{-- pagination of deprecated articles --}}
                <div class='mt-4 w-full text-slate-400'>
                    {{ $this->deprecatedArticles->onEachSide(0)->links() }}
                </div>
            @elseif (isset($filterText) && $filterText === '')
                {{-- no results available --}}
                <p class='mt-4 w-full text-xs uppercase text-slate-400'>
                    No results available.
                </p>
            @else
                {{-- unexpected situation --}}
                <p class='mt-4 w-full text-xs uppercase text-slate-400'>
                    I'm sorry, an unexpected situation has arisen.
                </p>
            @endif
        </div>
    @endif
</div>
