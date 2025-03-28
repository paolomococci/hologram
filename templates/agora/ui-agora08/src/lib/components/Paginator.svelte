<script lang="ts">
	import type Post from '$lib/interfaces/post'
	import type Posts from '$lib/interfaces/posts'
	import { writable } from 'svelte/store'
	import { getPosts } from '$lib/hooks/fetch-posts'
	import { postStore, isDetails } from '$lib/stores/posts-store'

	const postsPerPage = 10
	const currentPage = writable(1)
	let textOfFilter = $state('')
	let posts: Post[] | undefined
	let totalNumberOfPosts: number
	let totalNumberOfPages = $state(0)
	let postsApiResponse: Posts

	/**
	 * It is used to filter the content of post titles.
	 *
	 * @param filter
	 * @param current
	 */
	const retrievePosts = async (current?: number, filter?: string) => {
		try {
			postsApiResponse = await getPosts(current, filter)
			console.log(`Number of posts from Paginator component: `, postsApiResponse.num)
			console.log(`Posts retrieved from Paginator component: `, postsApiResponse.posts)
			console.log(`Status from Paginator component: `, postsApiResponse.status)
			posts = postsApiResponse.posts
			postStore.set(posts)
			isDetails.set(false)
			totalNumberOfPosts = postsApiResponse.num ? postsApiResponse.num : 1
			totalNumberOfPages = Math.ceil(totalNumberOfPosts / postsPerPage)
		} catch (error) {
			console.error(error)
			throw error
		}
	}

	/**
	 * To navigate through the post pagination.
	 *
	 * @param pageNumber
	 */
	function moveToPageNumber(pageNumber: number) {
		if (pageNumber >= 1 && pageNumber <= totalNumberOfPages) {
			currentPage.set(pageNumber)
		}
	}

	/**
	 * call retrieve posts
	 */
	retrievePosts(1, '')
</script>

<div>
	<section id="paginator-controller">
		<button
			id="prev"
			name="prev"
			disabled={$currentPage === 1}
			onclick={() => {
				moveToPageNumber($currentPage - 1)
				retrievePosts($currentPage, textOfFilter)
				console.log('Posts: ', posts)
				console.log('Current page: ', $currentPage)
			}}
			class="p-1.5 my-1.5 mr-0 ml-1.5 text-xs bg-cyan-900 rounded-l-lg cursor-pointer text-slate-400 disabled:cursor-not-allowed sm:text-sm md:my-2 md:ml-2 md:p-2 md:text-base lg:my-3.5 lg:ml-3.5 lg:p-3.5 lg:text-lg"
			>Prev</button
		>
		<input
			type="search"
			id="filter-posts"
			name="filter-posts"
			bind:value={textOfFilter}
			onblur={() => {
				retrievePosts(1, textOfFilter)
				$currentPage = 1
			}}
			class="p-1.5 text-xs text-center bg-cyan-900 text-slate-400 disabled:cursor-not-allowed sm:text-sm md:p-2 md:text-base lg:p-3.5 lg:text-lg"
		/>
		<button
			id="next"
			name="next"
			disabled={$currentPage === totalNumberOfPages}
			onclick={() => {
				moveToPageNumber($currentPage + 1)
				retrievePosts($currentPage, textOfFilter)
				console.log('Posts: ', posts)
				console.log('Current page: ', $currentPage)
			}}
			class="p-1.5 my-1.5 mr-1.5 ml-0 text-xs bg-cyan-900 rounded-r-lg cursor-pointer text-slate-400 disabled:cursor-not-allowed sm:text-sm md:my-2 md:mr-2 md:p-2 md:text-base lg:my-3.5 lg:mr-3.5 lg:p-3.5 lg:text-lg"
			>Next</button
		>
	</section>
	<section id="paginator-display">
		{#if totalNumberOfPages > 0}
			<output class="text-xs text-slate-400 sm:text-sm md:text-base lg:text-lg"
				>{$currentPage} / {totalNumberOfPages}</output
			>
		{/if}
	</section>
</div>
