# system setup

## check

```bash
dnf repolist
sudo dnf config-manager --set-enabled crb
sudo dnf check-update --refresh
dnf upgrade
dnf search cockpit
dnf list installed | grep cockpit
dnf list available
sudo dnf install cockpit cockpit-storaged cockpit-files cockpit-pcp
systemctl status cockpit
sudo systemctl enable --now cockpit.socket
sudo systemctl start cockpit
systemctl status cockpit --no-pager
systemctl status pmlogger
sudo systemctl enable --now pmlogger
sudo systemctl start pmlogger
systemctl status pmlogger --no-pager
sudo dnf install nano wget mlocate perl yum-utils
```
