# scaffolding

```bash
npm create vite@latest
cd ui-agora01
npm install
```

## add Tailwind 4

```bash
npm install tailwindcss @tailwindcss/vite
```

### setup of `tailwind.config.js` like this:

```js
import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
})
```

### import Tailwind CSS

Add `@import` into `/src/index.css` file like this:

```css
@import "tailwindcss";
```

At this point, it is necessary to edit file `vite.config.js` in the following manner:

```js
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite' // add this line

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    react(),
    tailwindcss(), // add this line
  ],
})
```

## install React router dom

```bash
npm i react-router-dom
```

## install Axios

```bash
npm i axios
```

## install the icons `lucide-react`

```bash
npm i lucide-react
```

## check the licenses of the packages used

```bash
license-report --output=csv > licenses_report.csv
```

## build

```bash
npm run build
```

Now it's time to fix the permissions:

```bash
chown --recursive developer_username:apache .
```
