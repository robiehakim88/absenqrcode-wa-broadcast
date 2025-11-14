@extends('layouts.app')

@section('title', 'Scan Absensi')

@section('content')
<div class="container">
    <h1>Scan QR Code Absensi</h1>
    <p class="text-muted">Arahkan kamera ke QR Code yang ada pada kartu siswa.</p>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div id="qr-reader" style="width: 100%;"></div>
                    <div id="qr-reader-results" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function onScanSuccess(decodedText, decodedResult) {
    html5QrcodeScanner.clear();
    const resultsDiv = document.getElementById('qr-reader-results');
    resultsDiv.innerHTML = '<div class="alert alert-info"><i class="bi bi-hourglass-split me-2"></i>Memproses absensi...</div>';

    fetch(decodedText, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            resultsDiv.innerHTML = `<div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i><strong>Sukses!</strong> ${data.message}</div>`;
        } else {
            resultsDiv.innerHTML = `<div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Gagal!</strong> ${data.message}</div>`;
        }
        setTimeout(() => {
            resultsDiv.innerHTML = '';
            startScanner();
        }, 3000);
    })
    .catch(error => {
        console.error('Error:', error);
        resultsDiv.innerHTML = `<div class="alert alert-danger"><i class="bi bi-x-octagon-fill me-2"></i><strong>Error!</strong> Terjadi kesalahan koneksi.</div>`;
        setTimeout(() => {
            resultsDiv.innerHTML = '';
            startScanner();
        }, 3000);
    });
}

function onScanFailure(error) {
    // handle scan failure, usually better to ignore it.
}

function startScanner() {
    html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
}

let html5QrcodeScanner;
document.addEventListener('DOMContentLoaded', () => {
    startScanner();
});
</script>
@endpush