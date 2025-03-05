import { Injectable, resource } from "@angular/core"
import ENV from "../env"
import { ApiResponse } from "./api-response"

@Injectable({
  providedIn: "root",
})
export class EndpointService {
  apiResponse?: ApiResponse | undefined

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
        console.log("Response: ", response)
        try {
          this.apiResponse = await response.json()
          console.log("this.apiResponse: ", this.apiResponse)
        } catch (error) {
          console.error(error)
        }
        return await response.json()
      }
    },
  })

  constructor() {}
}
