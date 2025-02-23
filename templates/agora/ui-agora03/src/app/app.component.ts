import { Component, Input } from "@angular/core"
import { RouterOutlet } from "@angular/router"

@Component({
  selector: "app-root",
  imports: [RouterOutlet],
  template: `
      <div
        class="rounded-lg border shadow-sm bg-slate-600 border-slate-400"
      >
        <div class="p-4">
          <h3 class="m-4 text-slate-200">
            {{ title }}
          </h3>
          <p class="my-2 font-thin prose text-slate-400">A simple incremental button.</p>
          <button class="mb-2" type="button" (click)="increment()">count is {{count}}</button>
        </div>
      </div>

    <router-outlet />
  `,
  styles: [],
})
export class AppComponent {
  title = "Agora"
  count: number = 0

  increment() {
    this.count++
  }
}
