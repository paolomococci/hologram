# Rust setup

## using `rustup`

On the Rust site the recommended method for installing on Unix-like systems seems to be the following:

```bash
cd ~
curl --proto '=https' --tlsv1.2 -sSf https://sh.rustup.rs | sh
rustc --version
```

If the last command does not show the version of Rust, the following additional steps may be required:

```bash
grep -i 'cargo' .bashrc
grep -i 'cargo' .profile
. ~/.bashrc
. ~/.profile
rustc --version
```
