<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $penggajian->employee->name }}</title>
    <style>
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 5px 0 0; font-size: 12px; color: #555; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .info-table .label { font-weight: bold; width: 120px; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .details-table th, .details-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .details-table th { background-color: #f5f5f5; font-weight: bold; }
        .total-row td { font-weight: bold; background-color: #eee; }
        .footer { display: table; width: 100%; margin-top: 40px; }
        .signature { display: table-cell; width: 50%; text-align: center; }
        .signature div { margin-top: 60px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ANITA KONVEKSI</h1>
        <p>Slip Gaji Pegawai</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Pegawai</td>
            <td>: {{ $penggajian->employee->name }}</td>
            <td class="label">Tanggal Cetak</td>
            <td>: {{ now()->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Posisi / Bagian</td>
            <td>: {{ $penggajian->employee->position ?? '-' }}</td>
            <td class="label">Bulan / Minggu</td>
            <td>: {{ \Carbon\Carbon::createFromFormat('Y-m', $penggajian->bulan)->isoFormat('MMMM YYYY') }} / Minggu ke-{{ $penggajian->minggu_ke }}</td>
        </tr>
        <tr>
            <td class="label">Tipe Gaji</td>
            <td>: {{ ucfirst($penggajian->employee->employee_type) }}</td>
            <td class="label">Status</td>
            <td>: {{ ucfirst($penggajian->status) }}</td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Hari / Kuantitas Kerja</th>
                <th>Tarif (Rate)</th>
                <th style="text-align:right;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Gaji Pokok ({{ ucfirst($penggajian->employee->employee_type) }})</td>
                <td>{{ $penggajian->hari_kerja }} Hari</td>
                <td>Rp {{ number_format($penggajian->employee->salary_rate, 0, ',', '.') }}</td>
                <td style="text-align:right;">Rp {{ number_format($penggajian->total_gaji, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align:right;">TOTAL DITERIMA</td>
                <td style="text-align:right;">Rp {{ number_format($penggajian->total_gaji, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Penerima,</p>
            <div>{{ $penggajian->employee->name }}</div>
        </div>
        <div class="signature">
            <p>Admin / Keuangan,</p>
            <div>Anita Konveksi</div>
        </div>
    </div>
</body>
</html>
