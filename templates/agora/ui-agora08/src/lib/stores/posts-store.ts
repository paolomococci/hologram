import { writable } from "svelte/store"

export const postStore = writable()
export const isDetails = writable(false)
export const selectedPostId = writable<number | null>(null)
export const postsPerPage = writable(10)
