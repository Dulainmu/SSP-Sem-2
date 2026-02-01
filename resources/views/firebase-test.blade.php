<!DOCTYPE html>
<html>
<head>
    <title>Firebase Upload Test</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .result { margin-top: 20px; padding: 15px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        input[type="file"] { margin: 10px 0; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        img { max-width: 100%; margin-top: 20px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>Firebase Upload Test</h1>
    <form action="/test-upload" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Select Image:</label><br>
            <input type="file" name="image" accept="image/*" required>
        </div>
        <button type="submit">Upload to Firebase</button>
    </form>

    @if(session('success'))
        <div class="result success">
            <strong>Success!</strong><br>
            Image uploaded successfully!<br>
            <strong>URL:</strong> <a href="{{ session('url') }}" target="_blank">{{ session('url') }}</a>
            <img src="{{ session('url') }}" alt="Uploaded Image">
        </div>
    @endif

    @if(session('error'))
        <div class="result error">
            <strong>Error!</strong><br>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="result error">
            <strong>Validation Errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr>
    <h3>Instructions:</h3>
    <ol>
        <li>Select an image file (JPG, PNG, etc.)</li>
        <li>Click "Upload to Firebase"</li>
        <li>If successful, you'll see the image URL and preview</li>
        <li>Check <code>storage/logs/laravel.log</code> for detailed logs</li>
    </ol>
</body>
</html>
