<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notification</title>
</head>
<body style="margin:0;padding:0;background:#f5f5f7;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f7;">
  <tr>
    <td align="center" style="padding:52px 20px;">
      <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%;max-width:580px;background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 4px 40px rgba(0,0,0,0.07);">

        <!-- Header -->
        <tr>
          <td style="background:#000000;padding:44px 52px 40px;text-align:center;">
            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;margin:0 auto 18px;">
              <rect x="4" y="17" width="28" height="16" rx="4" stroke="rgba(255,255,255,0.35)" stroke-width="1.5" fill="rgba(255,255,255,0.04)"/>
              <path d="M11 17v-5a7 7 0 0114 0v5" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" stroke-linecap="round" fill="none"/>
              <circle cx="18" cy="25" r="2" fill="rgba(255,255,255,0.85)"/>
              <rect x="17" y="27" width="2" height="3" rx="1" fill="rgba(255,255,255,0.5)"/>
            </svg>
            <p style="margin:0;color:#ffffff;font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;font-size:22px;font-weight:600;letter-spacing:-0.2px;">IMBox</p>
            <p style="margin:7px 0 0;color:rgba(255,255,255,0.36);font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;font-size:10px;font-weight:500;letter-spacing:2.5px;text-transform:uppercase;">Smart Locker Solutions</p>
          </td>
        </tr>

        <!-- Body -->
        <tr>
          <td style="padding:52px 52px 44px;font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;">
            <h2 style="margin:0 0 6px;color:#1d1d1f;font-size:28px;font-weight:600;letter-spacing:-0.5px;">Hello, <?= htmlspecialchars($receiver_name) ?></h2>
            <p style="margin:0 0 28px;color:#aeaeb2;font-size:14px;font-weight:400;">You have a new notification</p>
            <div style="width:28px;height:2px;background:#1d1d1f;margin:0 0 32px;border-radius:2px;"></div>
            <p style="margin:0 0 20px;color:#3a3a3c;font-size:16px;line-height:1.75;">You have a new notification from IMBox:</p>

            <?php if (!empty($message)): ?>
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="margin:0 0 28px;">
              <tr>
                <td style="background:#f5f5f7;border-radius:12px;padding:20px 24px;color:#3a3a3c;font-size:15px;line-height:1.7;">
                  <?= nl2br(htmlspecialchars($message)) ?>
                </td>
              </tr>
            </table>
            <?php endif; ?>

            <?php if (!empty($qr_code)): ?>
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="margin:0 0 32px;">
              <tr>
                <td style="border:1.5px solid #e5e5ea;border-radius:16px;padding:36px 24px;text-align:center;">
                  <p style="margin:0 0 6px;color:#1d1d1f;font-size:14px;font-weight:600;letter-spacing:-0.1px;">Locker Access</p>
                  <p style="margin:0 0 24px;color:#aeaeb2;font-size:12px;letter-spacing:0.3px;">Scan this QR code to open your locker cell</p>
                  <img src="cid:qr_code" alt="QR Code" style="width:180px;height:180px;display:block;margin:0 auto;border-radius:8px;" />
                </td>
              </tr>
            </table>
            <?php endif; ?>

            <p style="margin:0;color:#3a3a3c;font-size:16px;line-height:1.75;">Best regards,<br><span style="font-weight:600;color:#1d1d1f;">The IMBox Team</span></p>
          </td>
        </tr>

        <!-- Footer -->
        <tr>
          <td style="padding:24px 52px;background:#f9f9f9;border-top:1px solid #f0f0f0;text-align:center;">
            <p style="margin:0;color:#aeaeb2;font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;font-size:12px;line-height:1.8;">&copy; <?= date('Y') ?> IMBox. All rights reserved.<br><span style="color:#c7c7cc;">Secure. Smart. Swift.</span></p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>
</body>
</html>
