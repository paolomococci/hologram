# scaffolding

```bash
cd /var/www/html/agora-project/
npm create vite@latest
cd ui-agora05/
npm install
```

## add Tailwind 4

```bash
npm install tailwindcss @tailwindcss/vite
```

### setup of `tailwind.config.js` like this:

```bash
touch tailwind.config.js
```

editing it as follows:

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

```bash
touch vite.config.js
```

editing it as follows:

```js
import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
})
```

## install the icons `lucide`

```bash
npm i lucide
```

## build

```bash
npm run build
```

## check the licenses of the packages used

```bash
license-report --output=csv > licenses_report.csv
```

Now it's time to fix the permissions:

```bash
chown --recursive developer_username:apache .
```
