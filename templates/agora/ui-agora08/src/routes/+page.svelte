<script lang="ts">
	import { getContext } from 'svelte'
	import { getCsrfCookie } from '$lib/services/fetch-csrf-cookie'
	import { getPing } from '$lib/services/fetch-ping'
	import type Ping from '$lib/interfaces/ping'
	import starImage from '../../static/favicon.png'

	// declaration present in the layout
	const username = getContext('username')
	const csrfCookieStatus = getCsrfCookie()
	const pingData = getPing()
	let ping: Ping = { status: 0, message: '' }

	console.info('CSRF Cookie: ', csrfCookieStatus)
	console.info('Data promise: ', pingData)

	pingData.then((data) => {
		ping.status = data.status
		ping.message = data.message
	})
	console.info('Ping object', ping)
</script>

<!-- begin snippets -->

{#snippet awaitCard()}
	<p class="p-1">
		<img class="p-2 m-2 animate-ping" src={starImage} alt="logo" />
	</p>
{/snippet}

{#snippet pingCard(ping: Ping)}
	<dl class="p-1">
		<dt class="text-stone-400">status:</dt>
		<dd class="m-1 text-2xl font-bold text-yellow-800">{ping.status}</dd>
		<dt class="text-stone-400">message:</dt>
		<dd class="m-1 text-3xl font-light text-yellow-200">{ping.message}</dd>
	</dl>
{/snippet}

<!-- end snippets -->

<main id="app">
	<section id="title" class="flex justify-center items-center">
		<h3 class="m-4 font-thin text-cyan-400 uppercase">agora</h3>
	</section>
	<section id="username-context" class="flex justify-center items-center">
		<h5 class="m-4 font-bold text-cyan-200 lowercase">{username}</h5>
	</section>
	<section id="ping-test" class="flex justify-center items-center">
		<article>
			{#if !ping.status}
				{@render awaitCard()}
			{:else}
				{@render pingCard(ping)}
			{/if}
		</article>
	</section>
</main>
