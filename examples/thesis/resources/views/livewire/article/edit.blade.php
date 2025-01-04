<div class="mx-4">

    <x-alerts.offline />

    <p class="mt-4 text-sm/relaxed">
        You are about to edit the article identified by the ID number: {{ $articleForm->article->id }}
    </p>
    <div>
        {{-- title field --}}
        <div class="mb-3">
            <label class="block text-slate-600" for="article-title">
                Title <span wire:dirty.class="text-orange-400" wire:dirty wire:target="articleForm.title">modified</span>
            </label>
            <input type="text" spellcheck="false"
                class="p-2 w-full h-full align-text-top rounded-sm border text-start text-slate-300 bg-slate-600"
                wire:model.live.blur="articleForm.title" wire:dirty wire:dirty.class="border-orange-400">
            <div>
                @error('articleForm.title')
                    <span class="mt-2 text-red-500 transition-opacity delay-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
        {{-- subject field --}}
        <div class="mb-3">
            <label class="block text-slate-600" for="article-subject">
                Subject <span wire:dirty.class="text-orange-400" wire:dirty
                    wire:target="articleForm.subject">modified</span>
            </label>
            <input type="text" spellcheck="false"
                class="p-2 w-full h-full align-text-top rounded-sm border text-start text-slate-300 bg-slate-600"
                wire:model.live.blur="articleForm.subject" wire:dirty wire:dirty.class="border-orange-400">
        </div>
        <div>
            @error('articleForm.subject')
                <span class="mt-2 text-red-500 transition-opacity delay-500">{{ $message }}</span>
            @enderror
        </div>
        {{-- content field --}}
        <div class="mb-3">
            <label class="block text-slate-600" for="article-content">
                Content <span wire:dirty.class="text-orange-400" wire:dirty
                    wire:target="articleForm.content">modified</span>
            </label>
            <textarea id="article-content" spellcheck="false"
                class="p-2 w-full h-full align-text-top rounded-sm border sm:min-h-64 md:min-h-48 lg:min-h-36 peer text-start text-slate-300 bg-slate-600"
                wire:model.live.blur="articleForm.content" wire:dirty wire:dirty.class="border-orange-400"></textarea>
            <div>
                @error('articleForm.content')
                    <span class="mt-2 text-red-500 transition-opacity delay-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
        {{--  I removed the image_path field to move it to a separate view --}}
        {{-- isPublished and isDeprecated fields --}}
        <div class="mb-3">
            <label class="flex items-center text-slate-600">
                <input type="checkbox" name="isPublished" class="mr-2" wire:model.boolean="articleForm.isPublished">
                Published
            </label>
            <label class="flex items-center text-slate-600">
                <input type="checkbox" name="isDeprecated" class="mr-2" wire:model.boolean="articleForm.isDeprecated">
                Deprecated
            </label>
        </div>
        {{-- notifications field, array of values --}}
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
                        <input type="checkbox" value="phone" class="mr-2" wire:model="articleForm.notifications">
                        Phone
                    </label>
                </div>
            </div>
        </div>
        <div class="flex mb-3 w-full">
            <button class="flex justify-center items-center p-2 w-1/2 bg-green-600 rounded-sm" wire:click="update()"
                wire:confirm="Are you sure you want to save all the changes you just made?" wire:offline.attr="disabled"
                {{-- wire:dirty.class="hover:bg-gray-800" wire:dirty.remove.attr="disabled" disabled --}}>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-green-300 lucide lucide-save">
                    <title>update</title>
                    <path
                        d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                    <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                </svg>
            </button>
            <button class="flex justify-center items-center p-2 w-1/2 bg-blue-600 rounded-r-sm" wire:click="cancel()"
                wire:confirm="Are you sure you want to undo all the changes you just made?"
                wire:offline.attr="disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-blue-300 lucide lucide-eraser">
                    <title>cancel</title>
                    <path d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21" />
                    <path d="M22 21H7" />
                    <path d="m5 11 9 9" />
                </svg>
            </button>
        </div>
        <div wire:dirty.live.debounce.500ms wire:dirty.class="text-orange-400" wire:dirty.remove.attr="hidden" hidden>
            Please, don't forget to save your
            changes.
        </div>
    </div>
</div>
