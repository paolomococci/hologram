# https setup a self-signed certificate

## parameter for generate keys:

To generate a good passphrase I could use the following command:

```bash
pwgen -s 48 1
```

Here is just an example of the parameters to keep on hand:

```text
[long passphrase]
[national_acronym]
[state]
[city]
hologram-php831xdb.local
hologram-php831xdb.local
hologram-php831xdb.local
[webmaster@localhost]
```

Therefore I can proceed with the re-generation of the self-signed certificate:

```bash
ssh developer@192.168.1.138
ls -al /etc/ssl/self_signed_certs/
sudo rm /etc/ssl/self_signed_certs/hologram-php*
sudo openssl req -new -x509 -days 365 -out /etc/ssl/self_signed_certs/hologram-php831xdb.pem -keyout /etc/ssl/self_signed_certs/hologram-php831xdb.key
ls -al /etc/ssl/self_signed_certs/
sudo chmod 600 /etc/ssl/self_signed_certs/hologram-php831xdb*
sudo nano /etc/ssl/self_signed_certs/echo_passphrase.sh
```
