<script lang="ts">
  import axios from "axios"
  import ENV from "../../env"

  /**
   * Retrieve the CSRF cookie from the provided API.
   */
  async function retrieveSanctumCsrfCookie() {
    try {
      const response = await axios.get(`${ENV.baseUrl}sanctum/csrf-cookie`)
      console.log("Sanctum CSRF cookie: ", response)
    } catch (error) {
      console.error("Sanctum CSRF cookie error: ", error)
    }
  }

  retrieveSanctumCsrfCookie()
</script>
