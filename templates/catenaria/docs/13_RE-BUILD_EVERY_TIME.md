# re-build every time

If it becomes necessary to issue the x command every time a change occurs in some directories.

## install `watch`

```bash
npm i watch
```

Now you need to modify the `package.json` file similar to the following:

```json
{
    "private": true,
    "type": "module",
    "scripts": {
        "build": "vite build --watch",
        "dev": "vite"
    },
    "devDependencies": {
        "autoprefixer": "^10.4.20",
        "axios": "^1.7.4",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^1.0",
        "postcss": "^8.4.47",
        "tailwindcss": "^3.4.13",
        "vite": "^6.0"
    }
}
```
