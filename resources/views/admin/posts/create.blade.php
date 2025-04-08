@extends('layouts.admin')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="title">Název</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" maxlength="120" required>
        </div>
        <div class="form-group mb-3">
            <label for="exclusive">Exkluzivní článek</label>
            <div class="form-check">
                <input type="checkbox" name="exkluzivni" id="exkluzivni" class="form-check-input" value="1" {{ old('exkluzivni') ? 'checked' : '' }}>
                <label for="exclusive" class="form-check-label">Ano</label>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="lead_paragraph">Úvodní odstavec</label>
            <textarea name="lead_paragraph" id="lead_paragraph" class="form-control" required>{{ old('lead_paragraph') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="description">Obsah</label>
            <div class="text-editor-buttons mb-3">
                <button type="button" onclick="applyFormat('b')" class="btn btn-outline-secondary"><i class="fas fa-bold"></i></button>
                <button type="button" onclick="applyFormat('i')" class="btn btn-outline-secondary"><i class="fas fa-italic"></i></button>
                <button type="button" onclick="applyFormat('u')" class="btn btn-outline-secondary"><i class="fas fa-underline"></i></button>
                <button type="button" onclick="insertLink()" class="btn btn-outline-secondary"><i class="fas fa-link"></i></button>
                <button type="button" onclick="insertBr()" class="btn btn-outline-secondary"><i class="fas fa-level-down-alt"></i></button>
                <button type="button" onclick="insertHr()" class="btn btn-outline-secondary"><i class="fas fa-ruler-horizontal"></i></button>
            </div>
            <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="image">Obrázek</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpg, image/jpeg" onchange="previewImage()">
            @if ($errors->has('image'))
                <div class="text-danger">{{ $errors->first('image') }}</div>
            @endif
        </div>

        <div id="imagePreviewContainer" class="mb-3" style="display: none;">
            <label for="imagePreview">Náhled obrázku:</label>
            <br>
            <img id="imagePreview" src="" alt="Náhled obrázku" class="img-fluid mt-2">
        </div>

        <div class="mb-3">
            <label for="league_id" class="form-label">Liga</label>
            <select name="league_id" id="league_id" class="form-select" required>
                <option value="">Vyberte ligu</option>
                @foreach ($leagues as $league)
                    <option value="{{ $league->id }}">{{ $league->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="team_id">Týmy</label>
            <select name="teams[]" id="teams" class="form-select" multiple required>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success mt-3 submit-once">Vytvořit</button>
        </div>
    </form>

    <script>
        function applyFormat(tag) {
            var textarea = document.getElementById('description');
            var start = textarea.selectionStart;
            var end = textarea.selectionEnd;
            var selectedText = textarea.value.substring(start, end);
            var beforeText = textarea.value.substring(0, start);
            var afterText = textarea.value.substring(end);
            textarea.value = beforeText + `<${tag}>` + selectedText + `</${tag}>` + afterText;
        }

        function insertLink() {
            var url = prompt("Vlož odkaz sem!");
            if (url) {
                applyCustomTag('a', url);
            }
        }

        function insertBr() {
            var textarea = document.getElementById('description');
            var start = textarea.selectionStart;
            var beforeText = textarea.value.substring(0, start);
            var afterText = textarea.value.substring(start);
            textarea.value = beforeText + '<br>' + afterText;
        }

        function insertHr() {
            var textarea = document.getElementById('description');
            var start = textarea.selectionStart;
            var beforeText = textarea.value.substring(0, start);
            var afterText = textarea.value.substring(start);
            textarea.value = beforeText + '<hr>' + afterText;
        }

        function applyCustomTag(tag, value) {
            var textarea = document.getElementById('description');
            var start = textarea.selectionStart;
            var end = textarea.selectionEnd;
            var selectedText = textarea.value.substring(start, end);
            var beforeText = textarea.value.substring(0, start);
            var afterText = textarea.value.substring(end);
            if (tag === 'a') {
                textarea.value = beforeText + `<${tag} href="${value}">` + selectedText + `</${tag}>` + afterText;
            } else if (tag === 'img') {
                textarea.value = beforeText + `<${tag} src="${value}" alt="Image">` + afterText;
            }
        }

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
