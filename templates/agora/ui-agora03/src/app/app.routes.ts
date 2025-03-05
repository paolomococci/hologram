import { Routes } from "@angular/router"
import { EndpointCardComponent } from "./endpoint-card.component"

export const routes: Routes = [
  { path: "", pathMatch: "full", redirectTo: "endpoint" },
  { path: "endpoint", component: EndpointCardComponent },
  { path: "", pathMatch: "full", redirectTo: "" },
]
