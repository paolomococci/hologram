import { Component } from "@angular/core"
import { RouterOutlet } from "@angular/router"
import { MatSlideToggleModule } from "@angular/material/slide-toggle"

@Component({
  selector: "app-root",
  standalone: true,
  imports: [RouterOutlet, MatSlideToggleModule],
  template: `
    <header>
      <h1>{{ title }}</h1>

      <mat-slide-toggle> material toggle view test </mat-slide-toggle>
    </header>

    <router-outlet />
  `,
  styles: [],
})
export class AppComponent {
  title = "Agora"
}
