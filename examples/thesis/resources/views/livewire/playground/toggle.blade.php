<div>

    {{-- title of this component --}}
    <h2 class="text-xl font-semibold text-black dark:text-white">{{ $title }}</h2>

    {{-- explanation of this component --}}
    <p class="mt-4 text-sm/relaxed">
        {{ $explanation }}
    </p>

    <div x-data="{ currentTab: 'first' }">
        <button x-on:click="currentTab = 'first'" :class="{ 'active': currentTab === 'first' }">first</button>
        <button x-on:click="currentTab = 'second'" :class="{ 'active': currentTab === 'second' }">second</button>
        <button x-on:click="currentTab = 'third'" :class="{ 'active': currentTab === 'third' }">third</button>

        <div class="tab-wrap">
            <div x-show="currentTab === 'first'">
                <p>first tab…</p>
            </div>

            <div x-show="currentTab === 'second'">
                <p>second tab…</p>
            </div>

            <div x-show="currentTab === 'third'">
                <p>third tab…</p>
            </div>
        </div>
    </div>

</div>
