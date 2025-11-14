@extends('layouts.app')

@section('title', 'Grafik Kehadiran ' . $student->name)

@section('content')
<div class="container">
    <a href="{{ route('wali_kelas.dashboard') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Grafik Kehadiran: {{ $student->name }} (NIS: {{ $student->nis }})</h4>
        </div>
        <div class="card-body">
            <div style="height: 400px; position: relative;">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Tambahkan library Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil data dari Laravel ke dalam variabel JavaScript
        const attendanceData = @json($attendances);

        // Siapkan data untuk Chart.js
        const labels = attendanceData.map(a => a.date);
        const dataPoints = attendanceData.map(a => a.status === 'hadir' ? 1 : 0);

        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx, {
            type: 'line', // Tipe grafik garis
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kehadiran (1 = Hadir, 0 = Tidak Hadir)',
                    data: dataPoints,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.1,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 1.2, // Maksimal sumbu Y agar 1 tidak di ujung
                        ticks: {
                            stepSize: 1,
                            callback: function(value, index, ticks) {
                                if (value === 1) return 'Hadir';
                                if (value === 0) return 'Tidak Hadir';
                                return '';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y === 1) {
                                    label += 'Hadir';
                                } else {
                                    label += 'Tidak Hadir';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush