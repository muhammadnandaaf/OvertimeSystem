<!DOCTYPE html>
<html>
<head>
    <title>OVERTIME ORDER LETTER - {{ $spl->no_spl }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 11pt; line-height: 1.4; color: #000; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .content-table { width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: fixed; }
        .content-table th, .content-table td { border: 1px solid #000; padding: 8px; text-align: left; word-wrap: break-word; }
        .footer { margin-top: 40px; width: 100%; position: relative; }
        .signature-wrapper { width: 100%; display: table; }
        .signature { display: table-cell; width: 33.3%; text-align: center; vertical-align: top; }
        /* CSS tambahan untuk mencegah halaman kosong saat diprint */
        @media print { body { margin: 0; padding: 0; } .footer { page-break-inside: avoid; } }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0; font-size: 16pt;">OVERTIME ORDER LETTER</h2>
        <p style="margin: 0;">Nomor: {{ $spl->no_spl }}</p>
    </div>

    <p>Based on operational needs, on <strong>{{ $spl->tanggal }}</strong> The following employees are instructed to work overtime on:</p>

    <table class="content-table">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="width: 40%;">Employee Name</th>
                <th style="width: 20%;">Division</th>
                <th style="width: 20%;">Start Time</th>
                <th style="width: 20%;">Start End</th>
            </tr>
        </thead>
        <tbody>
            @foreach($spl->details as $detail)
            <tr>
                <td>{{ $detail->user->name }}</td>
                <td>{{ $detail->user->section }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->jam_mulai)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->jam_selesai)->format('H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-wrapper">
            <div class="signature">
                Prepared By,<br>
                <span style="font-size: 9pt; color: #666;">({{ $spl->created_at->format('d/m/Y H:i') }})</span>
                <br><br><br><br>
                <strong>( {{ $spl->creator->name }} )</strong><br>
                Supervisor {{ $spl->creator->section }}
            </div>

            <div class="signature">
                Approved By,<br>
                @if($spl->status_approval != 'Waiting Manager')
                    <span style="font-size: 9pt; color: #666;">Digital Signature</span>
                @endif
                <br><br><br><br>
                <strong>( {{ $manager->name ?? '..........................' }} )</strong><br>
                Manager {{ $spl->creator->department }}
            </div>

            <div class="signature">
                Acknowledged By,<br>
                @if($spl->status_approval == 'Approved')
                    <span style="font-size: 9pt; color: #666;">Verified by HR</span>
                @endif
                <br><br><br><br>
                <strong>( {{ $adminSdm->name ?? '..........................' }} )</strong><br>
                Admin HR 
            </div>
        </div>
    </div>
</body>
</html>