<!DOCTYPE html>
<html>
<head>
    <title>Cetak Label Aset</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }
        /* Grid Container */
        .label-container {
            width: 100%;
            /* Trik agar layout tidak berantakan */
            font-size: 0; 
        }
        
        /* Kotak Label Individual (2 Kolom per Baris) */
        .label-box {
            display: inline-block;
            width: 48%; /* Lebar 48% agar ada jarak 2% */
            margin-right: 2%;
            margin-bottom: 20px;
            border: 2px solid #000;
            border-radius: 8px;
            padding: 10px;
            box-sizing: border-box;
            vertical-align: top;
            
            /* Reset font size untuk konten */
            font-size: 12px; 
            page-break-inside: avoid; /* Jangan potong label di tengah halaman */
        }

        /* Hapus margin kanan setiap label genap (2, 4, 6...) */
        .label-box:nth-child(even) {
            margin-right: 0;
        }

        .qr-code {
            float: left;
            width: 35%;
        }
        .qr-code img {
            width: 100%;
            height: auto;
        }
        .info {
            float: right;
            width: 62%;
            padding-left: 3%;
        }
        .company-name {
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 5px;
            border-bottom: 2px solid #000;
            display: inline-block;
        }
        .asset-tag {
            font-family: monospace;
            font-size: 16px;
            font-weight: bold;
            background-color: #000;
            color: #fff;
            padding: 2px 6px;
            margin-top: 5px;
            display: inline-block;
            border-radius: 4px;
        }
        .warning-text {
            font-size: 8px;
            color: #555;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>

    <div class="label-container">
        @foreach($assets as $asset)
            <div class="label-box">
                <div class="qr-code">
                    <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(150)->generate($asset->asset_tag)) }} ">
                </div>

                <div class="info">
                    <div class="warning-text">PROPERTY OF:</div>
                    <div class="company-name">VODECO GROUP</div>
                    
                    <div style="margin-top: 5px;">
                        {{ Str::limit($asset->name, 35) }}
                    </div>

                    <div class="asset-tag">{{ $asset->asset_tag }}</div>
                </div>
                
                <div style="clear: both;"></div>
            </div>
        @endforeach
    </div>

</body>
</html>