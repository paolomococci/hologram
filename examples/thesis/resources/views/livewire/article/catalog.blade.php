{{-- refactoring --}}
<div class="w-2/5 h-full">
    {{-- useful paragraph during testing TODO: modify the constant TEST_PHASE accordingly --}}
    <div class="text-xs text-gray-700 dark:text-gray-300">
        @if (self::TEST_PHASE)
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
            <p>{{ var_dump($this->deprecatedArticles )}}</p>
            <h6>$this->totalNumberOfRetrievedArticles:</h6>
            <p>{{ var_dump($this->totalNumberOfRetrievedArticles) }}</p>
            <h6>$this->totalNumberOfApprovedArticles:</h6>
            <p>{{ var_dump($this->totalNumberOfApprovedArticles) }}</p>
            <h6>$this->totalNumberOfDeprecatedArticles:</h6>
            <p>{{ var_dump($this->totalNumberOfDeprecatedArticles) }}</p>
        @endif
    </div>
</div>

{{-- follows the actual view --}}
@php
    use App\Utils\CleaningUtility;
@endphp
