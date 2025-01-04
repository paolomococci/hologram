{{-- Data in json format will be passed as props. --}}
{{-- Attention: it is necessary to remove the character entities! --}}
@props(['jsonDataItems'])

@php
    if ($jsonDataItems) {
        $jsonDataItems = htmlspecialchars_decode($jsonDataItems);
        $arrayDataItems = json_decode($jsonDataItems);
    } else {
        $jsonDataItems = '';
    }
    $unrollAccordionIcon =
        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up"><path d="m18 15-6-6-6 6"/></svg>';
    $rollUpAccordionIcon =
        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>';
@endphp

<div>

    <section>

        <div x-data="{
            {{-- dataItems with persist plugin --}}
            dataItems: $persist(JSON.parse(@js($jsonDataItems))),
            {{-- dataItems: JSON.parse(@js($jsonDataItems)), --}}
            {{-- toggleAccordion() function --}}
            toggleAccordion(index) {
                console.log(`toggle item with index: ${index}`)
                const subjectAndContent = document.getElementById(`subjectAndContent-${index}`)
                const icon = document.getElementById(`icon-${index}`)
                const unrollAccordionIcon = `{{ $unrollAccordionIcon }}`
                const rollUpAccordionIcon = `{{ $rollUpAccordionIcon }}`
                {{-- title always visible, toggle subject and content --}}
                if (subjectAndContent.style.maxHeight && subjectAndContent.style.maxHeight !== '0px') {
                    subjectAndContent.style.maxHeight = '0'
                    icon.innerHTML = rollUpAccordionIcon
                } else {
                    subjectAndContent.style.maxHeight = subjectAndContent.scrollHeight + 'px'
                    icon.innerHTML = unrollAccordionIcon
                }
            },
        }">

            <div>

                @for ($index = 0; $index < count($arrayDataItems); $index++)
                    <div class="border-b border-slate-200/50 dark:border-slate-200">
                        <button x-on:click="toggleAccordion({{ $index }})"
                            class="flex justify-between items-center py-4 w-full text-green-300/50 dark:text-green-300">
                            <h3 class="mx-auto font-bold tracking-wider leading-relaxed"
                                x-text="dataItems[{{ $index }}].title"></h3>
                            <span id="icon-{{ $index }}"
                                class="transition-transform duration-500 text-green-300/50 dark:text-green-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-chevron-down">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </span>
                        </button>
                        <div id="subjectAndContent-{{ $index }}"
                            class="overflow-hidden max-h-0 transition-all duration-500 ease-in-out">
                            @if (!empty($arrayDataItems[$index]->subject))
                                <h5 class="pb-5 text-sm font-semibold tracking-wide leading-tight dark:text-cyan-300 text-cyan-300/50"
                                    x-text="dataItems[{{ $index }}].subject">
                                </h5>
                            @endif
                            <p class="pb-5 text-sm font-light tracking-normal leading-snug dark:text-slate-300 text-slate-300/50"
                                x-text="dataItems[{{ $index }}].content"></p>
                        </div>
                    </div>
                @endfor

            </div>

    </section>

</div>
