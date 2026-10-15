<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verification Code</title>
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
            <p style="margin:0 0 28px;color:#aeaeb2;font-size:14px;font-weight:400;">Identity Verification</p>
            <div style="width:28px;height:2px;background:#1d1d1f;margin:0 0 32px;border-radius:2px;"></div>
            <p style="margin:0 0 32px;color:#3a3a3c;font-size:16px;line-height:1.75;">Use the verification code below to complete your request. Do not share this code with anyone.</p>

            <!-- Code display -->
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="margin:0 0 32px;">
              <tr>
                <td style="background:#000000;border-radius:14px;padding:36px 32px;text-align:center;">
                  <p style="margin:0 0 14px;color:rgba(255,255,255,0.35);font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;font-size:10px;font-weight:500;letter-spacing:3px;text-transform:uppercase;">Verification Code</p>
                  <p style="margin:0;color:#ffffff;font-family:'SF Mono','Courier New',Courier,monospace;font-size:46px;font-weight:700;letter-spacing:14px;line-height:1;"><?= htmlspecialchars($code) ?></p>
                  <p style="margin:16px 0 0;color:rgba(255,255,255,0.3);font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;font-size:11px;letter-spacing:0.5px;">Valid for <?= htmlspecialchars($expires_in ?? '10 minutes') ?></p>
                </td>
              </tr>
            </table>

            <p style="margin:0;color:#aeaeb2;font-size:14px;line-height:1.7;">This code expires in <strong style="color:#3a3a3c;"><?= htmlspecialchars($expires_in ?? '10 minutes') ?></strong>. If you did not request this, please ignore this email.</p>
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
