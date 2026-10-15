<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="color-scheme" content="light">
  <title>Welcome to IMBox</title>
</head>
<body style="margin:0;padding:0;background:#f0f4f8;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="#f0f4f8" style="background:#f0f4f8;">
  <tr>
    <td align="center" bgcolor="#f0f4f8" style="padding:48px 20px;">
      <table role="presentation" cellpadding="0" cellspacing="0" width="580" style="width:100%;max-width:580px;border-radius:16px;overflow:hidden;box-shadow:0 4px 32px rgba(32,100,175,0.12);">

        <!-- Header -->
        <tr>
          <td bgcolor="#2064AF" style="background:#2064AF;padding:40px 48px 36px;text-align:center;">
            <img src="https://mail.imbox.solutions/imbox-header.png" alt="IMBox" width="160" style="display:block;margin:0 auto;max-width:160px;height:auto;" />
          </td>
        </tr>

        <!-- Body -->
        <tr>
          <td bgcolor="#ffffff" style="background:#ffffff;padding:48px 48px 40px;font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;">
            <h2 style="margin:0 0 6px;color:#1a1a2e;font-size:26px;font-weight:600;letter-spacing:-0.4px;">Hello, <?= htmlspecialchars($receiver_name) ?></h2>
            <p style="margin:0 0 24px;color:#8a9ab0;font-size:14px;font-weight:400;">Welcome aboard</p>
            <div style="width:32px;height:3px;background:#F08021;margin:0 0 28px;border-radius:2px;"></div>
            <p style="margin:0 0 18px;color:#3d4c5e;font-size:16px;line-height:1.75;">We're thrilled to have you on board. Your account has been successfully created.</p>
            <p style="margin:0 0 18px;color:#3d4c5e;font-size:16px;line-height:1.75;">You can now log in and start exploring everything IMBox has to offer.</p>
            <p style="margin:0 0 36px;color:#3d4c5e;font-size:16px;line-height:1.75;">If you have any questions, feel free to reach out to our support team at any time.</p>
            <p style="margin:0;color:#3d4c5e;font-size:16px;line-height:1.75;">Best regards,<br><span style="font-weight:700;color:#2064AF;">The IMBox Team</span></p>
          </td>
        </tr>

        <!-- Footer -->
        <tr>
          <td bgcolor="#f0f4f8" style="background:#f0f4f8;padding:22px 48px;border-top:1px solid #dde6ef;text-align:center;">
            <p style="margin:0;color:#8a9ab0;font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;font-size:12px;line-height:1.8;">
              &copy; <?= date('Y') ?> IMBox. All rights reserved.<br>
              <span style="color:#F08021;font-weight:500;">Smart Locker Solutions</span>
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>
</body>
</html>
