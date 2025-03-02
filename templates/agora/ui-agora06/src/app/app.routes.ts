import { Routes } from "@angular/router"
import { PostListComponent } from "./post-list.component"

export const routes: Routes = [
  { path: "", pathMatch: "full", redirectTo: "posts" },
  { path: "posts", component: PostListComponent },
  { path: "", pathMatch: "full", redirectTo: "" },
]
