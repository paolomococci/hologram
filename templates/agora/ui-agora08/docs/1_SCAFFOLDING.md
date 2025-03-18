# scaffolding

```bash
cd /var/www/html/agora-project/
npm create vite@latest
```

## scaffolding in ten steps

### first step

First, I type the project name: `ui-agora08`

### second step

I select a framework: `Svelte`

### third step

I select a variant: `SvelteKit`

### fourth step

Now I choose the model: `SvelteKit minimal`

### fifth step

I choose the syntax: `TypeScript`

### sixth step

I add the following packages by selecting them from the list: `prettier, vitest, tailwindcss, sveltekit-adapter`

### seventh step

I add tailwindcss plugin: `typography`

### eighth step

Now choose the adapter: `static (@sveltejs/adapter-static)`

### ninth step

I choose the package manage: `npm`

### tenth step

The last of these ten steps involves entering the project directory:

```bash
cd ui-agora08/
```

## install the icons `lucide-svelte`

```bash
npm i lucide-svelte
```

## check the licenses of the packages used

```bash
license-report --output=csv > licenses_report.csv
```

Now it's time to fix the permissions:

```bash
chown --recursive developer_username:apache .
```

## edit `svelte.config.js`:

```js
import adapter from '@sveltejs/adapter-static'
import { vitePreprocess } from '@sveltejs/vite-plugin-svelte'

/** @type {import('@sveltejs/kit').Config} */
const config = {
	// Consult https://svelte.dev/docs/kit/integrations
	// for more information about preprocessors
	preprocess: vitePreprocess(),
	kit: {
		adapter: adapter({
			pages: 'dist',          // change build directory name
      assets: 'dist',
      fallback: undefined,
      precompress: false,
      strict: true
		})
	}
}

export default config
```

## create `src/routes/+page.ts`:

```ts
export const prerender = true
```

## build

```bash
npm run build
```

## some tips

### to prevent the final semicolon from being automatically inserted

Edit the `.prettierrc` file as follows:

```conf
{
    "semi": false,
	"useTabs": true,
	"singleQuote": true,
	"trailingComma": "none",
	"printWidth": 100,
	"plugins": ["prettier-plugin-svelte", "prettier-plugin-tailwindcss"],
	"overrides": [
		{
			"files": "*.svelte",
			"options": {
				"parser": "svelte"
			}
		}
	]
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

### how to insert arbitrary file into build directory

Just put the file of interest in the `static` directory.

### how to prevent `Not Found` error when the application is served by a real web server

To prevent 404 error given by the routing mechanism provided by the framework when the application is running on a real web server just insert a properly edited `.htaccess` file into the `static` directory.

For example something like the following `.htaccess` file:

```conf
DirectoryIndex index.html

RewriteEngine On

RewriteRule ^index\.html$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.html [L]
```

### check for updates

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
