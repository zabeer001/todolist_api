@extends('layout')

@section('content')

    <style>
        .card-img-top {
            width: 7%; 
            cursor: pointer; /* Change cursor to pointer to indicate that the image is clickable */
        }
        .main-img {
            height: 195px; /* Adjust the main image size as needed */
        
        }
    </style>

    @php
        $images = $toDoList->todoMedia; /* lazy loading */
    @endphp
    

    <div class="container mt-5">
        <img src="{{ asset('uploads/' . ($images->first()->file ?? '')) }}" class="main-img" alt="Main Image"> 
        <div class="row mt-3 all-imgs">
            
            <!-- Placeholder for the main image, initially set to the first image or empty -->
         
            
            <!-- Thumbnail images -->
            @foreach ($images as $image)
                <img src="{{ asset('uploads/' . $image->file) }}" class="card-img-top" alt="Thumbnail Image">
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the main image element
            const mainImg = document.querySelector('.main-img');

            // Add event listener to the container holding the thumbnails
            document.querySelector('.all-imgs').addEventListener('click', function(e) {
               
                // Check if the clicked element is an image
                if (e.target.tagName === 'IMG' && e.target.classList.contains('card-img-top')) {
                    // Update the src attribute of the main image
                    console.dir(e);
                    mainImg.src = e.target.src;
                }
            });
        });
    </script>
@endsection
