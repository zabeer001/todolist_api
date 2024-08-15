@extends('layout')

@section('content')
    <button onclick="getData()">Get Data</button>
    <ul id="fetchData">
    </ul>
    <script>
        function getData() {
            let url = 'http://127.0.0.1:8000/api/todo-list';
            fetch(url)
                .then(res => res.json())
                .then(data => display(data))
                .catch(error => console.error('Error:', error));
        }

        function display(data) {
            let ul = document.getElementById("fetchData");
         
            for (let item of data) {
                let li = document.createElement('li');
                li.innerText = item.title;
                ul.appendChild(li); // Append the new list item to the ul
            }
        }
    </script>
@endsection
