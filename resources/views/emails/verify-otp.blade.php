<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify your Email</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; color: #333; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: #1e293b; padding: 30px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; color: #f59e0b; }
        .content { padding: 30px; text-align: center; }
        .content p { font-size: 16px; line-height: 1.6; color: #475569; }
        .otp-box { background: #f1f5f9; border: 2px dashed #cbd5e1; padding: 20px; margin: 25px auto; border-radius: 8px; max-width: 250px; text-align: center; font-size: 32px; font-weight: bold; color: #0f172a; letter-spacing: 5px; }
        .footer { text-align: center; padding: 20px; background: #f8fafc; font-size: 14px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KSM MotoWorks</h1>
            <p style="margin-top:10px; color:#cbd5e1;">Your Vehicle Service Platform</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $name }},</h2>
            <p>Thank you for registering with KSM MotoWorks. To complete your registration and securely verify your email address, please use the following One-Time Password (OTP):</p>
            
            <div class="otp-box">
                {{ $otp }}
            </div>
            
            <p>This code is valid for your current session. Do not share this code with anyone.</p>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} KSM MotoWorks. All rights reserved.<br>
            Ahmedabad, India.
        </div>
    </div>
</body>
</html>
