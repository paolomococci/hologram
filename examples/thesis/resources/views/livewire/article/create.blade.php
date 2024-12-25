<div class="mx-4">
    <form wire:submit="save()">
        <div class="mb-3">
            <label class="block text-slate-600" for="article-title">Title <span class="inline-flex text-orange-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="opacity-25 lucide lucide-circle-alert size-4 sm:size-3lg:size-5">
                        <title>required</title>
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" x2="12" y1="8" y2="12" />
                        <line x1="12" x2="12.01" y1="16" y2="16" />
                    </svg>
                </span></label>
            <input type="text" spellcheck="false"
                class="p-2 w-full h-full align-text-top rounded-sm border border-orange-400 text-start text-slate-300 bg-slate-600"
                wire:model.live.blur="articleForm.title">
            <div>
                @error('articleForm.title')
                    <span class="mt-2 text-red-500 delay-500 transition--opacity">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="block text-slate-600" for="article-subject">Subject</label>
            <input type="text" spellcheck="false"
                class="p-2 w-full h-full align-text-top rounded-sm border text-start text-slate-300 bg-slate-600"
                wire:model.live.blur="articleForm.subject">
        </div>
        <div>
            @error('articleForm.subject')
                <span class="mt-2 text-red-500 delay-500 transition--opacity">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="block text-slate-600" for="article-content">Content <span class="inline-flex text-orange-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="opacity-25 lucide lucide-circle-alert size-4 sm:size-3lg:size-5">
                        <title>required</title>
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" x2="12" y1="8" y2="12" />
                        <line x1="12" x2="12.01" y1="16" y2="16" />
                    </svg>
                </span></label>
            <textarea id="article-content" spellcheck="false"
                class="p-2 w-full h-full align-text-top rounded-sm border border-orange-400 sm:min-h-64 md:min-h-48 lg:min-h-36 peer text-start text-slate-300 bg-slate-600"
                wire:model.live.blur="articleForm.content"></textarea>
            <div>
                @error('articleForm.content')
                    <span class="mt-2 text-red-500 delay-500 transition--opacity">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="flex items-center text-slate-600">
                <input type="checkbox" name="published" class="mr-2" wire:model.boolean="articleForm.published">
                Published
            </label>
            <label class="flex items-center text-slate-600">
                <input type="checkbox" name="deprecated" class="mr-2" wire:model.boolean="articleForm.deprecated">
                Deprecated
            </label>
        </div>
        <div class="mb-3">
            <div>
                <div class="mb-2 text-slate-600">Notifications</div>
                <div class="flex gap-6 mb-3">
                    <label class="flex items-center text-slate-600">
                        <input type="radio" value="true" class="mr-2"
                            wire:model.boolean="articleForm.allowNotifications">
                        Yes
                    </label>
                    <label class="flex items-center text-slate-600">
                        <input type="radio" value="false" class="mr-2"
                            wire:model.boolean="articleForm.allowNotifications">
                        No
                    </label>
                </div>
                <div x-show="$wire.articleForm.allowNotifications">
                    <label class="flex items-center text-slate-600">
                        <input type="checkbox" value="email" class="mr-2" wire:model="articleForm.notifications">
                        Email
                    </label>
                    <label class="flex items-center text-slate-600">
                        <input type="checkbox" value="bulletin_board" class="mr-2"
                            wire:model="articleForm.notifications">
                        Bulletin board
                    </label>
                    <label class="flex items-center text-slate-600">
                        <input type="checkbox" value="none" class="mr-2" wire:model="articleForm.notifications">
                        None
                    </label>
                </div>
            </div>
        </div>
        <div class="flex mb-3 w-full">
            <button class="flex justify-center items-center p-2 w-full bg-green-600 rounded-sm" type="submit"
                wire:dirty.class="hover:bg-green-800" wire:dirty.remove.attr="disabled" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="text-green-300 lucide lucide-save">
                    <title>save</title>
                    <path
                        d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                    <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                </svg>
            </button>
        </div>
        <div wire:dirty.live.debounce.500ms wire:dirty.class="text-orange-400">Please don't forget to save article.
        </div>
    </form>
</div>
