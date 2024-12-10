<div class="pt-3 sm:pt-5">
    <h2 class="text-xl font-semibold text-black dark:text-white">Response</h2>

    <p class="mt-4 text-sm/relaxed">
        {{ $this->llmSolution }}
    </p>
    <p class="mt-4 text-red-600 text-sm/relaxed">
        {{ $this->errorMessage }}
    </p>
    <p wire:loading class="mt-4 text-cyan-700 opacity-40 text-sm/relaxed">
        Waiting for a solution...
    </p>
</div>
