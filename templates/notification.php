<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: #7c3aed; padding: 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 26px; }
        .body { padding: 32px; color: #333; line-height: 1.6; }
        .body h2 { color: #7c3aed; }
        .message-box { background: #f5f3ff; border-left: 4px solid #7c3aed; padding: 16px; border-radius: 4px; margin: 16px 0; }
        .footer { background: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Notification</h1>
        </div>
        <div class="body">
            <h2>Hello, <?= htmlspecialchars($receiver_name) ?>!</h2>
            <p>You have a new notification from IMBox:</p>
            <?php if (!empty($message)): ?>
                <div class="message-box">
                    <?= nl2br(htmlspecialchars($message)) ?>
                </div>
            <?php endif; ?>
            <p>Best regards,<br><strong>The IMBox Team</strong></p>
        </div>
        <div class="footer">
            &copy; <?= date('Y') ?> IMBox. All rights reserved.
        </div>
    </div>
</body>
</html>
