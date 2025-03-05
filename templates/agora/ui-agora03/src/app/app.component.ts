import { Component } from "@angular/core"
import { RouterOutlet } from "@angular/router"

@Component({
  selector: "app-root",
  standalone: true,
  imports: [RouterOutlet],
  template: `
    <header class="flex justify-center items-center m-4">
      <h3 class="font-thin text-cyan-400 uppercase">
        {{ title }}
      </h3>
    </header>

    <router-outlet />
  `,
  styles: [],
})
export class AppComponent {
  title = "Agora"
}
