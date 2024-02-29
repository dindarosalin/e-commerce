@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Products') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form id="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                            @if ($method == 'PUT')
                                @method('PUT')
                            @endif
                            @csrf
                            <div class="mb-3">
                                <label for="photos" class="form-label">Photos</label>
                                <div class="dropzone dz-clickable border rounded bg-light d-flex align-items-center justify-content-center p-3"
                                    id="photos-dropzone">
                                    <div class="dz-default dz-message text-center">
                                        <i class="bi bi-cloud-arrow-up" style="font-size: 2rem;"></i>
                                        <div class="mt-3">Drop files here or click to upload.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') ?? $product->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') ?? $product->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price') ?? $product->price }}">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        var myDropzonePhotos = new Dropzone("#photos-dropzone", {
            url: '{{ route('media.store') }}',
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            init: function() {
                var existingFiles = [];
                var dropzoneInstance = this;
                @foreach ($medias as $media)
                    existingFiles.push({
                        data: "{{ $media->id }}",
                        name: "{{ $media->file_name }}",
                        size: "{{ $media->size }}",
                        url: "{{ $media->getUrl() }}",
                        path: "{{ addslashes($media->getPath()) }}",
                        type: "{{ $media->mime_type }}"
                    });
                @endforeach
                existingFiles.forEach(function(file) {
                    var mockFile = {
                        name: file.name,
                        size: file.size,
                        type: file.type,
                        accepted: true
                    };
                    dropzoneInstance.emit("addedfile", mockFile);
                    dropzoneInstance.emit("thumbnail", mockFile, file.url);
                    dropzoneInstance.files.push(mockFile);
                    dropzoneInstance.emit("complete", mockFile);
                    $('#form').append('<input type="hidden" name="photos_old[]" value="' + file.data +
                        '" longName="' + file.name + '">')
                });
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('#form').append('<input type="hidden" name="photos_new[]" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = file.name;
                if ($('#form').find('input[name="photos_old[]"][longname="' + name + '"]').length != 0) {
                    $('#form').find('input[name="photos_old[]"][longname="' + name + '"]').remove()
                } else {
                    $('#form').find('input[name="photos_new[]"][value="' + name + '"]').remove()
                }
            },
            displayExistingFile: function(file, url) {
                var previewElement = this.previewsContainer.querySelector(".dz-preview");
                var imagePreview = previewElement.querySelector(".dz-image-preview");
                imagePreview.remove();
                var fileElement = previewElement.querySelector(".dz-file-preview");
                fileElement.textContent = file.name;
            }
        });
    </script>
@endpush
