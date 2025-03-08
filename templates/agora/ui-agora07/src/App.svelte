<script lang="ts">
  import ApiPostsCall from "./lib/ApiPostsCall.svelte"
  import ApiSanctumCsrfCookieCall from "./lib/ApiSanctumCsrfCookieCall.svelte"
</script>

<main>
  <header class="container sticky top-0 z-40 max-w-dvw">
    <div class="flex justify-center items-center">
      <h3 class="m-4 font-thin text-cyan-400 uppercase">Agora</h3>
    </div>
  </header>

  <div class="card">
    <ApiSanctumCsrfCookieCall />
    <ApiPostsCall />
  </div>
</main>
