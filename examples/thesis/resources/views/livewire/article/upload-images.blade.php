<div class="mx-4">
    <p class="mt-4 text-sm/relaxed">
        You are about to edit the article identified by the ID number: {{ $articleForm->article->id }}
    </p>
    {{-- image_path field, array of values --}}
    <div class="mb3">
        <label for="article-image-path" class="block text-slate-600">You can upload an image</label>
        <div class="flex item-center">
            {{-- support multiple image upload --}}
            <input type="file" id="article-image-path" multiple class="p-2 w-1/2" wire:model="articleForm.imageObject">
        </div>
        <div class="flex m-4">
            @if ($articleForm->imageObject)
                <div class="pr-4 mr-4">
                    <p class="text-slate-600">
                        These are the
                        <em class="uppercase">
                            {{ count($articleForm->imageObject) > 1 ? 'images' : 'image' }}
                        </em>
                        that are about to load:
                    </p>
                </div>
                <div>
                    @foreach ($articleForm->imageObject as $imgObj)
                        <span class="my-3">
                            <img src="{{ $imgObj->temporaryUrl() }}" alt="{{ $imgObj->temporaryUrl() }}" class="w-1/2">
                        </span>
                    @endforeach
                </div>
            @elseif ($articleForm->image_path)
                <div class="pr-4 mr-4">
                    <p class="text-slate-600">
                        These are the
                        <em class="uppercase">
                            {{ count($articleForm->image_path) > 1 ? 'images' : 'image' }}
                        </em>
                        already uploaded:
                    </p>
                </div>
                <div>
                    @foreach ($articleForm->image_path as $imgPath)
                        <span class="my-3">
                            <img src="{{ Storage::url($imgPath) }}" alt="{{ Storage::url($imgPath) }}" class="w-1/2">
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
        <div>
            @error('articleForm.imageObject')
                <span class="mt-2 text-red-500 transition-opacity delay-500">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div>
        <div class="flex mb-3 w-full">
            <button class="flex justify-center items-center p-2 w-1/2 bg-green-600 rounded-sm"
                wire:click="uploadImages()" wire:confirm="Are you sure you want to save all the changes you just made?">
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
                wire:confirm="Are you sure you want to undo all the changes you just made?">
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
