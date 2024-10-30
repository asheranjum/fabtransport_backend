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
            <h2>House Moving</h2>
        </div>

       <div class="content">

       <h3>Contact Information</h3>

            <p><strong>Email:</strong> {{ $PostData->email }}</p>
            <p><strong>Phone:</strong> {{ $PostData->phone }}</p>
            <p><strong>Subrub:</strong> {{ $PostData->subrub }}</p>
            <p><strong>Postal Code:</strong> {{ $PostData->postal_code }}</p>
            <p><strong>Address:</strong> {{ $PostData->address }}</p>

            <hr>

            <h3>Moving Details</h3>
            <p><strong>Moving From Location:</strong> {{ $PostData->moving_from_location }}</p>
            <p><strong>Moving To Location:</strong> {{ $PostData->moving_to_location }}</p>
            <p><strong>Moving From:</strong> {{ $PostData->moving_from }}</p>
            <p><strong>Moving To:</strong> {{ $PostData->moving_to }}</p>
            <p><strong>Bedrooms:</strong> {{ $PostData->bedrooms }}</p>
            <p><strong>Other Items:</strong> {{ $PostData->other_items }}</p>
            <p><strong>Moving Date:</strong> {{ $PostData->date }}</p>
            
            <hr>

        </div>


    
        <div class="footer">
            <p>This is an automated message. Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
