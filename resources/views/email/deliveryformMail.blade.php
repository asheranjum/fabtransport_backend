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
            <h2>Delivery Form</h2>
        </div>

        <div class="content">
            <h3>Pick-Up Details</h3>
            <p><strong>Pick-Up Location:</strong> {{ $PostData->pick_up_location }}</p>
            <p><strong>Pick-Up Name:</strong> {{ $PostData->pick_up_name }}</p>
            <p><strong>Pick-Up Email:</strong> {{ $PostData->pick_up_email }}</p>
            <p><strong>Pick-Up Phone:</strong> {{ $PostData->pick_up_phone }}</p>
            <p><strong>Pick-Up City:</strong> {{ $PostData->pick_up_city }}</p>
            <p><strong>Pick-Up Postal Code:</strong> {{ $PostData->pick_up_postal_code }}</p>
            <p><strong>Pick-Up Address:</strong> {{ $PostData->pick_up_address }}</p>

            <hr>

            <h3>Delivery Details</h3>
            <p><strong>Delivery Location:</strong> {{ $PostData->delivery_location }}</p>
            <p><strong>Delivery To:</strong> {{ $PostData->delivery_to }}</p>
            <p><strong>The Delivery Requires:</strong> {{ $PostData->the_delivery_requires }}</p>
            <p><strong>Delivery Name:</strong> {{ $PostData->delivery_name }}</p>
            <p><strong>Delivery Email:</strong> {{ $PostData->delivery_email }}</p>
            <p><strong>Delivery Phone:</strong> {{ $PostData->delivery_phone }}</p>
            <p><strong>Delivery City:</strong> {{ $PostData->delivery_city }}</p>
            <p><strong>Delivery Postal Code:</strong> {{ $PostData->delivery_postal_code }}</p>
            <p><strong>Delivery Address:</strong> {{ $PostData->delivery_address }}</p>

            <hr>

            <h3>Alternative Contact Details</h3>
            <p><strong>Name:</strong> {{ $PostData->different_name }}</p>
            <p><strong>Email:</strong> {{ $PostData->different_email }}</p>
            <p><strong>Address:</strong> {{ $PostData->different_address }}</p>

            <hr>

            <p><strong>Delivery Date:</strong> {{ $PostData->date }}</p>
        </div>
    
        <div class="footer">
            <p>This is an automated message. Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
