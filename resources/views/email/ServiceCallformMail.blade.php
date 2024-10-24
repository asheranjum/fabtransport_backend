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
            <h2>Service Call Form Form</h2>
        </div>

        <div class="content">
            <h3>Details</h3>
            <p><strong>Name:</strong> {{ $PostData->name }}</p>
            <p><strong>location:</strong> {{ $PostData->location }}</p>
            <p><strong>Issue:</strong> {{ $PostData->issue }}</p>
            <p><strong>Image:</strong> <img src="{{ url('storage/{{ $PostData->image }}') }}" alt="Service Call Image1" /></p>
            <p><strong>Image1</strong> <img src="{{ url('storage/{{ $PostData->image1 }}') }}" alt="Service Call Image1" /></p>
            <p><strong>Image2</strong> <img src="{{ url('storage/{{ $PostData->image2 }}') }}" alt="Service Call Image2" /></p>
            <p><strong>Image3</strong> <img src="{{ url('storage/{{ $PostData->image3 }}') }}" alt="Service Call Image3" /></p>
            <p><strong>Image4</strong> <img src="{{ url('storage/{{ $PostData->image4}}') }}" alt="Service Call Image4" /></p>
           
            <hr>
        </div>
    
        <div class="footer">
            <p>This is an automated message. Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
