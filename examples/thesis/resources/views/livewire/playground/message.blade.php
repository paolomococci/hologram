<div>

    <div class="flex justify-center px-10 item-center">
        <div class="grid flex-1 grid-cols-4 gap-10">
            <div class="w-20 h-10 rounded bg-slate-300 dark:bg-slate-300/30 text-slate-300/30 dark:text-slate-300">
                <button class="mt-2 ml-4" x-on:click="alert('Hello!')">hello</button>
            </div>
            <div x-data="{ message: 'Hello!' }"
                class="w-20 h-10 rounded bg-slate-300 dark:bg-slate-300/30 text-slate-300/30 dark:text-slate-300">
                <button class="mt-2 ml-4" x-on:click="message = 'World!'" x-text="message">hello</button>
            </div>

            {{-- dispatch --}}
            <div class="w-20 h-10 rounded bg-slate-300 dark:bg-slate-300/30 text-slate-300/30 dark:text-slate-300"
                x-on:notify="alert('Hello World!')">
                <button class="mt-2 ml-4 capitalize" x-on:click="$dispatch('notify')">
                    notify
                </button>
            </div>

            {{-- dispatch event --}}
            <div class="w-20 h-10 rounded bg-slate-300 dark:bg-slate-300/30 text-slate-300/30 dark:text-slate-300"
                x-on:notify="alert($event.detail.message)">
                <button class="mt-2 ml-4 capitalize" x-on:click="$dispatch('notify', { message: 'Some message!' })">
                    notify
                </button>
            </div>

            {{-- dispatching to other components --}}
            <div class="w-20 h-10 rounded bg-slate-300 dark:bg-slate-300/30 text-slate-300/30 dark:text-slate-300"
                x-data>
                <button class="mt-2 ml-4 capitalize"
                    x-on:click="$dispatch('set-title-to-other-component', 'I will set title to other component!')">
                    set
                </button>
            </div>

            {{-- dispatching to x-model --}}
            <div class="w-20 h-10 rounded bg-slate-300 dark:bg-slate-300/30 text-slate-300/30 dark:text-slate-300"
                hidden>
            </div>

            {{-- $nextTick --}}
            <div x-data="{ title: 'Hello' }"
                class="w-20 h-10 rounded bg-slate-300 dark:bg-slate-300/30 text-slate-300/30 dark:text-slate-300">
                <button class="mt-2 ml-4 capitalize"
                    x-on:click="
                        title = 'Hello World!';
                        $nextTick(() => { console.log($el.innerText) });
                    "
                    x-text="title"></button>
            </div>

            {{-- promises --}}
            <div x-data="{ title: 'Hello' }"
                class="w-20 h-10 rounded bg-slate-300 dark:bg-slate-300/30 text-slate-300/30 dark:text-slate-300">
                <button class="mt-2 ml-4 capitalize"
                    x-on:click="
                        title = 'Hello World!';
                        await $nextTick();
                        console.log($el.innerText);
                    "
                    x-text="title"></button>
            </div>
        </div>
    </div>

    <div class="p-10 m-10 bg-lime-300 rounded dark:bg-lime-300/30 text-lime-300/30 dark:text-lime-300">
        <div x-data="{ title: 'Original title.' }"
            x-on:set-title-to-other-component.window="
                title = $event.detail;
                console.log($event.detail);
            ">
            <h1 x-text="title"></h1>
        </div>
    </div>

    {{-- $root --}}
    <div class="p-10 m-10 bg-lime-300 rounded dark:bg-lime-300/30 text-lime-300/30 dark:text-lime-300">
        <div x-data data-message="Hello from all people on the World!">
            <button class="mt-2 ml-4 capitalize"
                x-on:click="
                    console.log($root.dataset.message);
                    alert($root.dataset.message);
                ">
                hello
            </button>
        </div>
    </div>

    {{-- $data --}}
    <div class="p-10 m-10 bg-lime-300 rounded dark:bg-lime-300/30 text-lime-300/30 dark:text-lime-300">
        <div x-data="{ greeting: 'Hello' }">
            <div x-data="{ name: 'John Doe' }">
                <button class="mt-2 ml-4 capitalize" x-on:click="sayHello($data)">
                    say hello
                </button>
            </div>
        </div>

        <script>
            function sayHello({
                greeting,
                name
            }) {
                alert(greeting + ' ' + name + '!')
            }
        </script>
    </div>

    {{-- $id for ensure that it won't conflict --}}
    <h3 class="font-semibold text-black text-md-end dark:text-white">$id for ensure that it won't conflict</h3>

    {{-- basic use --}}
    <div class="p-10 m-10 bg-lime-300 rounded dark:bg-lime-300/30 text-lime-300/30 dark:text-lime-300">
        <input class="py-2 my-2 rounded-sm border-2 border-orange-300 text-slate-900 bg-slate-300" type="text"
            :id="$id('text-input')">
        <input class="py-2 my-2 rounded-sm border-2 border-orange-300 text-slate-900 bg-slate-300" type="text"
            :id="$id('text-input')">
    </div>
    {{-- grouping x-id --}}
    <div class="p-10 m-10 bg-lime-300 rounded dark:bg-lime-300/30 text-lime-300/30 dark:text-lime-300">
        <div x-data="{ id: $id('text-input') }">
            <label class="dark:text-orange-400 text-orange-400/50" :for="id" x-text="id"></label>
            <input class="py-2 my-2 rounded-sm border-2 border-orange-300 text-slate-900 bg-slate-300" type="text"
                :id="id">
        </div>

        <div x-data="{ id: $id('text-input') }">
            <label class="dark:text-orange-400 text-orange-400/50" :for="id" x-text="id"></label>
            <input class="py-2 my-2 rounded-sm border-2 border-orange-300 text-slate-900 bg-slate-300" type="text"
                :id="id">
        </div>
    </div>
    {{-- grouping x-id with id scope --}}
    <div class="p-10 m-10 bg-lime-300 rounded dark:bg-lime-300/30 text-lime-300/30 dark:text-lime-300">
        <div x-id="['text-input']">
            <label class="dark:text-orange-400 text-orange-400/50" :for="$id('text-input')"
                x-text="$id('text-input')"></label>
            <input class="py-2 my-2 rounded-sm border-2 border-orange-300 text-slate-900 bg-slate-300" type="text"
                :id="$id('text-input')">
        </div>

        <div x-id="['text-input']">
            <label class="dark:text-orange-400 text-orange-400/50" :for="$id('text-input')"
                x-text="$id('text-input')"></label>
            <input class="py-2 my-2 rounded-sm border-2 border-orange-300 text-slate-900 bg-slate-300" type="text"
                :id="$id('text-input')">
        </div>
    </div>

    {{-- Alpine.data --}}
    <h3 class="font-semibold text-black text-md-end dark:text-white">Alpine.data</h3>

    {{-- dropdown component --}}
    <div class="p-10 m-10 bg-lime-300 rounded dark:bg-lime-300/30 text-lime-300/30 dark:text-lime-300">
        <div x-data="dropdown">
            <button class="mt-2 ml-4 uppercase" x-on:click="toggle">
                actions
            </button>

            <div class="mt-2 ml-4 capitalize" x-show="show">
                <a class="block" href="#">some one</a>
                <a class="block" href="#">some two</a>
                <a class="block" href="#">some three</a>
            </div>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('dropdown', () => ({
                    show: false,

                    toggle() {
                        this.show = ! this.show
                    }
                }))
            })
        </script>
    </div>

    {{-- Alpine.store --}}
    <h3 class="font-semibold text-black text-md-end dark:text-white">Alpine.store</h3>

    <div class="p-10 m-10 bg-lime-300 rounded dark:bg-lime-300/30 text-lime-300/30 dark:text-lime-300">
        {{-- register a store --}}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('nameOfStore', {
                    isDeprecated: false,

                    toggleValue() {
                        this.isDeprecated = ! this.isDeprecated
                    }
                })
            })
        </script>
        {{-- access to store --}}
        <div x-data :class="$store.nameOfStore.isDeprecated">
            <p class="text-orange-300" x-text="'isDeprecated: ' + $store.nameOfStore.isDeprecated"></p>
        </div>
        {{-- toggle isDeprecated on store --}}
        <button class="mt-2 ml-4 uppercase" x-on:click="$store.nameOfStore.toggleValue()">
            toggle
        </button>
    </div>

</div>
