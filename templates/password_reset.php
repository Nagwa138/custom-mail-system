<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: #dc2626; padding: 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 26px; }
        .body { padding: 32px; color: #333; line-height: 1.6; }
        .body h2 { color: #dc2626; }
        .btn { display: inline-block; margin: 20px 0; padding: 14px 28px; background: #dc2626; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .note { font-size: 13px; color: #888; margin-top: 16px; }
        .footer { background: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="body">
            <h2>Hello, <?= htmlspecialchars($receiver_name) ?>!</h2>
            <p>We received a request to reset your password. Click the button below to proceed.</p>
            <?php if (!empty($reset_link)): ?>
                <a href="<?= htmlspecialchars($reset_link) ?>" class="btn">Reset My Password</a>
            <?php endif; ?>
            <p class="note">This link will expire in 30 minutes. If you did not request a password reset, you can safely ignore this email.</p>
            <p>Best regards,<br><strong>The IMBox Team</strong></p>
        </div>
        <div class="footer">
            &copy; <?= date('Y') ?> IMBox. All rights reserved.
        </div>
    </div>
</body>
</html>
