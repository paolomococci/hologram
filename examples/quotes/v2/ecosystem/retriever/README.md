# `retriever` an example of Micro-Frontend application

This is an example of a Micro-Frontend application, which together with others, can be collected in a sort of ecosystem of the main application.
Micro-Frontend Applications instead of a monolithic Single Page Application, to be developed quickly when needed, avoiding the risk of affecting already well-tested functionality.
And, perhaps, at a later time, once consolidated, it will be possible to bring together the Micro-Frontend applications that had until then been developed separately in a new Single Page Application.

## scaffolding

```sh
npm create vue@latest
cd retriever
```

## setup

```sh
npm install
```

## transpiling and hot-reload for development

```sh
npm run dev
```

It is necessary to remember that to access the routes dedicated to the APIs collected in file `routes/api.php` of framework `Laravel` that each path must be preceded by the indication `/api`, as in the following example:

```javascript
export const API_TEST = 'https://192.168.1.XXX/api/test'
```

These paths can be collected in a single file, as can be, for example, `env.js`.

## lint

```sh
npm run lint
```

## transpile and minify

```sh
npm run build
```

## deploy setup

To successfully deploy to your development web server you need to edit the `vite.config.js` file similar to the following.

```javascript
...
  build: {
    outDir: OUT_DIR_NAME
  },
  base: URI_BASE,
...
```

Being careful to assign the correct paths to the constants present in the code.
