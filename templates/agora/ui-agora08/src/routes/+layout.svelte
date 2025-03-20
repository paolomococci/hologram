<script lang="ts">
	import { setContext } from 'svelte'
	import '../app.css'

	let { children } = $props()

	const username = 'John Doe'
	setContext('username', username)
</script>

{@render children()}
