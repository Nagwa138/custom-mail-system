import requests
from django.conf import settings


MAIL_API_URL = "https://mail.imbox.solutions/send.php"


def _send(template: str, email: str, name: str, subject: str = "", variables: dict = None) -> dict:
    response = requests.post(
        MAIL_API_URL,
        json={
            "template":       template,
            "receiver_email": email,
            "receiver_name":  name,
            "subject":        subject,
            "variables":      variables or {},
        },
        headers={
            "X-API-Key":    settings.IMBOX_MAIL_API_KEY,
            "Content-Type": "application/json",
        },
        timeout=10,
    )
    return response.json()


def send_otp(email: str, username: str, code: str, expires_in: str = "10 minutes") -> dict:
    return _send(
        template="otp",
        email=email,
        name=username,
        subject="Your verification code",
        variables={"code": code, "expires_in": expires_in},
    )


def send_welcome(email: str, username: str) -> dict:
    return _send(
        template="welcome",
        email=email,
        name=username,
    )


def send_password_reset(email: str, username: str, reset_link: str) -> dict:
    return _send(
        template="password_reset",
        email=email,
        name=username,
        variables={"reset_link": reset_link},
    )


def send_notification(email: str, username: str, subject: str, message: str) -> dict:
    return _send(
        template="notification",
        email=email,
        name=username,
        subject=subject,
        variables={"message": message},
    )
