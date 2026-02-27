<div>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Invitation Colocation</title>
    </head>

    <body style="font-family: sans-serif; line-height: 1.6; color: #333;">
        <h2>Bonjour !</h2>
        <p>Tu as été invité à rejoindre la colocation <strong>{{ $invitation->colocation->name }}</strong>.</p>

        <p>Clique sur le bouton ci-dessous pour accepter l'invitation :</p>

        <div style="margin: 30px 0;">
            <a href="{{ route('invitations.join', $invitation->token) }}"
                style="background-color: #4f46e5; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold;">
                Accepter l'invitation
            </a>
        </div>

        <p>Si tu ne souhaites pas rejoindre cette colocation, tu peux simplement ignorer cet email.</p>

        <p>Merci,<br>L'équipe ColocApp</p>
    </body>

    </html>
</div>