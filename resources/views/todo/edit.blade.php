@extends('layout')

@section('content')
    <style>
        .dropzone .dz-preview .dz-image img {
            display: block;
            width: 100%;
        }
    </style>
    <div class="container">
        <form method="POST" action="{{ route('todo.update', $toDoList->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="time">Time</label>
                <input type="time" class="form-control" id="time" name="time" value="{{ $toDoList->time }}">
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $toDoList->date }}">
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $toDoList->title }}">
            </div>
            <div class="form-group">
                <label for="Description">Description</label>
                <textarea class="form-control custom-textarea" id="Description" name="description">{{ $toDoList->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="document">Memories</label>
                <div class="needsclick dropzone" id="document-dropzone">

                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('todo.storeMedia') }}',

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
                // console.log(file.name)
                $('form').find('input[name="document[]"][value="' + file.name + '"]').remove();
                console.log('deletefile:' + file.name);
                /*  */
              
                $.ajax({
                    type: 'POST',
                    url:  '{{ route('todo.deleteFile') }}', 
                    data: {
                        _token: '{{ csrf_token() }}',
                        filename: file.name 
                    },
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            },

            init: function() {
                @if (isset($toDoList->todoMedia))
                    var files = {!! json_encode($toDoList->todoMedia) !!};
                    /* Iterate over each media item */

                    for (var i in files) {
                        var file = files[i];
                        console.log(file);
                        /* {id: 17, toDoListId: '3', file: '1711468264-6602eee88e13e_Screenshot 2024-03-12 202807.png', created_at: '2024-03-26T15:51:05.000000Z', updated_at: '2024-03-26T15:51:05.000000Z'} */

                        var filePath = '/uploads/' + file.file;
                        console.log(filePath);
                        /* /uploads/1711468264-6602eee88e13e_Screenshot 2024-03-12 202807.png */
                        var fileObject = {
                            url: filePath,
                            name: file.file,
                            size: 1000
                        };
                        this.options.addedfile.call(this, fileObject);
                        this.options.thumbnail.call(this, fileObject, fileObject.url);
                        fileObject.previewElement.classList.add('dz-complete');
                        $('form').append('<input type="hidden" name="document[]" value="' + fileObject.name + '">');
                        /*    $.each(data, function(key,value){
                         
                        var mockFile = { name: value.name, size: value.size };
                         
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
         
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "uploads/"+value.name);
                         
                    }); */
                    }
                @endif

                // Additional code from the original init function can go here if needed
            }

        }
    </script>
@endsection
