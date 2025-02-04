# test APIs with `curl`

## requests without a token

```bash
curl --insecure --request GET https://chirps-hologram-srv.local/api/posts
curl --insecure --request GET https://chirps-hologram-srv.local/api/post/101
curl --insecure --request DELETE https://chirps-hologram-srv.local/api/post/12
```

As expected, information cannot be obtained without presenting a valid token.

## attempt to register a user using a weak password

```bash
curl --insecure --header "Content-Type: application/json" --data '{"name": "Johnny Doe", "email": "johnny.doe@example.local", "password": "qwertyuiopas", "password_confirmation": "qwertyuiopas"}' --request POST https://chirps-hologram-srv.local/api/register
```

In this case, the password does not meet the validation requirements.

## attempt to register a user using a password that follows the guidelines set by the system

```bash
curl --insecure --header "Content-Type: application/json" --data '{"name": "John Doe", "email": "john.doe@example.local", "password": "KdRad#aD2mjX4_", "password_confirmation": "KdRad#aD2mjX4_"}' --request POST https://chirps-hologram-srv.local/api/register
```

Now the password passes validation and a new user is registered.

What makes it possible to validate strong passwords is determined by the following code snippet present in file `app/Http/Controllers/AuthController.php`:

```php
...
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|min:3|max:255',
                    'email' => 'required|max:36|email|unique:users',
                    'password' => [
                        'required',
                        'confirmed',
                        'unique:users',
                        Password::min(12)->max(24)->letters()->mixedCase()->numbers()->symbols(),
                    ],
                ]
            );
...
```

## logout

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request POST https://chirps-hologram-srv.local/api/logout
```

## login

```bash
curl --insecure --header "Content-Type: application/json" --data '{"email": "john.doe@example.local", "password": "KdRad#aD2mjX4_"}' --request POST https://chirps-hologram-srv.local/api/login
```

## accessing information thanks to a valid JWT token

```bash
curl --insecure --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request GET https://chirps-hologram-srv.local/api/posts
curl --insecure --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request GET https://chirps-hologram-srv.local/api/post/10
```

## make a post

```bash
curl --insecure --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --header "Content-Type: application/json" --data '{"title": "Some title for this post.", "content": "Example content of this post."}' --request POST https://chirps-hologram-srv.local/api/post
```

## show the post just inserted

```bash
curl --insecure --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request GET https://chirps-hologram-srv.local/api/post/501
```

## update the post just inserted

```bash
curl --insecure --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --header "Content-Type: application/json" --data '{"title": "I just changed the title of the post identified as five hundred.", "content": "The content of post number five hundred has just been modified. Even the author now appears different."}' --request PUT https://chirps-hologram-srv.local/api/post/501
```

## show the post just updated 

```bash
curl --insecure --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request GET https://chirps-hologram-srv.local/api/post/501
```

## I'm going to trash the previous post now

```bash
curl --insecure --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request DELETE https://chirps-hologram-srv.local/api/post/501
```

## refresh endpoint

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request POST https://chirps-hologram-srv.local/api/refresh
```

## whoami endpoint

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request POST https://chirps-hologram-srv.local/api/whoami
```

## update credentials

Now I will try to change the password:

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --header "Content-Type: application/json" --data '{"password": "_tqwR#5FdpX!", "password_confirmation": "_tqwR#5FdpX!"}' --request POST https://chirps-hologram-srv.local/api/update
```

I perform the logout: 

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request POST https://chirps-hologram-srv.local/api/logout
```

Now I am going to try to log in, but this time using a new password:

```bash
curl --insecure --header "Content-Type: application/json" --data '{"email": "john.doe@example.local", "password": "_tqwR#5FdpX!"}' --request POST https://chirps-hologram-srv.local/api/login
```

I am going to perform a simple check:

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request POST https://chirps-hologram-srv.local/api/whoami
```

And finally, I exit again from the session:

```bash
curl --insecure --verbose --header "Authorization: Bearer THE_TOKEN_SHOULD_BE_ENTERED_HERE" --request POST https://chirps-hologram-srv.local/api/logout
```
