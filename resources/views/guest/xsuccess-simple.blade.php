<!DOCTYPE html>
<html>
<head>
    <title>Test Success</title>
    <style>
        body { font-family: Arial; margin: 50px; }
        .card { background: #f8f9fa; padding: 20px; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>SUCCESS PAGE TEST</h1>
        <p><strong>Guest Name:</strong> {{ $guest->nama ?? 'Not found' }}</p>
        <p><strong>Phone:</strong> {{ $guest->telepon ?? 'Not found' }}</p>
        <p><strong>Institution:</strong> {{ $guest->instansi ?? 'Not found' }}</p>
        <p><strong>Purpose:</strong> {{ $guest->keperluan ?? 'Not found' }}</p>
        <p><strong>Department:</strong> {{ $guest->bidangInfo->nama ?? 'Not found' }}</p>
        <p><strong>Check-in:</strong> {{ $guest->check_in_at ? $guest->check_in_at->format('d F Y, H:i') : 'Not found' }} WIB</p>

        <hr>
        <p>If you see this message, the controller and data are working correctly.</p>
        <a href="{{ route('guest.form') }}">Back to Form</a>
    </div>
</body>
</html>
