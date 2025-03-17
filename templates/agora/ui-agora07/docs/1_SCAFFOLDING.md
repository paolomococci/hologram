# scaffolding

```bash
cd /var/www/html/agora-project/
npm create vite@latest
cd ui-agora07/
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
import { svelte } from '@sveltejs/vite-plugin-svelte'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    svelte(),
    tailwindcss(),
  ],
})
```

## install Axios

```bash
npm i axios
```

## install the icons `lucide-svelte`

```bash
npm i lucide-svelte
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

## some tips

### to prevent the final semicolon from being automatically inserted

Edit the `.prettierrc` file as follows:

```conf
{
    "semi": false
}
```

### how to center elements horizontally and vertically with Tailwind

```html
<div class="flex justify-center items-center h-screen"></div>
```

### how to center elements vertically with Tailwind

```html
<div class="flex items-center h-screen"></div>
```

### how to center elements horizontally with Tailwind

```html
<div class="flex justify-center items-center"></div>
```

## check for updates

When I need to update to the latest release:

```bash
su -
node -v
npm view node version
npm cache clean -f
npm install -g n
n stable
npm -v
npm view npm version
npm install -g npm@latest
tsc --version
npm install -g typescript@latest
exit
```
