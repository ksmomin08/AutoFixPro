<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmed</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; color: #333; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: #1e293b; padding: 30px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; color: #f59e0b; }
        .content { padding: 30px; }
        .content p { font-size: 16px; line-height: 1.6; color: #475569; }
        .details-box { background: #f1f5f9; border-left: 4px solid #f59e0b; padding: 20px; margin: 25px 0; border-radius: 4px; }
        .details-box p { margin: 10px 0; font-size: 15px; }
        .label { font-weight: bold; color: #1e293b; display: inline-block; width: 130px; }
        .status { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; color: white; }
        .status-success { background: #10b981; }
        .status-pending { background: #f59e0b; }
        .footer { text-align: center; padding: 20px; background: #f8fafc; font-size: 14px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        .btn { display: inline-block; background: #f59e0b; color: white; text-decoration: none; padding: 12px 25px; border-radius: 4px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KSM MotoWorks</h1>
            <p style="margin-top:10px; color:#cbd5e1;">Your Vehicle Service Platform</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $appointment->fullname }},</h2>
            <p>Great news! Your service booking has been officially <strong>accepted</strong> by our workshop. We are ready to provide premium care for your vehicle.</p>
            
            <div class="details-box">
                <p><span class="label">Booking ID:</span> #{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p><span class="label">Date:</span> {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y, g:i A') }}</p>
                <p><span class="label">Vehicle:</span> {{ $appointment->vehicle }}</p>
                <p><span class="label">Service required:</span> {{ $appointment->service }}</p>
                
                @php
                    $isPaid = $appointment->payment_status === 'paid';
                @endphp
                
                <p style="margin-top: 15px;">
                    <span class="label">Payment Status:</span> 
                    <span class="status {{ $isPaid ? 'status-success' : 'status-pending' }}">
                        {{ $isPaid ? 'SUCCESS (PAID)' : 'PENDING' }}
                    </span>
                </p>
            </div>
            
            <p>If you have any questions or need to make changes, please contact us immediately or reply to this email.</p>
            
            <center>
                <a href="{{ url('/') }}" class="btn">Visit KSM MotoWorks</a>
            </center>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} KSM MotoWorks. All rights reserved.<br>
            Ahmedabad, India.
        </div>
    </div>
</body>
</html>
