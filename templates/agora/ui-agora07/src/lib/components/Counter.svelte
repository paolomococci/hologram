<script lang="ts">
  import { Plus } from "lucide-svelte"

  let count: number = $state(0)

  /**
   * Simple demo.
   */
  const increment = () => {
    count += 1
  }
</script>

<button class="text-cyan-400 count-button" onclick={increment}>
  <Plus />
</button>

<output id="counter-view" class="block mt-4 text-2xl text-slate-400">
  count is {count}
</output>
