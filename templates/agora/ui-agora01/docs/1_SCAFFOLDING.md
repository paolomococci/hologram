# scaffolding

```bash
cd /var/www/html/agora-project/
npm create vite@latest ui-agora01 -- --template react-swc-ts
cd ui-agora01/
npm install
```

## add routing feature

```bash
npm install react-router
```

To begin, I edit `src/main.tsx` as follows:

```tsx
import "./index.css"
import ReactDOM from "react-dom/client"
import { BrowserRouter, Routes, Route } from "react-router"
import { LandingView } from "./lib/components/views/LandingView.tsx"
import { InfoView } from "./lib/components/views/InfoView.tsx"
import { PostsView } from "./lib/components/views/PostsView.tsx"

const root = document.getElementById("root")

ReactDOM.createRoot(root!).render(
  <BrowserRouter>
    <Routes>
      <Route path="/" element={<LandingView />} />
      <Route path="info" element={<InfoView />} />
      <Route path="posts" element={<PostsView />} />
    </Routes>
  </BrowserRouter>
)
```

## add Tailwind 4

```bash
npm install tailwindcss @tailwindcss/vite @tailwindcss/typography
```

### import Tailwind CSS

Add `@import` into `/src/index.css` file like this:

```css
@import "tailwindcss";
@plugin '@tailwindcss/typography';
```

At this point, it is necessary to edit file `vite.config.js` in the following manner:

```js
import { defineConfig } from "vite"
import react from "@vitejs/plugin-react-swc"
import tailwindcss from "@tailwindcss/vite"

// https://vite.dev/config/
export default defineConfig({
  plugins: [react(), tailwindcss()]
})
```

## install the icons `lucide-react`

```bash
npm install lucide-react
```

## add `Redux Toolkit`

```bash
npm install @reduxjs/toolkit
```

## add `react-redux`

```bash
npm install react-redux
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
