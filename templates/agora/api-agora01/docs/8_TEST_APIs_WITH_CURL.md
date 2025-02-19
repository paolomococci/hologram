# test APIs with `curl`

## posts model in superuser mode

```bash
curl --insecure --header "Content-Type: application/json" --data '{"user_id": 34, "title": "Some title.", "content": "Some content of this post."}' --request POST https://api-agora01.hologram-srv.local/api/posts
curl --insecure --request GET https://api-agora01.hologram-srv.local/api/posts/500
curl --insecure --header "Content-Type: application/json" --data '{"user_id": 50, "title": "I just changed the title of the post identified as five hundred.", "content": "The content of post number five hundred has just been modified. Even the author now appears different."}' --request PUT https://api-agora01.hologram-srv.local/api/posts/500
```

### unauthorized delete

```bash
curl --insecure --request DELETE https://api-agora01.hologram-srv.local/api/posts/1
```

## posts model in normal mode

```bash
curl --insecure --request GET https://api-agora01.hologram-srv.local/api/posts
curl --insecure --request GET https://api-agora01.hologram-srv.local/api/posts/1
```

## user model

### registration

```bash
curl --insecure --header "Content-Type: application/json" --data '{"name": "John Doe", "email": "john.doe@example.local", "password": "qSrV4^bU1Asx", "password_confirmation": "qSrV4^bU1Asx"}' --request POST https://api-agora01.hologram-srv.local/api/registration
```

### login

```bash
curl --insecure --header "Content-Type: application/json" --data '{"email": "john.doe@example.local", "password": "qSrV4^bU1Asx"}' --request POST https://api-agora01.hologram-srv.local/api/login
```

### check user

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" https://api-agora01.hologram-srv.local/api/user
```

### make a post

```bash
curl --insecure --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --header "Content-Type: application/json" --data '{"title": "Some title for this post.", "content": "Example content of this post."}' --request POST https://api-agora01.hologram-srv.local/api/posts
```

### show the post just inserted 

```bash
curl --insecure --request GET https://api-agora01.hologram-srv.local/api/posts/503
```

### update the post just inserted

```bash
curl --insecure --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --header "Content-Type: application/json" --data '{"title": "I just changed the title of the post identified as five hundred.", "content": "The content of post number five hundred has just been modified. Even the author now appears different."}' --request PUT https://api-agora01.hologram-srv.local/api/posts/503
```

### show the post just updated 

```bash
curl --insecure --request GET https://api-agora01.hologram-srv.local/api/posts/503
```

### I'm going to trash the previous post now

```bash
curl --insecure --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request DELETE https://api-agora01.hologram-srv.local/api/posts/503
```

### logout

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request POST https://api-agora01.hologram-srv.local/api/logout
```

## test registration and login with weak passwords

### registrations

Johnny Doe:

```bash
curl --insecure --header "Content-Type: application/json" --data '{"name": "Johnny Doe", "email": "johnny.doe@example.local", "password": "qwertyuiopas", "password_confirmation": "qwertyuiopas"}' --request POST https://api-agora01.hologram-srv.local/api/registration
```

password is accepted.

Jennifer Doe:

```bash
curl --insecure --header "Content-Type: application/json" --data '{"name": "Jennifer Doe", "email": "jennifer.doe@example.local", "password": "Πwertyuiopas", "password_confirmation": "Πwertyuiopas"}' --request POST https://api-agora01.hologram-srv.local/api/registration
```

password is not accepted.

## update password

Login:

```bash
curl --insecure --header "Content-Type: application/json" --data '{"email": "jj.doe@example.local", "password": "2WE!tYu$3pAs"}' --request POST https://posts
-php84.local/api/login
```

Change password:

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --header "Content-Type: application/json" --data '{"password": "_tqwR#5FdpX!", "password_confirmation": "_tqwR#5FdpX!"}' --request POST https://api-agora01.hologram-srv.local/api/update-password
```

Logout:

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request POST https://api-agora01.hologram-srv.local/api/logout
```

Login with new password:

```bash
curl --insecure --header "Content-Type: application/json" --data '{"email": "jj.doe@example.local", "password": "_tqwR#5FdpX!"}' --request POST https://api-agora01.hologram-srv.local/api/login
```

And again the logout:

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request POST https://api-agora01.hologram-srv.local/api/logout
```
