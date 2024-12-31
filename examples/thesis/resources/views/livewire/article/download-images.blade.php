<div>
    @foreach ($uriImages as $uriImage)
        <x-forms.downloadable-image uriImage="{{ $uriImage }}" />
    @endforeach
</div>
