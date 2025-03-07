<script lang="ts">
  import axios from "axios"
  import ENV from "../env"

  async function retrieveSanctumCsrfCookie() {
    try {
      const response = await axios.get(`${ENV.baseUrl}sanctum/csrf-cookie`)
      console.log(response)
    } catch (error) {
      console.error(error)
    }
  }

  retrieveSanctumCsrfCookie()
</script>
