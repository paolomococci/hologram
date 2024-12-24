<div class="mx-4">
    <form wire:submit="save()">
        <div class="mb-3">
            <label class="block text-slate-600" for="article-title">Title</label>
            <input type="text" spellcheck="false"
                class="p-2 w-full h-full align-text-top rounded-sm border text-start text-slate-300 bg-slate-600"
                wire:model="articleForm.title">
            <div>
                @error('articleForm.title')
                    <span class="mt-1 text-red-500 delay-500 transition--opacity">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="block text-slate-600" for="article-subject">Subject</label>
            <input type="text" spellcheck="false"
                class="p-2 w-full h-full align-text-top rounded-sm border text-start text-slate-300 bg-slate-600"
                wire:model="articleForm.subject">
        </div>
        <div>
            @error('articleForm.subject')
                <span class="mt-1 text-red-500 delay-500 transition--opacity">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="block text-slate-600" for="article-content">Content</label>
            <textarea id="article-content" spellcheck="false"
                class="p-2 w-full h-full align-text-top rounded-sm border sm:min-h-64 md:min-h-48 lg:min-h-36 peer text-start text-slate-300 bg-slate-600"
                wire:model="articleForm.content"></textarea>
            <div>
                @error('articleForm.content')
                    <span class="mt-1 text-red-500 delay-500 transition--opacity">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex mb-3 w-full">
            <button class="flex justify-center items-center p-2 w-full bg-green-600 rounded-sm hover:bg-green-800"
                type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-green-300 lucide lucide-save">
                    <title>save</title>
                    <path
                        d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                    <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                </svg>
            </button>
        </div>
    </form>
</div>
