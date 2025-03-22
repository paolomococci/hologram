<script lang="ts">
	import { getContext } from 'svelte'
	import { getCsrfCookie } from '$lib/hooks/fetch-csrf-cookie'
	import { getPing } from '$lib/hooks/fetch-ping'
	import type Ping from '$lib/interfaces/ping'
	import StarIcon from '$lib/components/StarIcon.svelte'

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
	<div class="flex items-center justify-center">
		<StarIcon />
	</div>
{/snippet}

{#snippet pingCard(ping: Ping)}
	<dl class="p-1">
		<dt class="text-stone-400">status:</dt>
		<dd class="m-1 text-2xl font-bold text-yellow-800">{ping.status}</dd>
		<dt class="text-stone-400">message:</dt>
		<dd class="m-1 text-3xl font-light text-yellow-200">{ping.message}</dd>
	</dl>
{/snippet}

{#snippet navCard()}
	<div class="m-2">
		<ul class="rounded-xl bg-stone-800 p-1">
			<li class="m-1 decoration-0">
				<a href="/info">info</a>
			</li>
			<li class="m-1 decoration-0">
				<a href="/posts">posts</a>
			</li>
		</ul>
	</div>
{/snippet}

<!-- end snippets -->

<div id="app" class="flex items-center justify-center">
	<header id="title" class="m-4">
		<h3 class="p-1 font-thin text-cyan-400 uppercase">agora</h3>
		<nav id="nav-card" class="m-0.5">
			{#if !ping.status}
				{@render awaitCard()}
			{:else}
				{@render navCard()}
			{/if}
		</nav>
	</header>
	<main>
		<!-- TODO -->
	</main>
	<footer id="username-context" class="fixed bottom-0 items-center justify-center">
		<h6 class="m-4 font-bold text-cyan-200 lowercase">
			<span class="mr-1 text-sm font-extralight text-stone-400">guest:</span>
			{username}
		</h6>
	</footer>
</div>
