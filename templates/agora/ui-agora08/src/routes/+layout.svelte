<script lang="ts">
	import { setContext } from 'svelte'
	import '../app.css'

	let { children } = $props()

	// Set context of username
	const username = 'John Doe'
	setContext('username', username)
</script>

{@render children()}
