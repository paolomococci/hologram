# `sample` 3.0

## project setup

```bash
npm install
```

## small changes

I add a few lines of code to the `vite.config.js` file to set the port and make the development build accessible over the network:

```js
...
  server: {
    host: true,
    port: 8080
  },
...
```

## compile and hot-reload for development

```bash
npm run dev
```

## compile and minify for docker image testing

```bash
npm run build
```
