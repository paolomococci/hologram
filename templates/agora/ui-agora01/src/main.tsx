import "./index.css"
import ReactDOM from "react-dom/client"
import { BrowserRouter, Routes, Route } from "react-router"
import { Landing } from "./lib/components/Landing.tsx"
import { Info } from "./lib/components/Info.tsx"
import { Posts } from "./lib/components/Posts.tsx"

const root = document.getElementById("root")

ReactDOM.createRoot(root!).render(
  <BrowserRouter>
    <Routes>
      <Route path="/" element={<Landing />} />
      <Route path="info" element={<Info />} />
      <Route path="posts" element={<Posts />} />
    </Routes>
  </BrowserRouter>
)
