import { Component, Injectable, resource } from "@angular/core"
import { RouterOutlet } from "@angular/router"
import { 
  LucideAngularModule, 
  Loader, 
  Plus
 } from "lucide-angular"
import ENV from "../env"

interface ApiResponse {
  status: number
  message: string
}

@Component({
  standalone: true,
  selector: "app-root",
  imports: [
    RouterOutlet, 
    LucideAngularModule
  ],
  template: `
    <div class="rounded-lg border shadow-sm bg-slate-600 border-slate-400">
      <div class="p-4">
        <h3 class="m-4 text-slate-200">
          {{ title }}
        </h3>
        <p class="my-2 font-thin prose text-slate-400">
          A simple incremental button.
        </p>
        <button class="mb-2" type="button" (click)="increment()">
          <i-lucide [img]="Plus"></i-lucide>
        </button>
        <output class="block">count is {{ count }}</output>
      </div>
    </div>

      @if (apiResponse.status != 200) {
        <div class="flex items-center mt-4 ml-24">
          <lucide-angular [img]="Loader" class="w-20 h-20 text-orange-400 animate-[spin_1s_ease-in-out_infinite]"></lucide-angular>
        </div>
      } @if (apiResponse.status === 200) {
        <div class="mt-4 rounded-lg border shadow-sm bg-slate-600 border-slate-400">
          <p class="mx-4 my-2 text-slate-400">{{ apiResponse.message }}</p>
        </div>
      }
    
    <router-outlet />
  `,
  styles: [],
})
export class AppComponent {
  readonly Loader = Loader
  readonly Plus = Plus
  title = "Agora"
  count: number = 0
  apiResponse: ApiResponse = {
    status: 0,
    message: "",
  }

  increment() {
    this.count++
  }

  // csrf-cookie
  csrfCookieUri = ENV.baseUrl + "sanctum/csrf-cookie"
  csrfCookieResource = resource({
    loader: async () => {
      const response = await fetch(this.csrfCookieUri)
      if (response.ok) {
        console.log(response)
        return await response.json()
      } else {
        console.error("Could not get a valid response from the API!")
      }
    },
  })

  // ping test
  apiPingResource = resource({
    loader: async () => {
      const response = await fetch(`${ENV.baseUrl}api/ping`)
      if (!response.ok) {
        console.error("Could not get a valid response from the API!")
      } else {
        let apiResponse = await response.json()
        this.apiResponse.status = apiResponse.status
        this.apiResponse.message = apiResponse.message
        console.log(apiResponse.message)
        return await response.json()
      }
    },
  })
}
