@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Název týmu</label>
            <input type="text" class="form-control" id="name" name="name" maxlength="20" required>
        </div>
        <div class="mb-3">
            <label for="league_id" class="form-label">Liga</label>
            <select class="form-select" id="league_id" name="league_id" required>
                <option value="">Vyberte ligu</option>
                @foreach ($leagues as $league)
                    <option value="{{ $league->id }}">{{ $league->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Obrázek týmu</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpg, image/jpeg" onchange="previewImage()">
            @if ($errors->has('image'))
                <div class="text-danger">{{ $errors->first('image') }}</div>
            @endif
        </div>

        <div id="imagePreviewContainer" class="mb-3" style="display: none;">
            <label for="imagePreview">Náhled obrázku:</label>
            <br>
            <img id="imagePreview" src="" alt="Náhled obrázku" class="img-fluid mt-2">
        </div>

        <button type="submit" class="btn btn-success submit-once mb-4">Vytvořit</button>
        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary mb-4">Zpět</a>
    </form>

    <script>
        function previewImage() {
            const file = document.getElementById('image').files[0];
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
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
        #imagePreview {
            max-width: 300px;
            height: auto;
        }
    </style>
@endsection
