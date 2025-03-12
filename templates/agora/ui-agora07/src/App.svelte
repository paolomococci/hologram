<script lang="ts">
  import ApiPostsFetch from "./lib/components/ApiPostsFetch.svelte"
  import ApiSanctumCsrfCookieCall from "./lib/components/ApiSanctumCsrfCookieCall.svelte"
  import Paginator from "./lib/components/Paginator.svelte"
</script>

<main>
  <header
    class="container sticky top-0 z-40 shadow-xl rounded-md max-w-dvw bg-[242424]/95 backdrop-blur-sm mx-0 px-0"
  >
    <div class="flex justify-center items-center">
      <h3 class="m-4 font-thin text-cyan-400 uppercase">Agora</h3>
    </div>
    <div class="justify-center items-center pb-2 mb-2">
      <Paginator />
    </div>
  </header>

  <div class="card">
    <ApiSanctumCsrfCookieCall />
    <ApiPostsFetch />
  </div>
</main>
