import { Component } from "@angular/core"
import { LucideAngularModule, Plus } from "lucide-angular"
import { EndpointCardComponent } from "./endpoint-card.component"

@Component({
  selector: "app-count-card",
  standalone: true,
  imports: [LucideAngularModule, EndpointCardComponent],
  template: `
    <div class="rounded-lg border shadow-sm bg-slate-600 border-slate-400">
      <div class="p-4">
        <p class="my-2 font-thin prose text-slate-400">
          A simple incremental button.
        </p>
        <button class="mb-2" type="button" (click)="increment()">
          <i-lucide [img]="Plus"></i-lucide>
        </button>
        <output class="block">count is {{ count }}</output>
      </div>
    </div>

    <app-endpoint-card />
  `,
  styles: ``,
})
export class CountCardComponent {
  readonly Plus = Plus
  count: number = 0

  increment() {
    this.count++
  }
}
