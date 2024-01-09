# https setup with a self-signed certificate

## parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[long passphrase]
[national_acronym]
[state]
[city]
hologram-php56.local
hologram-php56.local
hologram-php56.local
[]
```

```bash
mkdir -p /etc/ssl/self_signed_certs
openssl req -new -x509 -days 365 -out /etc/ssl/self_signed_certs/hologram-php56.pem -keyout /etc/ssl/self_signed_certs/hologram-php56.key
ls -al /etc/ssl/self_signed_certs/
chmod 600 /etc/ssl/self_signed_certs/hologram-php56*
sudo nano /etc/ssl/self_signed_certs/echo_passphrase.sh
```

```text
#!/bin/sh
echo "long passphrase"
```

```bash
sudo chmod +x /etc/ssl/self_signed_certs/echo_passphrase.sh
```
