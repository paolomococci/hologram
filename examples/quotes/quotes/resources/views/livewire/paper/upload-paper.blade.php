<div>

    {{-- form with responsive progress bar and save button --}}
    <form name="saveFile" wire:submit="save" enctype="multipart/form-data">
        <div x-data="{
                uploadingProgressBar: false,
                progress: 0,
                uploadButtonSave: false
            }"
            x-on:livewire-upload-start="uploadingProgressBar = true"
            x-on:livewire-upload-finish="uploadingProgressBar = false, uploadButtonSave = true"
            x-on:livewire-upload-error="uploadingProgressBar = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress">

            <x-label for="titleDocumentToUpload" class="mt-3 ml-1">Title:</x-label>
            <x-input maxlength="255" type="text" id="titleDocumentToUpload" placeholder="please enter a title"
                wire:model.blur="titleDocumentToUpload" />
            <div>
                @error('titleDocumentToUpload')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <x-label for="nameDocumentToUpload" class="mt-3 ml-1">Name:</x-label>
            <x-input readonly type="text" id="nameDocumentToUpload" wire:model="nameDocumentToUpload" />

            <x-label for="sizeDocumentToUpload" class="mt-3 ml-1">Size:</x-label>
            <x-input readonly type="text" id="sizeDocumentToUpload" wire:model="sizeDocumentToUpload" />

            <div class="mx-2">
                <x-label for="documentToUpload" class="mt-3 ml-1 cursor-pointer">
                    <span class="text-indigo-600 uppercase">
                        click here to select a file to upload
                    </span>
                    (.jpg,.png,.svg):
                    <input type="file" accept=".jpg,.png,.svg" id="documentToUpload" name="documentToUpload"
                        class="hidden mt-2" wire:model.blur="documentToUpload" />
                </x-label>
                <div>
                    @error('documentToUpload')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div x-show="uploadingProgressBar">
                    <progress max="100" x-bind:value="progress"></progress>

                </div>
                <div x-show="uploadButtonSave">
                    <button id="submitDocumentToUpload" type="submit"
                        class="items-center px-4 py-2 mt-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Save
                    </button>
                </div>
            </div>

        </div>
    </form>

    @if (session('status'))
        <div class="alert alert-success">
            <h3
                class="p-1 mt-2 text-base text-center bg-amber-200 rounded-s">
                {{ session('status') }}
            </h3>
        </div>
    @endif

    @script
        <script>
            const fileToUpload = $wire.el.querySelector('#documentToUpload');
            const nameToUpload = document.querySelector('#nameDocumentToUpload');
            const sizeToUpload = document.querySelector('#sizeDocumentToUpload');
            const submitToUpload = document.querySelector('#submitDocumentToUpload');
            fileToUpload.addEventListener("change", () => {
                console.log(fileToUpload.files[0]);
                nameToUpload.value = fileToUpload.files[0].name;
                sizeToUpload.value = fileToUpload.files[0].size;
                nameToUpload.dispatchEvent(new Event('input'));
                sizeToUpload.dispatchEvent(new Event('input'));
            });
        </script>
    @endscript

</div>
