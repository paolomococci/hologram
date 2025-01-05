# git setup

## I create a bare Git repository

```bash
cd /var
sudo mkdir repositories
sudo chown developer_username:developer_username repositories
cd repositories
mkdir sample.git && cd sample.git
git init --bare
```

Optionally:

```bash
git clone https://some_git_service.local/sample --bare
```

## I add post-receive hook

```bash
mkdir /var/www/html/sample
ls -al /var/www/html/
chown developer_username:www-data /var/www/html/sample
ls -al /var/repositories/sample.git/hooks/
nano /var/repositories/sample.git/hooks/post-receive
```

Edit similar to the following:

```text
git --work-tree=/var/www/html/sample/ --git-dir=/var/repositories/sample.git/ checkout -f
```

Now it is necessary to change the mode:

```bash
chmod +x /var/repositories/sample.git/hooks/post-receive
```

## I add the repository locally

Below are the commands useful for cloning the repository hosted in the virtual machine:

```bash
cd ~
mkdir Repositories && cd Repositories
git clone ssh://developer_username@192.168.1.102/var/repositories/sample
cd sample
git status
```

Now I need to set the credentials locally, specific to this repository:

```bash
git config user.name "developer_username"
git config user.email "developer_username@localhost"
```

Examining the `/sample/.git/config` file you will get something similar to the following:

```text
[core]
        repositoryformatversion = 0
        filemode = true
        bare = false
        logallrefupdates = true
[remote "origin"]
        url = ssh://developer_username@192.168.1.102/var/repositories/sample
        fetch = +refs/heads/*:refs/remotes/origin/*
[branch "master"]
        remote = origin
        merge = refs/heads/master
[user]
        name = developer_username
        email = developer_username@localhost
```

Finally, having already set up authentication via self-signed certificate, at this point just open the project locally with a code editor, create a file called `index.html` in directory `public` and execute the `commit` and `push` commands to find directly the file in path `/var/www/html/sample/public` as expected.
