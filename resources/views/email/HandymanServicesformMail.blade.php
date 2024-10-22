<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 7px;
        }
        .header {
            background: #e9e9e9;
            padding: 10px 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .header h2 {
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            padding: 10px 20px;
            background: #e9e9e9;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Handyman Services Form</h2>
        </div>

        <div class="content">
            <h3>Details</h3>
            <p><strong>Name:</strong> {{ $PostData->name }}</p>
            <p><strong>Email:</strong> {{ $PostData->email }}</p>
            <p><strong>Phone</strong> {{ $PostData->phone }}</p>
            <p><strong>Quote</strong> {{ $PostData->quote }}</p>     
           <p><strong>Image:</strong> <img src="{{ url('storage/handyman-services/4SoyHcPdJjBLYkK2PtoYsjlTF6u5GYQJuMkQTmgC.png') }}" alt="Handyman Service Image" /></p>

            <hr>
        </div>
    
        <div class="footer">
            <p>This is an automated message. Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
