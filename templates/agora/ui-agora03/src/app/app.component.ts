import { Component, Injectable, resource } from "@angular/core"
import { RouterOutlet } from "@angular/router"
import ENV from "../env"

interface ApiResponse {
  status: number,
  message: string
}

@Component({
  selector: "app-root",
  imports: [RouterOutlet],
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
          count is {{ count }}
        </button>
      </div>
    </div>

    <div class="mt-4 rounded-lg border shadow-sm bg-slate-600 border-slate-400">
      @if (apiResponse.status != 200) {
      <p class="mx-6 my-4 text-orange-400">Loading…</p>
      } @if (apiResponse.status === 200) {
      <p class="mx-4 my-2 text-slate-400">{{ apiResponse.message }}</p>
      }
    </div>

    <router-outlet />
  `,
  styles: [],
})
export class AppComponent {
  title = "Agora"
  count: number = 0
  apiResponse: ApiResponse = {
    status: 0,
    message: ""
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
