import { Component } from "@angular/core"
import { RouterOutlet } from "@angular/router"

@Component({
  selector: "app-root",
  standalone: true,
  imports: [RouterOutlet],
  template: `
    <header class="flex p-4 m-4">
      <h1 class="text-5xl font-thin text-purple-400">{{ title }}</h1>
    </header>

    <router-outlet />
  `,
  styles: [],
})
export class AppComponent {
  title = "Agora"
}
