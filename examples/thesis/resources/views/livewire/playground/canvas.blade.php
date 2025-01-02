<div>

    {{-- title of this component --}}
    <h2 class="text-xl font-semibold text-black dark:text-white">{{ $title }}</h2>

    {{-- explanation of this component --}}
    <p class="mt-4 text-sm/relaxed">
        {{ $explanation }}
    </p>

    <div x-data="canvas()" class="inline-block justify-center p-6">

        {{-- grid template --}}
        <div class="grid grid-rows-4 grid-flow-col gap-2">
            <template x-for="card in cards">
                <div class="w-10 h-10">
                    <div x-show="! card.cleared">
                        <button :style="'background: ' + (card.toggled ? card.color : '#999')"
                            class="p-1 m-1 w-full h-10 rounded-md" x-on:click="toggleCard(card)">  </button>
                    </div>
                </div>
            </template>
        </div>

        {{-- score indicator --}}
        <h1 class="p-10 text-3xl font-bold">
            <span class="text-xs">score: </span>
            <span x-text="points"></span>
            <span class="text-xs">points</span>
        </h1>

        {{-- feedback message --}}
        <div x-data="{ show: false, message: '' }"
            x-on:feedback.window="
                {{-- alert(message); --}}
                message = $event.detail.message;
                console.log(message);
                show = true;
                setTimeout(() => show = false, 2000);
            ">
            {{-- feedback message view --}}
            <p x-show="show" x-text="message" class="w-full h-10 dark:text-green-300 text-green-300/30"></p>
        </div>

    </div>

    <script>
        function pause(milliSecs) {
            return new Promise(resolve => setTimeout(resolve, milliSecs));
        }

        function feedback(message) {
            window.dispatchEvent(new CustomEvent('feedback', {
                detail: {
                    message
                }
            }))
        }

        function canvas() {
            return {
                cards: [{
                        color: '#f75',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#f00',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#800',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#ff0',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#fb0',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#0f0',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#088',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#00f',
                        toggled: false,
                        cleared: false,
                    },{
                        color: '#f75',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#f00',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#800',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#ff0',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#fb0',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#0f0',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#088',
                        toggled: false,
                        cleared: false,
                    },
                    {
                        color: '#00f',
                        toggled: false,
                        cleared: false,
                    },
                ].sort(() => Math.random() - .5),

                get toggledCards() {
                    return this.cards.filter(card => card.toggled)
                },

                get clearedCards() {
                    return this.cards.filter(card => card.cleared)
                },

                get remainingCards() {
                    return this.cards.filter(card => !card.cleared)
                },

                get points() {
                    return this.clearedCards.length
                },

                async toggleCard(card) {
                    card.toggled = !card.toggled
                    if (this.toggledCards.length !== 2) return
                    if (this.hasMatch() && this.remainingCards.length) {
                        feedback('Color matched!')
                        await pause(1000)
                        this.toggledCards.forEach(card => card.cleared = true)
                        if (!this.remainingCards.length) {
                            feedback('You found all couples!')
                            await pause(10000)
                        }
                    } else {
                        await pause(1000)
                    }
                    this.toggledCards.forEach(card => card.toggled = false)
                },

                hasMatch() {
                    return this.toggledCards[0]['color'] === this.toggledCards[1]['color']
                },
            }
        }
    </script>

</div>
