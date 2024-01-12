# setup HTTPS with a self-signed certificate

## to generate a good passphrase I could use the following command:

```bash
pwgen -s 48 1
```

### parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[long passphrase]
[national_acronym]
[state]
[city]
hologram-php831.local
hologram-php831.local
hologram-php831.local
[webmaster@localhost]
```

Therefore I can proceed with the re-generation of the self-signed certificate:

```bash
ls -al /etc/ssl/self_signed_certs/
sudo rm /etc/ssl/self_signed_certs/hologram-php*
sudo openssl req -new -x509 -days 365 -out /etc/ssl/self_signed_certs/hologram-php831.pem -keyout /etc/ssl/self_signed_certs/hologram-php831.key
ls -al /etc/ssl/self_signed_certs/
sudo chmod 600 /etc/ssl/self_signed_certs/hologram-php831*
sudo nano /etc/ssl/self_signed_certs/echo_passphrase.sh
```

```text
#!/bin/sh
echo "long passphrase"
```

```bash
sudo chmod +x /etc/ssl/self_signed_certs/echo_passphrase.sh
```
