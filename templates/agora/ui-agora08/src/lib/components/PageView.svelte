<script lang="ts">
	import { fade } from 'svelte/transition'
	import type Post from '$lib/interfaces/post'
	import { isDetails } from '$lib/stores/posts-store'
	import ENV from '$lib/environments/env'

	// receives data from the paginator component
	let { posts } = $props()

	let details: Post = $state({
		id: 0,
		title: '',
		content: '',
		created_at: new Date(),
		updated_at: new Date()
	})

	/**
	 * This is a feature to use if you are in an environment where posts may be edited over and over again in rapid succession.
	 *
	 * @param id
	 */
	const getPost = async (id: number): Promise<Post> => {
		const uri: string = ENV.cardUriBase + id
		try {
			const response = await fetch(uri)
			if (!response.ok) {
				throw new Error(`HTTP errors status: ${response.status}`)
			}
			const postJson = await response.json()
			return postJson.post
		} catch (error) {
			console.error("I'm sorry, an error occurred while querying the post id API: ", error)
			throw error
		}
	}
</script>

<!-- begin snippets -->

<!-- partial index of posts -->
{#snippet postCard(post: Post)}
	<div
		class="my-2 rounded-lg bg-stone-800 py-2"
		transition:fade={{
			delay: 250,
			duration: 750
		}}
	>
		<h5 class="m-1 font-serif text-xs text-cyan-600 sm:text-sm md:text-base lg:text-lg">
			<button
				onclick={async () => {
					// Start of a demo example if I need to use the version of the post stored in the system instead of the version downloaded during pagination.
					let resPost = getPost(post.id)
					let retrievedPost: Post = await resPost.then((res) => res)
					console.log('Title: ', retrievedPost.title)
					console.log('Content: ', retrievedPost.content)
					console.log('Username: ', retrievedPost.user?.name)
					// End of demo.
					isDetails.set(true)
					details = post
				}}
				class="prose-base md:prose-lg lg:prose-xl cursor-pointer transition delay-300 duration-300 ease-in-out hover:text-cyan-100 hover:shadow-2xl hover:shadow-stone-600"
				>{post.title}</button
			>
		</h5>
		<p
			class="prose-sm md:prose-base lg:prose-lg m-1 line-clamp-2 text-justify font-serif text-stone-400"
		>
			{post.content}
		</p>
		<h6
			class="prose-sm md:prose-base lg:prose-lg m-1 font-mono text-xs text-cyan-400 sm:text-sm md:text-base lg:text-lg"
		>
			{#if post.user}
				{post.user.name}
			{/if}
		</h6>
	</div>
{/snippet}

<!-- detail view of the selected post -->
{#snippet detailCard(details: Post)}
	<div
		class=" text-xs sm:text-sm md:text-base lg:text-lg"
		transition:fade={{
			delay: 250,
			duration: 750
		}}
	>
		<button
			onclick={() => {
				console.log('Go back!')
				isDetails.set(false)
			}}
			class="mb-2 cursor-pointer transition delay-300 duration-300 ease-in-out hover:text-cyan-100 hover:shadow-2xl hover:shadow-stone-600"
			>go back</button
		>
		<h5 class="m-1 font-serif text-cyan-600">
			{details.title}
		</h5>
		<p class="prose-sm md:prose-base lg:prose-lg m-1 text-justify font-serif text-stone-400">
			{details.content}
		</p>
		<h6 class="m-1 font-mono text-cyan-400">
			{#if details.user}
				{details.user.name}
			{/if}
		</h6>
	</div>
{/snippet}

<!-- end snippets -->

<div>
	<div class="items-center gap-8">
		{#if $isDetails}
			{@render detailCard(details)}
		{:else}
			{#each posts as post}
				{@render postCard(post)}
			{/each}
		{/if}
	</div>
</div>
