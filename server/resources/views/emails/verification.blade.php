<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .verification-code {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            font-size: 24px;
            color: #fff;
            background-color: #4CAF50;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 10px 20px;
            background-color: #f1f1f1;
            font-size: 12px;
            color: #666;
        }
        @media (max-width: 600px) {
            .container {
                width: 100%;
                margin: 0;
            }
            .content {
                padding: 15px;
            }
            .verification-code {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Email Verification</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $user->name }},</h2>
            <p>Thank you for registering with us! To complete your registration, please verify your email address using the code below:</p>
            <div class="verification-code">{{ $verificationCode }}</div>
            <p>Please enter this code in the verification field on our website.</p>
            <p>If you did not create an account, please ignore this email.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
