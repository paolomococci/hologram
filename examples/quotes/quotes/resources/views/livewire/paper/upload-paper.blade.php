<div>

    <form name="saveFile" wire:submit="save" enctype="multipart/form-data">
        <x-label for="titleDocumentToUpload" style="margin-left: 0.25rem;margin-top: 0.75rem">Title:</x-label>
        <x-input maxlength="255" type="text" id="titleDocumentToUpload" placeholder="please enter a title"
            wire:model.blur="titleDocumentToUpload" />
        <div>
            @error('titleDocumentToUpload')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="nameDocumentToUpload" style="margin-left: 0.25rem;margin-top: 0.75rem">Name:</x-label>
        <x-input type="text" id="nameDocumentToUpload" wire:model="nameDocumentToUpload" />

        <x-label for="sizeDocumentToUpload" style="margin-left: 0.25rem;margin-top: 0.75rem">Size:</x-label>
        <x-input type="text" id="sizeDocumentToUpload" wire:model="sizeDocumentToUpload" />

        <div style="margin-top: 0.5rem; margin-bottom: 0.5rem">
            <x-label for="documentToUpload" style="margin-left: 0.25rem;margin-top: 0.75rem;cursor:pointer">
                <span style="color: #67f;text-transform: uppercase">
                    click here to upload a file
                </span>
                (.jpg,.png,.svg,.pdf):
                <input type="file" accept=".jpg,.png,.svg,.pdf" id="documentToUpload" name="documentToUpload"
                    style="margin-top: 0.5rem; display: none" wire:model.blur="documentToUpload" />
            </x-label>
            <div>
                @error('documentToUpload')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button id="submitDocumentToUpload" type="submit"
            class="items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
            style="margin-top: 0.75rem">
            waiting for a file to be selected
        </button>
    </form>

    @if (session('status'))
        <div class="alert alert-success">
            <h3
                style="font-size: 1rem;background-color: yellow;text-align: center;margin-top: 0.5rem;padding: 0.25rem;border-radius: 0.25rem">
                {{ session('status') }}
            </h3>
        </div>
    @endif

    @script
        <script>
            const filesToUpload = document.getElementById('documentToUpload');
            const nameToUpload = document.getElementById('nameDocumentToUpload');
            const sizeToUpload = document.getElementById('sizeDocumentToUpload');
            const submitToUpload = document.getElementById('submitDocumentToUpload');
            submitToUpload.disabled = true;
            console.log(submitToUpload.disabled);
            filesToUpload.addEventListener("change", () => {
                nameToUpload.value = filesToUpload.files[0].name;
                sizeToUpload.value = filesToUpload.files[0].size;
                nameToUpload.dispatchEvent(new Event('input'));
                sizeToUpload.dispatchEvent(new Event('input'));
                console.log(nameToUpload.value);
                console.log(sizeToUpload.value);
                /*
                 * workaround: wait five seconds before making the sending button available
                 * I have to wait for all communications with the server to complete
                 */
                setTimeout(() => {
                    readyToSave()
                }, 5000)
                // if multiple file
                // console.log(submitToUpload.disabled);
                // for (const file of filesToUpload.files) {
                //     document.getElementById('nameDocumentToUpload').value = file.name;
                //     console.log(file);
                // }
            });

            function readyToSave() {
                submitToUpload.disabled = false;
                submitToUpload.innerHTML = "Save";
            }
        </script>
    @endscript

</div>
