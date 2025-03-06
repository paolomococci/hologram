import { Component } from "@angular/core"
import { LucideAngularModule, Loader } from "lucide-angular"
import { EndpointService } from "./endpoint.service"

@Component({
  selector: "app-endpoint-card",
  standalone: true,
  imports: [LucideAngularModule],
  template: `
    <div class="flex justify-center items-center">
      @if (endpointService.apiResponse?.status != 200) {
      <div class="mt-4">
        <lucide-angular
          [img]="Loader"
          class="w-20 h-20 stroke-1 stroke-orange-400 animate-[spin_1s_ease-in-out_infinite]"
        ></lucide-angular>
      </div>
      } @if (endpointService.apiResponse?.status === 200) {
      <div
        class="mt-4 rounded-lg border shadow-sm bg-slate-600 border-slate-400"
      >
        <p class="mx-4 my-2 text-slate-400">
          {{ endpointService.apiResponse?.message }}
        </p>
      </div>
      }
    </div>
  `,
  styles: ``,
})
export class EndpointCardComponent {
  readonly Loader = Loader
  constructor(readonly endpointService: EndpointService) {}
}
