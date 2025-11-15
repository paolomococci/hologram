# containerization of PHP DSA, (Data Structures and Algorithm) development environment

For a `micro-container` oriented architecture.

## local repository

```shell
git init
git branch -m main
git status
git add .
git commit -m "initializing the local repository"
git log
git tag -a v0.0.0 -m "starting version of the microservice"
git reset --hard v0.0.0
```

## `lamp-dsa-cntr` is an example of use in development sessions

In this example I try to customize an image named `lamp-dsa-img:1.0`

### sources

*First of all, a directory with the sources must be prepared which will then be copied into the image thanks to the dockerfile and subsequently compiled.*

It will therefore be necessary to obtain the following sources:

* php-src-php-8.5.0beta3.zip

Then place them in the sources directory.

## create an example of container

```shell
ls ~/applications/stacks/LAMP/dsa/
cd ~/applications/stacks/LAMP/dsa/
```

## image build

Once the example web application is built I can issue the following command:

```shell
podman image ls | grep "lamp-dsa-img"
cat Dockerfile
podman build --tag lamp-dsa-img:1.0 .
```

The output of this command should also contain the digest of the newly created local image.

Now I continue with the verification of some details:

```shell
podman image ls | grep "lamp-dsa-img"
podman images --no-trunc --quiet lamp-dsa-img:1.0
podman image inspect lamp-dsa-img:1.0
```
