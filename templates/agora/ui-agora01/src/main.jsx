import "./index.css"
import ReactDOM from "react-dom/client"
import { BrowserRouter, Routes, Route } from "react-router"
import { LandingView } from "./lib/components/views/LandingView.jsx"
import { InfoView } from "./lib/components/views/InfoView.tsx"
import { PostsView } from "./lib/components/views/PostsView.jsx"

const root = document.getElementById("root")

ReactDOM.createRoot(root).render(
  <BrowserRouter>
    <Routes>
      <Route path="/" element={<LandingView />} />
      <Route path="info" element={<InfoView />} />
      <Route path="posts" element={<PostsView />} />
    </Routes>
  </BrowserRouter>
)
