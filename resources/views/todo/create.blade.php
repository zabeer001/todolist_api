<!-- resources/views/users/create.blade.php -->

@extends('layout')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('todo.store') }}" enctype="multipart/form-data">
            @csrf <!-- CSRF Token -->
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" placeholder="">
            </div>
            <div class="form-group">
                <label for="time">Time</label>
                <input type="time" class="form-control" id="time" name="time" placeholder="">
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="football">
            </div>
            <div class="form-group">
                <label for="Description">Description</label>
                <textarea class="form-control" id="Description" name="description"
                    placeholder="playing football in Friday with Shital and collect players"></textarea>
            </div>
            <div class="form-group">
                <label for="document">Memories</label>
                <div class="needsclick dropzone" id="zabeer-dropzone">

                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.zabeerDropzone = {
            url: '{{ route('todo.storeMedia') }}',
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            }
        }
    </script>
@endsection
