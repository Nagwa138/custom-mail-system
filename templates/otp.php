<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: #0f172a; padding: 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 24px; letter-spacing: 1px; }
        .body { padding: 40px 32px; color: #333; line-height: 1.6; }
        .body h2 { color: #0f172a; margin-top: 0; }
        .code-box { margin: 32px auto; text-align: center; }
        .code { display: inline-block; font-size: 42px; font-weight: bold; letter-spacing: 12px; color: #0f172a; background: #f1f5f9; padding: 20px 36px; border-radius: 8px; border: 2px dashed #cbd5e1; }
        .note { font-size: 13px; color: #888; margin-top: 24px; }
        .footer { background: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>IMBox Verification</h1>
        </div>
        <div class="body">
            <h2>Hello, <?= htmlspecialchars($receiver_name) ?>!</h2>
            <p>Use the verification code below to complete your request. Do not share this code with anyone.</p>
            <div class="code-box">
                <span class="code"><?= htmlspecialchars($code) ?></span>
            </div>
            <p class="note">This code expires in <strong><?= htmlspecialchars($expires_in ?? '10 minutes') ?></strong>. If you did not request this, please ignore this email.</p>
        </div>
        <div class="footer">
            &copy; <?= date('Y') ?> IMBox. All rights reserved.
        </div>
    </div>
</body>
</html>
