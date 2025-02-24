# scaffolding

```bash
npm create vite@latest
cd ui-agora02/
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
import vue from '@vitejs/plugin-vue'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    tailwindcss(),
  ],
})
```

## install Axios

```bash
npm i axios
```

## install the icons `lucide-vue-next`

```bash
npm i lucide-vue-next
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
