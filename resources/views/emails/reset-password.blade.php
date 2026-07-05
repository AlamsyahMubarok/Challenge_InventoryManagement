<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Atur Ulang Kata Sandi</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 30px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px;">
        <h2 style="color: #111827; margin-top: 0;">Atur Ulang Kata Sandi</h2>

        <p>Halo {{ $user->name }},</p>

        <p>
            Kami menerima permintaan untuk mengatur ulang kata sandi akun Inventra Anda.
            Klik tombol di bawah ini untuk membuat kata sandi baru.
        </p>

        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}"
               style="background-color: #111827; color: #ffffff; padding: 12px 20px; text-decoration: none; border-radius: 6px; display: inline-block;">
                Atur Ulang Kata Sandi
            </a>
        </p>

        <p>
            Link ini akan kedaluwarsa dalam 60 menit.
        </p>

        <p>
            Jika Anda tidak meminta reset kata sandi, abaikan email ini.
        </p>

        <p style="margin-bottom: 0;">
            Salam,<br>
            Inventra
        </p>

        <hr style="margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;">

        <p style="font-size: 12px; color: #6b7280;">
            Jika tombol tidak bisa diklik, salin link berikut ke browser:
        </p>

        <p style="font-size: 12px; word-break: break-all;">
            <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
        </p>
    </div>
</body>
</html>
