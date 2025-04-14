@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Název týmu</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $team->name }}" maxlength="20" required>
        </div>

        <div class="mb-3">
            <label for="league_id" class="form-label">Liga, do které spadá</label>
            <select class="form-select" id="league_id" name="league_id" required>
                @foreach ($leagues as $league)
                    <option value="{{ $league->id }}" {{ $team->league_id == $league->id ? 'selected' : '' }}>
                        {{ $league->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Obrázek týmu</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpg, image/jpeg" onchange="previewImage(event)">
        </div>

        @if ($team->image)
            <div class="mb-3" id="current-image-container">
                <p><strong>Aktuální obrázek:</strong></p>
                <img src="{{ asset('storage/' . $team->image) }}" alt="{{ $team->name }}" class="img-fluid" style="max-width: 300px; height: auto;">
            </div>
        @endif

        <div id="image-change-text" class="mt-3 text-success" style="display:none;">
            <p><strong>Obrázek bude změněn!</strong></p>
        </div>
        <div id="image-preview" class="mt-3 mb-4"></div>

        <button type="submit" class="btn btn-warning submit-once mb-4">Upravit</button>
        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary mb-4">Zpět</a>
    </form>

    <script>
        function previewImage(event) {
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                var currentImageContainer = document.getElementById('current-image-container');
                if (currentImageContainer) {
                    currentImageContainer.remove();
                }

                var imagePreview = document.getElementById('image-preview');
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid" style="max-width: 300px; height: auto;">`;

                var changeText = document.getElementById('image-change-text');
                changeText.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                form.addEventListener('submit', function () {
                    const submitButton = form.querySelector('button.submit-once');

                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerText = 'Probíhá...';
                    }
                });
            });
        });
    </script>

    <style>
        #image-preview {
            max-width: 300px;
            height: auto;
        }
    </style>
@endsection
