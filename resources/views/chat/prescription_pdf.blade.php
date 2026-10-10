<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resep Obat Digital - MedikaCare</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 40px;
        }
        .header {
            border-bottom: 3px double #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        .clinic-name {
            font-size: 28px;
            font-weight: bold;
            color: #10439f;
            text-transform: uppercase;
        }
        .doctor-info {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
        }
        .prescription-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .meta-table td {
            padding: 4px 0;
        }
        .medication-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .medication-table th {
            border-bottom: 2px solid #333;
            text-align: left;
            padding: 10px;
            font-size: 14px;
        }
        .medication-table td {
            border-bottom: 1px solid #ddd;
            padding: 12px 10px;
            font-size: 14px;
        }
        .notes-section {
            background-color: #f9f9f9;
            border-left: 4px solid #10439f;
            padding: 15px;
            margin-bottom: 40px;
            font-size: 14px;
        }
        .signature-section {
            float: right;
            text-align: center;
            width: 250px;
            margin-top: 20px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
            font-weight: bold;
        }
        .print-btn {
            background-color: #10439f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 20px;
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">🖨️ Cetak Resep Obat</button>

    <div class="header">
        <div class="clinic-name">MedikaCare Clinic</div>
        <div class="doctor-info">
            {{ $prescription->consultation->doctor->user->name }} | No. Izin Praktik: {{ $prescription->consultation->doctor->medical_id }}<br>
            Jl. Kesehatan No. 12, Jakarta Selatan | Telp: +62 21 500-1234
        </div>
    </div>

    <div class="prescription-title">RESEP DOKTER DIGITAL</div>

    <table class="meta-table">
        <tr>
            <td style="width: 15%; font-weight: bold;">Nama Pasien:</td>
            <td style="width: 50%;">{{ $prescription->consultation->patient->name }}</td>
            <td style="width: 15%; font-weight: bold;">Tanggal:</td>
            <td>{{ $prescription->created_at->format('d M Y H:i') }} WIB</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nomor HP:</td>
            <td>{{ $prescription->consultation->patient->phone ?? '-' }}</td>
            <td style="font-weight: bold;">ID Konsul:</td>
            <td>KNS-{{ str_pad($prescription->consultation->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
    </table>

    <table class="medication-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 45%;">Nama Obat</th>
                <th style="width: 25%;">Dosis</th>
                <th style="width: 25%;">Frekuensi Aturan Pakai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prescription->medications as $index => $med)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ $med['name'] }}</td>
                    <td>{{ $med['dosage'] }}</td>
                    <td>{{ $med['frequency'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($prescription->notes)
        <div class="notes-section">
            <strong>Catatan Dokter / Instruksi Tambahan:</strong><br>
            {{ $prescription->notes }}
        </div>
    @endif

    <div class="signature-section">
        <p>Jakarta, {{ $prescription->created_at->format('d M Y') }}</p>
        <p>Dokter Pemeriksa,</p>
        <div style="height: 50px;">
            <!-- Simple digital stamp mockup -->
            <span style="border: 2px solid #22c55e; color: #22c55e; font-size: 10px; font-weight: bold; padding: 4px; border-radius: 4px; display: inline-block; transform: rotate(-5deg); margin-top: 15px;">
                SIGNED DIGITALLY
            </span>
        </div>
        <div class="signature-line">
            {{ $prescription->consultation->doctor->user->name }}
        </div>
    </div>

</body>
</html>
