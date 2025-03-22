<script lang="ts">
	import Paginator from '$lib/components/Paginator.svelte'
	import PostsView from '$lib/components/PostsView.svelte'
</script>

<div class="agora">
	<div class="navbar">
		<header id="posts-title" class="items-center justify-center">
			<h5 class="m-4 font-bold text-cyan-200 uppercase">posts</h5>
			<nav id="posts-nav" class="my-2">
				<div>
					<a href="/">home</a>
				</div>
			</nav>
			<section id="posts-paginator">
				<article class="m-4">
					<Paginator />
				</article>
			</section>
		</header>
	</div>
	<div class="items-center justify-center">
		<main class="mt-52">
			<section id="posts-view" class="card">
				<PostsView />
			</section>
		</main>
	</div>
</div>
