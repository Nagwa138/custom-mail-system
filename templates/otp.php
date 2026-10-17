<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="color-scheme" content="light">
  <title>Verification Code</title>
</head>
<body style="margin:0;padding:0;background:#f0f4f8;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="#f0f4f8" style="background:#f0f4f8;">
  <tr>
    <td align="center" bgcolor="#f0f4f8" style="padding:48px 20px;">
      <table role="presentation" cellpadding="0" cellspacing="0" width="580" style="width:100%;max-width:580px;border-radius:16px;overflow:hidden;box-shadow:0 4px 32px rgba(32,100,175,0.12);">

        <!-- Header -->
        <tr>
          <td bgcolor="#2064AF" style="background:#2064AF;padding:40px 48px 36px;text-align:center;">
            <img src="https://mail.imbox.solutions/imbox-logo.png" alt="IMBox" width="160" style="display:block;margin:0 auto;max-width:160px;height:auto;" />
          </td>
        </tr>

        <!-- Body -->
        <tr>
          <td bgcolor="#ffffff" style="background:#ffffff;padding:48px 48px 40px;font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;">
            <h2 style="margin:0 0 6px;color:#1a1a2e;font-size:26px;font-weight:600;letter-spacing:-0.4px;">Hello, <?= htmlspecialchars($receiver_name) ?></h2>
            <p style="margin:0 0 24px;color:#8a9ab0;font-size:14px;font-weight:400;">Identity Verification</p>
            <div style="width:32px;height:3px;background:#F08021;margin:0 0 28px;border-radius:2px;"></div>
            <p style="margin:0 0 28px;color:#3d4c5e;font-size:16px;line-height:1.75;">Use the verification code below to complete your request. Do not share this code with anyone.</p>

            <!-- Code display -->
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="margin:0 0 28px;">
              <tr>
                <td bgcolor="#2064AF" style="background:#2064AF;border-radius:12px;padding:32px;text-align:center;">
                  <p style="margin:0 0 12px;color:rgba(255,255,255,0.6);font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:3px;text-transform:uppercase;">Verification Code</p>
                  <p style="margin:0;color:#ffffff;font-family:'SF Mono','Courier New',Courier,monospace;font-size:44px;font-weight:700;letter-spacing:12px;line-height:1;"><?= htmlspecialchars($code) ?></p>
                  <p style="margin:14px 0 0;color:rgba(255,255,255,0.5);font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;font-size:11px;letter-spacing:0.5px;">Valid for <?= htmlspecialchars($expires_in ?? '10 minutes') ?></p>
                </td>
              </tr>
            </table>

            <p style="margin:0;color:#8a9ab0;font-size:14px;line-height:1.7;">This code expires in <strong style="color:#3d4c5e;"><?= htmlspecialchars($expires_in ?? '10 minutes') ?></strong>. If you did not request this, please ignore this email.</p>
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
