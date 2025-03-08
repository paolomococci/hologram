<script lang="ts">
  import axios from "axios"
  import ENV from "../env"
  import { LoaderPinwheel } from "lucide-svelte"
  import type ApiResponse from "./api-response"

  let apiResponse: ApiResponse = {
    status: 503,
    message: "Service Unavailable",
  }

  async function retrieveApiResponse() {
    try {
      const response = await axios.get<ApiResponse>(`${ENV.baseUrl}api/ping`)
      console.log(response)
      apiResponse = response.data
    } catch (error) {
      console.error(error)
    }
  }

  retrieveApiResponse()
</script>

<main>
  <div class="flex z-20 justify-center items-center mt-4">
    {#if apiResponse?.status != 200}
      <div>
        <LoaderPinwheel
          class="w-20 h-20 stroke-1 stroke-orange-400 animate-[spin_1s_ease-in-out_infinite]"
        />
      </div>
    {:else}
      <div>
        <p>{apiResponse.message}</p>
      </div>
    {/if}
  </div>
</main>
