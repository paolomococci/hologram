<div>

    @if ($author)
        <div class="flex items-center">
            <i class="bi bi-pencil-square icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                Update author &#8220;{{ $author->name }}&#8221;
            </h2>
        </div>

        <form wire:submit="update">
            <div
                class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">

                <div>
                    <x-label for="name" class="mt-3 ml-1">Name:</x-label>
                    <x-input maxlength="255" type="text" size="35" id="name" wire:model.blur="name" />
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-label for="surname" class="mt-3 ml-1">Surname:</x-label>
                    <x-input required maxlength="255" type="text" size="35" id="surname"
                        wire:model.blur="surname" />
                    <div>
                        @error('surname')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-label for="nickname" class="mt-3 ml-1">Nickname:</x-label>
                    <x-input required maxlength="255" type="text" size="35" id="nickname"
                        wire:model.blur="nickname" />
                    <div>
                        @error('nickname')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-label for="email" class="mt-3 ml-1">Email:</x-label>
                    <x-input readonly maxlength="255" type="text" size="35" id="email"
                        wire:model.blur="email" />
                    <div>
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-label for="suspended" class="inline mt-3 ml-1">
                        Suspended:
                    </x-label>
                    <x-input type="checkbox" id="suspended" name="suspended" wire:model.blur="suspended" />

                    <h3 class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                        author of the following articles:
                    </h3>

                    <div class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        @foreach ($relatedArticles as $relatedArticle)
                            <section class="p-1 mt-1 ml-1 border border-gray-400 border-solid rounded-lg">
                                <h2 class="inline">
                                    {{ $relatedArticle->title }}
                                </h2>
                                <x-label for="checkbox_related_article_{{ $relatedArticle->id }}">
                                    check the following box to immediately remove this correlation
                                </x-label>
                                <x-input type="checkbox" name="checkbox_related_article_{{ $relatedArticle->id }}"
                                    id="checkbox_related_article_{{ $relatedArticle->id }}"
                                    value="{{ $relatedArticle->id }}" wire:model.change='removeCorrelations'
                                    wire:change="removeCorrelation()" />
                            </section>
                        @endforeach
                    </div>

                    <div>
                        <x-label for="articles" class="mt-3 ml-1">add a correlation to
                            the following article:</x-label>
                        <x-input list="articles" maxlength="255" type="text" size="35" id="articleToBeRelated"
                            name="articleToBeRelated" wire:model.blur="articleToBeRelated" />
                        <datalist name="articles" id="articles" class="rounded-xl bg-gray-950 text-slate-50"
                            placeholder="Pick an article...">
                            @foreach ($articles as $article)
                                <option value="{{ $article['title'] }}" class="text-center rounded-xl">
                                    {{ $article['title'] }}
                                </option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>

            <x-button type="submit" class="inline-block m-1 ">Update</x-button>
        </form>

        @if (session('status'))
            <div class="alert">
                <h3 class="p-1 mt-2 text-base text-center rounded-s"
                    style="border-radius: 0.25rem;background-color: #ff7">
                    {{ session('status') }}
                </h3>
            </div>
        @endif
    @endif

</div>
