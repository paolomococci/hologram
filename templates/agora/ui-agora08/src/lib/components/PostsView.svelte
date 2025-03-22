<script lang="ts">
	import { postStore } from '$lib/stores/posts-store'
	import type Post from '$lib/interfaces/post'
	import StarIcon from './StarIcon.svelte'
	import PageView from './PageView.svelte'

	let posts: Post[] | unknown

	/**
	 * Retrieve posts from the store
	 */
	async function retrieve() {
		postStore.subscribe((postSub) => {
			posts = postSub
			console.log('Posts values from paginator component to posts view component: ', posts)
		})
	}

	retrieve()
</script>

<div>
	<div class="mt-4 flex items-center justify-center">
		{#if !posts}
			<div>
				<StarIcon />
			</div>
		{:else}
			<PageView {posts} />
		{/if}
	</div>
</div>
