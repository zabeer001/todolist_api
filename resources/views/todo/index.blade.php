@extends('layout')

@section('content')


<a href="{{ route('todo.create') }}" type="button" class="btn btn-sm btn-info">add todo List</a>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    
                    <th scope="col">Date</th>
                    
                    <th scope="col">Time</th>

                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($todoLists as $index => $todoList) --}}
                @foreach ($toDoLists as $toDoList)
                    <tr>
                        <th scope="row">{{ $toDoList->id }}</th>
                        <td >{{ $toDoList->date }}</td>
                        <td >{{ $toDoList->time }}</td>
                        <td>{{ $toDoList->title }}</td>
                        <td>{{ $toDoList->description }}</td>
                        <td>
                            <a href="{{ route('todo.show', $toDoList->id) }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                          
                            <a href="{{ route('todo.edit', $toDoList->id) }}">
                                <i class="fa-solid fa-pen-to-square" style="color: #52f226;"></i>
                            </a>

                            <form method="POST" action="{{ route('todo.destroy', $toDoList->id) }}"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"
                                    style="border: none; background-color: transparent; cursor: pointer;"
                                    onclick="confirmDelete({{ $toDoList->id }})">
                                    <i class="fa-solid fa-trash" style="color: #ed0c0c;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    <script>
        function confirmDelete(todoId) {
            if (window.confirm('Are you sure you want to delete this ToDo item?')) {
                document.querySelector('form[action="{{ route('todo.destroy', ':id') }}"]'.replace(':id', todoId)).submit();
            }
        }
    </script>
@endsection
