import ENV from '$lib/environments/env'
import type Post from '$lib/interfaces/post'
import type Posts from '$lib/interfaces/posts'

/**
 *
 * retrieve posts
 *
 * @param current current page
 * @param filter string or substring to search for in the post title
 * @returns Promise<Posts>
 */
export const getPosts = async (current?: number, filter?: string): Promise<Posts> => {
	try {
		const response = await fetch(`${ENV.paginateUrl}${current}?filter=${filter}`)
		if (!response.ok) {
			throw new Error(`HTTP errors status: ${response.status}`)
		}
		const dataJson = response.json()
		console.info('Data values from fetch posts hook: ', dataJson)
        return dataJson
	} catch (error: any) {
		console.error(`${error.name}: ${error.message}`)
		return {
			status: error.status
		}
	}
}
